<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MoneyFormat extends Component
{
    public $num;
    public $unit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($num)
    {
        $num = number_format($num, 2, '.', ',');

        if (app()->getLocale() === 'mm') {
            $en_nums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            $mm_nums = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉"];
            $num = str_replace($en_nums, $mm_nums, $num);
        }

        $this->num = $num;
        $this->unit = auth()->user()->setting->budget_unit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.format.money');
    }
}
