var scrollPopup;

function initMenu(){
	scrollPopup = new iScroll('scrollPopup', {vScrollbar:false, hScroll:false, desktopCompatibility: true});
}

function drawMenuBackground(rectWidth, rectHeight){

    var context = document.getCSSCanvasContext('2d', 'menu_background', rectWidth, rectHeight);    

    var arrowHeight = 20;
    var radius = 6;
    var lineWidth = 1;
    var pad = lineWidth/2;
    var xs = pad;
    var ys = pad + arrowHeight;
    var xe = rectWidth - pad;
    var ye = rectHeight - pad;

    var gradient = context.createLinearGradient(rectWidth/2, 0, rectWidth/2, arrowHeight * 2);
    gradient.addColorStop(0, '#eee'); 
    gradient.addColorStop(1, '#151d31'); 

    context.beginPath();

    context.lineJoin = 'miter';

    context.moveTo(xs + radius, ys);
	
	var positionFleche = 270;
	
    context.lineTo(positionFleche - (arrowHeight + pad), ys);
    context.lineTo(positionFleche, pad);
    context.lineTo(positionFleche + (arrowHeight + pad), ys);

    context.lineTo(xe - radius, ys);

    context.arcTo(xe, ys, xe, ys + radius, radius);

    context.lineTo(xe, ye - radius);
    context.arcTo(xe, ye, xe - radius, ye, radius);

    context.lineTo(xs + radius, ye);initMenu
    context.arcTo(xs, ye, xs, ye - radius, radius);

    context.lineTo(xs, ys + radius);
    context.arcTo(xs, ys, xs + radius, ys, radius);

    context.fillStyle = gradient;

    //context.fillStyle = '#000';
    context.globalAlpha = .95;
    context.fill();

    context.globalAlpha=1;

    context.strokeStyle = '#48484a';
    context.lineWidth = lineWidth;
    context.stroke();

}

function showMenu(el){
	
	$('.popup').hide('fast');
	
    var menu = document.getElementById($(el).attr('popup'));
	drawMenuBackground($(menu).outerWidth(), $(menu).outerHeight());

	$(menu).show();

    var targetLeft = el.offsetLeft;
    var targetBottom = el.offsetHeight;
    var targetWidth = el.offsetWidth;  
	var targetHeight = el.offsetHeight;     
    var menuWidth = menu.offsetWidth;

    var menuLeft = targetLeft - (targetWidth/2) - (menuWidth/2);
	$(menu).css('top', targetBottom + targetHeight);
	$(menu).css('left', (targetLeft - menuWidth + targetWidth + 15 ) + "px");
	
    menu.onclick = function(e){
        if(e.target.tagName.toLowerCase() == 'a'){
            var type = e.target.innerHTML;
            var link = el.getAttribute('href');
            $(menu).hide();
        }
    }
	jQuery('#article, #sommaire, #header').click(hideMenu);
	
	if($(el).attr('popup') == "popup_info")
	{
		jQuery('#description_site').click(function(){
			$('.description_site').show();
			$('.description_kinoa').hide();
			$(this).addClass('selected');
			$('#description_kinoa').removeClass('selected');
			scrollPopup.refresh();
			return false;
		});
		jQuery('#description_kinoa').click(function(){
			$('.description_kinoa').show();
			$('.description_site').hide();
			$(this).addClass('selected');
			$('#description_site').removeClass('selected');
			scrollPopup.refresh();
			return false;
		});

		scrollPopup.refresh();
	}
}

function hideMenu()
{
	$('.popup').hide('fast');
	jQuery('#wrapper').unbind('click');
}

jQuery(document).ready(function(){
	initMenu();
	jQuery('#info, #fontSize').click(function(){
		showMenu(this);
		return false;
	});
});