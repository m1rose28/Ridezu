$(document).ready(function(){
	var pagebody = $("#pagebody");
	var themenu  = $("#navmenu");
	var topbar   = $("#toolbarnav");
	var content  = $("#content");
	var viewport = {
    	width  : $(window).width(),
    	height : $(window).height()
	};
	// retrieve variables as 
	// viewport.width / viewport.height
	
	function openme() { 
		$(function () {
		    pagebody.animate({
		       left: "280px"
		    }, { duration: 190, queue: false });
			themenu.animate({
		       left: "0px"
		    }, { duration: 190, queue: false });
		});
	}
	
	function closeme() {
		var closeme = $(function() {
	    	pagebody.animate({
	            left: "0px"
	    	}, { duration: 190, queue: false });
			themenu.animate({
		       left: "-280px"
		    }, { duration: 190, queue: false });
		});
	}

	// checking whether to open or close nav menu
	$("#menu-btn").live("click", function(e){
		e.preventDefault();
		var leftval = pagebody.css('left');
		
		if(leftval == "0px") {
			openme();
		}
		else { 
			closeme(); 
		}
	});
	
	
});

	function closeme() {
	var pagebody = $("#pagebody");
	var themenu  = $("#navmenu");
	var topbar   = $("#toolbarnav");
	var content  = $("#content");
	var viewport = {
    	width  : $(window).width(),
    	height : $(window).height()
	};
	// retrieve variables as 
	// viewport.width / viewport.height

		var closeme = $(function() {
	    	pagebody.animate({
	            left: "0px"
	    	}, { duration: 190, queue: false });
			themenu.animate({
		       left: "-280px"
		    }, { duration: 190, queue: false });
		});
	}
