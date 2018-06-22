var scrollSommaire;
var scrollImanquables;
var scrollArticle;
var scrollComments;
var scrollPages;
var scrollCategory = [];

/** Chargement des polices **/
loadFonts();

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', loaded, false);
window.addEventListener('onorientationchange' in window ? 'orientationchange' : 'resize', setHeight, false);

var tabArticles = [];
var currentArticle = "";
var boolShowNextArticle = false;

function loadFonts()
{
	google.load("webfont", "1");
	jQuery('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='+MyAjax.font_logo_api+'">').appendTo('head');
	jQuery('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='+MyAjax.font_title_api+'">').appendTo('head');

	var styles = "<style>";

	styles += '#header #logo {font-family: "'+MyAjax.font_logo_libelle+'";}';
	styles += 'h1, h2, .content h3 {font-family: "'+MyAjax.font_title_libelle+'";}';
	styles += '#header {border-bottom: 2px solid '+MyAjax.header_border_color+';background: '+MyAjax.header_bg_color+';}';
	styles += '#header #logo { color: '+MyAjax.header_txt_color+'} ';
	styles += '#footer {background-color: '+MyAjax.header_bg_color+'}';

	styles += "</style>";

	jQuery(styles).appendTo('head');
}

function majSommaire()
{
	scrollSommaire.refresh();
}

function loaded() 
{
	jQuery('#fontSize').hide();
	makeFooter();
	document.addEventListener('touchmove', function(e){ e.preventDefault(); });
	
	/** Position des overlays Immanquables **/
	$('.bOverlay').each(function(i){
		
		var cOverlay = $('.cOverlay', this);
		var overlay = $('.overlay', this);
		var sectionWidth = $(cOverlay).outerWidth();
		var h3 = $('h3', cOverlay);
		
		var height = cOverlayDefault = $(cOverlay).outerHeight();
		
		if( height < 60 )
			height = 60;
		
		var position = (height/2) - (cOverlayDefault/2);
		
		$(overlay).height(height);
		$(cOverlay).css("bottom", position + "px");
	});
	$('#scrollImmanquables').width($('#scrollImmanquables table').outerWidth() + 30);
	$('#scrollComments').width($('#scrollComments table').outerWidth() + 30);
	$('#scrollPages').width($('#scrollPages table').outerWidth() + 30);
	
	scrollImanquables = new iScroll('immanquables', {hScrollbar:false, vScroll:false});
	scrollArticle = new iScroll('article', {vScrollbar:false, hScroll:false});
	scrollSommaire = new iScroll('sommaire', {vScrollbar:false, hScroll:false});
	
	if($('#scrollComments').length > 0)
		scrollComments = new iScroll('blocComments', {hScrollbar:false, vScroll:false});
	if($('#scrollPages').length > 0)
		scrollPages = new iScroll('blocPages', {hScrollbar:false, vScroll:false});
	
	setHeight();
	
	majSommaire();
	
	loadCategory(0, false);
	
	$('a.plus', '.blocCat').live('click', function(){
		var categoryID = $(this).attr('categoryID');
		var debut = $(this).attr('debut');
		getListArticles(categoryID, debut, this);
		return false;
	});
	
	$('#nextCategory').click(function(){
		var debut = $(this).attr('debut');
		loadCategory(debut);
		return false;
	});
	
	$('.post').live('click', function(){
		var permalink = $(this).attr('permalink');
		getArticle(permalink);
		return false;
	});
	
	$('#logo, #home').click(function(){
		goToHome();
		return false;
	});
	
	/** Taille du texte **/
	jQuery('.pick-fontsize').click(function(){
		
		var fontsize = jQuery(this).css('font-size');
		
		jQuery('#article').css('font-size', fontsize);
		
		scrollArticle.refresh();
		
		return false;
	});
	
	if(location.hash.match(/.+id\/(.*)/))
	{
		var permalink = location.hash.match(/.+id\/(.*)/)[1];
		getArticle(permalink);
	}
}

function makeFooter()
{
	for(var i = 0 ; i <= 9; i++)
	{
		if(i%2 == 0)
			html = '<div style="height:28px;width:'+($('#footer').width()/9)+'px;float:left"></div>';
		else
			html = '<div style="height:28px;background:#fff;width:'+($('#footer').width()/9)+'px;float:left"></div>';
			
		$(html).appendTo('#footer');
	}
}

