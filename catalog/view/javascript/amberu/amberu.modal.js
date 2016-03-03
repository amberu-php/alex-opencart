//common 
function amberuAnimateIt(element, animation, timeout){
	element = $(element);
	element.addClass('animated ' + animation);
	//wait for animation to finish before removing classes
	window.setTimeout( function(){
		element.removeClass('animated ' + animation);
	}, timeout);         
}
function amberuGetWindowSizes() {
	var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    y = w.innerHeight|| e.clientHeight|| g.clientHeight;
	return {'x' : x, 'y' : y};
}
//easyModal
var amberuEasyModal = {
	'openAnimation' : 'zoomInDown',
	'closeAnimation' : 'zoomOutUp',
	'animationTimeout' : 1000,
	'setValues' : function(selector, values) {
		var id = $(selector).attr('id');
		if (id) {
			amberuEasyModal.items[id]['values'] = values;
			return true;
		}
		else {
			return false;
		}
	},
	'getValues' : function(selector) {
		var id = $(selector).attr('id');
		if ((id) && ('values' in amberuEasyModal.items[id])) {
			return amberuEasyModal.items[id]['values'];
		}
		else {
			return false;
		}
	},
	'fill' : function (selector, content, title, values, inputHidden) {
		content = typeof content !== 'undefined' ? content : '';
		title = typeof title !== 'undefined' ? title : '';
		inputHidden = typeof inputHidden !== 'undefined' ? inputHidden : '';
		$(selector + ' .amberu-easy-modal-title').html(title);
		$(selector + ' .amberu-easy-modal-content').html(content);
		amberuEasyModal.setValues(selector, values);
		$(selector + ' .amberu-easy-modal-input-hidden').val(inputHidden);
	},
	//height
	'setHeight' : function (el) {
		var viewportHeight = Math.min($(window).height(), amberuGetWindowSizes().y);
		var viewportWidth = $(window).width();
		//reset
		$(el).css('max-height', '');
		$(el + ' .amberu-easy-modal-content').css('max-height', '');
		//measurement
		var elStyle = document.getElementById($(el).attr('id')).style.cssText;
		$(el).css({ 'margin' : '0', 'left' : viewportWidth+1000, 'display' : 'block'});
		var titleHeight = $(el + ' .amberu-easy-modal-title').outerHeight(true);
		var controlHeight = $(el + ' .amberu-easy-modal-control').outerHeight(true);
		//90% from viewportHeight
		var easyModalHeight = Math.round(viewportHeight * 0.9);
		var easyModalIndentHeight = $(el).outerHeight() - $(el).height();//padding + border + margin
		var contentHeight = easyModalHeight - titleHeight - controlHeight - easyModalIndentHeight;
		//remove and reset added properties to modal window(assign old style string)
		document.getElementById($(el).attr('id')).style.cssText = elStyle;
		$(el).css('max-height', easyModalHeight);
		$(el + ' .amberu-easy-modal-content').css('max-height', contentHeight);
	},
	'open' : function (el, animation) {
		animation = typeof animation !== 'undefined' ? animation : amberuEasyModal.openAnimation;
		amberuEasyModal.setHeight(el);
		$(el).trigger('openModal');
		if (animation) {
			var animationTimeout = amberuEasyModal.animationTimeout;
			amberuAnimateIt(el, animation, animationTimeout);
		}
	},
	'close' : function (el, animation) {
		animation = typeof animation !== 'undefined' ? animation : amberuEasyModal.closeAnimation;		
		var animationTimeout = animation ? amberuEasyModal.animationTimeout : 0;
		if (animation) {
			amberuAnimateIt(el, animation, animationTimeout);
		}
		window.setTimeout( function(){
			$(el).trigger('closeModal');
			//$('.amberu-easy-modal-content').html('<div class="amberu-loading">Загрузка...</div>');
		}, animationTimeout);
	},
	//accounting
	'items' : new Object(),
}
//initialization
$(document).ready(function() {
	$('[class~="amberu-easy-modal"]').each(function(index, el) {
		var id = $(el).attr('id');
		if (id) {
			amberuEasyModal.items[id] = new Object;
		}
	});
	
	$('.amberu-easy-modal-btn-product-add').click(function(e) {
		var el = $(this).attr('value');
		var values = amberuEasyModal.getValues(el);
		values['product_page'] = typeof values['product_page'] !== 'undefined' ? values['product_page'] : false;
		if (values['product_page']) {
			amberuProductPageConfirmedAdd();
		}
		else if ((typeof values['product_id'] !== 'undefined') && (typeof values['quantity'] !== 'undefined')) {
			cart.confirmedAdd(values['product_id'], values['quantity']);
		}
		amberuEasyModal.close(el);
	});
	$('.amberu-easy-modal-btn-close').click(function(e) {
		var target = $(this).attr('value');
		amberuEasyModal.close(target);
		e.preventDefault();
	});
	//easy-modal initialization
	$('.amberu-easy-modal').each(function(index, el) {
		el = $(el);
		var options = {
			overlay: 0.2,
			overlayClose: false,
			zIndex: function () {
				var selector = '.amberu-easy-modal';
				var zIndex = 100;
				var elements = $(selector);
				elements.each(function(index, el) {
					var cssDisplay = $(el).css('display');
					if (cssDisplay == 'block') {
						var elZindex = parseInt($(el).css('z-index'));
						zIndex = zIndex < elZindex ? elZindex + 1 : zIndex;
					}
				});
				return zIndex;
			},
			//transitionIn: 'animated rotateIn',
			//transitionOut: 'animated rotateOutDownLeft',
			//closeButtonClass: '.animated-close'
		}
		if (el.attr('id') == 'amberu-easy-modal-product') {
			options['top'] = '5%';
		}
		el.easyModal(options);
	});

});



