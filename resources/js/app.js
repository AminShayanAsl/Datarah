require('./bootstrap');
import $ from "jquery";
window.$ = $;

window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    if (mainNav) {
        const headerHeight = mainNav.clientHeight;
        window.addEventListener('scroll', function() {
            const currentTop = document.body.getBoundingClientRect().top * -1;
            if ( currentTop < scrollPos) {
                // Scrolling Up
                if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                    mainNav.classList.add('is-visible');
                } else {
                    mainNav.classList.remove('is-visible', 'is-fixed');
                }
            } else {
                // Scrolling Down
                mainNav.classList.remove(['is-visible']);
                if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
                    mainNav.classList.add('is-fixed');
                }
            }
            scrollPos = currentTop;
        });
    }
})

$(document).ready(function(){
    $('#mainNav .navbar-toggler').click(function () {
        $('#mainNav .collapse').slideToggle();
    });

    // Scroll horizontal devices
    $('.items').mousedown(function (event) {
        $(this)
            .data('down', true)
            .data('x', event.clientX)
            .data('scrollLeft', this.scrollLeft)
            .addClass("dragging");

        return false;
    }).mouseup(function () {
        $(this)
            .data('down', false)
            .removeClass("dragging");
    }).mousemove(function (event) {
        if ($(this).data('down') === true) {
            this.scrollLeft = $(this).data('scrollLeft') + $(this).data('x') - event.clientX;
        }
    }).bind('touchstart', function (event) {
        $(this)
            .data('down', true)
            .data('x', event.touches[0].pageX)
            .data('scrollLeft', this.scrollLeft)
            .addClass("dragging");

        return false;
    }).bind('touchend', function () {
        $(this)
            .data('down', false)
            .removeClass("dragging");
    }).bind('touchmove', function (event) {
        if ($(this).data('down') === true) {
            this.scrollLeft = $(this).data('scrollLeft') + $(this).data('x') - event.touches[0].pageX;
        }
    });
    $('.items .item *').bind('touchstart', function (event) {
        $(this).data('move', false);
    }).bind('touchmove', function (event) {
        $(this).data('move', true);
    }).bind('touchend', function (event) {
        if ($(this).data('move') === false) {
            window.open($(this).closest('.item').attr('href'));
        }
    });
    $('.grouping-tags a').click(function () {
        var level = $(this).attr('data-level-num');
        var lesson = $(this).attr('data-lesson-name');
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            if (level) {
                $('input[name="level"]').val('');
            } else if (lesson) {
                $('input[name="lesson"]').val('');
            }
        } else {
            $(this).parent().parent().find('.active').removeClass('active');
            $(this).addClass('active');
            if (level) {
                $('input[name="level"]').val(level);
            } else if (lesson) {
                $('input[name="lesson"]').val(lesson);
            }
        }
    });
    $('.pr-num').each(function () {
        $(this).html(persianNum($(this).html()));
    });
    $('.show-more').click(function () {
        if($(this).html() === 'نمایش بیشتر') {
            $(this).html('نمایش کمتر');
        } else {
            $(this).html('نمایش بیشتر');
        }
        $(this).parent().find('.more-box').slideToggle();
    });
    $('.btn-reject').click(function () {
        $(this).next('.reject-box').slideToggle();
    });
    $('.reject-reason').click(function () {
        $(this).parent().find('.reject-reason-box').slideToggle();
    });
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
