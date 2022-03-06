<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting');
    }

    public function updateLanguage()
    {
        $validator = validator(request()->all(), [
            'language' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json([
                "success" => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $user = auth()->user();
        $user->setting->language = request()->language;
        $result = $user->setting->save();

        if(!$result) {
            return Response::json([
                "success" => false,
                "errors" => ['Error on Updading Language'],
            ], 500);
        }

        return Response::json([
            "success" => true,
            "language" => $user->setting->language,
        ], 200);
    }

    public function updateUnit(){
        $validator = validator(request()->all(), [
            'unit' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json([
                "success" => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 200);
        }

        $user = auth()->user();
        $user->setting->budget_unit = request()->unit;
        $result = $user->setting->save();

        if(!$result) {
            return Response::json([
                "success" => false,
                "errors" => ['Error on Updading Unit'],
            ], 500);
        }

        return Response::json([
            "success" => true,
            "unit" => $user->setting->budget_unit,
        ], 200);
    }
}
