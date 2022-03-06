<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Budget;
use App\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        if (isset($request->type)) {
            if ($request->type === 'income' || $request->type === 'expense') {

                return view("budget.add", [
                    "title" => "Add " . ucwords($request->type),
                    "type" => ucwords($request->type),
                    "categories" => Category::where('type', $request->type)->where(function ($query) {
                        $query->where("categories.user_id", 1)
                            ->orWhere("categories.user_id", auth()->user()->id);
                    })->get(),
                    "unit" => auth()->user()->setting->budget_unit,
                ]);
            }
        }

        return abort(404);
    }
    public function save(Request $request)
    {
        $validator = validator($request->all(), [
            "category_id" => 'required',
            "type" => 'required',
            "amount" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $budget = new Budget();
            $budget->type = $request->type;
            $budget->remark = $request->remark;
            $budget->amount = $request->type === 'Income' ? number_format($request->amount, 2, ".", "") : number_format("-" . $request->amount, 2, ".", "");
            $budget->category_id = $request->category_id;
            $budget->user_id = auth()->user()->id;
            $budget->created_at = $request->date ?? date("Y-m-d h:m:s");
            $budget->save();

            return redirect()->route('home')->with('info', 'Budget added');
        } catch (QueryException $th) {
            return back()->with('error', 'Error in Adding Budget');
        }
    }
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "budget_id" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $budget = Budget::findOrFail($request->budget_id);

            $response = Gate::inspect('delete', $budget);

            if ($response->allowed()) {
                $countDeleted = $budget->delete();

                if ($countDeleted) {
                    return back()->with('info-deleted', "Deleted");
                }
            } else {
                return back()->with('error', $response->message());
            }
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Budget Not Found');
        } catch (QueryException $e) {
            return back()->with('error', 'Error in deleting Budget');
        }
    }
}
