$(document).ready(function() {
    // if (screen.width > 1024) {
    //     $(".mobile").remove();
    // } else {
    //     $(".desktop").remove();
    // }

    $('.sci-header-desktop').hcSticky();

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
    $('.sidebar').hcSticky();
});


$(function() {
    var lastScrollTop = 0,
        delta = 15;
    $(window).scroll(function(event) {
        var st = $(this).scrollTop();

        if (Math.abs(lastScrollTop - st) <= delta)
            return;
        if ((st > lastScrollTop) && (lastScrollTop > 0)) {
            // downscroll code
            $(".head-one").slideUp(100);
            $(".sci-header-mobile .top").slideUp(100);
            // $(".head-two").slideUp(100);
            // $(".navbar-default").css("top", "0px");
            // $(".sci-header-mobile").css("top", "-60px");
        } else {
            // upscroll code
            $(".head-one").slideDown(100);
            $(".sci-header-mobile .top").slideDown(100);
            // $(".head-two").slideDown(100);
            // $(".navbar-default").css("top", "-30px");
            // $(".sci-header-mobile").css("top", "0px");
        }
        lastScrollTop = st;
    });
});


function buttonUp() {
    var valux = $('.sb-search-input').val();
    valux = $.trim(valux).length;
    if (valux !== 0) {
        $('.sb-search-submit').css('z-index', '99');
    } else {
        $('.sb-search-input').val('');
        $('.sb-search-submit').css('z-index', '-999');
    }
}

$(document).ready(function() {
    var submitIcon = $('.sb-icon-search');
    var submitInput = $('.sb-search-input');
    var searchBox = $('.sb-search');
    var isOpen = false;

    $(document).mouseup(function() {
        if (isOpen == true) {
            submitInput.val('');
            $('.sb-search-submit').css('z-index', '-999');
            submitIcon.click();
        }
    });

    submitIcon.mouseup(function() {
        return false;
    });

    searchBox.mouseup(function() {
        return false;
    });

    submitIcon.click(function() {
        if (isOpen == false) {
            searchBox.addClass('sb-search-open');
            isOpen = true;
        } else {
            searchBox.removeClass('sb-search-open');
            isOpen = false;
        }
    });

});
$('#close-newsletter').click(function() {
    $('.newsletter-div').fadeOut(300);
    $('body').css('margin-bottom', '0');
});
$('#search-btn').click(function() {
    $('.search-mobile-div').slideToggle(100);
});
