
if (window.$ != undefined) {
    $(document).ready(function () {
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
        if (isAndroid) {
            $("strong").css("font-weight", "bold");
            $("i").css("font-style", "oblique");
            $("em").css("font-style", "oblique");
        }

        if ($('body').width() <= 300) {
            $('.site-text').css('font-size', '9pt');
        }
    });
}

//window.onload = function () {
//    var width = screen.width;
//    var fontSize;
//    if (width < 320) {
//        fontSize = '8pt';
//        document.getElementById('site-text').style.fontSize = fontSize;
//    } if (width > 320) {
//        fontSize = '11pt';
//        document.getElementById('site-text').style.fontSize = fontSize;
//    }
//}
