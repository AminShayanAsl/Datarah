@extends('layout')

@section('title')
    <title>{{ $question->getTitle() }}</title>
@stop

@section('content')
    <!-- Page Header-->
    <header class="masthead" style="background-image: url({{ asset('images/question-page-bg.png') }})">
        <div class="container position-relative px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    <div class="page-heading">
                        <h1>صفحه سوال</h1>
                        <span class="subheading">اگر پاسخ این سوال را می‌دانید، لطفا آن را در انتهای صفحه بنویسید.</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content-->
    <div class="container mb-5">
        <div class="d-flex">
            <div class="text-center ms-2">
                <button class="q-approval btn btn-outline-dark rounded-circle"><i class="fa-solid fa-caret-up"></i></button>
                <div class="question-vote d-block pt-1 pr-num" data-question-vote="<?php print_r(count($question->getApproval()) - count($question->getDisapproval())) ?>" dir="ltr">
                    <?php print_r(count($question->getApproval()) - count($question->getDisapproval())) ?>
                </div>
                <button class="q-disapproval btn btn-outline-dark rounded-circle"><i class="fa-solid fa-caret-down"></i></button>
                <div class="bookmark-question mt-1 fs-4">
                    <div class="unsaved <?php echo ($question_bookmarked) ? 'd-none' : '' ; ?>">
                        <i class="fa-regular fa-bookmark text-secondary"></i>
                    </div>
                    <div class="saved <?php echo ($question_bookmarked) ? '' : 'd-none' ; ?>">
                        <i class="fa-solid fa-bookmark eastern-blue-text"></i>
                    </div>
                </div>
            </div>
            <div class="w-100">
                <div class="alert alert-secondary w-100">
                    <h5>{{ $question->getTitle() }}</h5>
                    <span class="pr-num sub-label">{{ getJDate($question->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
                    <hr>
                    <div class="lh-lg">{!! $question->getContent() !!}</div>
                    <?php
                    for ($i=0; $i<2; $i++) {
                    if ($question->getTags()[$i] !== '') {
                    $tag = tagDetail($question->getTags()[$i]);
                    if (is_numeric($question->getTags()[$i])) {
                        $filter = 'level';
                    } else {
                        $filter = 'lesson';
                    }
                    ?>
                    <a href="{{ url('questions/?'.$filter.'='.$question->getTags()[$i]) }}" class="btn btn-outline-dark mx-1 tag">
                        <img src="{{ asset('images/'.$tag['image']) }}" class="img-icon">
                        {{ $tag['text'] }}
                    </a>
                    <?php }
                    }
                    ?>
                    <span class="sub-label d-block mt-3 px-1">{{ $question->getUser()->getDisplayName() }}</span>
                </div>
            </div>
        </div>
        <hr>
        <?php
        $answer_exists = false;
        foreach ($question->getAnswers() as $answer) {
            if ($answer->getConfirmation()) {
                $answer_exists = true;
        ?>
        <div class="d-flex">
            <div class="text-center ms-2" data-answer-id="{{ $answer->getId() }}">
                <button class="a-approval btn btn-outline-dark rounded-circle"><i class="fa-solid fa-caret-up"></i></button>
                <div class="answer-vote d-block pt-1 pr-num" data-answer-vote="<?php print_r(count($answer->getApproval()) - count($answer->getDisapproval())) ?>" dir="ltr">
                    <?php print_r(count($answer->getApproval()) - count($answer->getDisapproval())) ?>
                </div>
                <button class="a-disapproval btn btn-outline-dark rounded-circle"><i class="fa-solid fa-caret-down"></i></button>
            </div>
            <div class="w-100">
                <div class="alert alert-secondary w-100">
                    <div class="lh-lg">{!! $answer->getContent() !!}</div>
                    <span class="pr-num sub-label">{{ getJDate($answer->getCreatedAt())->format('%A %d %B %Y ساعت %H:%M') }}</span><br>
                    <span class="sub-label d-block mt-3 px-1">{{ $answer->getUser()->getDisplayName() }}</span>
                </div>
            </div>
        </div>
        <?php
            }
        } if (!$answer_exists) {
        ?>
        <div class="alert alert-info mb-3 rounded-3">
            <b>تاکنون برای این سوال پاسخی ثبت نشده است، شما می‌توانید اولین نفری باشید که به این سوال پاسخ می‌دهید.</b>
        </div>
        <?php
        }
        ?>
        <hr>
        <?php
        if (!isset($_SESSION))
        {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
        ?>
        <div class="warning-box alert alert-warning mb-3 rounded-3">
            <b>برای ثبت پاسخ، ابتدا باید وارد شوید.</b>
        </div>
        <?php
        }
        ?>
        <div <?php if (!isset($_SESSION['auth'])) { echo "disabled"; } ?>>
            <form action="{{ url('answer') }}" method="post" class="answer-form m-auto mt-3 pb-5">
                {{ csrf_field() }}
                <label class="fw-bold mt-4">پاسخ سوال</label>
                <p class="sub-label mt-1">پاسخ خود را در قسمت پایین ثبت نمایید.</p>
                <textarea id="editor" name="answer"></textarea>
                <input name="question-id" value="{{ $question->getId() }}" class="d-none">
                <button type="submit" class="btn btn-success mt-3 py-2 float-start">ثبت پاسخ</button>
            </form>
        </div>
    </div>

    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                toolbar: [
                    'undo', 'redo',
                    '|', 'heading',
                    '|', 'bold', 'italic', 'link',
                    '|', 'bulletedList', 'numberedList'
                ],
                language: {
                    // The UI will be English.
                    ui: 'en',

                    // But the content will be edited in Arabic.
                    content: 'ar'
                }
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( err => {
                console.error( err.stack );
            } );

        $(document).ready(function(){
            $('.q-approval').click(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                $.ajax({
                    url: '{{ url('question-approval/') }}',
                    method: 'POST',
                    data: {question_id: {{ $question->getId() }} },
                    success: function (result = '') {
                        if (result['message']) {
                            $.sweetModal({
                                content: '<h4 class="f-iranSans">'+ result['message'] +'</h4>',
                                icon: $.sweetModal.ICON_WARNING
                            });
                        } else if (result['number']) {
                            var vote_num = parseInt($('.question-vote').attr('data-question-vote')) + result['number'];
                            $('.question-vote').html(persianNum(String(vote_num))).attr('data-question-vote', vote_num);
                        }
                    }
                });
            });

            $('.q-disapproval').click(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                $.ajax({
                    url: '{{ url('question-disapproval/') }}',
                    method: 'POST',
                    data: {question_id: {{ $question->getId() }} },
                    success: function (result = '') {
                        if (result['message']) {
                            $.sweetModal({
                                content: '<h4 class="f-iranSans">'+ result['message'] +'</h4>',
                                icon: $.sweetModal.ICON_WARNING
                            });
                        } else if (result['number']) {
                            var vote_num = parseInt($('.question-vote').attr('data-question-vote')) + result['number'];
                            $('.question-vote').html(persianNum(String(vote_num))).attr('data-question-vote', vote_num);
                        }
                    }
                });
            });

            $('.a-approval').click(function () {
                var answer_id = $(this).parent().attr('data-answer-id');
                var parent = $(this).parent();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                $.ajax({
                    url: '{{ url('answer-approval/') }}',
                    method: 'POST',
                    data: {answer_id: answer_id },
                    success: function (result = '') {
                        if (result['message']) {
                            $.sweetModal({
                                content: '<h4 class="f-iranSans">'+ result['message'] +'</h4>',
                                icon: $.sweetModal.ICON_WARNING
                            });
                        } else if (result['number']) {
                            var vote_num = parseInt(parent.find('.answer-vote').attr('data-answer-vote')) + result['number'];
                            parent.find('.answer-vote').html(persianNum(String(vote_num))).attr('data-answer-vote', vote_num);
                        }
                    }
                });
            });

            $('.a-disapproval').click(function () {
                var answer_id = $(this).parent().attr('data-answer-id');
                var parent = $(this).parent();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                $.ajax({
                    url: '{{ url('answer-disapproval/') }}',
                    method: 'POST',
                    data: {answer_id: answer_id },
                    success: function (result = '') {
                        if (result['message']) {
                            $.sweetModal({
                                content: '<h4 class="f-iranSans">'+ result['message'] +'</h4>',
                                icon: $.sweetModal.ICON_WARNING
                            });
                        } else if (result['number']) {
                            var vote_num = parseInt(parent.find('.answer-vote').attr('data-answer-vote')) + result['number'];
                            parent.find('.answer-vote').html(persianNum(String(vote_num))).attr('data-answer-vote', vote_num);
                        }
                    }
                });
            });

            $('.bookmark-question svg').click(function () {
                <?php
                if (!isset($_SESSION)) {
                    session_start();
                }
                if (!isset($_SESSION['auth'])) {
                ?>
                $.sweetModal({
                    content: '<h4 class="f-iranSans">برای ذخیره سوال ابتدا باید وارد حساب کاربری خود شوید.</h4>',
                    icon: $.sweetModal.ICON_WARNING
                });
                <?php
                } else {
                ?>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
                $.ajax({
                    url: '{{ url('question-bookmark/') }}',
                    method: 'POST',
                    data: {question_id: {{ $question->getId() }} },
                    success: function (question_bookmarked = '') {
                        if (question_bookmarked) {
                            $('.bookmark-question .saved').removeClass('d-none');
                            $('.bookmark-question .unsaved').addClass('d-none');
                        } else {
                            $('.bookmark-question .saved').addClass('d-none');
                            $('.bookmark-question .unsaved').removeClass('d-none');
                        }
                    }
                });
                <?php
                    }
                ?>
            });

            <?php
            if ($status === 'successful') {
            ?>
                $.sweetModal({
                    content: '<h4 class="f-iranSans lh-lg">پاسخ شما ثبت گردید و پس از بررسی ادمین در این صفحه قرار خواهد گرفت.</h4>',
                    icon: $.sweetModal.ICON_SUCCESS,
                    buttons: [
                        {
                            label: '<span class="f-iranSans">متوجه شدم</span>',
                            classes: 'greenB'
                        }
                    ]
                });
            <?php
            }
            ?>
        });

        $('.answer-form button').click(function (e) {
            var answer = $('.answer-form .ck-editor__editable').html();
            if ($.trim(answer) === '<p><br data-cke-filler="true"></p>') {
                e.preventDefault();
                $.sweetModal({
                    content: '<h4 class="f-iranSans">پاسخ سوال نباید خالی باشد.</h4>',
                    icon: $.sweetModal.ICON_WARNING
                });
            } else {
                $('.answer-form textarea[name="answer"]').html(answer);
            }
        });

        function persianNum(text) {
            var pr_nums = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            var result = '';
            for (var i=0; i < text.length; i++) {
                if ($.isNumeric(text[i])) {
                    result += pr_nums[parseInt(text[i])];
                } else {
                    result += text[i];
                }
            }
            return result;
        }
    </script>
@stop
