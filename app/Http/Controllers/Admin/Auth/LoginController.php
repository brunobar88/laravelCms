<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::PAINEL;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $data = $request->only(['email', 'password']);
        $remenber = $request->only('remember', false);

        $validator = $this->validator($data);

        if($validator->fails()) {
            return redirect(route('login'))->withErrors($validator)->withInput();
        }

        if(Auth::attempt($data, $remenber)) {
            return redirect(route('admin'));
        } else {
            $validator->errors()->add('password', 'os campos não estão preenchidos de forma correta');
            return redirect(route('login'))->withInput()->withErrors($validator);
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('login'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'max:100', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);
    }
}
