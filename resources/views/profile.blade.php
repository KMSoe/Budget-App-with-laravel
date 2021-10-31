@extends('layouts.app')

@section('content')
@if(session('info'))
<div class="alert alert-info">
    {{ session('info') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-warning">
    <ol>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ol>
</div>
@endif
<x-breadcrumb link="{{ route('profile') }}" is-active=1 current-page='Profile' icon-class='fas fa-user' >
</x-breadcrumb>

<section class="user-info-section my-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col col-md-10 col-lg-8">
                <h1 class="mb-3">{{ Auth()->user()->name }}</h1>
                <div class="mb-3">
                    <img src="{{ asset('storage/profiles/' .  Auth()->user()->profile) }}" alt="{{ Auth()->user()->name }}">
                </div>
                <form action="{{ route('profile-upload') }}" method="POST" enctype="multipart/form-data" class="mb-3">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" id="photo" name="photo" placeholder="Upload Profile Picture" class="form-control">
                        <button type="submit" class="btn bg-active text-white">{{ __('Upload') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Yearly Balance Brief Section Start -->
<section class="yearly-balance-section my-5">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            @foreach ($results as $result)
            <article class="py-4">
                <h5 class="mb-2 pe-1 font-weight-bold">
                    <x-number-localization num="{{ $result[0]->year }}" />
                    <span class="d-inline-block float-end {{ $result[0]->net_budget >= 0 ? 'plus' : 'minus' }}">{{ $result[0]->net_budget >= 0 ? "+" : "" }} <x-money-format num="{{ $result[0]->net_budget }}" /></span>
                </h5>
                <table class="table table-bordered text-center" id="income-expense-table">
                    <thead class="text-white thead-dark">
                        <tr class="border-secondary border-bottom-0">
                            <th class="border-secondary">{{ __('Month') }}</th>
                            <th class="border-secondary">{{ __('Income') }}</th>
                            <th class="border-secondary">{{ __('Expense') }}</th>
                            <th class="border-secondary">{{ __('Balance') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($result[1] as $res)
                        <tr class="table-hover font-weight-bold">
                            <td class="text-active font-weight-bold">{{ __($res->month) }}</td>
                            <td class="plus">{{ $res->income > 0 ? '+' : ""}} <x-money-format num="{{$res->income}}" /></td>
                            <td class="minus"><x-money-format num="{{$res->expense}}" /></td>
                            <td class="{{ $res->net_budget > 0 ? 'plus' : 'minus' }}">{{$res->net_budget > 0 ? "+" : "" }} <x-money-format num="{{$res->net_budget}}" /></td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot class="font-weight-bold">
                        <tr>
                            <td class="text-white">{{ __('Total') }}</td>
                            <td class="plus">+<x-money-format num="{{$result[0]->income}}" /></td>
                            <td class="minus"><x-money-format num="{{$result[0]->expense}}" /></td>
                            <td class="{{ $result[0]->net_budget >= 0 ? 'plus' : 'minus' }}">{{ $result[0]->net_budget >= 0 ? "+" : "" }} <x-money-format num="{{$result[0]->net_budget}}" /></td>
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ route('statistics', ['year' => $result[0]->year]) }}" class="btn bg-active text-white rounded">{{ __('See Detail') }}</a>
            </article>
            @endforeach
        </div>
    </div>
</section>
<!-- Yearly Balance Brief Section End -->
@endsection