function setHeight() 
{
	//var wrapperH =  window.innerHeight - $('#header').outerHeight();
	//$('#sommaire, #article').height(wrapperH);
}

function loadCategory( debut )
{
	$('#nextCategory').addClass('loader');
	jQuery.ajax({
		url: MyAjax.ajaxurl,
		type: 'POST',
		dataType: "json", 
		data: {
			debut:debut,
			action: 'wpti_categories',
			ajaxgetcat: MyAjax.ajaxgetcat
		},
		complete: function()
		{
			$('#nextCategory').removeClass('loader');
		},
		success: function(json)
		{
			if(json.categories)
			{
				for(var i = 0 ; i < json.categories.length ; i++)
				{
					var bgColor = json.categories[i].bg_color;
					var txtColor = json.categories[i].txt_color;
					var categoryID = json.categories[i].categorie_id;
					var debut = json.categories[i].debut;
					
					var html = '<h2 class="title'+categoryID+'">' + json.categories[i].title + '</h2>';
					
					html += '<div id="blocCat'+categoryID+'" class="blocCat">'
						+'<div id="scrollCat'+categoryID+'" class="scrollCat">';
					
					if(json.categories[i].posts)
					{
						var table = "<table class=\"liste\" height=\"250\" id=\"tableCat"+categoryID+"\"><tr>";
						for(var j = 0 ; j < json.categories[i].posts.length ; j++)
						{
							var borderRight = "";
							
							if(j+1 != json.categories[i].posts.length)
								borderRight = 'border-right';
							
							table += "<td class=\""+borderRight+"\" onclick=\"getArticle('"+json.categories[i].posts[j].permalink+"')\">";
							table += "<div class=\"bloc\"></div>";
							
							if(json.categories[i].posts[j].thumbnail != "") 
							{
								table += "<div class=\"thumbnail\"><img src=\"" + json.categories[i].posts[j].thumbnail + "\" width=\"200\" /></div><br/>";
							} 
							
							table += "<h3>" + json.categories[i].posts[j].title + "</h3>";
							
							if(json.categories[i].posts[j].thumbnail == "") 
								table +="<br/>";
							
							table += json.categories[i].posts[j].excerpt;
							
							table += "</td>";
						}
						
						if(json.categories[i].total_posts > postsPerPage)
						{
							table += "<td style=\"vertical-align:middle;width:100px\">"
							 + "<a class=\"plus\" categoryID=\""+categoryID+"\" debut=\""+debut+"\"></a></td>";
						}
						
						table += "</tr></table>";
						
						html += table;
					}
					
					html += "</div></div><div class=\"clear\"></div>";
					
					$(html).appendTo('#contentCategory');
					
					jQuery('#tableCat'+categoryID).css('background-color', bgColor);
					jQuery('#tableCat'+categoryID).css('color', txtColor);
					jQuery('table, table h3, h2', '#tableCat'+categoryID).css('color', txtColor);
					jQuery('.title'+categoryID+', #blocCat'+categoryID).css('color', txtColor);
					jQuery('.title'+categoryID+', #blocCat'+categoryID).css('background-color', bgColor);
					jQuery('.border-right', '#tableCat'+categoryID).css('border-right','1px solid ' + txtColor);
					
					$('#scrollCat'+categoryID).width($('#tableCat'+categoryID).outerWidth() + 30);
					var scroll = new iScroll('blocCat'+categoryID, {
						hScrollbar:false, vScroll:false
					});
					
					scrollCategory.push({categoryID:categoryID, scroll:scroll});
					
					$('#nextCategory').attr('debut', json.fin);
					
					if(json.nbCategories <= json.fin)
					{
						$('#nextCategory').hide();
					}
				}
				majSommaire();
			}
		}
	});
}

