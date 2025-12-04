<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        // Достаем посты из ПУБЛИЧНЫХ групп
        $posts = Post::orderBy('created_at', 'desc')->whereIn(
            'group_id',
            Group::all()->where('is_private', '=',0)->pluck('id')->toArray()
        );
        return view('posts', [
            'posts' => $posts->paginate($perpage)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($group_id)
    {
        if(!Gate::allows('create-post', Group::all()->where('id', $group_id)->first())) {
            return redirect('/error')->with(
                'message', 'Вы не можете публиковать посты в этой группе.'
            );
        }

        return view('post_create', [
            'group_id'=>$group_id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //$out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $validated = $request->validate([
            'text' => 'required|max:1023',
            'tags' => 'max:511',
            'group_id' => 'required|exists:groups,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'audio' => 'mimes:mp3,wav,ogg|max:24728'
        ]);

        $imageData = null;
        $audioData = null;

        if ($request->hasFile('image')) {
            $imageData = $request->file('image')->store('posts', 'public');
        }

        if ($request->hasFile('audio')) {
            $audioData = $request->file('audio')->store('posts', 'public');
        }

        Post::create([
            'text' => $validated['text'],
            'tags' => $validated['tags'],
            'image' => $imageData,
            'audio' => $audioData,
            'user_id' => Auth::id(),
            'group_id' => $validated['group_id']
        ]);

        return redirect(route('post.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::all()->where('id', $id)->first();
        if($post == null){
            return redirect('/posts')->with('error','Пост с таким id не найден.');
        }
        if($post->group->is_private == 1 AND $post->user_id != Auth::id() AND $post->group->admin->id != Auth::id()) {
            return redirect('/posts')->with('error', 'Публикация недоступна.');
        }
        if($post === null) {
            abort(404);
        }
        $rating = $post->rates()->avg('rate');

        return view('post', [
            'post' => $post,
            'comments' => Comment::all()->where('post_id', $id),
            'rating' => $rating,
            'group_id' => $post->group->id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::all()->where('id', $id)->first();
        return view('post_edit', [
            'post' => $post,
            'group_id' => $post->group->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::all()->where('id', $id)->first();
        $validated = $request->validate([
            'text' => 'required|max:255'
        ]);
        $post->update([
            'text' => $validated['text'],
        ]);

        return redirect()->route('post.show', $post->id)->with('success', 'Пост успешно обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Gate::allows('destroy-post', Post::all()->where('id', $id)->first())) {
            return redirect('/error')->with(
                'message', 'Вы не можете удалить этот пост.'
            );
        }

        $post = Post::all()->where('id', $id)->first();
        foreach ($post->comments as $comment) {
            $comment->delete();
        }

        if($post->image != null){
            Storage::disk('public')->delete($post->image);
        }
        if($post->audio != null){
            Storage::disk('public')->delete($post->audio);
        }
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Пост успешно удален.');
    }


    public function getImage(string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post->image || !Storage::disk('public')->exists($post->image)) {
           return null;
        }

        return Storage::disk('public')->response($post->image);
    }

    public function getAudio(string $id)
    {
        $post = Post::findOrFail($id);

        if (!$post->audio || !Storage::disk('public')->exists($post->audio)) {
            return null;
        }

        return Storage::disk('public')->response($post->audio);
    }
}
