<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PharIo\Version\Exception;

class GroupControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //return response(Group::all());


        $groups = Group::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * (request()->page ?? 0))
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->with('users')->get();

        $groups = $groups->map(function($group){
            return [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'is_private' => $group->is_private,
                'admin_id' => $group->admin_id,
                'admin' => $group->admin_id ? $group->admin->name : null,
                'created_at' => $group->created_at,
                'updated_at' => $group->updated_at,
                'image' => $group->image
            ];
        });

        return response()->json($groups);
    }

    public function total(Request $request)
    {
        return response(Group::where('name', 'LIKE', '%' . $request->search . '%')->count());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::with('users', 'admin')->find($id);
        $group =  [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'is_private' => $group->is_private,
                'admin_id' => $group->admin_id,
                'admin' => $group->admin_id ? $group->admin->name : null,
                'created_at' => $group->created_at,
                'updated_at' => $group->updated_at,
                'image' => $group->image
            ];

        return response($group);
    }

//    public function posts(Request $request, string $id){
//        $perpage = $request->perpage ?? 5;
//        $page = $request->page ?? 0;
//        $offset = $perpage * $page;
//
//        $posts = Post::where('group_id', $id)
//        ->with(['user', 'group'])
//            ->orderBy('id', 'desc')
//            ->skip($offset)
//            ->take($perpage)
//            ->get();
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
//    }


    public function subscribe(Request $request)
    {
        $id = $request->user_id;
        $group_id = $request->group_id;
        $group = Group::all()->where('id', $group_id)->first();
        if ($group->users()->where('user_id', $id)->exists()) {
            return response('Вы уже подписаны на эту группу', 400);
        }

        $group->users()->attach($id);

        return response( 'Вы успешно подписались', 200);
    }

    public function unsubscribe(Request $request)
    {
        $id = $request->user_id;
        $group_id = $request->group_id;
        $group = Group::all()->where('id', $group_id)->first();
        if ($id == null || !$group->users()->where('user_id', $id)->exists()) {
            return response('Вы не подписаны на эту группу', 400);
        }

        $group->users()->detach($id);

        return response('Вы успешно отписались',200);
    }

    public function subscribers(Request $request){
        $group = Group::all()->where('id', $request->group_id)->first();
        if($group == null) return response('Такой группы не существует.', 404);
        return response($group->users()->pluck('users.id')->toArray());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:64',
            'description' => 'max:256',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = request()->file('image');
        if($image){

            $imageFileName = $image->getClientOriginalName().'_'.rand(1,100000).'.'.$image->getClientOriginalExtension();

            try{
                $imagePath = Storage::disk('s3')->putFileAs('groups', $image, $imageFileName);
                $imageURL = Storage::disk('s3')->url($imagePath);
            } catch (Exception $ex) {
                return response()->json(
                    [
                        'code' => 500,
                        'message' => 'Ошибка при загрузке в хранилище S3.'
                    ]
                );
            }
        }

        $group = new Group($validated);
        $group->admin_id = $request->user_id;
        $group->is_private = $request->is_private == 1 ? 1 : 0;
        if($image) $group->image = $imageURL;
        $group->save();
        return response()->json(
            [
                'code' => 201,
                'message' => 'Группа успешно создана.'
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::find($id);
        if($group == null) return response()->json(
            [
                'code' => 404,
                'message' => 'Группа не найдена.'
            ],
            404
        );

        if(!Gate::forUser(auth()->user())->allows('editOrDestroyGroup', [$group])){
            return response()->json(
                [
                    'code' => 401,
                    'message' => 'Редактировать группу может только создатель.'
                ],
                401
            );
        }

        $validated = $request->validate([
            'name' => 'required|max:64',
            'description' => 'nullable|max:256',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try{
            if($request['name']) $group->name = $validated['name'];
            if($request['description']) $group->description = $validated['description'];
            if($request->hasFile('image')){
                try{
                    if($group->image){
                        $bucket = config('filesystems.disks.s3.bucket');
                        $baseUrl = Storage::disk('s3')->getClient()->getEndpoint();
                        $fullBaseUrl = str_replace('://', '://' . $bucket . '.', $baseUrl);
                        $url = str_replace($fullBaseUrl, '', $group->image);
                        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                        $out->writeln('0_0');
                        if(Storage::disk('s3')->exists($url)) {
                            Storage::disk('s3')->delete($url);
                        }
                    }

                    $image = request()->file('image');
                    $imageFileName = $image->getClientOriginalName().'_'.rand(1,100000).'.'.$image->getClientOriginalExtension();
                    $imagePath = Storage::disk('s3')->putFileAs('groups', $image, $imageFileName);
                    $imageURL = Storage::disk('s3')->url($imagePath);
                    $group->image = $imageURL;
                } catch (\Exception $e){
                    return response()->json(['message' => 'Ошибка при загрукзе в S3 хранилище: ' . $e->getMessage()], 500);
                }
            } else {
                if($group->image){
                    $bucket = config('filesystems.disks.s3.bucket');
                    $baseUrl = Storage::disk('s3')->getClient()->getEndpoint();
                    $fullBaseUrl = str_replace('://', '://' . $bucket . '.', $baseUrl);
                    $url = str_replace($fullBaseUrl, '', $group->image);
                    $out = new \Symfony\Component\Console\Output\ConsoleOutput();
                    $out->writeln('0_0');
                    if(Storage::disk('s3')->exists($url)) {
                        Storage::disk('s3')->delete($url);
                    }
                    $group->image = null;
                }
            }
            $group->save();
            return response()->json([
                'message' => 'Группа успешно обновлена',
                'code' => 201
                ]);
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Ошибка при обновлении группы: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::find($id);
        if($group == null) return response()->json(
            [
                'code' => 404,
                'message' => 'Группа не найдена.'
            ],
            404
        );

        if(!Gate::forUser(auth()->user())->allows('editOrDestroyGroup', [$group])){
            return response()->json(
                [
                    'code' => 401,
                    'message' => 'Удалить группу может только создатель.'
                ],
                401
            );
        }

        if($group->posts()->count() > 0){
            return response()->json(['code' => 401, 'message'=>'Нельзя удалить непустую группу'], 401);
        }
        if($group->image != null) {
            $bucket = config('filesystems.disks.s3.bucket');
            $baseUrl = Storage::disk('s3')->getClient()->getEndpoint();
            $fullBaseUrl = str_replace('://', '://' . $bucket . '.', $baseUrl);
            $url = str_replace($fullBaseUrl, '', $group->image);
//            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
//            $out->writeln($url);
//            $out->writeln($baseUrl);
            if(Storage::disk('s3')->exists($url)) {
                Storage::disk('s3')->delete($url);
            }
        };
        $deleted = Group::destroy($id);

        if($deleted === 0){
            return response()->json(['code' => 500, 'message'=>'Не удалось удалить группу'], 500);
        }

        return response()->json(['code'=>200, 'message'=>'Группа успешно удалена']);
    }
}
