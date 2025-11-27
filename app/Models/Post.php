<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'group_id',
        'text',
        'tags',
        'image',
        'audio',
    ];

    function group() : BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    function rates(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "rates");
    }

}
