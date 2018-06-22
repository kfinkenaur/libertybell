<?php 
defined('_JEXEC') or die;

$user = JFactory::getUser();
$userId = $user->get('id');
$doc=JFactory::getDocument();
$doc->addStylesheet(JUri::base() . 'components/com_cubic/assets/css/jquery.ui.css');
//$doc->addStylesheet(JUri::base() . '/components/com_cubic/assets/css/progress-style-bootstrap.css');
//$doc->addStylesheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
$doc->addStylesheet(JUri::base() . 'components/com_cubic/assets/css/progress-style.css');
$doc->addStylesheet(JUri::base() . 'components/com_cubic/assets/forms/form-review.css');
$doc->addStyleSheet(JUri::base() . 'components/com_cubic/assets/css/cubic.css');
$doc->addStyleSheet(JUri::base() . 'components/com_cubic/assets/css/template.css');
$doc->addStyleSheet(JUri::base() . 'components/com_cubic/assets/css/bootstrap.min.css');
$doc->addStylesheet(JUri::base() . 'components/com_cubic/assets/css/customsticky.css');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/jquery-1.10.2.js');
//$doc->addScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/jquery-ui.js');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/angular.min.js');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/bootstrap.min.js');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/components/ngCart/ngCart.js');
$doc->addScript(JUri::base() . 'components/com_cubic/assets/components/ngCart/ngCart.js');

$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/angular-ui-router.min.js'); // for multipage
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/angular-animate.min.js'); // for multipage
$doc->addScript(JUri::base() . 'components/com_cubic/assets/js/app.js');
$doc->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.2/angular-sanitize.js');

//get the array containing all the script declarations
//$headData = $doc->getHeadData();
//$scripts = $headData['scripts'];

//remove your script, i.e. mootools
//unset($this->_scripts['/media/jui/js/bootstrap.min.js']);
//$headData['scripts'] = $scripts;
//$document->setHeadData($headData);

$results = $this->results;
$catsresults = $this->catsresults;

$order_id = $this->order_id;

$curuser = JFactory::getUser();
$curuser_login = $curuser->id;
$curuser_email = $curuser->email;
$curuser_name =  $curuser->name;

$json_results = json_encode($results, JSON_NUMERIC_CHECK);
$json_catresults = json_encode($catsresults, JSON_NUMERIC_CHECK);

$params = JComponentHelper::getParams('com_cubic');
$packing_service_pack_yourself = $params->get('packing_service_pack_yourself');
$packing_service_professional_packing = $params->get('packing_service_professional_packing');
$packing_service_professional_packing_and_unpacking = $params->get('packing_service_professional_packing_and_unpacking');
$pricing_special_handling = $params->get('pricing_special_handling');
$pricing_storage = $params->get('pricing_storage');
$pricing_boxes_for_storage = $params->get('pricing_boxes_for_storage');

$app = JFactory::getApplication();
$menu = $app->getMenu()->getActive()->id;
if($menu > 0){
    $ItemID = '&Itemid='.$menu;
}

$redirectUrl = urlencode(base64_encode('index.php?option=com_cubic&view=reservation'.$ItemID));
//var_dump($redirectUrl);exit;
$login_url = JRoute::_('index.php?option=com_users&view=login&return='.$redirectUrl);
$registration_url = JRoute::_('index.php?option=com_users&view=registration&return='.$redirectUrl);

