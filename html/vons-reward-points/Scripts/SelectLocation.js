var department = 'none';
var service;

$(document).ready(function () {
    $(".search-button").click(searchButtonClick);

    $(".current-button").click(currentButtonClick);

    $("#location-input").click(function () {
        $(this).val('');
        $(this).removeClass('italic');
        $(this).addClass('black');
        $(this).css('border', '1px solid #bababa');
    });
});

function geolocationNotSupported() {
    alert('Geolocation services are either disabled or not supported on your device');
}


function redirectToCurrentLocation(position) {
    if ($.mobile.pageLoading) {
        $.mobile.pageLoading();
    }
    var loc = position.coords.latitude + ',' + position.coords.longitude;
    readDepartmentInput();
    window.location = '/StoreLocator/ListView?service=' + service + '&location=' + loc + '&department=' + department;
}

function setServiceAndDepartment(srv, dep) {
    service = srv;
    if (dep) {
        department = dep;
    }
}

function readDepartmentInput() {
    if (department == 'deli') { //croocked nail
        service = 'StoreLocator';
    }
    var webmenu = document.getElementById('select-choice');
    if (webmenu) {
        department = webmenu.value;
    }
    else {
        var dropdown = document.getElementById('webmenu-smart');
        if (dropdown) {
            department = dropdown.value;
        }
    }
}

function searchButtonClick() {
    var location = document.getElementById('location-input').value;
    if (location == '' || location == 'Enter Zip Code or City & State') {
        document.getElementById('location-input').style.border = '1px solid #a52020';
    } else {
        if (window.$ != undefined) {
            if ($.mobile.pageLoading) {
                $.mobile.pageLoading();
            }
        }
        var isSignatureCafe = department == 'deli';
        if (isSignatureCafe) { //croocked nail
            service = 'StoreLocator';
        }
        var webmenu = document.getElementById('select-choice');
        if (webmenu != null) {
            department = webmenu.value;
        }
        else {
            var dropdown = document.getElementById('webmenu-smart');
            if (dropdown != null) {
                department = dropdown.value;
            }
        }
        window.location = '/StoreLocator/ListView?service=' + service + '&location=' + location + '&department=' + department;
    }
}

function currentButtonClick() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(redirectToCurrentLocation, geolocationNotSupported);
    } else {
        if (navigator.userAgent.toLowerCase().indexOf("blackberry") > -1) {
            if (blackberry.location.GPSSupported) {
                var lat = blackberry.location.latitude;
                var lon = blackberry.location.longitude;
                if (lat == 0 || lon == 0) {
                    return;
                }
                loc = lat + ',' + lon;
                var isSignatureCafe = department == 'deli';
                if (isSignatureCafe) { //croocked nail
                    service = 'StoreLocator';
                }
                var dropdown = document.getElementById('webmenu-smart');
                if (dropdown != null) {
                    department = dropdown.value;
                }
                var url = '/StoreLocator/ListView?service=' + service + '&location=' + loc + '&department=' + department;
                window.location = url;
            }
        } else {
            geolocationNotSupported();
        }
    }
}