jQuery(function() {

jQuery("#foo2").carouFredSel({
	responsive: true,
	circular: true,
	scroll: 1,
	items: {
		
		visible: {
			min: 1,
			max: 6
		}
	}, 
	prev	: {	
		button	: "#foo2_prev",
		key		: "left"
	},
	next	: { 
		button	: "#foo2_next",
		key		: "right"
	}
});
	
});