//amberu-my-modal
var amberuMyModal = {
	//common
	
	//accounting
	'items' : new Object(),
	
	//fill
	'fill' : function (el, content, title, inputHidden) {
		content = typeof content !== 'undefined' ? content : '';
		title = typeof title !== 'undefined' ? title : '';
		inputHidden = typeof inputHidden !== 'undefined' ? inputHidden : '';
		//el .clasName - space between el and clasName here is descendant selector(A descendant of an element could be a child, grandchild, great-grandchild, and so on, of that element.)
		$(el + ' .amberu-my-modal-title').html(title);
		//reopen realization
		if (amberuMyModal.getOpenStatus(el) > 0) {
			$(el + ' .amberu-my-modal-content').prepend(content + '<br/>');
		}
		else {
			$(el + ' .amberu-my-modal-content').html(content);
		}
		//
		$('.amberu-my-modal-input-hidden').val(inputHidden);
	},
	//height
	'setHeight' : function (el) {
		var viewportHeight = $(window).height();
		var viewportWidth = $(window).width();
		//reset
		$(el).css('max-height', '');
		$(el + ' .amberu-my-modal-content').css('max-height', '');
		//measurement
		var elStyle = document.getElementById($(el).attr('id')).style.cssText;
		$(el).css({ 'margin' : '0', 'left' : viewportWidth+1000, 'display' : 'block'});
		var titleHeight = $(el + ' .amberu-my-modal-title').outerHeight(true);
		var controlHeight = $(el + ' .amberu-my-modal-control').outerHeight(true);
		//90% from viewportHeight
		var myModalHeight = Math.round(viewportHeight * 0.9);
		var myModalIndentHeight = $(el).outerHeight() - $(el).height();//padding + border + margin
		var contentHeight = myModalHeight - titleHeight - controlHeight - myModalIndentHeight;
		//remove and reset added properties to modal window(assign old style string)
		document.getElementById($(el).attr('id')).style.cssText = elStyle;
		$(el).css('max-height', myModalHeight);
		$(el + ' .amberu-my-modal-content').css('max-height', contentHeight);
	},
	//openStatus
	'setOpenStatus' : function (selector, event) {
		var id = $(selector).attr('id');
		if (id) {
			if (id in amberuMyModal.items) {
				//initialize
				if (!('open' in amberuMyModal.items[id])) {
					amberuMyModal.items[id]['open'] = 0;
				}
				
				if (event == 'open') {
					amberuMyModal.items[id]['open']++;
				}
				else if (event == 'close') {
					amberuMyModal.items[id]['open'] = 0;
				}
				return amberuMyModal.items[id]['open'];
			}
			else {
				return false;
			}
		}
	},
	'getOpenStatus' : function (selector) {
		var id = $(selector).attr('id');
		if (id) {
			if (id in amberuMyModal.items) {
				return amberuMyModal.items[id]['open'];
			}
			else {
				return false;
			}
		}
	},
	//open
	'open' : function (el, autoClose) {
		amberuMyModal.setHeight(el);
		autoClose = typeof autoClose !== 'undefined' ? parseInt(autoClose) : 0;
		//reopen realization
		var openStatus = amberuMyModal.getOpenStatus(el);
		$(el).css('display', 'block');
		if (openStatus > 0) {
			//reopened
			amberuAnimateIt(el, 'shake', 1000);
		}
		else {
			amberuAnimateIt(el, 'zoomInRight', 1000);
		}
		openStatus = amberuMyModal.setOpenStatus(el, 'open');
		if (autoClose) {
			window.setTimeout( function(){
				if ((!$(el).hasClass('amberu-my-modal-hovered')) && (openStatus == amberuMyModal.getOpenStatus(el))) {
					amberuMyModal.close(el);
				}
			}, autoClose);
		}
	},
	//close
	'close' : function (el) {
		var openStatus = amberuMyModal.getOpenStatus(el);
		amberuAnimateIt(el, 'zoomOutRight', 1000);
		window.setTimeout( function(){
			if (openStatus == amberuMyModal.getOpenStatus(el)) {
				$(el).css('display', 'none');
				//$(el + ' .amberu-my-modal-content').html('<div class="amberu-loading">Загрузка...</div>');
				//remove hovered class
				$(el).removeClass('amberu-my-modal-hovered');
				//reopen realization
				amberuMyModal.setOpenStatus(el, 'close');
			}
		}, 1000);
	},
	
	//initialization
	'initialize' : function (id) {
		id = typeof id !== 'undefined' ? id : false;
		if(id) {
			//accounting
			amberuMyModal.items[id] = new Object;
			
			$('#' + id + ' ' + '.amberu-my-modal-btn-open').click(function(e) {
				var target = $(this).attr('value');
				amberuMyModal.setHeight(target);
				$(target).css('display', 'block');
				amberuAnimateIt(target, 'zoomInRight', 1000);
				e.preventDefault();
			});
			$('#' + id + ' ' + '.amberu-my-modal-btn-close').click(function(e) {
				var target = $(this).attr('value');
				amberuMyModal.close(target);
				e.preventDefault();
			});
			
			$('#' + id).hover(function(e) {
				$(e['delegateTarget']).addClass('amberu-my-modal-hovered');
			});
			//initialization
			$('#' + id).css('display', 'none');
		}
		else {
			//accounting
			$('[class~="amberu-my-modal"]').each(function(index, el) {
				var id = $(el).attr('id');
				if (id) {
					amberuMyModal.items[id] = new Object;
				}
			});
			
			$('.amberu-my-modal-btn-close').click(function(e) {
				var target = $(this).attr('value');
				amberuMyModal.close(target);
				e.preventDefault();
			});
			//on hover add class// see using class equals(class="value") coz .amberu-my-modal-content etc. starts with .amberu-my-modal too
			$('[class~="amberu-my-modal"]').hover(function(e) {
				$(e['delegateTarget']).addClass('amberu-my-modal-hovered');
			});
			//initialization
			$('[class~="amberu-my-modal"]').css('display', 'none');
		}
	},
}

$(document).ready(function() {
	amberuMyModal.initialize();
});

/*
//jquery-ui
$(function() {
	$( "#amberu-dialog" ).dialog({
	  resizable: true,
	  autoOpen: false,
	  height: 'auto',
	  modal: true,
	  buttons: {
		"Подтвердить": function() {
		  $( this ).dialog( "close" );
		},
		"Отмена": function() {
		  var target = $(this);
		  //$( this ).dialog( "close" );
		  amberuAnimateIt('.ui-dialog', 'zoomOutUp', 1000);
		  window.setTimeout( function(){
			$( target ).dialog( "close" );
			//$('#modal3-inner').html('<div class="amberu-loading">Загрузка...</div>');
		  }, 1000);
		}
	  }
	});
});
$('.amberu-dialog-open').click(function(e) {
	var target = $(this).attr('value');
	$(target).dialog( "open" );
	amberuAnimateIt('.ui-dialog', 'zoomInDown', 1000);
	e.preventDefault();
});
*/