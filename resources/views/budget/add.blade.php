@extends('layouts.app')

@section('content')
@if($errors->any())
<div class="alert alert-warning">
    <ol>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ol>
</div>
@endif
<x-breadcrumb link="" current-page="Add {{ $type }}" is-active=1 icon-class='fas fa-plus-circle'>
</x-breadcrumb>

<!-- Add Income Section Start -->
<section class="add-budget-section row justify-content-center pt-1 pb-4">
    <div class="col-sm-11 col-md-8 col-lg-7 col-xl-6 px-4">
        <h4 class="text-center mb-4">
            <i class="fas fa-dollar-sign me-2 {{ $type === 'Income' ? 'plus' : 'minus' }}"></i>
            {{ __("Add $type")}}
        </h4>
        <form action="{{ route('budgets.store') }}" class="add-item-form" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">
            <div class="row g-0 mb-3">
                <div class="col-sm-3 my-auto">
                    <i class="fas fa-calendar-alt me-1"></i>
                    <label for="date" class="">{{ __('Date') }}</label>
                </div>
                <div class="col-sm-9 form-group position-relative">
                    <input type="text" class="form-control" id="pick-date" placeholder="{{ __('Today') }}" name="date" value="" autocomplete="off">
                    <i class="fas fa-calendar-alt  position-absolute input-field-symbol"></i>
                </div>
            </div>
            <div class="row g-0 mb-3">
                <div class="col-sm-3 my-auto">
                    <i class="fas fa-th-large me-1"></i>
                    <label for="category-id" class="">{{ __('Category') }}</label>
                </div>
                <div class="col-sm-9">
                    <select id="category-id" name="category_id" class="w-100 form-select ">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ __($cat->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- <div class="other-category-input row g-0 mb-3">
                                <div class="col-sm-3 my-auto">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <label for="category" class="">Remark</label>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" id="category" class="form-control d-inline-block"
                                        placeholder="Add category name you like">
                                </div>
                            </div> -->
            <div class="row g-0 mb-3">
                <div class="col-sm-3 my-auto">
                    <i class="fas fa-pen me-1"></i>
                    <label for="remark" class="">{{ __('Remark') }}</label>
                    <br class="d-none d-md-inline-block">&nbsp;
                </div>
                <div class="col-sm-9">
                    <input type="text" id="remark" name="remark" class="form-control d-inline-block" placeholder="{{ __('Write remark') }}">
                    <span class="text-muted">{{ __('Optional') }}</span>
                </div>
            </div>
            <div class="row g-0 mb-3">
                <div class="col-sm-3 my-auto">
                    <i class="fas fa-dollar-sign me-1"></i>
                    <label for="amount" class="">{{ __('Amount') }}</label>
                </div>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="number" id="amount" name="amount" class="form-control d-inline-block" step=".0001" placeholder="{{ __('Enter Amount') }}">
                        <span class="input-group-text">{{ __($unit) }}</span>
                    </div>
                </div>
            </div>
            <div class="row g-0 my-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <button type="submit" id="btnsubmit" class="btn rounded mt-3 {{ $type === 'Income' ? 'btn-primary' : 'btn-danger' }}">{{ __('Add') }}</button>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Add Income Section End -->

@endsection