var $ = jQuery;

jQuery(document).ready(function($) {

	function runMaxInit()
	{
		if (typeof window.maxFoundry === 'undefined')
			window.maxFoundry = {};

		window.maxFoundry.maxadmin = new maxAdmin();
	 	window.maxFoundry.maxadmin.init();

		window.maxFoundry.maxmodal = new maxModal();
		window.maxFoundry.maxmodal.init();

		window.maxFoundry.maxAjax = new maxAjax();
		window.maxFoundry.maxAjax.init();

		window.maxFoundry.maxTabs = new maxTabs(); 
		window.maxFoundry.maxTabs.init();

		//window.maxFoundry.maxcollection = new maxCollection();
		//window.maxFoundry.maxcollection.init();
	}

	runMaxInit();

}); /* END OF JQUERY */
