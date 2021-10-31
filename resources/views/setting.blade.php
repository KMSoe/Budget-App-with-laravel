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
<!-- Breadcrumb Section Start -->
<section class="breadcrumb-section pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <ol class="breadcrumb px-2 py-3 mx-3 mb-3">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class=""><i class="fas fa-home me-2"></i>Home</a></li>
                    <li class="breadcrumb-item active"><a href="#" class=""><i class="fas fa-cog me-2"></i>Setting</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<section class="setting-section my-5">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            
        </div>
    </div>
</section>
@endsection