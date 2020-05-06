jQuery(document).ready(function($) {

    function calculateMenuItems(){
        let menu = $('#festival-menu'),
            sub_menu = $('#festival-sub-menu'),
            items = menu.find('.nav-item'),
            total_width = 0;


        items.each((i, item) => {
            total_width += $(item).outerWidth(true);

            if(total_width > menu.outerWidth())
                sub_menu.append($(item));
        });

        menu.closest('#festival-menu-wrap').css({
            'position': 'relative',
            'top': 0
        });
    }

    calculateMenuItems();

    /*
    ** Sticky header
    */
    $('#header .stick-line').mouseover(function() {
        $('#header').addClass('hover');
    });

    $('#header').siblings().mouseover(function() {
        $('#header').removeClass('hover');
    });

    function stickyNav() {
        var scrollTopPosition = $('#festival-menu-wrap').height();
        var stickyNavTop = $('#header').height() + scrollTopPosition;

        var scrollTop = $(window).scrollTop();

        if (scrollTop > stickyNavTop) {
            $('#header').addClass('stick');
        } else {
            $('#header').removeClass('stick');
        }

    };

    stickyNav();

    $(window).scroll(function () {
        stickyNav();
    });

    //function toggle active class
    function activeBlock(activator, visibleBlock) {

        $(activator).on('click', function (e) {
            if ($(this).hasClass('show_menu')) {
                $(this).removeClass('show_menu');
                $(visibleBlock).removeClass('active_menu');
            } else {
                $(this).addClass('show_menu').parents('body').find('.activator').not($(this)).removeClass('show_menu');
                $(visibleBlock).addClass('active_menu').parents('body').find('.hidden_item').not(visibleBlock).removeClass('active_menu');
            }

            e.stopPropagation();
            //return false;
        });

        //Exclude Item
        $('html,body').click(function (e) {
            if ($(e.target).closest(visibleBlock).length && !$(e.target).is(visibleBlock))return;
            {
                $(visibleBlock).removeClass('active_menu');
                $(activator).removeClass('show_menu');
            }
        });
    }

    activeBlock('#fest-icon-wrap', '#fest-menu-box');
    activeBlock('.lang-menu .current-lang', '.lang-menu .lang-box');
    activeBlock('#header #search-icon', '#search-wrap');
    activeBlock('.share-btn-multi', '.share-btn-multi .share-drop');

    $('#fest-close').on('click', function (e) {
            $('#fest-icon-wrap').removeClass('show_menu');
            $('#fest-menu-box').removeClass('active_menu');
        e.stopPropagation();
    });

    /*MAIN SLider*/
    $('#top-slider').slick({
        infinite: true,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev">' +
        '<svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '<path d="M44.6994 14.4711L31.2139 0.633211C30.3911 -0.211071 29.0568 -0.211071 28.234 0.633211C27.411 1.47767 27.411 2.84658 28.234 3.69103L38.1224 13.8378H2.1071C0.943476 13.8378 0 14.8059 0 16C0 17.1938 0.943476 18.1621 2.1071 18.1621H38.1224L28.2343 28.3089C27.4114 29.1534 27.4114 30.5223 28.2343 31.3667C28.6456 31.7886 29.185 32 29.7243 32C30.2635 32 30.8028 31.7886 31.2143 31.3667L44.6994 17.5289C45.5223 16.6844 45.5223 15.3155 44.6994 14.4711Z" transform="translate(45.3167 32) rotate(-180)" fill="white"/>\n' +
        '</svg>' +
        '</button>',
        nextArrow: '<button type="button" class="slick-next">' +
        '<svg width="46" height="32" viewBox="0 0 46 32" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '<path d="M44.6994 14.4711L31.2139 0.633211C30.3911 -0.211071 29.0568 -0.211071 28.234 0.633211C27.411 1.47767 27.411 2.84658 28.234 3.69103L38.1224 13.8378H2.1071C0.943476 13.8378 0 14.8059 0 16C0 17.1938 0.943476 18.1621 2.1071 18.1621H38.1224L28.2343 28.3089C27.4114 29.1534 27.4114 30.5223 28.2343 31.3667C28.6456 31.7886 29.185 32 29.7243 32C30.2635 32 30.8028 31.7886 31.2143 31.3667L44.6994 17.5289C45.5223 16.6844 45.5223 15.3155 44.6994 14.4711Z" fill="white"/>\n' +
        '</svg>' +
        '</button>'
    });

    /*MAIN event-carousel*/
    $('.main-event-carousel .carousel-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true
       // asNavFor: '.main-event-carousel .carousel-nav'
    });


    /*Content Slider for inner page*/

    $('.img-slider-wrap .slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.img-slider-wrap .slider-nav',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: true,
                    prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                    nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
                }
            }
        ]
    });

    $('.img-slider-wrap .slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.img-slider-wrap .slider-for',
        focusOnSelect: true,
        prevArrow: '<button type="button" class="slick-prev slick-arrow"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
        nextArrow: '<button type="button" class="slick-next slick-arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
    });


    //function activates horizontal scroll
    function scrollXItem(parentEl, childEl, scrollCount){
        var scrollItem = scrollCount;
        $(parentEl).each(function (i) {

            var subCount = $(this).find(childEl).length;
            var wrapWidth = $(this).width();
            $(this).find('.item-wrap').width(wrapWidth);

            if(subCount > scrollItem){
                $(this).mCustomScrollbar({
                    theme: "dark-3",
                    axis:"x"
                });
            }else{
                $(this).mCustomScrollbar('destroy');
            }
        });


    }

    //GALLERY fancybox plugin

    if($('[data-fancybox="gallery"]').length > 0){
        $('[data-fancybox="gallery"]').fancybox({
            buttons: [
                "zoom",
                //"share",
                //"slideShow",
                //"fullScreen",
                //"download",
                "thumbs",
                "close"
            ],
            transitionEffect: 'slide'
        });
    }


    checkSize();

    $(window).resize(function () {
        calculateMenuItems();
        stickyNav();
        checkSize();
    });



    function checkSize(){
        if ($(window).width() >= '992'){
            scrollXItem('.main-event-wrap .sub-event', '.sub-event-item', 4);
            scrollXItem('.filter-content .sub-event', '.sub-event-item', 6);
            scrollXItem('.more-events .sub-event', '.sub-event-item', 6);
        }else if($(window).width() < '575'){
            scrollXItem('.main-event-wrap .sub-event', '.sub-event-item', 3);
            scrollXItem('.filter-content .sub-event', '.sub-event-item', 2);
            scrollXItem('.more-events .sub-event', '.sub-event-item', 2);
        }else{
            scrollXItem('.main-event-wrap .sub-event', '.sub-event-item', 4);
            scrollXItem('.filter-content .sub-event', '.sub-event-item', 3);
            scrollXItem('.more-events .sub-event', '.sub-event-item', 2);
        }

        if ($(window).width() < '576'){
            $('#header').find('#user-icon').insertBefore('#header .navbar .navbar-toggler');
            $('#header').find('#search-icon').insertBefore('#header .navbar .navbar-toggler');

            $('.right-sidebar .sidebar-title').on('click', function () {
                $(this).parent('.sidebar-item').toggleClass('act-content');
            });
        }else{
            if($('#header .navbar .navbar-toggler').siblings('#user-icon').length){
                $('#user-icon').prependTo('#header .form-inline');
                $('#search-icon').prependTo('#header .form-inline');
            }
        }
    }

    //plugin /jQuery Form Styler/ for select
    $('select, input[type="checkbox"]').styler({selectSmartPositioning: false});

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#contact-form, #subscribe-form').on('submit', (e) => {
        e.preventDefault();

        let form = $(e.currentTarget);

        $.ajax({
            'type': 'post',
            'data': form.serialize(),
            'url': form.attr('action'),
            'success': (data) => {
                swal({
                    title: 'Success',
                    text: data.message,
                    type: 'success',
                    confirmButtonText: 'Ok',
                    confirmButtonClass: 'btn btn-primary',
                });

                form.find('input').val('');
            },
            'error': (xhr) => {
                let response = xhr.responseJSON;

                $.each(response.errors, (field, message) => {
                    form.find(`#${field}`).closest('form').before($('<div class="error pt-2">').html(message));
                });
            }
        });
    });

});
