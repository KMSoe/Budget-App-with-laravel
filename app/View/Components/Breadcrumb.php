<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $link;
    public $isActive;
    public $currentPage;
    public $iconClass;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $isActive, $currentPage, $iconClass)
    {
        $this->link = $link;
        $this->isActive = $isActive;
        $this->currentPage = $currentPage;
        $this->iconClass = $iconClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