function getListArticles(categoryID, debut, element)
{
	var scroll;
	for(var i = 0; i < scrollCategory.length ; i++)
	{
		if(scrollCategory[i].categoryID == categoryID)
		{
			scroll = scrollCategory[i].scroll;
		}
	}
	
	$(element).addClass('loader');
	$(element).attr('onclick', '');
	$(element).unbind('click');
	var td = $(element).parents('td');
	var table = $(td).parents('table');
	
	jQuery.ajax({
		url: MyAjax.ajaxurl,
		type: 'POST',
		dataType: "json", 
		data: {
			debut:debut,
			action: 'wpti_categories',
			ajaxgetcat: MyAjax.ajaxgetcat,
			categorie_id: categoryID
		},
		complete: function()
		{
			$(element).removeClass('loader');
		},
		success: function(json)
		{
			html = "";
			for(var i = 0 ; i < json.posts.length ; i++)
			{
				var post = json.posts[i];
				
				var borderRight = 'border-left';
				
				html += "<td class=\""+borderRight+"\" onclick=\"getArticle('"+post.permalink+"')\">";
				html += "<div class=\"bloc\"></div>";
				
				if(post.thumbnail != "") 
				{
					html += "<div class=\"thumbnail\"><img src=\"" + post.thumbnail + "\" width=\"200\" /></div><br/>";
				} 
				
				html += "<h3>" + post.title + "</h3>";
				
				if(post.thumbnail == "") 
					html +="<br/>";
				
				html += post.excerpt;
				
				html += "</td>";
			}
			
			jQuery(html).insertBefore(td);
			
			jQuery('table, table h3, h2', '#tableCat'+categoryID).css('color', jQuery('#tableCat'+categoryID).css('color'));
			
			$(element).attr('debut', json.debut);
			
			
			if(json.debut >= json.total_posts)
			{
				jQuery(td).remove();
			}
			
			$($(table).parents('.scrollCat')).width($(table).outerWidth() + 30);
			scroll.refresh();
		}
		
		
	});
	
}

function goToHome()
{
	jQuery('#fontSize').hide();
	
	$('#sommaire').show();	
	$('#article').hide();
	
	//scrollSommaire.refresh();
	
	window.location.hash = "";
	majSommaire();
}

function errorGetArticle()
{
	goToHome();
	alert('Une erreur est survenue lors du chargement de la page. Veuillez réessayer.');
}

function getArticle(permalink)
{
	currentArticle = permalink;
	
	jQuery.ajax({
		url: permalink,
		dataType: 'html',
		async: true,
		beforeSend: function()
		{
			window.location.hash = "#id/" + permalink; 

			jQuery('#fontSize').show();
			$('#sommaire').hide();
			$('#article').show();

			$('#contentArticle').html("<br/><br/><br/><a class=\"loader\" style=\"margin:0 auto\"></a>");
		},
		error: errorGetArticle,
		timeout: errorGetArticle,
		parsererror: errorGetArticle,
		abort: errorGetArticle,
		success: function(html)
		{
			$('#contentArticle').html(html);
			// Commentaires
			jQuery('#commentform').unbind('submit');

			jQuery('#commentform').submit(function(){
				sendComment(jQuery(this).attr('action'), jQuery(this).serialize(), permalink);
				return false;
			});

			$('#reply-title a').click(function(){return false;});

			$('.comment-reply-link').click(function(){
				getArticle($(this).attr('href'));
				return false;
			}); 

			$('a#cancel-comment-reply-link').click(function(){
				getArticle($(this).attr('href'));
				return false;
			}); 

			/** On raffraichie le scroll **/
			scrollArticle.refresh();

			setTimeout(function () { scrollArticle.refresh(); }, 5000);
		}
	});
}

function sendComment(action, values, permalink)
{
	jQuery.ajax({
		url: action,
		type: "POST",
		data: values,
		beforeSend: function()
		{
			
		},
		error: function()
		{
		},
		success: function(html)
		{
			getArticle(permalink);
		}
	});
}

function showPrevArticle()
{
	var index = 0;
	for(var i = 0; i < tabArticles.length ; i++)
	{
		if(tabArticles[i] == currentArticle)
		{
			index = i - 1;
		}
	}
	
	if(index >= 0)
	{
		getArticle(tabArticles[index]);
	}
	else
	{
		
	}
	
	return false;
}

function showNextArticle()
{
	var index = 0;
	for(var i = 0; i < tabArticles.length ; i++)
	{
		if(tabArticles[i] == currentArticle)
		{
			index = i + 1;
		}
	}
	
	if(index < tabArticles.length)
	{
		getArticle(tabArticles[index]);
	}
	else
	{
		boolShowNextArticle = true;
		$('#nextArticles a').click();
	}
	return false;
}