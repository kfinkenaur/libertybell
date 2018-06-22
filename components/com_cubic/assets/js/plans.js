var plansApp = angular.module('plansApp',['ngCart','ngAnimate','ui.router']);

/*myApp.config(function($stateProvider, $urlRouterProvider) {

    $baseUrl = jQuery("#base_uri").val();
    
    $stateProvider
    
        // route to show our basic form (/form)
        .state('form', {
            url: '/form',
            templateUrl: $baseUrl+'components/com_cubic/assets/forms/form.html',
            controller: 'myCtrl'
        })
        
        // nested states 
        // each of these sections will have their own view
        // url will be nested (/form/inventory)
        .state('form.inventory', {
            url: '/inventory',
            templateUrl: $baseUrl+'components/com_cubic/assets/forms/form-inventory.html'
        })
        
        // url will be /form/details
        .state('form.details', {
            url: '/details',
            templateUrl: $baseUrl+'components/com_cubic/assets/forms/form-details.html'
        })
        
        // url will be /form/payment
        .state('form.review', {
            url: '/review',
            templateUrl: $baseUrl+'components/com_cubic/assets/forms/form-review.html'
        });
       
    // catch all route
    // send users to the form page 
    $urlRouterProvider.otherwise('/form/inventory');
})*/

plansApp.controller ('plansCtrl', ['$scope', '$http', 'ngCart', function($scope, $http, ngCart) {
    ngCart.setTaxRate(7.5);
    ngCart.setShipping(2.99); 
    $scope.filters = { };
    var selector = "#json_results";
    var plans_data = jQuery(selector).text();
    //console.log(plans_data);
    $scope.json_results = jQuery.parseJSON(plans_data);
    $.each( $scope.json_results, function( key, value ) {
     // console.log(key);
      //console.log(jQuery.parseJSON(value.orderdata));
        $scope.json_results[key]['neworderdata'] = jQuery.parseJSON(value.orderdata);
        //console.log($scope.json_results[key]['neworderdata']['home_type']);
    });   

    //console.log('jr:'+$scope.json_results);

    $baseUrl = jQuery("#base_uri").val();

    function goToByScroll(id)
    {    
        // Remove "link" from the ID
        //id = id.replace("link", "");
        // Scroll
        $('html,body').animate({scrollTop: $("#"+id).offset().top}, 'slow');
    }

    $scope.deleteMove = function(moveId) {
        //console.log(moveId);
        if(moveId > 0){
            $.post($baseUrl+'index.php?option=com_cubic&task=reservation.deleteorder&order='+moveId).error(function(status){console.log(status); $('#message').html('<div id="alertFadeOut" class="alert alert-danger">Move could not Deleted !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }) }).done(function(data){$('#planNo'+moveId).fadeOut(3000); goToByScroll('message'); $('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Deleted !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); });
        } else {
            $('#planNo'+moveId).fadeOut(3000);
            goToByScroll('message');
            $('#message').html('<div id="alertFadeOut" class="alert alert-danger">Move could not Deleted !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); });
        }
    };

}]);