/*****
 * menu sticky
 */

(function ($) {
    $(document).ready(function () {
        $(document).scroll(function () {
            if ($(document).scrollTop() > 0) {
                $("#kalys_nav_menu").addClass("sticky");
            } else {
                $("#kalys_nav_menu").removeClass("sticky");
            }
        })
    })
})(jQuery)
