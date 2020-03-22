<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $arrSettings = [];

        $allSettings = Setting::all();
        
        foreach($allSettings as $setting) {
            $arrSettings[ $setting->name ] = $setting->content;
        }

        return view('admin.settings.index', ['settings' => $arrSettings]);
    }

    public function configSave(Request $request)
    {
        $data = $request->only(['title', 'subTitle', 'email', 'bgColor', 'textColor']);

        $validator = $this->validateSettings($data);

        if($validator->fails()) {
            return redirect(route('settings'))->withErrors($validator);
        }

        foreach($data as $chave => $valor) {
            Setting::where('name', $chave)->update(['content' => $valor]);
        }

        return redirect(route('settings'))->with('warning', 'configurações salvas com sucesso');
    }

    public function validateSettings(array $data) 
    {
        return Validator::make($data, [
            'title'     => ['string', 'max:100'],
            'subTitle'  => ['string', 'max:100'],
            'email'     => ['string', 'email'],
            'bgColor'   => ['string', 'regex:/#[A-Za-z0-9]{6}/'],
            'textColor' => ['string', 'regex:/#[A-Za-z0-9]{6}/'],
        ]);
    }
}
