<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PharIo\Version\Exception;

class PostControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $perPage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        $posts = [];
        if(request()->group_id == -1) {
            $posts = Post::with(['user', 'group'])
                ->whereHas('group', function ($query) {
                    $query->where('is_private', false);
                })
                ->orderBy('id', 'desc')
                ->skip($perPage * $page)
                ->take($perPage)
                ->get()
                ->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'text' => $post->text,
                        'audio' => $post->audio,
                        'image' => $post->image,
                        'tags' => $post->tags,
                        'user_id' => $post->user_id,
                        'user_name' => $post->user ? $post->user->name : null,
                        'group_id' => $post->group_id,
                        'group_name' => $post->group ? $post->group->name : null,
                        'created_at' => $post->created_at,
                        'updated_at' => $post->updated_at
                    ];
                });
        } else {
            $posts = Post::with(['user', 'group'])
                ->whereHas('group', function ($query) {
                    $query->where('id', request()->group_id);
                })
                ->orderBy('id', 'desc')
                ->skip($perPage * $page)
                ->take($perPage)
                ->get()
                ->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'text' => $post->text,
                        'audio' => $post->audio,
                        'image' => $post->image,
                        'tags' => $post->tags,
                        'user_id' => $post->user_id,
                        'user_name' => $post->user ? $post->user->name : null,
                        'group_id' => $post->group_id,
                        'group_name' => $post->group ? $post->group->name : null,
                        'created_at' => $post->created_at,
                        'updated_at' => $post->updated_at
                    ];
                });
        }
        return response()->json($posts);

//        $posts = Post::limit($request->perpage ?? 5)
//            ->offset(($request->perpage ?? 5) * (request()->page ?? 0))->with(['user', 'group'])->get();
//
//        $posts = $posts->filter(function($post){
//            return !$post->group->is_private;
//        })->map(function ($post) {
//            return [
//                'id' => $post->id,
//                'text' => $post->text,
//                'audio' => $post->audio,
//                'image' => $post->image,
//                'tags' => $post->tags,
//                'user_id' => $post->user_id,
//                'user_name' => $post->user ? $post->user->name : null,
//                'group_id' => $post->group_id,
//                'group_name' => $post->group ? $post->group->name : null,
//                'created_at' => $post->created_at,
//                'updated_at' => $post->updated_at
//            ];
//        })->sortByDesc('id')->values();
//
//        return response()->json($posts);
    }

    public function total(Request $request){
        if(request()->group_id == -1) {
            return response(Post::all()->filter(function($post){
                return !$post->group->is_private;
            })->count());
        } else {
            return response(Post::all()->filter(function($post){
                return $post->group->id == request()->group_id;
            })->count());
        }

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Gate::forUser(User::find($request['user_id']))->allows('create-post', [ Group::find($request['group_id'])])) {

//            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//            $out->writeln(Group::find($request['group_id']));

            return response()->json(
                [
                    'code' => 401,
                    'message' => 'У вас нет прав создавать посты в этой группе.'
                ]
            );
        }

        $validated = $request->validate([
            'text' => 'required|max:1023',
            'audio' => 'required|file|mimes:mp3,wav,ogg',
            'group_id' => 'required|exists:groups,id',
            'image' => 'required|file|image|mimes:jpeg,png,jpg',
        ]);

        $image = request()->file('image');
        $imageFileName = $image->getClientOriginalName().'_'.rand(1,100000).'.'.$image->getClientOriginalExtension();
        $audio = request()->file('audio');
        $audioFileName = $audio->getClientOriginalName().'_'.rand(1,100000).'.'.$audio->getClientOriginalExtension();

        try{
            $imagePath = Storage::disk('s3')->putFileAs('posts', $image, $imageFileName);
            $imageURL = Storage::disk('s3')->url($imagePath);

            $audioPath = Storage::disk('s3')->putFileAs('posts', $audio, $audioFileName);
            $audioURL = Storage::disk('s3')->url($audioPath);
        } catch (Exception $ex) {
            return response()->json(
                [
                    'code' => 500,
                    'message' => 'Ошибка при загрузке в хранилище S3.'
                ]
            );
        }

        $post = new Post($validated);
        $post->image = $imageURL;
        $post->audio = $audioURL;
        $post->user_id = $request['user_id'];
        $post->group_id = $validated['group_id'];
        $post->save();
        return response()->json(
            [
                'code' => 201,
                'message' => 'Пост успешно добавлен.'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Post::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
