<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PDOException;
use stdClass;

class Budget extends Model
{
    static function getBudgetDetails($type, $month, $year, $total_amount)
    {
        $budgetDetails = self::join('categories', 'budgets.category_id', '=', 'categories.id')->where('budgets.type', $type)->where("budgets.user_id", auth()->user()->id)->whereRaw('extract(month from budgets.created_at) = ?', [$month])->whereRaw('extract(year from budgets.created_at) = ?', [$year])->select(DB::raw('SUM(budgets.amount) AS amount'), 'budgets.category_id')->groupBy('budgets.category_id')->get();

        $category_names = $category_amount_percentages = $category_colors = [];

        if (abs($total_amount) > 0) {
            foreach ($budgetDetails as $budget) {
                $category_names[] = $budget->categoryName = trans(Category::find($budget->category_id)->name);
                $category_colors[] = $budget->iconColor = Icon::find(Category::find($budget->category_id)->icon_id)->color;
                $category_amount_percentages[] = $budget->percentage = number_format(abs(($budget->amount / $total_amount) * 100), 2, '.', '');
            };
        } else {
            $category_names[] = trans("No $type");
            $category_amount_percentages[] = 100;
            $category_colors[] = "gray";
        }

        return [$budgetDetails, $category_names, $category_amount_percentages, $category_colors];
    }
    static function getBudgetTableByYear($year, $month = 12)
    {
        $yearly_result = [];
        $brief = new stdClass();
        $brief->year = $year;
        $brief->income = self::where('type', 'Income')->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        $brief->expense = self::where('type', 'Expense')->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        $brief->net_budget = self::whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        $brief->percentage = number_format($brief->net_budget <= 0 ? 100 : abs(($brief->expense / $brief->income) * 100), 2, '.', ',');
        $yearly_result[] = $brief;

        $monthly_results = [];

        $stat = new stdClass();
        $stat->months = [];
        $stat->incomes = [];
        $stat->expenses = [];

        for ($i = 1; $i <= $month; $i++) {
            $income_amount = $expense_amount = 0;
            $income_amount = self::where('type', 'Income')->whereRaw('extract(month from created_at) = ?', [$i])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
            $expense_amount = self::where('type', 'Expense')->whereRaw('extract(month from created_at) = ?', [$i])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');

            $res = new stdClass();
            $res->month = $stat->months[] = trans(date('M', mktime(0, 0, 0, $i, 10)));
            $res->income = $stat->incomes[] = $income_amount;
            $res->expense =  $expense_amount;
            $stat->expenses[] = abs($expense_amount);
            $res->net_budget =  $income_amount + $expense_amount;

            $monthly_results[] = $res;
        }
        $yearly_result[] = $monthly_results;
        $yearly_result[] = $stat;

        return $yearly_result;
    }
}
