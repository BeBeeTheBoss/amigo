<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            ->get();

        if (!$data || count($data)==0) {
            return sendResponse(null, 404, 'User not found');
        }

        return sendResponse($data, 200);
    }

    public function update(Request $request, $id = null)
    {

        $user = $this->model->find($id);
        if (!$user) {
            return sendResponse(null, 404, 'User not found');
        }

        $request->name ? $user->name = $request->name : null;
        $request->phone ? $user->phone = $request->phone : null;
        $request->description ? $user->description = $request->description : null;
        $request->last_seen_at ? $user->last_seen_at = $request->last_seen_at : null;
        $request->is_active ? $user->is_active = $request->is_active : null;

        if ($request->image) {
            Storage::delete('/profile_images/' . $user->image);
            $user->image = null;
            if ($request->file('image')) {
                $imageName = storeImage($request->file('image'), '/profile_images/'); //store image to destination folder
                $user->image = $imageName;
            }
        }

        $user->save();
        return sendResponse($user, 200, 'Your data has been updated');
    }
}
