var serviceType;
var url;
var dept = 'none';

$(".clickable-footer").click(function (e) {
	var location = $(e.currentTarget).find(".hidden-link").attr('href');
	var target = $(e.currentTarget).find(".hidden-link").attr('target');
	window.open(location, target);
});

$(".clickable-weekly").click(function (e) {
	e.preventDefault();
	setServiceTypeAndUrl('WeeklySpecials', '/StoreLocator/SelectLocation?service=WeeklySpecials');
	useGeoLocation()
});

$(".clickable-locator").click(function (e) {
	e.preventDefault();
	setServiceTypeAndUrl('StoreLocator', '/StoreLocator/SelectLocation?service=StoreLocator');
	useGeoLocation()
});

function useGeoLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(updateCurrentLocation, errorFindingPosition);
	} else {
		if ($.mobile.pageLoading) {
			$.mobile.pageLoading();
		}
		window.location = url;
	}
}

function errorFindingPosition() {
	window.location = url;
}

function updateCurrentLocation(position) {
	if ($.mobile.pageLoading) {
		$.mobile.pageLoading();
	}
    var loc = position.coords.latitude + ',' + position.coords.longitude;
    window.location = '/StoreLocator/ListView?service=' + serviceType + '&location=' + loc + '&department=' + dept;
}

function setServiceTypeAndUrl(service, selectUrl) {
	if (service) {
		serviceType = service;
	}
	if (selectUrl) {    
		url = selectUrl;
	}
}