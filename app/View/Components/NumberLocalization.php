<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NumberLocalization extends Component
{
    public $num;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($num)
    {
        $this->num = $num;

        if (app()->getLocale() === 'mm') {
            $en_nums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            $mm_nums = ["၀", "၁", "၂", "၃", "၄", "၅", "၆", "၇", "၈", "၉"];
            $this->num = str_replace($en_nums, $mm_nums, $this->num);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.format.number.localization');
    }
}
