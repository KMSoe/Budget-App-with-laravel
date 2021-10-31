<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Budget;
use App\Category;
use App\Icon;
use stdClass;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    private $months = ["Jan", "Feb", "Mar", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    public function index()
    {
        if (isset(request()->year)) {
            $year = request()->year;
            if ($year < date("Y")) {
                $month = 12;
            } else {
                $month = date("m");
            }
        } else {
            $year = date("Y");
            $month = date("m");
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
