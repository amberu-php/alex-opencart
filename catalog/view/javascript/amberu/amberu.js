//common
function amberuUrlAddParam(url, param, value) {
   var a = document.createElement('a'), regex = /(?:\?|&amp;|&)+([^=]+)(?:=([^&]*))*/gi;
   var params = {}, match, str = []; a.href = url;
   while (match = regex.exec(a.search))
       if (encodeURIComponent(param) != match[1]) 
           str.push(match[1] + (match[2] ? "=" + match[2] : ""));
   str.push(encodeURIComponent(param) + (value ? "=" + encodeURIComponent(value) : ""));
   a.search = str.join("&");
   return a.href;
}

//overlay
var amberuOverlay = {
	'style' : {
		'zIndex' : 2000,
		'background' : '#000',
		'cursor' : 'progress',
		'opacity' : 0.2,
	},
	'basicCss' : 'display: block; position: fixed; top : 0px; left: 0px; width: 100%; height: 100%;',
	'browsersCompatibility' : true,
	'classNames' : 'amberu-overlay',
	'getCompatibleOpacity' : function () {
		var style = 'filter: alpha(opacity=' + (amberuOverlay.style.opacity * 100) + '); -moz-opacity: ' + amberuOverlay.style.opacity + '; -khtml-opacity: ' + amberuOverlay.style.opacity + ';';
		return style;
	},
	'getCssText' : function () {
		var style = amberuOverlay.basicCss;
		var propertyName;
		for (var key in amberuOverlay.style) {
			if (amberuOverlay.style.hasOwnProperty(key)) {
				propertyName = key;
				if (propertyName == 'zIndex') {
					propertyName = 'z-index';
				}				
				style += ' ' + propertyName + ': ' + amberuOverlay.style[key] + ';';
			}
		}
		if (amberuOverlay.browsersCompatibility) {
			style += ' ' + amberuOverlay.getCompatibleOpacity();
		}
		return style;
	},
	'getHtml' : function (id) {
		var idProp = typeof id !== 'undefined' ? 'id="' + id + '" ' : '';
		var classProp = amberuOverlay.classNames ? 'class="' + amberuOverlay.classNames + '" ' : '';
		var html = '<div ' + idProp + classProp + 'style="' + amberuOverlay.getCssText() + '"></div>';
		return html;
	},
	'show' : function (id) {
		$(document.body).append(amberuOverlay.getHtml(id));
	},
	'hide' : function (id) {
		var id = typeof id !== 'undefined' ? id : false;
		if (id) {
			$('#' + id).css('display', 'none');
		}
		else {
			$('.' + amberuOverlay.classNames).css('display', 'none');
		}
	},
	'remove' : function (id) {
		var id = typeof id !== 'undefined' ? id : false;
		if (id) {
			$('#' + id).remove();
		}
		else {
			$('.' + amberuOverlay.classNames).remove();
		}
	},
};

//Ajax-Search
$(document).ready(function() {
	$('#amberu-search-text').keyup( function(e) {
		var searchText = $(this).val();
		if ((searchText) && (e['keyCode'] != 13)) {
			$.ajax({
				url: 'index.php?route=amberu/search/ajax&search=' + searchText,
				type: 'post',
				data: 'search=' + searchText,
				dataType: 'json',
				success: function(json) {
					//$('#amberu-search-dropdown .amberu-dropdown-menu-inner').html('Success');
					
					var resultLentgh = 7;
					//extended/more search
					var extenedMoreBtnHtml = '';
					var textMoreResults = (json['products'].length > resultLentgh) ? json['amberu_text_search_more'] + '<br/>' : '';
					extenedMoreBtnHtml += 
						'<div style="text-align: center; margin-top: 10px;">\
						  <a onclick="$(\'#amberu-search-button\').trigger(\'click\')" style="display: inline-block; cursor: pointer;">'
						    + textMoreResults
						    + json['amberu_text_search_extended']
						  + 
						  '</a>\
						</div>'
					;
					
					if (json['products'].length) {
						var html = '<table><tbody>';
						for (var i=0; ((i < json['products'].length) && (i < resultLentgh)); i++) {
							html += 
							'<tr>\
							<td><a href="' + json['products'][i]['href'] + '"><img src="' + json['products'][i]['thumb'] + '" /></a></td>\
							<td><a href="' + json['products'][i]['href'] + '">' + json['products'][i]['name'] + '</a></td>\
							</tr>\
							';
						}
						//moreResults
						html += (json['products'].length > resultLentgh) ? 
							'<tr>\
							<td style="text-align: center; font-size: 18px; font-weight: bolder;">...</td>\
							<td style="text-align: center; font-size: 18px; font-weight: bolder;">...</td>\
							</tr>' 
						: '';
						
						html += '</tbody></table>';
						html += extenedMoreBtnHtml;
						
						//assign result html, if search text that requested is equal to search input text presently, after successful request
							//don't need anymore//replace all space symbols at the end of line, coz json['search'] do//if ($('#amberu-search-text').val().replace(/\s+$/,'') == json['search']) {
						if ($('#amberu-search-text').val() == json['amberu_full_search']) {
							$('#amberu-search-dropdown .amberu-dropdown-menu-inner').html(html);
						}
					}
					else {
						var html = json['text_empty'] + extenedMoreBtnHtml;
						$('#amberu-search-dropdown .amberu-dropdown-menu-inner').html(html);
					}
					
					//open if closed && search input not empty
					if ((!$('#amberu-search-dropdown').hasClass('open')) && ($('#amberu-search-text').val())) {
						$('#amberu-search-dropdown .dropdown-toggle').dropdown('toggle');
					}					
				},
				error: function(xhr, ajaxOptions, thrownError) {
					//alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					//commented out coz if enter key pressed all ajax will be stoped, and error will fire
					//alert('ОШИБКА ПОДКЛЮЧЕНИЯ К СЕРВЕРУ');
				}
			});
		}
		else {
			//if opened then close
			if ($('#amberu-search-dropdown').hasClass('open')) {
				$('#amberu-search-dropdown .dropdown-toggle').dropdown('toggle');
			}
		}
	});
	//on #amberu-search-dropdown hide
	$('#amberu-search-dropdown').on('hide.bs.dropdown', function () {
		$('#amberu-search-dropdown .amberu-dropdown-menu-inner').html('<div style="text-align: center; font-size: 18px; font-weight: bolder;">...</div>');
	})
});

