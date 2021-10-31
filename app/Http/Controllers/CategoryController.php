<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Icon;
use App\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;
use stdClass;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $admin__income_categories = Category::join('icons', 'categories.icon_id', '=', 'icons.id')->where("categories.user_id", 1)->where('type', 'Income')->select('categories.*', 'icons.color', 'icons.class')->get();
        $admin__expense_categories = Category::join('icons', 'categories.icon_id', '=', 'icons.id')->where("categories.user_id", 1)->where('type', 'Expense')->select('categories.*', 'icons.color', 'icons.class')->get();

        $user_income_categories = Category::join('icons', 'categories.icon_id', '=', 'icons.id')->where("categories.user_id", auth()->user()->id)->where('type', 'Expense')->select('categories.*', 'icons.color', 'icons.class')->get();
        $user_expense_categories = Category::join('icons', 'categories.icon_id', '=', 'icons.id')->where("categories.user_id", auth()->user()->id)->where('type', 'Expense')->select('categories.*', 'icons.color', 'icons.class')->get();

        if (auth()->user()->role->value === 2) {
            $income_categories = $admin__income_categories;
            $expense_categories = $admin__expense_categories;
        } else {
            $income_categories = [...$admin__income_categories, ...$user_income_categories];
            $expense_categories = [...$admin__expense_categories, ...$user_expense_categories];
        }

        return view('categories.index', [
            "title" => 'Categories',
            "income_categories" => $income_categories,
            "expense_categories" => $expense_categories,
        ]);
    }
    public function create()
    {
        if (isset($_GET["type"])) {
            if ($_GET['type'] === 'income' || $_GET['type'] === 'expense') {
                $icons = Icon::whereNotIn("id", Category::where("user_id", 1)->orWhere("user_id", auth()->user()->id)->select('icon_id'))->get();

                $first_icon = new stdClass();
                $first_icon->id = 9;
                $first_icon->class = "fas fa-dollar-sign";
                $first_icon->color = "#85bb65";

                return view("categories.add", [
                    "title" => 'Add '. ucwords($_GET['type']) . 'Category',
                    "type" => ucwords($_GET['type']),
                    "icons" => $icons,
                    "first_icon" => $icons[0] ?? $first_icon,
                ]);
            }
        }

        return abort(404);
    }
    public function store()
    {
        $validator = validator(request()->all(), [
            "icon_id" => 'required',
            "type" => 'required',
            "name" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $category = new Category();
        $category->name = request()->name;
        $category->type = ucfirst(request()->type);
        $category->icon_id = request()->icon_id;
        $category->user_id = auth()->user()->id;
        $category->save();

        return redirect()->route('categories.index')->with('info', 'Budget added');
    }

    public function destroy()
    {
        $validator = validator(request()->all(), [
            "category_id" => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $category = Category::find(request()->category_id);
        $response = Gate::inspect('delete', $category);

        if ($response->allowed()) {
            $category->delete();
            return back()->with('info', "Deleted");
        }
        return back()->with('error', $response->message());
    }
}
