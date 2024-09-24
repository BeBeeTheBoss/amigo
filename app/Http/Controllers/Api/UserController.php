<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct(protected User $model) {}

    public function index(Request $request, $id = null)
    {

        $data = $id ? $this->model->find($id) : $this->model
            ->when($request->name, function ($query) use ($request) {
                $name = str_replace(' ', '', $request->name);
                $query->whereRaw('REPLACE(LOWER(name), " ", "") LIKE ?', ['%' . strtolower($name) . '%']);
            })->when($request->phone, function ($query) use ($request) {
                $query->where('phone', $request->phone);
            })
            ->inRandomOrder()
            ->paginate(20, ['*'], 'page', $request->page);

        if($id){
            if (!$data) {
                return sendResponse(null, 404, 'User not found');
            }
            new UserResource($data);
        }else{
            if (count($data) == 0) {
                return sendResponse(null, 404, 'User not found');
            }
            UserResource::collection($data);
        }

        return sendResponse($data, 200);
    }

    public function update(Request $request, $id = null)
    {

        info($request->all());

        $user = $this->model->find($id);
        if (!$user) {
            return sendResponse(null, 404, 'User not found');
        }

        $request->name ? $user->name = $request->name : null;
        $request->phone ? $user->phone = $request->phone : null;
        $request->description ? $user->description = $request->description : null;
        $request->last_seen_at ? $user->last_seen_at = $request->last_seen_at : null;
        $request->is_active ? $user->is_active = $request->is_active : null;
        $user->save();
        return sendResponse(new UserResource($user), 200, 'Your data has been updated');
    }

    public function updatePfp(Request $request){
        $user = $this->model->find(Auth::user()->id);

        Storage::delete('/public/profile_images/' . $user->image);
        $user->image = null;
        $user->save();

        if($request->file('image')){
            $imageName = storeImage($request->file('image'), '/profile_images/'); //store image to destination folder
            $user->image = $imageName;
            $user->save();
        }

        return sendResponse(new UserResource($user), 200, 'Your profile picture has been updated');

    }

}
