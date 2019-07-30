<script type="text/javascript">
	/*
 * jQuery ScrollingTable v1.0
 * https://github.com/vlada-j/ScrollingTable
 *
 * Copyright 2012, Vlada Janosevic
 * http://www.vladajanosevic.info/
 * Free to use and change
 *
 * Required: jQuery 1.11.1
 */
+function ($) {
	"use strict";

	var ScrollingTable = function (ele, op) {
		ele = $(ele);
		var wrapper = null,
			hors=ele.find('.headerHor'),
			vers=ele.find('.headerVer');

		ele.wrap('<div class="scrollingTable"/>');
		wrapper = $(ele.parent());
		wrapper.bind('scroll',
			function() {
				hors.css('top', wrapper.scrollTop());
				vers.css('left', wrapper.scrollLeft());
			}
		);
	};

	ScrollingTable.DEFAULTS = {};

	$.fn.ScrollingTable = function (option) {
		return this.each(function () {
			var $this	= $(this),
				data	= $this.data('ScrollingTable'),
				options	= $.extend({}, ScrollingTable.DEFAULTS, $this.data(), typeof option == 'object' && option)

			if (!data) {
				$this.data('ScrollingTable', (data = new ScrollingTable(this, options)));
			}
		});
	};

	$.fn.ScrollingTable.Constructor = ScrollingTable;

}(window.jQuery);
</script>