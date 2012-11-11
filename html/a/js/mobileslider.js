function MobileSlider(container, options) {
	this.init(container, options);
}

MobileSlider.prototype.init = function init(container, options) {
	if(typeof container === "string") {
		this.container_element = document.getElementById(container);
	} else {
		this.container_element = container;
	}
	
	this.events = {
		start: ['touchstart', 'mousedown'],
		move: ['touchmove', 'mousemove'],
		end: ['touchend', 'touchcancel', 'mouseup']
	};
	
	this.options = options;
	
	this.allowDecimals = this.options.decimals;
	this.decimalPlaces = this.options.decimal_places;
	
	if(this.options.toggle) {
		this.options.start = 0;
		this.options.min = 0;
		this.options.max = 1;
		this.allowDecimals = true;
		this.decimalPlaces = 2;
		
		var option1 = document.createElement('span');
		option1.innerHTML = this.options.toggle_values[1];
		option1.setAttribute("id", "option1");
		option1.setAttribute("class", "togglespan");
		this.container_element.appendChild(option1);
		
		var option0 = document.createElement('span');
		option0.innerHTML = this.options.toggle_values[0];
		option0.setAttribute("id", "option0");
		option0.setAttribute("class", "togglespan");
		this.container_element.appendChild(option0);
		
		var selected_value_element = document.createElement("span");
		selected_value_element.setAttribute("id", "selectedvalue");
		this.container_element.appendChild(selected_value_element);
		this.selected_value_element = document.getElementById("selectedvalue");
		
		option1.style.left = option1.offsetWidth +"px";
		
	}

	this.supportsWebkit3dTransform = (
      'WebKitCSSMatrix' in window && 
      'm11' in new WebKitCSSMatrix()
    );
	
	this.circle = this.container_element.getElementsByClassName('circle')[0];
    this.bar = this.container_element.getElementsByClassName('bar')[0];
    
    this.start = this.start.bind(this);
    this.move = this.move.bind(this);
    this.end = this.end.bind(this);
    
    this.addEvents("start");
    this.setValue(this.options.start);
};

MobileSlider.prototype.addEvents = function addEvents(name) {
    var list = this.events[name];
    var handler = this[name];
    
    for (var next in list){
      this.container_element.addEventListener(list[next], handler, false);
    }
};

MobileSlider.prototype.removeEvents = function removeEvents(name){ 
	var list = this.events[name];
    var handler = this[name];
      
    for (var next in list){
      this.container_element.removeEventListener(list[next], handler, false);
    }
};

MobileSlider.prototype.start = function start(event) {	
	this.addEvents("move");
    this.addEvents("end");
    this.handle(event);
};

MobileSlider.prototype.move = function move(event) {
	this.handle(event);
};

MobileSlider.prototype.end = function end(event) {
	this.removeEvents("move");
    this.removeEvents("end");
};

MobileSlider.prototype.setValue = function setValue(value) {
	if (value === undefined){ value = this.options.min; }
    
    value = Math.min(value, this.options.max);
    value = Math.max(value, this.options.min);
    
    var circleWidth = this.circle.offsetWidth;
    var barWidth = this.bar.offsetWidth;
    var range = this.options.max - this.options.min;
    var width = barWidth - circleWidth;
    var position = Math.round((value - this.options.min) * width / range);

    this.setCirclePosition(position);
    this.value = value;
    this.callback(value);
};

MobileSlider.prototype.setCirclePosition = function setCirclePosition(x_position) {
    
	if (this.supportsWebkit3dTransform) {
		this.circle.style.webkitTransform = 'translate3d(' + x_position + 'px, 0, 0)';
		if(this.options.toggle) {
			var option0 = document.getElementById("option0");
    		var option1 = document.getElementById("option1");
    		
    		option0.style.webkitTransform = 'translate3d(' + ((option0.offsetLeft)-x_position) + 'px, 0, 0)';
    		option1.style.webkitTransform = 'translate3d(' + ((option0.offsetLeft - 20)-x_position) + 'px, 0, 0)';
			
			this.setToggleValue();
		}
    } else {
    	this.circle.style.webkitTransform = 
    	this.circle.style.MozTransform = 
    	this.circle.style.msTransform = 
    	this.circle.style.OTransform = 
    	this.circle.style.transform = 'translateX(' + x_position + 'px)';
      
    	if(this.options.toggle) {
    		var option0 = document.getElementById("option0");
    		var option1 = document.getElementById("option1");
    	    
    		option0.style.webkitTransform = 
    		option0.style.MozTransform = 
    		option0.style.msTransform = 
    		option0.style.OTransform = 
    		option0.style.transform = 'translateX(' + ((option0.offsetLeft)-x_position) + 'px)';
    		
    		option1.style.webkitTransform = 
    		option1.style.MozTransform = 
    		option1.style.msTransform = 
    		option1.style.OTransform = 
    		option1.style.transform = 'translateX(' + ((option0.offsetLeft - 20)-x_position) + 'px)';
    		
    		this.setToggleValue();
    	}
    }
};

MobileSlider.prototype.setToggleValue = function setToggleValue() {
	if(this.circle.style.transform === "translateX(0px)") {
		this.selected_value_element.innerHTML = this.options.toggle_values[0];
	} else {
		this.selected_value_element.innerHTML = this.options.toggle_values[1];
	}
};

MobileSlider.prototype.handle = function handle(event) {
    event.preventDefault();
    if (event.targetTouches){ event = event.targetTouches[0]; }
  
    var position = event.pageX; 
    var element;
    var circleWidth = this.circle.offsetWidth;
    var barWidth = this.bar.offsetWidth;
    var width = barWidth - circleWidth;
    var range = (this.options.max - this.options.min);
    var value;
      
    for (element = this.element; element; element = element.offsetParent) {
      position -= element.offsetLeft;
    }
    
    position += circleWidth / 2;
    position = Math.min(position, barWidth);
    position = Math.max(position - circleWidth, 0);
  
    this.setCirclePosition(position);
    	value = (this.options.min + (position * range / width)).toFixed(this.decimalPlaces);
    if(this.allowDecimals) {
    	
    } else {
    	value = this.options.min + Math.round(position * range / width);
    }
    this.setValue(value);
};

MobileSlider.prototype.callback = function callback(value) { 
    if (this.options.update){
    	this.options.update(value);
    }
};