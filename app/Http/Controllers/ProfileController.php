<?php

namespace App\Http\Controllers;

use App\Budget;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use stdClass;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $time = Carbon::now();

        $user_start_year = Budget::where('user_id', auth()->user()->id)->min(DB::raw('YEAR(created_at)')) ?? $time->year;

        $current_year = $time->year;

        $results = [];

        for ($i = $current_year; $i >= $user_start_year; $i--) {
            $results[] = Budget::getBudgetTableByYear($i);
        }

        return view('profile', [
            "title" => 'Profile',
            "results" => $results,
        ]);
    }
    public function upload(Request $request)
    {
        $validator = validator(request()->all(), [
            'photo' => 'required | image | mimes:jpeg,bmp,png,jpg',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $user = User::find(auth()->user()->id);

        if (!$user) {
            return back()->with("error", "Invalid");
        }

        if ($request->hasFile('photo')) {
            if ($user->profile && $user->profile !== "avatar.svg") {
                if (Storage::disk('public')->exists('profiles/' . $user->profile)) {
                    Storage::disk('public')->delete('profiles/' . $user->profile);
                }
            }
            $imagePath = $request->file('photo');
            $imageName = ucwords(explode(" ", $user->name)[0]) . $user->id . time() . "." . $imagePath->extension();

            $path = $request->file('photo')->storeAs('profiles', $imageName, 'public');

            $affected = DB::table("users")
                ->where("id", $user->id)
                ->update(["profile" => $imageName]);

            if (!$affected) {
                return back()->with("error", "Error");
            }
        }

        return redirect()->route('profile')->with('info', "Profile Picture uploaded.");
    }
}
