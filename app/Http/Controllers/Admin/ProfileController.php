<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::find(Auth::id());
        if($user) {
            return view('admin.profile.index', ['user' => $user]);
        }

        return  redirect(route('admin'));
    }

    public function save(Request $request)
    {
        $user = User::find(Auth::id());

        if($user) {
            $data = $request->only(['name', 'email', 'password', 'password_confirmation']);

            $validator = $this->ValidadorEdit(['name' => $data['name'],'email' => $data['email']]);

            $user->name = $data['name'];

            if($user->email != $data['email']) {
                $hasEmail = User::where('email', $data['email'])->get();
                if(count($hasEmail) === 0) {
                    $user->email = $data['email'];
                } else {
                    $validator->errors()->add('email', __('validation.unique', ['attribute' => 'email',]));
                }
            }

            if(!empty($data['password'])) {
                if(strlen($data['password']) >= 4) {
                    if($data['password'] === $data['password_confirmation']) {
                        $user->password = Hash::make($data['password']);
                    } else {
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password',
                        ]));
                    }
                } else {
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 4,
                    ]));
                }
            }
            if(count($validator->errors()) > 0){
                return redirect(route('profile', ['user' => Auth::id()]))->withErrors($validator);
            }
            $user->save();

            return redirect(route('profile'))->with('warning', 'seu usuario foi alterado com exito');
        }

        return redirect(route('profile'));
    }

    public function ValidadorEdit(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200'],
        ]);
    }
}
