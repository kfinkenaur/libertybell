jQuery(document).ready(function($){

$('.slides').slick({
  dots: false,
  infinite: true,
  speed: 3000,
  fade: true,
  slide: 'div',
  cssEase: 'linear'
});

$(".slides img").show();

if ($('.slides div img').length === 0) {
$('nav').addClass('navPush');
$('.custom-header').show();
}

if ($('.custom-header img').length === 1) {
$('nav').removeClass('navPush');
}
$('#menuTab').click(function() {
     $('nav').slideToggle('300');
});

$(window).resize(function() {
              var windowWidth = $(window).width();
              if (windowWidth > 769) {                  
                  $('nav').show();
              } else {
                  $('nav').hide();
              }
              });
});