<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Budget;
use App\Category;
use App\Icon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function __invoke(Request $request)
    {
        $time = Carbon::now();

        $validator = Validator::make($request->all(), [
            "month" => 'in:1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12',
        ], ['month.in' => 'Invalid Month!!!'], []);

        if ($validator->fails()) {
            return redirect("/")->with("error", $validator->errors());
        }

        $month = $request->month ?? $time->month;
        $year = $request->year ?? $time->year;

        $total_values = Budget::getBrief($month, $year);

        [$incomeDetails, $income_category_names, $income_category_amount_percentages, $income_category_colors] = Budget::getBudgetDetailByMonth("Income", $month, $year);
        
        [$expenseDetails, $expense_category_names, $expense_category_amount_percentages, $expense_category_colors] = Budget::getBudgetDetailByMonth("Expense", $month, $year);

        return view("home", [
            "title" => "Home",
            "total" => $total_values,
            "daily_budgets" => Budget::getBudgetByMonth($month, $year),
            "income_details" => $incomeDetails,
            "expense_details" => $expenseDetails,
            "income_graph_data" => [$income_category_names, $income_category_amount_percentages, $income_category_colors],
            "expense_graph_data" => [$expense_category_names, $expense_category_amount_percentages, $expense_category_colors],
        ]);
    }
}
