@extends('layout')

@section('title')
    <title>پشتیبانی</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/support.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>پشتیبانی</h1>
                        <span class="subheading">در این قسمت با روش برقراری ارتباط با ما آشنا می‌شوید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <div class="pattens-blue-bg rounded-3 p-3">
            در صورت بروز هر یک از موارد زیر از طریق ایمیل <a class="text-decoration-none" href="https://mail.google.com/mail/?view=cm&fs=1&to=datarah2024@gmail.com" target="_blank">datarah@gmail.com</a> با ما ارتباط برقرار کنید.
            <ul class="mt-3 lh-lg">
                <li>نیاز داشتن به راهنمایی در مورد عملکرد سایت</li>
                <li>مواجهه با هر گونه مشکل در کارکرد سایت</li>
                <li>ارائه پیشنهاد در مورد سایت</li>
                <li>و ...</li>
            </ul>
        </div>
    </div>
@stop
