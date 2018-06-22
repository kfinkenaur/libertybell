<?php 
defined('_JEXEC') or die;

$user = JFactory::getUser();
$userId = $user->get('id');
$doc=JFactory::getDocument();
$doc->addStylesheet("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
//$doc->addStylesheet(JUri::base() . '/components/com_cubic/assets/css/progress-style-bootstrap.css');
$doc->addStylesheet('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
$doc->addStylesheet(JUri::base() . '/components/com_cubic/assets/css/progress-style.css');
$doc->addScript('http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');
$doc->addScript('https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js');
$doc->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js');
$doc->addScript(JUri::base() . '/components/com_cubic/assets/components/ngCart/ngCart.js');

$doc->addScript('//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.10/angular-ui-router.min.js'); // for multipage
$doc->addScript('//ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-animate.min.js'); // for multipage
$doc->addScript(JUri::base() . '/components/com_cubic/assets/js/plans.js');

$results = $this->results;
//$catsresults = $this->catsresults;

$json_results = json_encode($results, JSON_NUMERIC_CHECK);
//$json_catresults = json_encode($catsresults, JSON_NUMERIC_CHECK);
//echo '<pre>';echo $json_results;echo '</pre>';
?>
<style>
hr {
    margin:40px 0;
} 
h3 { color:#1758AA}
h3 span {font-size:14px; display:block;}
span[ng-click] {
        cursor: pointer;
    }
.active ul{
    display: block !important;
}
/*.body{
    color:#fff;
}*/
</style>
<script>
</script>
<input type="hidden" id="base_uri" name="base_uri" value="<?php echo JUri::base(); ?>" />
<div class="body" lang="en" ng-app="plansApp">
    
    <div ng-controller="plansCtrl">
        <!-- views will be injected here -->

        <span style="display:none;" id="json_results"><?php echo $json_results; ?></span>

        <div class="row-fluid" id="unbooked-move-plans-title-box">
            <div class="col-md-12">
                <h2 class="bold-title">unbooked move plans</h2>
                <div class="vertical-spacer-15"></div>
            </div>
        </div>

        <!-- ng-show="plan_result.orderdata" -->

        <div class="row-fluid">
            <div id="message"></div>
            <div class="col-md-6 col-xs-6 large-6 columns myhome-plan-grid" id="planNo{{plan_result.id}}" ng-repeat="plan_result in json_results">
                <div class="myhome-plan-card">
                    <div class="row-fluid">
                        <div class="small-6 columns">
                            <div class="myhome-plan-card-plan-desc" ng-bind="plan_result.neworderdata.home_type"></div>
                            <div class="myhome-plan-card-plan-desc" ng-hide="plan_result.neworderdata.home_type">1 Bedroom, Small (600-800 sq ft)</div>
                            <div class="vertical-spacer-10"></div>
                            <div>Move date: <strong ng-bind="plan_result.neworderdata.date"></strong> <strong ng-hide="plan_result.neworderdata.date">1/28/2016</strong></div>
                        </div>
                    </div>
                    <div class="myhome-mover-name">Liberty Bell Moving & Storage</div>
                    <div class="vertical-spacer-10"></div>
                    <div class="myhome-price" ng-show="plan_result.neworderdata.totalcost">${{plan_result.neworderdata.totalcost}}</div>
                    <div class="myhome-price" ng-hide="plan_result.neworderdata.totalcost">$1,983.50</div>
                    <div class="myhome-card-bottom-spacer"></div>
                    <div class="myhome-card-links">
                        <div>
                            <a class="myhome-view-move-plan-link" href="<?php echo JRoute::_('index.php?option=com_cubic&view=reservation&order={{plan_result.id}}'); ?>">Continue Move Plan</a>
                        </div>
                    </div>
                    <div class="myhome-mp-status-box myhome-mp-status-in">
                        <div class="myhome-mp-status">in progress</div>
                        <div class="delete-move-plan-link-box">
                            <a class="delete-move-plan-link" href="#" data-move-plan-id="202435" ng-click="deleteMove(plan_result.id);">Delete Move Plan</a>
                        </div>
                    </div>
                    <div class="myhome-mp-id-box">
                        <div style="text-transform:uppercase;" class="myhome-mp-uuid" ng-show="plan_result.neworderdata.move_id" ng-model="plan_result.neworderdata.move_id">{{plan_result.neworderdata.move_id}}</div>
                        <div class="myhome-mp-uuid" ng-hide="plan_result.neworderdata.move_id">B0B90A</div>
                        <div>Move Plan ID</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div ui-view></div>
        </div>
    </div>

</div>