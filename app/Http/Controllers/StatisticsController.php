<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Budget;
use App\Category;
use App\Icon;
use Carbon\Carbon;
use stdClass;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $time = Carbon::now();
        $year = $month = null;

        if (isset($request->year)) {
            $year = $request->year;
            if ($year < $time->year || $year > $time->year) {
                $month = 12;
            } else {
                $month = $time->month;
            }
        } else {
            $year = $time->year;
            $month = $time->month;
        }

        $yearly_result_table = Budget::getBudgetTableByYear($year, $month);

        [$incomeDetails, $income_category_names, $income_category_amount_percentages, $income_category_colors] = Budget::getBudgetDetails("Income", $month, $year, $yearly_result_table[0]->income);

        [$expenseDetails, $expense_category_names, $expense_category_amount_percentages, $expense_category_colors] = Budget::getBudgetDetails("Expense", $month, $year, $yearly_result_table[0]->expense);

        return view('statistics', [
            "title" => 'Statistics',
            "year" => $year,
            "yearly_result_table" => $yearly_result_table,
            "income_details" => $incomeDetails,
            "expense_details" => $expenseDetails,
            "income_graph_data" => [$income_category_names, $income_category_amount_percentages, $income_category_colors],
            "expense_graph_data" => [$expense_category_names, $expense_category_amount_percentages, $expense_category_colors],
        ]);
    }
}
