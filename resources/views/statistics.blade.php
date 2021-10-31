@extends('layouts.app')
<style>
    .ui-datepicker-calendar,
    .ui-datepicker-month {
        display: none;
    }
</style>
@section('content')
@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif

<x-breadcrumb link="{{ route('statistics') }}" is-active=1 current-page='Statistics' icon-class='fas fa-chart-line' >
</x-breadcrumb>
<!-- income-expense-yearly Section Start -->
<section class="income-expense-yearly-section py-3 px-1 px-lg-3 px-xl-4">
    <div class="mb-4">
        <button class="btn select-btn bg-active text-white d-inline-block py-1 px-3 mb-4" id="pick-year-btn">
            <i class="fas fa-calendar-alt me-2"></i>
            <span id="current-year" class="font-weight-bold"><x-number-localization num="{{ $year }}" /></span>
        </button>
        <input type="hidden" id="year" autocomplete="off" onchange="changeYear()">
        <h3 class="mb-4">{{ __('Monthly Financial Graph') }}</h3>
        <canvas id="income-expense-multi-line" style="height: 300px;"></canvas>
    </div>
    <div class="row py-3">
        <div class="col-12 col-xl-6 mb-5">
            <h5 class="mb-4">{{ __('Yearly Finances in Table') }}</h5>
            <table class="table table-bordered text-center" id="income-expense-table">
                <thead class="text-white">
                    <tr class="thead-dark">
                        <th class="border-secondary">{{ __('Month') }}</th>
                        <th class="border-secondary">{{ __('Income') }}</th>
                        <th class="border-secondary">{{ __('Expense') }}</th>
                        <th class="border-secondary">{{ __('Balance') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($yearly_result_table[1] as $res)
                    <tr class="font-weight-bold">
                        <td class="text-active">{{ __($res->month) }}</td>
                        <td class="plus">{{ $res->income > 0 ? "+" : "" }} <x-money-format num="{{ $res->income }}" /></td>
                        <td class="minus"><x-money-format num="{{ $res->expense }}" /></td>
                        <td class="{{ $res->net_budget >= 0 ? 'plus' : 'minus' }}">{{ $res->net_budget > 0 ? "+" : "" }} <x-money-format num="{{ $res->net_budget }}" /></td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot class="font-weight-bold">
                    <tr>
                        <td class="text-white">{{ __('Total') }}</td>
                        <td class="plus">+ <x-money-format num="{{ $yearly_result_table[0]->income }}" /></td>
                        <td class="minus"> <x-money-format num="{{ $yearly_result_table[0]->expense }}" /></td>
                        <td class="{{ $yearly_result_table[0]->net_budget >= 0 ? 'plus' : 'minus' }}">{{ $yearly_result_table[0]->net_budget >= 0 ? "+" : "" }} <x-money-format num="{{ $yearly_result_table[0]->net_budget }}" /></td>
                    </tr>
                </tfoot>
                </tfoot>
            </table>
        </div>
        <div class="col-12 col-xl-6 my-auto">
            <div class="total-income-expenses-graph-container row">
                <h5 class="text-center mb-4">{{ __('Financial Progress Bar') }}</h5>
                <div class="col-md-12 col-xl-12 d-flex flex-column justify-content-center align-items-center">
                    <div class="total-income-amount progress mb-4 mt-2" style="height: 25px">
                        <div class="total-expense-amount progress-bar bg-minus" style="width: <?= htmlspecialchars($yearly_result_table[0]->percentage) ?>%;"></div>
                    </div>
                    <div class="text-center text-md-start text-xl-center">
                        @if ($yearly_result_table[0]->income == 0 && $yearly_result_table[0]->expense == 0)
                        <p>{{ __('You have No Income, Expense.') }}</p>
                        @elseif ($yearly_result_table[0]->income == 0)
                        <p>{{ __('You have No Income.') }}</p>
                        @else
                        <p class="font-weight-bold"><i class="fas fa-chart-line me-2"></i>
                            <x-number-localization num='{{ __("You have spent :Percentage% of your Income in :Year.", ["percentage" => $yearly_result_table[0]->percentage, "year" => $year]) }}' />
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- income-expense-yearly Section End -->
<!-- Income Expense Category graph- Section Start -->
<section class="income-expense-category-pie-graph-section">
    <div class="row">
        <div class="col-12 my-3 pt-5 pb-3 ps-2 sticky-top bg-main" style="z-index: 1;">
            <h4 class="mb-3">{{ __('Financial Amount Detail on Category') }}</h4>
            <div class="swip-nav d-md-none d-flex justify-content-flex-start mt-4 mt-md-5 mb-md-3">
                <a class="income-category-pie-nav active btn select-btn text-white me-3 py-1 px-3">
                    <i class="fas fa-check me-2"></i>{{ __('Income') }}
                </a>
                <a class="expense-category-pie-nav btn select-btn text-white me-3 py-1 px-3">
                    <i class="fas fa-check me-2"></i>{{ __('Expense') }}
                </a>
            </div>
        </div>

        <div class="col-12 col-md-6 income-category-pie-container ">
            <h5 class="mb-4 text-center text-md-start">{{ __('Income amount on Category') }}</h5>
            <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                <canvas id="income-category-pie"></canvas>
            </div>
            <div class="mt-4">
                @if ($yearly_result_table[0]->income > 0)
                <p class="text-center mx-auto">{{ __('Total Income') }}: <x-money-format num="{{ $yearly_result_table[0]->income }}" /></p>
                <ul class="income-categories mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                    @foreach ($income_details as $item)
                    <li class="d-flex py-1">
                        <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->iconColor) ?>;font-size: 22px;"></i>
                        <span class="flex-fill my-auto"><span class="d-inline-block mb-2">{{ __($item->categoryName) }}</span><br><span class="border-top border-secondary pt-2"><x-money-format num="{{ $item->amount }}" /></span></span>
                        <span class="my-auto"><x-number-localization num="{{ $item->percentage }}" />&percnt;</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-center mx-auto">{{ __('You have No Income.') }}</p>
                @endif
            </div>
        </div>
        <div class="col-12 col-md-6 expense-category-pie-container">
            <h5 class="mb-4 text-center text-md-start">{{ __('Expense amount on Category') }}</h5>
            <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                <canvas id="expense-category-pie"></canvas>
            </div>
            <div class="mt-4">
                @if ($yearly_result_table[0]->expense != 0)
                <p class="text-center mx-auto">{{ __('Total Expense') }}: <x-money-format num="{{ $yearly_result_table[0]->expense }}" /></p>
                <ul class="expense-categories mx-auto mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                    @foreach ($expense_details as $item)
                    <li class="d-flex py-1">
                        <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->iconColor) ?>;font-size: 22px;"></i>
                        <span class="flex-fill my-auto"><span class="d-inline-block mb-2">{{ __($item->categoryName) }}</span><br><span class="border-top border-secondary pt-2"><x-money-format num="{{ $item->amount }}" /></span></span>
                        <span class="my-auto"><x-number-localization num="{{ $item->percentage }}" />&percnt;</span>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-center mx-auto">{{ __('You have No Expense.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Income Expense Category graph- Section Start -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<script>
    const months = <?= json_encode($yearly_result_table[2]->months); ?>;
    const incomes = <?= json_encode($yearly_result_table[2]->incomes); ?>;
    const expenses = <?= json_encode($yearly_result_table[2]->expenses); ?>;

    // Income, Expense Multiple Line Graph
    const labels = [
        "",
        ...months
    ];

    const data = {
        labels: labels,
        datasets: [{
                label: "Income",
                backgroundColor: "#08fa08",
                borderColor: "#08fa08",
                data: [0, ...incomes],
            },
            {
                label: "Expense",
                backgroundColor: "#fa0808",
                borderColor: "#fa0808",
                data: [0, ...expenses],
            },
        ]
    };

    const table_config = {
        type: "line",
        data,
    };

    var table = new Chart(
        document.getElementById("income-expense-multi-line"),
        table_config,
    );

    // Income Category Pie
    const income_category_names = '<?= implode(',', $income_graph_data[0]) ?>'.split(",");
    const income_category_percentages = '<?= implode(',', $income_graph_data[1]) ?>'.split(",");
    const income_category_colors = '<?= implode(',', $income_graph_data[2]) ?>'.split(",");

    const total_inc_cat_pie_data = {
        labels: income_category_names,
        datasets: [{
            backgroundColor: income_category_colors,
            data: income_category_percentages,
            hoverOffset: 1
        }]
    };

    const total_inc_cat_config_pie = {
        type: "pie",
        data: total_inc_cat_pie_data,
        options: {
            responsive: true
        }
    };

    const total_inc_cat_pie_chart = new Chart(
        document.getElementById("income-category-pie"),
        total_inc_cat_config_pie
    );

    // Expense Category Pie
    const expense_category_names = '<?= implode(',', $expense_graph_data[0]) ?>'.split(",");
    const expense_category_percentages = '<?= implode(',', $expense_graph_data[1]) ?>'.split(",");
    const expense_category_colors = '<?= implode(',', $expense_graph_data[2]) ?>'.split(",");

    const total_exp_cat_pie_data = {
        labels: expense_category_names,
        datasets: [{
            backgroundColor: expense_category_colors,
            data: expense_category_percentages,
            hoverOffset: 1,
        }]
    };

    const total_exp_cat_config_pie = {
        type: "pie",
        data: total_exp_cat_pie_data,
        options: {
            responsive: true
        }
    };

    const total_inc_exp_pie_chart = new Chart(
        document.getElementById("expense-category-pie"),
        total_exp_cat_config_pie
    );
    
</script>
@endsection