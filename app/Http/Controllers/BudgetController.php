<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Budget;
use App\Category;
use Illuminate\Support\Facades\Date;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add()
    {
        if (isset($_GET["type"])) {
            if ($_GET['type'] === 'income' || $_GET['type'] === 'expense') {

                return view("budget.add", [
                    "title" => "Add " . ucwords($_GET['type']), 
                    "type" => ucwords($_GET['type']),
                    "categories" => Category::where('type', $_GET['type'])->where(function ($query) {
                        $query->where("categories.user_id", 1)
                            ->orWhere("categories.user_id", auth()->user()->id);
                    })->get(),
                    "unit" => auth()->user()->setting->budget_unit,
                ]);
            }
        }

        return abort(404);
    }
    public function save()
    {

        $validator = validator(request()->all(), [
            "category_id" => 'required',
            "type" => 'required',
            "amount" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $budget = new Budget();
        $budget->type = request()->type;
        $budget->remark = request()->remark;
        $budget->amount = request()->type === 'Income' ? number_format(request()->amount, 2, ".", "") : number_format("-" . request()->amount, 2, ".", "");
        $budget->category_id = request()->category_id;
        $budget->user_id = auth()->user()->id;
        $budget->created_at = request()->date ?? date("Y-m-d h:m:s");
        $budget->save();

        return redirect()->route('home')->with('info', 'Budget added');
    }
    public function delete()
    {
        $validator = validator(request()->all(), [
            "budget_id" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $budget = Budget::find(request()->budget_id);
        $response = Gate::inspect('delete', $budget);

        if ($response->allowed()) {
            $budget->delete();
            return back()->with('info', "Deleted");
        } 
        return back()->with('error', $response->message());
    }
}
