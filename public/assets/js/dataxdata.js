(function ($) {
    'use strict';

    var body = $("body"), windowWidth = window.innerWidth;

    $('[data-toggle="tooltip"]').tooltip();

    // sidebar mouse events
    $(document).on("mouseenter", "body:not(.sidebar-pinned) .admin-sidebar", function (e) {
        if (windowWidth >= 1200) {
            $(this).addClass("sidebar-show");
        }
    });
    $(document).on("mouseleave", "body:not(.sidebar-pinned) .admin-sidebar", function (e) {
        if (windowWidth >= 1200) {
            $(this).removeClass("sidebar-show");
        }
    });

    //sidebar pin - toggle sidebar pin
    $(document).on("click", ".admin-pin-sidebar", function (e) {
        e.preventDefault();
        body.toggleClass("sidebar-pinned");
        $(this).toggleClass("pinned");
        // trigger resize event for charts to redraw if required
        window.dispatchEvent(new Event('resize'));
    });

    // append backdrop for mobile
    body.append('<div class="sidebar-backdrop "></div>');

    // close event on mobile by clicking close button or backdrop
    $(document).on("click", " .admin-close-sidebar ,.sidebar-backdrop", function (e) {
        e.preventDefault();
        body.removeClass("sidebar-open");

    });
    $(document).on("click", ".open-dropdown", function (e) {
        e.preventDefault();
        if (!$(this).next().is(":visible")) {
            //opens the adjacent list to the target
            $(this).next().slideDown();
            $(this).parent().addClass("opened");
        }
        else {
            //closes the adjacent list to the target
            $(this).next().slideUp();
            $(this).parent().removeClass("opened");
        }
    });
    $(document).on("click", "[data-toggleclass]", function (e) {
        e.preventDefault();
        $($(this).attr("data-target")).toggleClass($(this).attr("data-toggleClass"));
    });
    
    //Select2 JS Integratiion
    if ($(".dataxdata-select2").length) {
        $(".dataxdata-select2").select2();
    }



})(window.jQuery);


