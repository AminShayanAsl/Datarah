@extends('base')

@section('title')
    <title>ثبت‌نام</title>
@stop

@section('body')
    <div class="register h-100 d-flex align-items-center justify-content-center container py-md-0 py-3">
        <div class="row rounded-5 shadow-lg p-3 my-5">
            <div class="d-block pb-3">
                <?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
                <a href="<?php echo (substr($_SERVER['HTTP_REFERER'], strrpos($_SERVER['HTTP_REFERER'], '/')) === '/sign-up-account') ? 'sign-up' : url()->previous();  ?>" class="previous text-decoration-none link-secondary">بازگشت<span class="h4">&#8592;</span></a>
                <?php } else { ?>
                <a href="{{ url()->previous() }}" class="previous text-decoration-none link-secondary">بازگشت<span class="h4">&#8592;</span></a>
                <?php } ?>
            </div>
            <div class="col-md-6 col-12 text-md-end text-center">
                <b>ثبت‌نام</b>
                <form action="{{ url('sign-up-account/') }}" method="post" class="m-md-0 m-auto">
                    {{ csrf_field() }}
                    <input class="inp mt-4" type="text" name="display-name" placeholder="نام کاربری"/>
                    <input class="inp mt-4" type="email" name="email" placeholder="ایمیل"/>
                    <input class="inp mt-4" type="text" name="code" placeholder="کد ارسال شده"/>
                    <div class="mt-4 text-center ps-4">
                        <button type="submit" class="btn btn-outline-success btn-lg" id="btn_register">ثبت</button>
                        <button type="submit" class="btn btn-outline-primary btn-lg d-block m-md-0 me-4" id="send_code">ارسال کد</button>
                    </div>
                </form>
                <div class="mt-5 mb-2">
                    <b>آیا حساب کاربری دارید؟</b>
                    <a href="{{ url('sign-in') }}" class="text-decoration-none">ورود</a>
                </div>
            </div>
            <div class="col-md-6 col-12 mt-md-0 mt-5 text-center">
                <img src="{{ asset('images/signup.jpg') }}">
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    e.preventDefault();
                    if ($('#btn_register').css('display') === 'none') {
                        $('#send_code').trigger("click");
                    } else {
                        $('#btn_register').trigger("click");
                    }
                }
            });

            $('#send_code').click(function (e) {
                e.preventDefault();
                var email = $('input[name="email"]').val();
                var display_name = $('input[name="display-name"]').val();
                var regExp = /[a-zA-Z\u0600-\u06FF]/g;
                if (!regExp.test(display_name)) {
                    $.sweetModal({
                        content: '<h4 class="f-iranSans">نام کاربری باید حداقل شامل یک حرف باشد.</h4>',
                        icon: $.sweetModal.ICON_WARNING
                    });
                } else if (email === '') {
                    $.sweetModal({
                        content: '<h4 class="f-iranSans">ایمیل خود را وارد کنید.</h4>',
                        icon: $.sweetModal.ICON_WARNING
                    });
                } else if (!IsEmail(email)) {
                    $.sweetModal({
                        content: '<h4 class="f-iranSans">ایمیل خود را به صورت صحیح وارد کنید.</h4>',
                        icon: $.sweetModal.ICON_WARNING
                    });
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    })
                    $.ajax({
                        url: '{{ url('sign-up-code/') }}',
                        method: 'POST',
                        data: {email: email},
                        success: function ($message='') {
                            if ($message) {
                                $.sweetModal({
                                    content: '<h4 class="f-iranSans">'+ $message +'</h4>',
                                    icon: $.sweetModal.ICON_WARNING
                                });
                            } else {
                                var timer = 120;
                                $('input[name="code"]').fadeIn();
                                $('#btn_register').fadeIn();
                                $('#send_code').removeClass('d-block m-md-0 me-4').attr('disabled', 'disabled').html(persianNumber(timer));
                                var countdown = setInterval(function() {
                                    timer--;
                                    $('#send_code').html(persianNumber(timer));
                                    if (timer === 0) {
                                        clearInterval(countdown);
                                        $('#send_code').removeAttr('disabled').html('ارسال مجدد');
                                    }
                                }, 1000);
                            }
                        }
                    });
                }
            });

            function IsEmail(email) {
                const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            function persianNumber(num) {
                var num_st = num.toString();
                var pr_nums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                var result = '';
                for (var i=0; i < num_st.length; i++) {
                    result += pr_nums[parseInt(num_st[i])];
                }
                return result;
            }

            <?php if (isset($message)) { ?>
                $.sweetModal({
                        content: '<h4 class="f-iranSans">{{ $message }}</h4>',
                        icon: $.sweetModal.ICON_WARNING
                    });
            <?php } ?>
        });
    </script>
@stop
