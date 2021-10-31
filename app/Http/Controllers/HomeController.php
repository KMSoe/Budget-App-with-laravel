<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Budget;
use App\Category;
use App\Icon;
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
    public function __invoke()
    {
        $months = ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        if (isset($_GET["time"])) {
            $request_time = explode(" ", $_GET["time"]);
            if (count($request_time) !== 2) {
                return redirect("/")->with("error", "Invalid Request");
            } elseif (in_array($request_time[0], $months) && intval($request_time[1])) {
                $month = array_search($request_time[0], $months) + 1;
                $year = $request_time[1];
            } else {
                return redirect("/")->with("error", "Invalid Request");
            }
        } else {
            $year = date("Y");
            $month = date("m");
        }
    
        $income_amount = $expense_amount = $net_budget = 0;

        $income_amount = Budget::where('type', 'Income')->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        $expense_amount = Budget::where('type', 'Expense')->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        $net_budget = $income_amount + $expense_amount;
        $percentage = $net_budget <= 0 ? 100 : number_format((abs($expense_amount) / abs($income_amount) * 100), 2, ".");

        $total_values = [
            "year" => $year,
            "month" => trans(date('M', mktime(0, 0, 0, intval($month), 10))),
            "income" => $income_amount,
            "expense" => abs($expense_amount),
            "net_budget" => $net_budget,
            "percentage" => $percentage,
        ];

        $dailyBudgets = Budget::where('user_id', auth()->user()->id)->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->select(DB::raw('SUM(amount) AS amount'), DB::raw('DATE(created_at) AS date'))->groupBy('date')->orderBy('date', 'DESC')->get();

        $daily_cards = [];
        $len = count($dailyBudgets);

        for ($i = 0; $i < $len; $i++) {
            $income = Budget::where('type', 'Income')->where(DB::raw('DATE(created_at)'), $dailyBudgets[$i]->date)->where('user_id', auth()->user()->id)->sum('amount');
            $expense = Budget::where('type', 'Expense')->where(DB::raw('DATE(created_at)'), $dailyBudgets[$i]->date)->where('user_id', auth()->user()->id)->sum('amount');

            $dailyBudget = new stdClass();

            $day = date("M d", strtotime($dailyBudgets[$i]->date));
            $dailyBudget->day = trans(date("M", strtotime($dailyBudgets[$i]->date))) . " " . date("d", strtotime($dailyBudgets[$i]->date)) ;
            $dailyBudget->income = $income;
            $dailyBudget->expense = $expense;
            $dailyBudget->net_budget = $dailyBudgets[$i]->amount;
            $dailyBudget->percentage = $income_amount == 0 ? 100 : number_format(abs($expense / $income_amount) * 100, 2, ".", ",");
            $dailyBudget->items = Budget::join('categories', 'budgets.category_id', '=', 'categories.id')->where("budgets.user_id", auth()->user()->id)->where(DB::raw('DATE(budgets.created_at)'), $dailyBudgets[$i]->date)->select('budgets.*', 'categories.name AS name')->orderBy('created_at', 'DESC')->get();

            $budgetCount = count($dailyBudget->items);
            for ($j = 0; $j < $budgetCount; $j++) {
                $dailyBudget->items[$j]->icon = Category::join('icons', 'categories.icon_id', '=', 'icons.id')->where('categories.id', $dailyBudget->items[$j]->category_id)->select('categories.icon_id', 'icons.class', 'icons.color')->first();

                $dailyBudget->items[$j]->amount = $dailyBudget->items[$j]->amount;
            }
            $daily_cards[] = $dailyBudget;
        }

        [$incomeDetails, $income_category_names, $income_category_amount_percentages, $income_category_colors] = Budget::getBudgetDetails("Income", $month, $year, $income_amount);

        [$expenseDetails, $expense_category_names, $expense_category_amount_percentages, $expense_category_colors] = Budget::getBudgetDetails("Expense", $month, $year, $expense_amount);
 
        return view("home", [
            "title" => "Home",
            "total" => $total_values,
            "daily_budgets" => $daily_cards,
            "income_details" => $incomeDetails,
            "expense_details" => $expenseDetails,
            "income_graph_data" => [$income_category_names, $income_category_amount_percentages, $income_category_colors],
            "expense_graph_data" => [$expense_category_names, $expense_category_amount_percentages, $expense_category_colors],
        ]);
    }
}
