$(document).ready(function () {
    $('a.same-page-link').bind('click', function (ev) {
        var target = $($(this).attr('href')).offset().top;
        var deviceAgent = navigator.userAgent.toLowerCase();
        var agentID = deviceAgent.match(/(ipod|ipad)/);
        if (agentID) {
            target -= window.scrollY;
        }

        $.mobile.silentScroll(target);
        return false;
    });
});
    