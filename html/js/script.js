$(document).ready(function(){
	var pagebody = $("#pagebody");
	var themenu  = $("#navmenu");
	var topbar   = $("#toolbarnav");
	var content  = $("#mainpage");
	var viewport = {
    	width  : $(window).width(),
    	height : $(window).height()
	};
	// retrieve variables as 
	// viewport.width / viewport.height
	
	function openme() { 
		$(function () {
		    topbar.animate({
		       left: "280px"
		    }, { duration: 120,easing: 'linear', queue: false });
		    pagebody.animate({
		       left: "280px"
		    }, { duration: 120,easing: 'linear', queue: false });
			themenu.animate({
		       left: "0px"
		    }, { duration: 120,easing: 'linear', queue: false });
		});
	}
	
	function closeme() {
		var closeme = $(function() {
	    	topbar.animate({
	            left: "0px"
	    	}, { duration: 120, easing: 'linear', queue: false });
	    	pagebody.animate({
	            left: "0px"
	    	}, { duration: 120, easing: 'linear', queue: false });
			themenu.animate({
		       left: "-280px"
		    }, { duration: 120, easing: 'linear', queue: false });
		});
	}

	// checking whether to open or close nav menu
	$("#menu-btn").live("click", function(e){
		e.preventDefault();
		
		if(tp==""){
			var leftval = pagebody.css('left');
			
			if(leftval == "0px") {
				openme();
			}
			else { 
				closeme(); 
			}
		}
		
		if(tp!=""){
			navt1();	
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
	    	topbar.animate({
	            left: "0px"
	    	}, { duration: 120, easing: 'linear', queue: false });
	    	pagebody.animate({
	            left: "0px"
	    	}, { duration: 120, easing: 'linear', queue: false });
			themenu.animate({
		       left: "-280px"
		    }, { duration: 120, easing: 'linear', queue: false });
		});
	}
