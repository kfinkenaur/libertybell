/* Topo link
-------------------------------------------------------------- */
$(document).ready(function() {

    $('a[href=#top]').click(function(){
        $('html, body').animate({scrollTop:0}, 'slow');
        return false;
    });

});

/* Sub menu togle (em desenvolvimento)
-------------------------------------------------------------- */
$(document).ready(function(){

        $("ul.sub-menu").hide();
        $(".current-menu-item").show();

	$('.current-menu-item').click(function(){
	$("ul.sub-menu").slideToggle();
	});

});
