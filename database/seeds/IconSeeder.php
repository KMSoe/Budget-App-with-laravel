<?php

use Illuminate\Database\Seeder;
use App\Icon;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $icon_classes = [
            "fas fa-utensils",
            "fas fa-home",
            "fas fa-glass-martini-alt",
            "fas fa-tshirt",
            "fas fa-shopping-cart",
            "fas fa-plane-departure",
            "fas fa-bus",
            "fas fa-graduation-cap",
            "fas fa-dollar-sign",
            "fas fa-file-invoice-dollar",
            "fas fa-first-aid",
            "fas fa-soap",
            "fas fa-dollar-sign",
            "fas fa-chalkboard-teacher",
            "fas fa-chart-area",
            "fab fa-get-pocket",
            "fab fa-sellcast",
        ];

        $icons_colors = [
            '#00ffff', '#f0ffff', '#f5f5dc', '#000000',
            '#0000ff', '#a52a2a', '#00ffff', '#00008b',
            '#008b8b', '#a9a9a9', '#006400', '#bdb76b',
            '#8b008b', '#556b2f', '#ff8c00', '#9932cc',
            '#8b0000', '#e9967a', '#9400d3', '#ff00ff',
            '#ffd700', '#008000', '#4b0082', '#f0e68c',
            '#add8e6', '#e0ffff', '#90ee90', '#d3d3d3',
            '#ffb6c1', '#ffffe0', '#00ff00', '#ff00ff',
            '#800000', '#000080', '#808000', '#ffa500',
            '#ffc0cb', '#800080', '#800080', '#ff0000',
            '#c0c0c0', '#ffffff', '#ffff00'
        ];
        $icons = [
            ["class" => "fas fa-utensils", "color" => "#e7ab3c"],
            ["class" => "fas fa-home", "color" => "#0068b2"],
            ["class" => "fas fa-glass-martini-alt", "color" => "#b7a8a3"],
            ["class" => "fas fa-tshirt", "color" => "#085719"],
            ["class" => "fas fa-shopping-cart", "color" => "#b63333"],
            ["class" => "fas fa-plane-departure", "color" => "#0fe73e"],
            ["class" => "fas fa-bus", "color" => "#d2f50a"],
            ["class" => "fas fa-graduation-cap", "color" => "#e7ab3c"],
            ["class" => "fas fa-dollar-sign", "color" => "#85bb65"],
            ["class" => "fas fa-file-invoice-dollar", "color" => "#4e575c"],
            ["class" => "fas fa-first-aid", "color" => "#e41809"],
            ["class" => "fas fa-soap", "color" => "#866b8d"],
            ["class" => "fas fa-dollar-sign", "color" => "#e33010"],
            ["class" => "fas fa-chalkboard-teacher", "color" => "#e7ab3c"],
            ["class" => "fas fa-chart-area", "color" => "#0dd427"],
            ["class" => "fab fa-get-pocket", "color" => "#3ce7e7"],
            ["class" => "fab fa-sellcast", "color" => "#e43a36"],
        ];
        // foreach ($icon_classes as $key => $value) {
        //     Icon::create(["class" => $value, "color" => $icons_colors[$key]]);
        // }

        foreach ($icons as $icon) {
            Icon::create($icon);
        }

    }
}
