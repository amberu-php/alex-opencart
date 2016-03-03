var amberuSpinner = {
	'opts' : {
	  lines: 11, // The number of lines to draw
	  length: 30, // The length of each line
	  width: 8, // The line thickness
	  radius: 20, // The radius of the inner circle
	  corners: 1, // Corner roundness (0..1)
	  rotate: 9, // The rotation offset
	  direction: 1, // 1: clockwise, -1: counterclockwise
	  color: '#007A88', // #rgb or #rrggbb or array of colors
	  speed: 1, // Rounds per second
	  trail: 50, // Afterglow percentage
	  shadow: true, // Whether to render a shadow
	  //hwaccel: false, // Whether to use hardware acceleration
	  className: 'amberu-spinner', // The CSS class to assign to the spinner
	  zIndex: 2e9, // The z-index (defaults to 2000000000)
	  //top: '50%', // Top position relative to parent
	  //left: '50%' // Left position relative to parent
	},
	'spinner' : false,
	'spinSpinner' : function (selector, opts) {
		var target = $(selector).get(0);
		opts = typeof opts !== 'undefined' ? opts : amberuSpinner.opts;
		if (!amberuSpinner.spinner) {
			amberuSpinner.spinner = new Spinner(opts).spin(target);
		} else {
			amberuSpinner.spinner.spin(target);
		}
	},
	'stopSpinner' : function (selector) {
		var target = $(selector).get(0);
		if (amberuSpinner.spinner) {	
			amberuSpinner.spinner.stop(target);
		}
	},
}