@extends('layout')

@section('title')
    <title>راهنما</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/help.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>راهنما</h1>
                        <span class="subheading">راهنما بخش‌های مختلف را در این صفحه مشاهده می‌کنید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <div class="title pattens-blue-bg rounded-3 p-3 col-md-10 col-12 m-auto my-3">
            معرفی <b>دیتاراه</b>
            <i class="fa-solid fa-caret-down float-start"></i>
            <i class="fa-solid fa-caret-up float-start"></i>
        </div>
        <div class="more bg-secondary text-light rounded-3 p-3 col-md-10 col-12 m-auto">
            برای معرفی دیتاراه می‌توانید فیلم زیر را مشاهده کنید:
            <div id="77224675398" class="rounded-3 m-md-5 mt-2 overflow-hidden"><script type="text/JavaScript" src="https://www.aparat.com/embed/hnwwz22?data[rnddiv]=77224675398&data[responsive]=yes&titleShow=true&recom=self"></script></div>
        </div>

        <div class="title pattens-blue-bg rounded-3 p-3 col-md-10 col-12 m-auto my-3">
            افزودن سوال
            <i class="fa-solid fa-caret-down float-start"></i>
            <i class="fa-solid fa-caret-up float-start"></i>
        </div>
        <div class="more bg-secondary text-light rounded-3 p-3 col-md-10 col-12 m-auto">
            برای افزودن سوال می‌توانید فیلم زیر را مشاهده کنید:
            <div id="83523197461" class="rounded-3 m-md-5 mt-2 overflow-hidden"><script type="text/JavaScript" src="https://www.aparat.com/embed/cvpxm3r?data[rnddiv]=83523197461&data[responsive]=yes&titleShow=true&recom=self"></script></div>
        </div>

        <div class="title pattens-blue-bg rounded-3 p-3 col-md-10 col-12 m-auto my-3">
            ثبت پاسخ
            <i class="fa-solid fa-caret-down float-start"></i>
            <i class="fa-solid fa-caret-up float-start"></i>
        </div>
        <div class="more bg-secondary text-light rounded-3 p-3 col-md-10 col-12 m-auto">
            برای ثبت پاسخ می‌توانید فیلم زیر را مشاهده کنید:
            <div id="44207248684" class="rounded-3 m-md-5 mt-2 overflow-hidden"><script type="text/JavaScript" src="https://www.aparat.com/embed/wjb7839?data[rnddiv]=44207248684&data[responsive]=yes&titleShow=true&recom=self"></script></div>
        </div>
    </div>

    <script>
        $('.title').click(function () {
            $(this).nextAll('.more').first().slideToggle();
            $(this).find('.fa-caret-down').toggle();
            $(this).find('.fa-caret-up').toggle();
        });
    </script>
@stop
