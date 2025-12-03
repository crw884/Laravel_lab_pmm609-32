<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $post_id)
    {
        $validated = $request->validate([
            'comment'=>"required",
        ]);

        Comment::create([
            'text' => $validated['comment'],
            'post_id' => $post_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
