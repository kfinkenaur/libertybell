var myApp = angular.module('myApp',['ngCart','ngAnimate', 'ngSanitize', 'ui.router']);

myApp.config(function($stateProvider, $urlRouterProvider) {

    $baseUrl = jQuery("#base_uri").val();
    $imagesUrl = jQuery("#images_uri").val();
    $loginUrl = jQuery("#login_uri").val();
    $regUrl = jQuery("#registration_uri").val();
    
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
})

myApp.controller ('myCtrl', ['$scope', '$http', 'ngCart', function($scope, $http, ngCart) {
    ngCart.setTaxRate(7.5);
    ngCart.setShipping(2.99);

    //$scope.ei_firstname = 'John';
    //$scope.ei_lastname = 'Doe';
    //$scope.ei_email = 'john.doe@gmail.com';

    $scope.ei_firstname = '';
    $scope.ei_lastname = '';
    $scope.ei_email = '';

    $scope.date = new Date();

    $scope.filters = { };
    $scope.filters.category = 0;
    var selector = "#json_results";
    var pros_data = jQuery(selector).text();
    //console.log(pros_data);
    $scope.json_results = jQuery.parseJSON(pros_data);
    //console.log($scope.json_results);   

    var catselector = "#json_catresults";
    var cats_data = jQuery(catselector).text();
    //console.log(cats_data);
    $scope.json_catresults = jQuery.parseJSON(cats_data);

    //$scope.selectedcate = 15;
    //$scope.selectedsubcate = 0;

    function generateMoveID()
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 6; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function generateRandomID()
    {
        var text = "";
        var possible = "0123456789";

        for( var i=0; i < 5; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    $scope.baseUrl = $baseUrl;
    $scope.imagesUrl = $imagesUrl;
    $scope.loginUrl = $loginUrl;
    $scope.regUrl = $regUrl;

    // we will store all of our form data in this object
    $scope.formData = {};

    var order_id = jQuery("#order_id").text();
    //console.log('order_id ='+order_id);

    //console.log($scope.formData.totalcost);
    $scope.formData.packing_service = 0.00;

    $scope.formData.cur_user_email = jQuery("#cur_user_email").text();
    $scope.formData.cur_user_name = jQuery("#cur_user_name").text();
    $scope.formData.cur_user_login = jQuery("#cur_user_login").text();

    if(order_id > 0){
        ngCart.empty();
        //console.log('Cart is empty now !!');

        var json_order_data = jQuery("#json_order_data").text();
        //console.log(json_order_data);
        $scope.order_data = jQuery.parseJSON(json_order_data);

        $.each( $scope.order_data.items, function( ordDataKey, ordDataValue ) {
          //console.log( ordDataKey + ": " + ordDataValue.id );
          //console.log("("+ordDataValue.id+","+ordDataValue.name+","+ordDataValue.price+","+ordDataValue.weight+","+ordDataValue.size+","+ordDataValue.quantity+","+ordDataValue.category+","+ordDataValue.categoryquantity+")");
          //$orderData[key] = value;
          ngCart.addItem(ordDataValue.id, ordDataValue.name, ordDataValue.price, ordDataValue.weight, ordDataValue.size, ordDataValue.quantity, ordDataValue.category, ordDataValue.categoryname, ordDataValue.categoryquantity);
        });

        $.each( $scope.order_data.boxes, function( ordBoxKey, ordBoxValue ) {
          //console.log( ordDataKey + ": " + ordDataValue.id );
          //console.log("("+ordDataValue.id+","+ordDataValue.name+","+ordDataValue.price+","+ordDataValue.weight+","+ordDataValue.size+","+ordDataValue.quantity+","+ordDataValue.category+","+ordDataValue.categoryquantity+")");
          //$orderData[key] = value;
          ngCart.addBox(ordBoxValue.id, ordBoxValue.name, ordBoxValue.price, ordBoxValue.weight, ordBoxValue.size, ordBoxValue.quantity, ordBoxValue.category, ordBoxValue.categoryquantity);
        });

        $.each( $scope.order_data, function( ordFormDataKey, ordFormDataValue ) {
          //console.log( ordFormDataKey + ": " + ordFormDataValue );
          $scope.formData[ordFormDataKey] = ordFormDataValue;
          //console.log("("+ordDataValue.id+","+ordDataValue.name+","+ordDataValue.price+","+ordDataValue.weight+","+ordDataValue.size+","+ordDataValue.quantity+","+ordDataValue.category+","+ordDataValue.categoryquantity+")");
          //$orderData[key] = value;
          //ngCart.addItem(ordDataValue.id, ordDataValue.name, ordDataValue.price, ordDataValue.weight, ordDataValue.size, ordDataValue.quantity, ordDataValue.category, ordDataValue.categoryquantity);
        });

        //$scope.formData

        //console.log($scope.order_data);
    } else {

      $scope.formData.move_id = generateMoveID();

      $scope.formData.packing_service_pack_yourself = parseFloat(jQuery("#packing_service_pack_yourself").text());
      $scope.formData.packing_service_professional_packing = parseFloat(jQuery("#packing_service_professional_packing").text());
      $scope.formData.packing_service_professional_packing_and_unpacking = parseFloat(jQuery("#packing_service_professional_packing_and_unpacking").text());
      $scope.formData.pricing_special_handling = parseFloat(jQuery("#pricing_special_handling").text());
      $scope.formData.pricing_storage = parseFloat(jQuery("#pricing_storage").text());
      $scope.formData.pricing_boxes_for_storage = parseFloat(jQuery("#pricing_boxes_for_storage").text());

      $scope.formData.totalcost = (ngCart.totalCost() + $scope.formData.pricing_special_handling + $scope.formData.pricing_storage + $scope.formData.pricing_boxes_for_storage + $scope.formData.packing_service ).toFixed(2);
    }

    $scope.selectPackingService= function(value) {
       console.log(value);
       $scope.formData.packing_service = parseFloat(value);
       $scope.formData.totalcost = (parseFloat(ngCart.totalCost()) + parseFloat($scope.formData.pricing_special_handling) + parseFloat($scope.formData.pricing_storage) + parseFloat($scope.formData.pricing_boxes_for_storage) + parseFloat($scope.formData.packing_service)).toFixed(2);
    }

    $scope.selectcategory= function(index, category) {
       $scope.selectedcate = index;
       console.log($scope.selectedcate);
       console.log($scope.filters); 
       $scope.filters.category = parseInt(category.id);
       console.log('carid:'+category.id);
       if(jQuery(window).width() <= 1200 ){
         if(category.id != 2) {
          jQuery('#sideviewtoggle1_start').trigger('click');
         }
       }
    };

    $scope.onloadselectcategory= function() {
       /*$scope.selectedcate = 0;
       console.log($scope.selectedcate); 
       //console.log(category.id);
       console.log($scope.filters); 
       $scope.filters.category = 1;
       console.log($scope.filters.category); 
       //category.showCategories = true;*/
    };

    $scope.selectsubcategory= function(index, subcategory) {
       $scope.selectedsubcate = index;
       $scope.filters.category = subcategory.id;
       if(jQuery(window).width() <= 1200 ){ jQuery('#sideviewtoggle1_start').trigger('click'); }
    };    
    
    $scope.editPost = function(id) {
    
        jQuery('#editModal').modal();      // triggers the modal pop up
    }

    $scope.list = [];

    $scope.submit = function() {
        if ($scope.text) {
            $scope.list.push(this.text);
            $scope.text = '';
        }
    };

    // function to process the form
    $scope.processForm = function() {
        console.log('awesome!');  
    };

    /*$(document).ajaxStart(function(){
    $("#wait").css("display", "block");
    });

    $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
    });*/

    /*var progressTimer;
    $(document).ajaxStart(function () {
        $("#wait").css("display", "block");
        //if a new ajax request is started then don't remove the progress icon
        clearTimeout(progressTimer);
    }).ajaxStop(function () {
        progressTimer = setTimeout(function () {
            $("#wait").css("display", "none");
        }, 3000)
    });*/ 

    $scope.httpPost = function() {
        if($scope.formData.cur_user_login > 0){
          var $orderData = {};
          //console.log($scope.formData);
          $.each( $scope.formData, function( key, value ) {
            //console.log( key + ": " + value );
            $orderData[key] = value;
          });
          $orderData['items'] = {};
          $orderData['totalcost'] = (parseFloat(ngCart.totalCost()) + parseFloat($scope.formData.pricing_special_handling) + parseFloat($scope.formData.pricing_storage) + parseFloat($scope.formData.pricing_boxes_for_storage) + parseFloat($scope.formData.packing_service)).toFixed(2);
          $.each( ngCart.getItems(), function( ngkey, ngvalue ) {
            //console.log( key + ": " + value );
            $orderData['items'][ngkey] = {};
            $.each( ngvalue, function( ngitemkey, ngitemvalue ){
              ngitemkey = ngitemkey.replace("_","");
              if(ngitemkey == 'id' || ngitemkey == 'name' || ngitemkey == 'price' || ngitemkey == 'quantity' || ngitemkey == 'size' || ngitemkey == 'category' || ngitemkey == 'categoryquantity' || ngitemkey == 'weight'){
                  $orderData['items'][ngkey][ngitemkey] = ngitemvalue;  
              }
            });
          });
          $orderData['boxes'] = {};
          $.each( ngCart.getBoxes(), function( ngkey, ngvalue ) {
            //console.log( key + ": " + value );
            $orderData['boxes'][ngkey] = {};
            $.each( ngvalue, function( ngboxkey, ngboxvalue ){
              ngboxkey = ngboxkey.replace("_","");
              if(ngboxkey == 'id' || ngboxkey == 'name' || ngboxkey == 'price' || ngboxkey == 'quantity' || ngboxkey == 'size' || ngboxkey == 'category' || ngboxkey == 'categoryquantity' || ngboxkey == 'weight'){
                  $orderData['boxes'][ngkey][ngboxkey] = ngboxvalue;  
              }
            });
          });
          //$orderData.push();
          //console.log(ngCart.getItems());
          //$orderData['items'] = ngCart.getItems();
          //console.log($orderData);
          //console.log($scope.formData);
          //$.post($baseUrl+'components/com_cubic/save.php', $orderData).error(function(status){console.log(status)});
          //console.log(order_id);
          if(order_id > 0){
            $("#wait").css("display", "block");  setTimeout(function () { $.post($baseUrl+'index.php?option=com_cubic&task=reservation.updateorder&order='+order_id, $orderData).error(function(status){console.log(status); $("#wait").css("display", "none"); }).done(function(data){console.log('completed!!!'); $("#wait").css("display", "none"); $('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Updated !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); }); }, 3000); 
          } else {
            $("#wait").css("display", "block");  setTimeout(function () { $.post($baseUrl+'index.php?option=com_cubic&task=reservation.saveorder', $orderData).error(function(status){console.log(status); $("#wait").css("display", "none"); }).done(function(data){console.log('completed!!!'); $("#wait").css("display", "none"); $('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Saved !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); });  }, 3000);
          }
        } else {
          jQuery('#usersignInModal').modal();
        }
    };

    $scope.printPlan = function() {
        var review_html_data = jQuery('#form_review_data').html();
        //console.log(review_html_data);
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>Form Review</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css" /><link href="http://192.168.1.29/libertybell/templates/prostar/css/template.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(review_html_data);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        //console.log(frameDoc);
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    };

    $scope.addCustomItem = function() {

        //$scope.custom_list = [];
        //console.log(this.item_name);
        //ngCart.empty();

        if (this.item_name) {
          $scope.custom_item_name = this.item_name;
          $scope.item_name = '';
        }
        
        if (this.item_subtitle) {
          $scope.custom_item_subtitle = this.item_subtitle;
          $scope.item_subtitle = '';
        }
        
        if (this.item_weight) {
          $scope.custom_item_weight = this.item_weight;
          $scope.item_weight = '';
        }
        
        if (this.item_size) {
          $scope.custom_item_size = this.item_size;
          //$scope.custom_list.push(this.item_size);
          $scope.item_size = '';
        }
        
        if (this.item_price) {
          $scope.custom_item_price = this.item_price;
          //$scope.custom_list.push(this.item_price);
          $scope.item_price = '';
        }

        $scope.custom_item_id = generateRandomID();

        //console.log($scope.custom_item_name);
        //console.log($scope.custom_item_name);
        //console.log($scope.custom_item_price);
        //console.log($scope.custom_item_weight);
        //console.log($scope.custom_item_size);
        //console.log($scope.filters.category);

        ngCart.addItem($scope.custom_item_id, $scope.custom_item_name, $scope.custom_item_price, $scope.custom_item_weight, $scope.custom_item_size, 1, $scope.filters.category, $scope.filters.categoryname, 1);
        
        //$('#editModal').modal('toggle');
        //$(document).trigger('click');
        //$('#custom_item_popup_close').trigger('click');
        //$('.body').trigger('click');
        //$('body').removeClass('modal-open');
        //$('.modal-backdrop').removeClass('in');
        
        //$("#wait").css("display", "block");

        setTimeout(function () {

          //$("#wait").css("display", "none");
          //$('html,body').animate({
          //scrollTop: $("#message").offset().top},
          //'fast');
          $('#custom_mail_message').html('<div id="alertFadeOut" class="alert alert-success">Custom Item added to your Inventory !</div>');
          $('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); });

        }, 3000);
    };

    $scope.emailPlan = function() {
        //alert('toemail:'+jQuery('#toemail').val());
        var $postData = {};
        var review_html_data = jQuery('#form_email_data').html();
        var email_id = jQuery('#toemail').val();

        var header_html_data = '';
        
        review_html_data = header_html_data+review_html_data;

        //console.log(review_html_data);
        //$postData['html_data'] = review_html_data;
        //console.log($postData);return;
        //$.post($baseUrl+'index.php?option=com_cubic&task=reservation.emailPlan', $postData).error(function(status){console.log(status)}).done(function(data){console.log('completed!!!');$('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Updated !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); });
        //setTimeout(function () {
          var request = $.ajax({
            url: $baseUrl+'index.php?option=com_cubic&task=reservation.emailPlan',
            method: "POST",
            data: { postData : review_html_data, email_id : email_id },
            dataType: "html"
          });

          request.done(function( msg ) {
            //$("#wait").css("display", "none");
            //$( "#log" ).html( msg );
              //console.log('success!');
              $('#mail_message').html('<div id="alertFadeOut" class="alert alert-success">Move Sent !</div>');
              $('#alertFadeOut').fadeOut(3000, function () {
                  $('#alertFadeOut').text('');
              });
          });
           
          request.fail(function( jqXHR, textStatus ) {
            //$("#wait").css("display", "none");
            //alert( "Request failed: " + textStatus );
              $('#mail_message').html('<div id="alertFadeOut" class="alert alert-danger">Email could not sent !</div>');
              $('#alertFadeOut').fadeOut(3000, function () {
                  $('#alertFadeOut').text('');
              });
          });
        //},3000);
    };

    $scope.submitPlan = function() {
        if($scope.formData.cur_user_login > 0){
          $("#wait").css("display", "block");

          //alert('toemail:'+jQuery('#toemail').val());
          var $postData = {};

          //jQuery( "#booking_email_headings_main" ).replaceWith( "Your move is booked!" );

          jQuery('#email_customer_summary').css("display","block");

          var review_html_data = jQuery('#form_email_data').html();
          //var email_id = jQuery('#toemail').val();

          var header_html_data1 = '<h1>One move has been booked!</h1>';
          review_html_data1 = header_html_data1+review_html_data;

          review_html_data1 = review_html_data1.replace('Your move is not booked yet!', '');
          review_html_data1 = review_html_data1.replace('Log in and complete your booking to lock in your price.', '');
          review_html_data1 = review_html_data1.replace('Reserve your move! Your move is not booked yet.', 'Reserved move details');

          //jQuery('#form_email_data').html();
          
          jQuery('#email_customer_summary').css("display","none");
          
          var review_html_data_user = jQuery('#form_email_data').html();

          var header_html_data2 = '<h1>Your move has been booked!</h1>';
          review_html_data2 = header_html_data2+review_html_data_user;

          //jQuery(review_html_data2).find("#email_customer_summary").remove();

          review_html_data2 = review_html_data2.replace('Your move is not booked yet!', '');
          review_html_data2 = review_html_data2.replace('Log in and complete your booking to lock in your price.', '(Please email service@libertybellmoving.com if you need to edit your inventory)');
          review_html_data2 = review_html_data2.replace('Reserve your move! Your move is not booked yet.', 'THIS EMAIL IS TO LET YOU KNOW THAT LIBERTY BELL MOVING & STORAGE HAS RECEIVED THE FOLLOWING INVENTORY SUBMISSION');

          //console.log(review_html_data);
          //$postData['html_data'] = review_html_data;
          //console.log($postData);return;
          //$.post($baseUrl+'index.php?option=com_cubic&task=reservation.emailPlan', $postData).error(function(status){console.log(status)}).done(function(data){console.log('completed!!!');$('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Updated !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); });
          setTimeout(function () {
          var request = $.ajax({
            url: $baseUrl+'index.php?option=com_cubic&task=reservation.submitPlan',
            method: "POST",
            data: { postData : review_html_data1, postUserData : review_html_data2 },
            dataType: "html"
          });
           
          request.done(function( msg ) {
            //$( "#log" ).html( msg );
              //console.log('success!');
              $('#message').html('<div id="alertFadeOut" class="alert alert-success">Order Placed Successfully !</div>');
              $('#alertFadeOut').fadeOut(5000, function () {
                  $('#alertFadeOut').text('');
              });
              $("#wait").css("display", "none");
          });
           
          request.fail(function( jqXHR, textStatus ) {
            //alert( "Request failed: " + textStatus );
              $('#message').html('<div id="alertFadeOut" class="alert alert-danger">Move could not be booked !</div>');
              $('#alertFadeOut').fadeOut(5000, function () {
                  $('#alertFadeOut').text('');
              });
              $("#wait").css("display", "none");
          });
          },3000);
        } else {
          jQuery('#usersignInModal').modal();
        }
    };

    $scope.showReviewModal = function() {
      jQuery('#reviewModal').modal().css({'width':'800px', 'left':'40%', 'color': '#000'});
      jQuery('#form_review_data').show();
    }

    $scope.emailInventoryPlan = function() {
        //alert('in email inventory plan..!');
        if($scope.ei_email.length > 0){
          $("#wait").css("display", "block");

          var frontuserdata = {};

          frontuserdata['firstname'] = $scope.ei_firstname;
          frontuserdata['lastname'] = $scope.ei_lastname;
          frontuserdata['email'] = $scope.ei_email;

          //alert('toemail:'+jQuery('#toemail').val());

          jQuery('#input_ei_firstname').text($scope.ei_firstname);
          jQuery('#input_ei_lastname').text($scope.ei_lastname);

          var $postData = {};

          //jQuery( "#booking_email_headings_main" ).replaceWith( "Your move is booked!" );

          jQuery('#email_customer_summary').css("display","block");

          var review_html_data = jQuery('#form_email_data').html();
          //var email_id = jQuery('#toemail').val();

          //var header_html_data1 = '<h1>One move has been booked!</h1>';
          var header_html_data1 = '';
          review_html_data1 = header_html_data1+review_html_data;

          review_html_data1 = review_html_data1.replace('Your move is not booked yet!', '');
          review_html_data1 = review_html_data1.replace('Log in and complete your booking to lock in your price.', '');
          review_html_data1 = review_html_data1.replace('Reserve your move! Your move is not booked yet.', 'INVENTORY SUBMISSION SUMMERY');

          //jQuery('#form_email_data').html();
          
          jQuery('#email_customer_summary').css("display","block");
          
          var review_html_data_user = jQuery('#form_email_data').html();

          //var header_html_data2 = '<h1>Your move has been booked!</h1>';
          var header_html_data2 = '';
          review_html_data2 = header_html_data2+review_html_data_user;

          //jQuery(review_html_data2).find("#email_customer_summary").remove();

          review_html_data2 = review_html_data2.replace('Your move is not booked yet!', '');
          review_html_data2 = review_html_data2.replace('Log in and complete your booking to lock in your price.', '');
          review_html_data2 = review_html_data2.replace('Reserve your move! Your move is not booked yet.', 'THIS EMAIL IS TO LET YOU KNOW THAT LIBERTY BELL MOVING & STORAGE HAS RECEIVED THE FOLLOWING INVENTORY SUBMISSION');

          //console.log(review_html_data);
          //$postData['html_data'] = review_html_data;
          //console.log($postData);return;
          //$.post($baseUrl+'index.php?option=com_cubic&task=reservation.emailPlan', $postData).error(function(status){console.log(status)}).done(function(data){console.log('completed!!!');$('#message').html('<div id="alertFadeOut" class="alert alert-success">Move Updated !</div>');$('#alertFadeOut').fadeOut(3000, function () { $('#alertFadeOut').text(''); }); });
          setTimeout(function () {
          var request = $.ajax({
            url: $baseUrl+'index.php?option=com_cubic&task=reservation.emailInventoryPlan',
            method: "POST",
            data: { postData : review_html_data1, postUserData : review_html_data2, frontuserdata : frontuserdata },
            dataType: "html"
          });
           
          request.done(function( msg ) {
            //$( "#log" ).html( msg );
              //console.log('success!');
              $('#message').html('<div id="alertFadeOut" class="alert alert-success" style="font-weight:bold;text-transform:uppercase;">THANK YOU FOR SUBMITTING YOUR INVENTORY. WE WILL EMAIL YOU AN ESTIMATE WITHIN AN HOUR IF RECEIVED BETWEEN 7AM and 7PM or BEFORE 8AM THE NEXT BUSINESS DAY. WE ALSO EMAILED YOU A RECORD OF THIS INVENTORY.</div>');
              $('html,body').animate({scrollTop: $("#message").offset().top}, 'fast');
              $('#alertFadeOut').fadeOut(10000, function () {
                  $('#alertFadeOut').text('');
              });
              $("#wait").css("display", "none");
          });
           
          request.fail(function( jqXHR, textStatus ) {
            //alert( "Request failed: " + textStatus );
              $('#message').html('<div id="alertFadeOut" class="alert alert-danger" style="font-weight:bold;text-transform:uppercase;">Move could not be booked !</div>');
              $('html,body').animate({scrollTop: $("#message").offset().top}, 'fast');
              $('#alertFadeOut').fadeOut(10000, function () {
                  $('#alertFadeOut').text('');
              });
              $("#wait").css("display", "none");
          });
          },3000);
        } else {
          console.log('email is blank');
        }
    };

}]);

jQuery("#togglemenu1").animate({
    width: 0
});

/*
AppCtrl = ($scope)->
  $scope.datepickerOptions =
    format: 'yyyy-mm-dd'
    language: 'fr'
    autoclose: true
    weekStart: 0
    
  $scope.date = '2000-03-12'

app.controller 'myCtrl', AppCtrl    
angular.bootstrap document, ['myapp']
*/