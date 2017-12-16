'use strict';

     (function($) {
         $(document).ready(function() {
            $("[data-fancybox]").fancybox({
			// Options will go here
			buttons : [
			'slideShow',
			'fullScreen',
			'thumbs',
			// 'download',
			'zoom',
			'close'
				],
			loop : true,
			transitionEffect : "slide",
			thumbs : {
				autoStart   : false,                  // Display thumbnails on opening
				hideOnClose : true,                   // Hide thumbnail grid when closing animation starts
				parentEl    : '.fancybox-container',  // Container is injected into this element
				axis        : 'Y'                     // Vertical (y) or horizontal (x) scrolling
			}
			});
         });
     })(jQuery)
