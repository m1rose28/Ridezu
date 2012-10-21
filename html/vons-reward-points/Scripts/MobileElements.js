if (window.$ != undefined) {
    $(document).ready(function () {
        setDevisePixelRatio();
    });
} else {
    window.onload = setDevisePixelRatio();
}

function setDevisePixelRatio() {
    var pixelRatio = window.devicePixelRatio;
    var cookieName = "_devicePixelRatio";
    setCookie(cookieName, pixelRatio, 999);
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}
