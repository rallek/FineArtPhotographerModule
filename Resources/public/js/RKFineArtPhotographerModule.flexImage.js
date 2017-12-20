'use strict';
	
	(function($) {
			$(document).ready(function() {
				var rowHeight = $('#flexImageParameters').data('row-height');
				$('#rk-album').flexImages({ rowHeight: rowHeight });
			});
			
	})(jQuery)