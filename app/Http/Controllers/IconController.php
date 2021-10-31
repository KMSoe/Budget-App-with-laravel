<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Icon;

class IconController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    public function index()
    {
        $icons = Icon::all();

        return view('icons.index', [
            "title" => 'Icons',
            'icons_count' => count($icons),
            'icons' => $icons,
        ]);
    }
    public function create()
    {
        return view('icons.add', [
            "title" => 'Add Icon',
        ]);
    }
    public function store()
    {
        $validator = validator(request()->all(), [
            'class' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $icon = new Icon();
        $icon->class = request()->class;
        $icon->color = request()->color;
        $icon->save();

        return redirect()->route('icons.index')->with('info', 'Icon added');
    }
    public function edit()
    {
        $icon = Icon::find(request()->id);

        if(!$icon){
            return back()->with('info', 'Invalid Icon Id');
        }
        return view('icons.edit', [
            "title" => 'Edit Icon',
            "icon" => $icon,
        ]); 
    }
    public function update()
    {
        $validator = validator(request()->all(), [
            'id' => 'required',
            'class' => 'required',
            'color' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $icon = Icon::find(request()->id);
        $icon->class = request()->class;
        $icon->color = request()->color;
        $icon->save();

        return redirect()->route('icons.index')->with('info', 'Icon Updated');
    }
}
