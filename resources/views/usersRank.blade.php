@extends('layout')

@section('title')
    <title>رتبه‌بندی کاربران</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/users-rank.jpg') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>رتبه‌بندی کاربران</h1>
                        <span class="subheading">در این قسمت پنج کاربر برتر سایت را مشاهده می‌کنید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <div class="pattens-blue-bg rounded-3 p-3 text-secondary">
            <b>راهنما : </b>
            نحوه محاسبه امتیاز به این صورت است که هر سوال تایید شده دارای ۵ امتیاز و هر پاسخ تایید شده دارای ۱۰ امتیاز می‌باشد.
        </div>
        <table class="users-rank table table-hover m-auto mt-4 text-center">
            <thead>
                <th scope="col">رتبه</th>
                <th scope="col">نام کاربر</th>
                <th scope="col">سوالات</th>
                <th scope="col">پاسخ‌ها</th>
                <th scope="col">امتیاز</th>
            </thead>
            <tbody>
            <?php
            foreach ($users_rank as $key=>$user_rank) {
            ?>
            <tr>
                <th scope="row">
                <?php
                    if ($key === 0) {
                ?>
                <div class="medal bg-gold rounded-circle py-1">
                    اول
                </div>
                <?php
                    } elseif ($key === 1) {
                ?>
                <div class="medal bg-silver rounded-circle py-1">
                    دوم
                </div>
                <?php
                    } elseif ($key === 2) {
                ?>
                <div class="medal bg-bronze rounded-circle py-1">
                    سوم
                </div>
                <?php
                    } elseif ($key === 3) {
                ?>
                <div class="rounded-circle py-1">
                    چهارم
                </div>
                <?php
                    } else {
                ?>
                <div class="rounded-circle py-1">
                    پنجم
                </div>
                <?php
                    }
                ?>
                </th>
                <td>{{ $user_rank['display_name'] }}</td>
                <td class="pr-num">{{ $user_rank['confirmed_questions'] }}</td>
                <td class="pr-num">{{ $user_rank['confirmed_answers'] }}</td>
                <td class="pr-num">{{ $user_rank['score'] }}</td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
@stop