//echo '<pre>';echo $json_results;echo '</pre>';
?>
<style>
hr {margin:40px 0; }
h3 { color:#1758AA}
h3 span {font-size:14px; display:block;}
span[ng-click] {cursor: pointer; }
.active ul{display: block !important; }
.body{color:#fff; }
@media (min-width: 768px) and (max-width: 1200px)
{
#togglemenu1{width:0px;}
#togglemenu2{display:none;}
.funnel-wrapper .funnel-left{left: inherit !important;}
/*div.funnel-wrapper div.items-categories{overflow: inherit !important;}   */ 
.funnel-wrapper .funnel-right{right: 0px !important;}
.col-xs-12.col-sm-3.col-md-3.funnel-right.inventory-right{overflow: inherit !important;}
}
@media (min-width: 720px) and (max-width: 768px)
{
#togglemenu1{width:0px;}
#togglemenu2{display:none;}
.funnel-wrapper .funnel-left{left: inherit !important;}
/*div.funnel-wrapper div.items-categories{overflow: inherit !important;}   */ 
.funnel-wrapper .funnel-right{right: 0px !important;}
.col-xs-12.col-sm-3.col-md-3.funnel-right.inventory-right{overflow: inherit !important;}
}
@media (min-width: 480px) and (max-width: 720px)
{
#togglemenu1{width:0px;}
#togglemenu2{display:none;}
.funnel-wrapper .funnel-left{left: inherit !important;}
/*div.funnel-wrapper div.items-categories{overflow: inherit !important;}   */ 
.funnel-wrapper .funnel-right{right: 0px !important;}
.col-xs-12.col-sm-3.col-md-3.funnel-right.inventory-right{overflow: inherit !important;}
}
@media (min-width: 300px) and (max-width: 480px)
{
#togglemenu1{width:0px;}
#togglemenu2{display:none;}
.funnel-wrapper .funnel-left{left: inherit !important;}
/*div.funnel-wrapper div.items-categories{overflow: inherit !important;}   */ 
.funnel-wrapper .funnel-right{right: 0px !important;}
.col-xs-12.col-sm-3.col-md-3.funnel-right.inventory-right{overflow: inherit !important;}
}
@media (min-width: 260px) and (max-width: 300px)
{
#togglemenu1{width:0px;}
#togglemenu2{display:none;}
.funnel-wrapper .funnel-left{left: inherit !important;}
/*div.funnel-wrapper div.items-categories{overflow: inherit !important;}   */ 
.funnel-wrapper .funnel-right{right: 0px !important;}
.col-xs-12.col-sm-3.col-md-3.funnel-right.inventory-right{overflow: inherit !important;}
}
</style>
<script>
</script>
<script>

jQuery(function(){ // on DOM load
    //console.log('sidetogglemenu jquery loaded..');

    /*menu1 = new sidetogglemenu({  // initialize first menu example
        id: 'togglemenu1',
        marginoffset: 10
    });

    menu2 = new sidetogglemenu({  // initialize second menu example
        id: 'togglemenu2',
        position: 'right',
        revealamt: -5
    });*/

    var togMenu1Width = jQuery(".inventory-left").outerWidth();
    var togMenu2Width = jQuery(".inventory-right").outerWidth();
    var c = 0;
    togMenu1Width = 225;
    togMenu2Width = 350;
    //console.log(togMenu1Width);
    //console.log(togMenu2Width);

    function slideHideCategoriesBar(){
        //console.log('width:'+togMenu1Width);
        jQuery("#togglemenu1").animate({
                width: 0
        });
        //jQuery('.sideviewtoggle2').one('click');
        //jQuery("#togglemenu1").animate({left: '-=100%'});
        jQuery('#sideviewtoggle1_end').show();
        jQuery('#sideviewtoggle1_start').hide();
        jQuery('#sideviewtoggle2_end').hide();
        jQuery('#sideviewtoggle2_start').show();
    };

    jQuery('.sideviewtoggle1').click(function(){
        //console.log('sadfjnsdfjksdfn');
        var thisID1 = jQuery(this).attr('id');
        console.log(thisID1);
        if(thisID1 == "sideviewtoggle1_start"){
            console.log('yes in');
            jQuery("#togglemenu1").animate({
                width: 0
            });
            //jQuery('.sideviewtoggle2').one('click');
            //jQuery("#togglemenu1").animate({left: '-=100%'});
            jQuery('#sideviewtoggle1_end').show();
            jQuery('#sideviewtoggle1_start').hide();
            jQuery('#sideviewtoggle2_end').hide();
            jQuery('#sideviewtoggle2_start').show();
        } else {
            console.log('width:'+togMenu1Width);
            jQuery("#togglemenu1").animate({
                width: togMenu1Width
            });
            jQuery("#togglemenu2").slideUp();
            //jQuery('#togglemenu2').toggle('slide');
            //jQuery("#togglemenu1").animate({left: '+=100%'});
            jQuery('#sideviewtoggle1_end').hide();
            jQuery('#sideviewtoggle1_start').show();
            jQuery('#sideviewtoggle2_end').show();
            jQuery('#sideviewtoggle2_start').hide();
        }
        //jQuery('#togglemenu1').toggle();
    });

    jQuery('.sideviewtoggle2').click(function(){
        //console.log('hhahhhahhhah');
        var thisID2 = jQuery(this).attr('id');
        //console.log(thisID2);
        if(thisID2 == "sideviewtoggle2_start"){
            jQuery('#togglemenu2').toggle('slide');
            /*jQuery("#togglemenu1").animate({
                width: togMenu1Width
            });*/
            //jQuery("#togglemenu2").animate({right: '-=100%'});
            jQuery('#sideviewtoggle2_end').show();
            jQuery('#sideviewtoggle2_start').hide();
            jQuery('#sideviewtoggle1_end').hide();
            jQuery('#sideviewtoggle1_start').show();
        } else {
            //console.log('width:'+togMenu2Width);
            jQuery('#togglemenu2').toggle('slide');
            jQuery("#togglemenu1").animate({
                width: 0
            });
            //jQuery("#togglemenu2").animate({right: '+=100%'});
            jQuery('#sideviewtoggle2_end').hide();
            jQuery('#sideviewtoggle2_start').show();
            jQuery('#sideviewtoggle1_end').show();
            jQuery('#sideviewtoggle1_start').hide();
        }
    });
    //console.log(menu1);
    //console.log(menu2);

    var screenWidth = jQuery(window).width();
    //console.log('width:'+screenWidth);
    if(screenWidth <= 1200 ){
        jQuery('.fixedheader').addClass('fixed');
        /*jQuery(window).scroll(function(){
          var sticky = jQuery('.fixedheader'),
              scroll = jQuery(window).scrollTop();

          if (scroll >= 100) sticky.addClass('fixed');
          else sticky.removeClass('fixed');
        });*/
    }
});

</script>
<!--<div>
    <div id="progressWizard" class="progress-wizard desktop">
        <ul class="steps">
            <li class="step bold completed current" data-index="1">Inventory</li>
            <li class="step bold completed" data-index="2">Details</li>
            <li class="step bold completed" data-index="3">Compare</li>
            <li class="step bold active" data-index="4">Review</li>
            <li class="step bold" data-index="5">Book</li>
        </ul>
        <div class="progress-wrapper"></div>
    </div>
</div>--> 
<input type="hidden" id="base_uri" name="base_uri" value="<?php echo JUri::base(); ?>" />
<input type="hidden" id="images_uri" name="images_uri" value="<?php echo JUri::base().'components/com_cubic/assets/'; ?>" />
<input type="hidden" id="login_uri" name="base_uri" value="<?php echo $login_url; ?>" />
<input type="hidden" id="registration_uri" name="base_uri" value="<?php echo $registration_url; ?>" />
<div class="body" lang="en" ng-app="myApp">
    
    <div ng-controller="myCtrl" ng-init="onloadselectcategory();">
        <!-- views will be injected here -->

        <span style="display:none;" id="json_results"><?php echo $json_results; ?></span>
        <span style="display:none;" id="json_catresults"><?php echo $json_catresults; ?></span>

        <span style="display:none;" id="order_id"><?php echo $order_id; ?></span>
        <span style="display:none;" id="json_order_data"><?php echo (!empty($this->savedOrderData) ? $this->savedOrderData->orderdata : "" ) ?></span>

        <span style="display:none;" id="packing_service_pack_yourself"><?php echo $packing_service_pack_yourself; ?></span>
        <span style="display:none;" id="packing_service_professional_packing"><?php echo $packing_service_professional_packing; ?></span>
        <span style="display:none;" id="packing_service_professional_packing_and_unpacking"><?php echo $packing_service_professional_packing_and_unpacking; ?></span>
        <span style="display:none;" id="pricing_special_handling"><?php echo $pricing_special_handling; ?></span>
        <span style="display:none;" id="pricing_storage"><?php echo $pricing_storage; ?></span>
        <span style="display:none;" id="pricing_boxes_for_storage"><?php echo $pricing_boxes_for_storage; ?></span>

        <span style="display:none;" id="cur_user_name"><?php echo $curuser_name; ?></span>
        <span style="display:none;" id="cur_user_email"><?php echo $curuser_email; ?></span>
        <span style="display:none;" id="cur_user_login"><?php echo $curuser_login; ?></span>

        <div class="container">
        <!-- <div class="toggle-group">
            <button id="sideviewtoggle1_start" class="sideviewtoggle1" style="display:none;">Toggle Menu 1</button>
            <button id="sideviewtoggle1_end" class="sideviewtoggle1">Toggle Menu 1</button>
            <button id="sideviewtoggle2_start" class="sideviewtoggle2" style="display:none;">Toggle Menu 2</button>
            <button id="sideviewtoggle2_end" class="sideviewtoggle2" >Toggle Menu 2</button>
         </div> -->
            <div ui-view>
            </div>

        </div>
    </div>

</div>
<script>
function removejscssfile(filename, filetype){
    var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
    var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
    var allsuspects=document.getElementsByTagName(targetelement)
    for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
    if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
        allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
    }
}
// Will be true if bootstrap 3 is loaded, false if bootstrap 2 or no bootstrap
var bootstrap3_enabled = (typeof $().emulateTransitionEnd == 'function');
console.log('bootstrap:'+bootstrap3_enabled);
if(bootstrap3_enabled){
    
} else { 
    //removejscssfile("bootstrap.min.js", "js") //remove all occurences of "somescript.js" on page
    removejscssfile("template.css", "css") //remove all occurences "somestyle.css" on page
    //document.write('<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />');
    //document.write('<scr'+ 'ipt src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></scr'+'ipt>');
}

var bootstrap3_enabled_now = (typeof $().emulateTransitionEnd == 'function');
console.log('bootstrap:'+bootstrap3_enabled_now);
</script>