//SelectPricelist
$(document).ready(function () {
	$('.amberu-pricelist-select-container .select-amberu-pricelist-number').change(function (e) {
		amberuOverlay.show();
		var opts = amberuSpinner.opts;
		opts['position'] = 'fixed';
		amberuSpinner.spinSpinner(document.body, opts);
	});
});

function amberuSelectPricelistChange(value) {
		var url = location.href;
		var value = value.split('=');
		var param = value[0];
		var value = value[1];
		var newUrl = amberuUrlAddParam(url, param, value);
		//location.href and location equal, but one shorter another
		location = newUrl;
}

//CartSelectPricelist
function amberuCartSelectPricelistOver() { 
		$('#cart ul').css('display', 'block');
		$('#cart').addClass('fake-open');
}
function amberuCartSelectPricelistOut() {
		$('#cart ul').css('display', '');
		$('#cart').addClass('open');
		$('#cart').removeClass('fake-open');
}
function amberuCartSelectPricelistChange(value) {
		var url = location.href;
		var value = value.split('=');
		var param = value[0];
		var value = value[1];
		var newUrl = amberuUrlAddParam(url, param, value);
		amberuOverlay.show();
		var opts = amberuSpinner.opts;
		opts['position'] = 'fixed';
		amberuSpinner.spinSpinner(document.body, opts);
		//location.href and location equal, but one shorter another
		location = newUrl;
}

//Cart Bag Img
function amberuCartBagImgOver(showTransformFlag) {
	if (showTransformFlag === undefined) {
		showTransformFlag = 0;
	}
	var cart = document.getElementById('cart');
	if ((cart.className.indexOf('open') == -1) || (showTransformFlag)) {
		var el = document.getElementById('cart-total');
		//el.style.border = '2px solid #fff';
		//el.style.borderRadius = '10px';
		//el.style.padding = '3px 3px 0px 3px';
		if (el) {
			el.style.cssText = 
				'transform: scale(0.97, 0.97);\
				-webkit-transform: scale(0.97, 0.97);\
				-moz-transform: scale(0.97, 0.97);\
				-o-transform: scale(0.97, 0.97);\
				-ms-transform: scale(0.97, 0.97);\
				';
			el.style.borderBottom = '3px solid #fff';
		}
		el = document.getElementById('amberu-cart-bag-img');
		el.style.cssText = 
			'transform: scale(0.97, 0.97);\
			-webkit-transform: scale(0.97, 0.97);\
			-moz-transform: scale(0.97, 0.97);\
			-o-transform: scale(0.97, 0.97);\
			-ms-transform: scale(0.97, 0.97);\
			';
	}
}
function amberuCartBagImgOut() {
	var cart = document.getElementById('cart');
	if(cart.className.indexOf('open') == -1) {
		var el = document.getElementById('cart-total');
		if (el) {
			el.style.cssText = '';
			el.style.borderColor = 'transparent';
			//el.style.padding = '0px';
		}
		el = document.getElementById('amberu-cart-bag-img');
		el.style.cssText = '';
	}
	
}
function amberuCartBagImgClick() {
	var cart = document.getElementById('cart');
	if(cart.className.indexOf('open') == -1) {
		amberuCartBagImgOut();
	}
	else {
		amberuCartBagImgOver(1);
	}
}