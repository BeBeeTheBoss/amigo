<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(protected User $model) {}

    public function getUsers()
    {

        return $this->model->get();
    }

    public function register(UserRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = $this->model->create($this->toArray($request));

            $user = $this->model->find($user->id);
            Auth::login($user);

            $token = $user->createToken('Amigo_Token')->plainTextToken;

            if ($request->file('image')) {
                $imageName = storeImage($request->file('image'), '/profile_images/'); //store image to destination folder
                $user->image = $imageName;
                $user->save();
            }

            $user->image = url('storage/profile_images/' . $user->image);
            $user->default_image_path = url('images/default_profile.png');

            $data = [
                'user' => $user,
                'token' => $token
            ];

            DB::commit();

            return sendResponse($data, 201, "Sign up completed! Have fun with your amigos");
        } catch (\Throwable $th) {

            DB::rollBack();
            return sendResponse(null, 500, $th->getMessage());
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        $user = $this->model->where('phone', $request->phone)->first();
        if (!$user) {
            return sendResponse(null, 404, "This phone number is not registered yet");
        }

        if (!Hash::check($request->password, $user->password)) {
            return sendResponse(null, 401, "The password you entered is incorrect");
        }

        Auth::login($user);
        $token = $user->createToken('Amigo_Token')->plainTextToken;

        $user->image = url('storage/profile_images/' . $user->image);
        $user->default_image_path = url('images/default_profile.png');

        $data = [
            'user' => $user,
            'token' => $token
        ];

        return sendResponse($data, 200, "Login success! Welcome back from amigo");
    }

    public function logout()
    {
        if (Auth::user()) {

            try {
                Auth::logout();
            } catch (\Throwable $th) {
                return sendResponse(null, 500, "Logout failed!");
            }

            return sendResponse(null, 200, "Logout success! Promise me that you come back to amigo");
        }

        return sendResponse(null, 404, "Already logged out");
    }

    private function toArray($request)
    {
        return [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'default_image_path' => 'default_profile.png' //set default profile image which is located on public/images folder
        ];
    }
}
