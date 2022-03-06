<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use stdClass;

class Budget extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    static function getBrief($month, $year)
    {
        [$total_income, $total_expense, $net_budget, $percentage] = Budget::calculateTotalBudget(true, $month, $year);

        return [
            "year" => $year,
            "month" => trans(Carbon::create(0, $month, 1)->shortMonthName),
            "income" => $total_income,
            "expense" => abs($total_expense),
            "net_budget" => $net_budget,
            "percentage" => $percentage,
        ];
    }

    static function getBudgetByMonth($month, $year)
    {
        [$total_income, $total_expense, $net_budget, $percentage] = Budget::calculateTotalBudget(true, $month, $year);

        $dailyBudgets = Budget::where('user_id', auth()->user()->id)->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->select(DB::raw('SUM(amount) AS amount'), DB::raw('DATE(created_at) AS date'))->groupBy('date')->orderBy('date', 'DESC')->get();

        $daily_cards = [];
        $len = count($dailyBudgets);

        for ($i = 0; $i < $len; $i++) {
            $dailyBudget = new stdClass();

            $dailyBudget->day = trans(Carbon::create($dailyBudgets[$i]->date)->format('M')) . " " . Carbon::create($dailyBudgets[$i]->date)->format('d');
            $dailyBudget->income = Budget::where('type', 'Income')->where(DB::raw('DATE(created_at)'), $dailyBudgets[$i]->date)->where('user_id', auth()->user()->id)->sum('amount');
            $dailyBudget->expense = Budget::where('type', 'Expense')->where(DB::raw('DATE(created_at)'), $dailyBudgets[$i]->date)->where('user_id', auth()->user()->id)->sum('amount');;
            $dailyBudget->net_budget = $dailyBudgets[$i]->amount;
            $dailyBudget->percentage = $total_income == 0 ? 100 : number_format(abs($dailyBudget->expense / $total_income) * 100, 2, ".", ",");
            $dailyBudget->items = Budget::join('categories', 'budgets.category_id', '=', 'categories.id')->where("budgets.user_id", auth()->user()->id)->where(DB::raw('DATE(budgets.created_at)'), $dailyBudgets[$i]->date)->select('budgets.*', 'categories.name AS name', 'categories.icon_id')->join('icons', 'categories.icon_id', '=', 'icons.id')->select('budgets.*', 'categories.name AS name', 'categories.icon_id', 'icons.color', 'icons.class')->orderBy('budgets.created_at', 'DESC')->get();

            $daily_cards[] = $dailyBudget;
        }
        return $daily_cards;
    }

    static function getBudgetDetailByMonth($type, $month, $year)
    {
        [$total_income, $total_expense, $net_budget, $percentage] = Budget::calculateTotalBudget(true, $month, $year);

        if ($type === 'Income') {
            [$details, $category_names, $percentages, $category_colors] = Budget::getBudgetDetails($type, $month, $year, $total_income);

            return  [$details, $category_names, $percentages, $category_colors];
        } elseif ($type === 'Expense') {
            [$details, $category_names, $percentages, $category_colors] = Budget::getBudgetDetails($type, $month, $year, $total_expense);

            return  [$details, $category_names, $percentages, $category_colors];
        }
    }

    static function getBudgetDetails($type, $month, $year, $total_amount)
    {
        $budgetDetails = Budget::join('categories', 'budgets.category_id', '=', 'categories.id')->where('budgets.type', $type)->where("budgets.user_id", auth()->user()->id)->whereRaw('extract(month from budgets.created_at) = ?', [$month])->whereRaw('extract(year from budgets.created_at) = ?', [$year])->select(DB::raw('SUM(budgets.amount) AS amount'), 'budgets.category_id')->groupBy('budgets.category_id')->get();

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

    static function calculateTotalBudget($onlyMonth = true, $month = null, $year)
    {
        $total_income = $total_expense = $net_budget = $percentage = 0;

        if ($onlyMonth) {
            $total_income = Budget::where('type', 'Income')->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
            $total_expense = Budget::where('type', 'Expense')->whereRaw('extract(month from created_at) = ?', [$month])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        } else {
            $total_income = Budget::where('type', 'Income')->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
            $total_expense = Budget::where('type', 'Expense')->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
        }

        $net_budget = $total_income + $total_expense;
        $percentage = $net_budget <= 0 ? 100 : number_format((abs($total_expense) / abs($total_income) * 100), 2, ".");

        return [$total_income, $total_expense, $net_budget, $percentage];
    }

    static function getBudgetTableByYear($year, $month = 12)
    {
        $yearly_result = [];
        $brief = new stdClass();
        $brief->year = $year;
        [$brief->income, $brief->expense, $brief->net_budget, $brief->percentage] = Budget::calculateTotalBudget(false, $month, $year);

        $yearly_result[] = $brief;

        $monthly_results = [];

        $stat = new stdClass();
        $stat->months = [];
        $stat->incomes = [];
        $stat->expenses = [];

        for ($i = 1; $i <= $month; $i++) {
            $income_amount = $expense_amount = 0;
            $income_amount = Budget::where('type', 'Income')->whereRaw('extract(month from created_at) = ?', [$i])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');
            $expense_amount = Budget::where('type', 'Expense')->whereRaw('extract(month from created_at) = ?', [$i])->whereRaw('extract(year from created_at) = ?', [$year])->where('user_id', auth()->user()->id)->sum('amount');

            $res = new stdClass();
            $res->month = $stat->months[] = Carbon::create(0, $i + 1, 0, 0, 0, 0)->format('M');
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
