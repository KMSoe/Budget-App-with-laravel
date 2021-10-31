<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ["name" => "Salary", "type" => "Income", "icon_id" => 9, "user_id" => 1],
            ["name" => "Dividends", "type" => "Income", "icon_id" => 15, "user_id" => 1],
            ["name" => "Part-time Job", "type" => "Income", "icon_id" => 14, "user_id" => 1],
            ["name" => "Pocket-money", "type" => "Income", "icon_id" => 16, "user_id" => 1],
            ["name" => "Sell", "type" => "Income", "icon_id" => 17, "user_id" => 1],
            ["name" => "Food", "type" => "Expense", "icon_id" => 1, "user_id" => 1],
            ["name" => "Home & Hostel Fee", "type" => "Expense", "icon_id" => 2, "user_id" => 1],
            ["name" => "Drink", "type" => "Expense", "icon_id" => 3, "user_id" => 1],
            ["name" => "Clothing", "type" => "Expense", "icon_id" => 4, "user_id" => 1],
            ["name" => "Shopping", "type" => "Expense", "icon_id" => 5, "user_id" => 1],
            ["name" => "Travel", "type" => "Expense", "icon_id" => 6, "user_id" => 1],
            ["name" => "Transportation", "type" => "Expense", "icon_id" => 7, "user_id" => 1],
            ["name" => "Education", "type" => "Expense", "icon_id" => 8, "user_id" => 1],
            ["name" => "Health", "type" => "Expense", "icon_id" => 11, "user_id" => 1],
            ["name" => "Beauty", "type" => "Expense", "icon_id" => 12, "user_id" => 1],
            ["name" => "Tax", "type" => "Expense", "icon_id" => 10, "user_id" => 1],
            // ["name" => "Bill", "type" => "Expense", "icon_id" => 13, "user_id" => 1],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
