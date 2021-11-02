@extends('layouts.app')
<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
@section('content')
@include('partials/budget-choose')
<!-- Select Month modal -->
<div class="modal" id="select-month">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="ps-3 py-3">
                <h5 class="modal-title text-center">Select a month</h5>
            </div>
            <div class="modal-body">
                <form action="/home" method="GET" id="select-month-form">
                    <input type="text" name="time" id="monthpicker" placeholder="Select a month" class="form-control" autocomplete="off" onkeyup="disableButtonSelectMonth(this)">
                </form>
            </div>
            <div class="text-center pt-2 pb-3">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="ms-3 btn btn-primary" form="select-month-form" id="btnsubmit" type="submit">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>
@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif
<a href="" type="button" class="back-to-top rounded d-lg-none">
    <span class="up-arrow mx-auto"></span>
</a>
<div class="row">
    <div class="col-lg-8">
        <!-- Total balance Section Start -->
        <section class="total-balance-section py-3 px-4">
            <div class="row justify-content-center justify-content-lg-start">
                <div class="col-sm-10 col-md-8 col-lg-10 col-xl-8 mb-3" style="background-color: unset;">
                    <a class="btn bg-active text-white select-btn py-1 px-3 my-2" id="pick-month-btn">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <span id="year-month">
                            <x-number-localization num="{{ $total['year'] }}" />&nbsp;&dash;&nbsp;{{ __($total['month']) }}
                        </span>
                    </a>
                    <input type="hidden" id="month" autocomplete="off" onchange="changeDate()">

                    <div class="card-body">
                        <h3 class="h5">{{ __('Total Balance') }}</h3>
                        <div class="row">
                            <div class="col-10">
                                <span class="total-balance font-weight-bold text-white">
                                    <x-money-format num="{{ $total['net_budget'] }}" />
                                </span>
                                @if($total['income'] == 0)
                                <p class="minus font-weight-bold mt-2">{{ __('You have No Income.') }}</p>
                                @elseif($total['income'] < $total['expense']) <p class="minus font-weight-bold mt-2">{{ __('Your Expense is greater than your Income.') }}</p>
                                    @elseif($total['expense'] == 0)
                                    <p class="minus font-weight-bold mt-2">{{ __('You have No Expense.') }}</p>
                                    @else
                                    <p class="minus font-weight-bold mt-2">
                                        <x-number-localization num='{{ __("You have spent :Percentage% of your Income in :Month.", ["percentage" => $total["percentage"], "month" => $total["month"]]) }}' />
                                    </p>
                                    @endif
                            </div>
                            <div class="col-2 add-button">
                                <a href="" data-bs-toggle="modal" data-bs-target="#choose" class=" d-block w-100 h-100 position-relative">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Total balance Section End -->

        <!-- Total Income, Expense Section Start -->
        <section class="total-value-section px-1 px-lg-3">
            <div class="row d-flex justify-content-center justify-content-lg-start align-items-stretched">
                <div class="col-6 col-sm-4 col-lg-5 col-xl-4">
                    <div class="card mx-auto w-100 h-100 mb-3" style="background-color: unset;">
                        <div class="bg-plus card-body position-relative text-white">
                            <h3 class="card-title h4">{{ __('Total Income') }}</h3>
                            <span class="total-income-value font-weight-bold">
                                <x-money-format num="{{ $total['income'] }}" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-5 col-xl-4">
                    <div class="card mx-auto w-100 h-100 mb-3" style="background-color: unset;">
                        <div class="bg-minus card-body position-relative text-white">
                            <h3 class="card-title h4">{{ __('Total Expense') }}</h3>
                            <span class=" total-expense-value font-weight-bold">
                                <x-money-format num="{{ $total['expense'] }}" />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Total Income, Expense Section End -->

        <!-- Daily statistics Section Start-->
        <section class="daily-stat-section py-5 px-1 px-lg-3">
            <div class="row px-2 justify-content-center justify-content-lg-start">
                <div class="col-sm-10 col-md-8 col-lg-10 col-xl-8">
                    <h4 class="h5 mb-3">{{ __('Daily Budgets') }}</h4>
                    @forelse ($daily_budgets as $card)
                    <div class=" card daily-stat-card rounded mb-3">
                        <div class="card-header d-flex px-2">
                            <span class="flex-fill me-2">
                                <x-number-localization num="{{ $card->day }}" />
                            </span>
                            <span class="me-2">{{ __('Income')}}:
                                <x-money-format num="{{ $card->income }}" />
                            </span>
                            <span class="me-2">{{ __('Expense') }}:
                                <x-money-format num="{{ $card->expense }}" />
                            </span>
                        </div>
                        <div class="card-body p-0">
                            <ul class="mb-0 px-0">
                                @foreach ($card->items as $item)
                                <li class="d-flex py-2 px-3">
                                    <i class="cat-icon {{ $item->icon->class }} me-3 my-auto" style="background-color: <?= htmlspecialchars($item->icon->color) ?>;"></i>
                                    <span class="flex-fill my-auto">{{ __($item->name) }} <br> <span class="text-muted">{{ __($item->remark) }}</span></span>
                                    <span class="{{ $item->amount > 0 ? 'plus' : 'minus' }} font-weight-bold my-auto">{{ $item->amount > 0 ? '+' : '' }}
                                        <x-money-format num="{{ $item->amount }}" />
                                    </span>

                                    <form action="{{ route('budgets.destroy') }}" method="POST" class="my-auto text-end" style="box-sizing: border-box;width: 40px;height: 40px;">
                                        @csrf
                                        <input type="hidden" name="budget_id" value="{{ $item->id }}">
                                        <button style="outline: none;border: none;background-color: unset;" type="submit">
                                            <i class="cat-icon fas fa-times-circle my-auto"></i>
                                        </button>
                                    </form>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer">
                            <p class="mb-0" style="letter-spacing: 1px;">
                                @if($total['income'] == 0)
                                {{ __('You have No Income in this month.') }}
                                @elseif($card->percentage == 0)
                                {{ __('You have No Expense.') }}
                                @else
                                <x-number-localization num='{{ __(":Percentage% of your monthly Income was spent.", ["percentage" => $card->percentage, "month" => $total["month"] ]) }}' />
                                @endif

                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-muted mt-5">{{ __('You have neither Income nor Expense.') }}</p>
                    @endforelse
                </div>
            </div>

        </section>
        <!-- Daily statistics Section End-->

    </div>
    <div class="col-lg-4">
        <section class="py-3">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-12 mx-auto">
                    <div class="pt-5 pb-3 ps-2 mobile-sticky-nav bg-main">
                        <h4>{{ __('Financial Amount Detail on Category') }}</h4>
                        <div class="swip-nav d-flex justify-content-flex-start mt-4 mb-md-3">
                            <a class="income-category-pie-nav active btn select-btn text-white me-3 py-1 px-3">
                                <i class="fas fa-check me-2"></i>{{ __('Income') }}
                            </a>
                            <a class="expense-category-pie-nav btn select-btn text-white me-3 py-1 px-3">
                                <i class="fas fa-check me-2"></i>{{ __('Expense') }}
                            </a>
                        </div>
                    </div>

                    <div class="income-category-pie-container mt-5">
                        <h5 class="mb-4 text-center text-md-start">{{ __('Income amount on Category') }}</h5>
                        <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                            <canvas id="income-category-pie"></canvas>
                        </div>
                        <div class="my-4 pb-3">
                            @if ($total['income'] > 0)
                            <p class="text-center mx-auto">{{ __('Total Income') }}:
                                <x-money-format num="{{ $total['income'] }}" />
                            </p>
                            <ul class="income-categories mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                                @foreach ($income_details as $item)
                                <li class="d-flex py-1">
                                    <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->iconColor) ?>;font-size: 22px;"></i>
                                    <span class="flex-fill my-auto"><span class="d-inline-block mb-2">{{ __($item->categoryName) }}</span><br><span class="border-top border-secondary pt-2">
                                            <x-money-format num="{{ $item->amount }}" />
                                        </span></span>
                                    <span class="my-auto">
                                        <x-number-localization num="{{ $item->percentage }}" />&percnt;
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-center mx-auto">{{ __('You have No Income.') }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="expense-category-pie-container mt-5">
                        <h5 class="mb-4 text-center text-md-start">{{ __('Expense amount on Category') }}</h5>
                        <div class="income-expense-pie-container position-relative mx-auto ms-md-auto" id="pie-small">
                            <canvas id="expense-category-pie"></canvas>
                        </div>
                        <div class="my-4 pb-3">
                            @if ($total['expense'] > 0)
                            <p class="text-center mx-auto">{{ __('Total Expense') }}:
                                <x-money-format num="{{ $total['expense'] }}" />
                            </p>
                            <ul class="expense-categories mx-auto mt-4 ps-0 w-100 w-md-50 w-lg-100 px-lg-1 px-xl-3">
                                @foreach ($expense_details as $item)
                                <li class="d-flex py-1">
                                    <i class="fas fa-square me-3 my-auto" style="color: <?= htmlspecialchars($item->iconColor) ?>;font-size: 22px;"></i>
                                    <span class="flex-fill my-auto"><span class="d-inline-block mb-2">{{ $item->categoryName }}</span><br><span class="border-top border-secondary pt-2">
                                            <x-money-format num="{{ $item->amount }}" />
                                        </span></span>
                                    <span class="my-auto">
                                        <x-number-localization num="{{ $item->percentage }}" />&percnt;
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-center mx-auto">{{ __('You have No Expense.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
<script>
    // Income Category Pie
    const income_category_names = <?= json_encode($income_graph_data[0]) ?>;
    const income_category_percentages = <?= json_encode($income_graph_data[1]) ?>;
    const income_category_colors = <?= json_encode($income_graph_data[2]) ?>;

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
            aspectRatio: .8,
        }
    };

    const total_inc_cat_pie_chart = new Chart(
        document.getElementById("income-category-pie"),
        total_inc_cat_config_pie
    );

    // Expense Category Pie
    const expense_category_names = <?= json_encode($expense_graph_data[0]) ?>;
    const expense_category_percentages = <?= json_encode($expense_graph_data[1]) ?>;
    const expense_category_colors = <?= json_encode($expense_graph_data[2]) ?>;

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
            aspectRatio: .8,
        }
    };

    const total_inc_exp_pie_chart = new Chart(
        document.getElementById("expense-category-pie"),
        total_exp_cat_config_pie
    );
</script>
@endsection