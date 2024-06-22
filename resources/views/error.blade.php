@extends('layout')

@section('title')
    <title>خطا</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/error.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>خطا</h1>
                        <span class="subheading">مشکلی پیش آمده است.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5 text-center">
        <img src="{{ asset('images/404.png') }}" class="col-11 col-md-6">
        <h2 class="fw-bold my-4">صفحه مورد نظر یافت نشد.</h2>
        <a href="{{ url('/') }}" class="text-decoration-none">صفحه اصلی</a>
    </div>
@stop
