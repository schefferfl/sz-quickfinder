/**
 * Created by roemmichde on 20.03.14.
 */
(function($) {
	'use strict';
	var pageType = 8375;
	var timer = null;

	var initAutocomplete = function() {
		var $searchbox = $('.tx-indexedsearch-searchbox-sword');
		$searchbox.attr('autocomplete', 'off');
		var container =  $('.tx-indexedsearch-searchbox-results');
		$searchbox.bind('click keyup',function(e) {
			var L = $('body').attr('data-languid');
			if(e.type != 'click') {
				jQuery('.tx-indexedsearch-searchbox-results').html('<div class="ajax-loader"></div>');
			}
			if(timer) {
				clearTimeout(timer);
			}
			timer = setTimeout(function(){
				if($searchbox.val().length > 2) {
					$.ajax({
						url: './?type=' + pageType + '&L=' + L + '&tx_szindexedsearch_pi1[searchString]=' + encodeURIComponent($searchbox.val()),
						success: function(response) {
							container.html(response);
							container.show();
						},
						error: function(error) {
							console.error(error);
						}
					});
				} else {
					container.hide();
					container.html('');
				}
			}, 150);
		});
		$(document).bind('click keyup', function(e){
			if(!container.is(e.target) && container.has(e.target).length === 0 && !$(e.target).hasClass('tx-indexedsearch-searchbox-sword')) {
				container.hide();
			}
		})

	};

	$(function() {
		initAutocomplete();
	});
}) (jQuery);