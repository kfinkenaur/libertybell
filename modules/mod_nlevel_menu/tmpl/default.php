<?php
/**
 * @package NLevel Responsive Menu
 * @version 2.0.0
 * @license http://www.raindropsinfotech.com GNU/GPL
 * @copyright (c) 2015 Raindrops Company. All Rights Reserved.
 * @author http://www.raindropsinfotech.com
 */
defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript(JURI::base().'modules/'.$module->module.'/assets/js/jquery.smartmenus.js');

$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/assets/css/style.css');
$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/assets/css/jquery.mmenu.all.css');
$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/assets/css/sm-core-css.css');
$document->addStyleSheet(JURI::base().'modules/'.$module->module.'/assets/css/sm-blue.css');


$style = $params->get('custom_css');
$classPrefix = $params->get('class_prefix');
$document->addStyleDeclaration( $style );

$script = '
jQuery(document).ready(function(){
    jQuery(".nlevel-menu").smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8,
        showDuration:300
    });
});';
$document->addScriptDeclaration($script);
?>
<!-- Generate menu for desktop view start -->
<?php
if(!empty($menus)){
    ?>
    <nav id="rain_main_ul" role="navigation"> 
        <ul class="nlevel-menu sm sm-blue">
            <?php 
            $app = JFactory::getApplication();
            $currMenu = $app->getMenu()->getActive()->id;
            $viewtype = $params->get('viewtype');
            $startlevel =1;

            if(isset($menus) && count($menus)){
                $countUlOpened = 0; $level = 1; 
                for($i = 0; $i < count($menus); $i++){
                    if($i == 0){ 
                        $countUlOpened++;
                    }

                    $class = "";
                    $hasChild = " level-".$level." ";

                    if($i < count($menus)-1 && $menus[$i+1]->level > $menus[$i]->level){
                        $hasChild .= " havechild";
                    }

                    if($menus[$i]->id == $itemID){        
                        if($level == $startlevel)
                            $class  = ' class="active first_level first '.$hasChild.'  " ';
                        else
                            $class  .= ' class="active '.$hasChild.'" first ';

                        $class  .= ' ';
                    }else{   
                        if($level == $startlevel)
                            $class  = ' class="first_level '.$hasChild.'  " ';
                        else         
                            $class  .= ' class="'.$hasChild.' " ';
                    }

                    $li = "<li ".$class.">";
                    $style = $target = "";        
                    $divLink = "<a ".$target." href='".$menus[$i]->flink."'>".$menus[$i]->title."</a>";
                    $li.=$divLink; 
                    echo $li;

                    if($i < count($menus)-1  && $menus[$i+1]->level > $menus[$i]->level ){
                        $hasChildContent = '';
                        if($level == $startlevel){
                            $hasChildContent = "first_level_content";
                        }
                        echo "<ul>";            

                        $countUlOpened++;
                        $level++;
                    }
                    
                    if($i < count($menus)-1 && $menus[$i+1]->level < $menus[$i]->level ){
                        echo "</li>";
                        echo"</ul></li>";
                        $countUlOpened--;
                        $level--;
                        for($j = 1; $j < $menus[$i]->level - $menus[$i+1]->level; $j++){
                            echo "</ul></li>";
                            $countUlOpened--;
                            $level--;
                        }            
                    }

                    if( $i < count($menus)-1 && $menus[$i+1]->level == $menus[$i]->level){
                        echo "</li>";
                    }
                }
                for($i=0; $i< $countUlOpened - 1; $i++){
                        echo "</li></ul>";
                }
                ?>
                </li>
            </ul>
                <?php 
            }

            ?>
            </ul>
    </nav> 
    <?php
}
?>
<!-- Generate menu for desktop view end -->

<!-- Generate menu for mobile view start -->
<?php 

$ulMenus = $loop = $loopD = array();
$loopC = $counter = $ilIdC = 0;
$level = $startlevel;
$ilId = array('mm-0');


if(isset($menus) && count($menus)){
    for($i=0;$i < count($menus);$i++) {        
        $liActive = '';        
        if($currMenu == $menus[$i]->id)
            $liActive ="active";

        if($i == 0){ 
            $firstUl = '';            
            if($viewtype == 2)
                $firstUl = 'first-ul';

            if(isset($loop[$loopC])){
                $loop[$loopC] .= '<ul id="'.$ilId[count($ilId)-1].'" class="blank mm-list mm-panel mm-opened mm-current '.$firstUl.'" >';    
            }else{
                $loop[$loopC] = '<ul id="'.$ilId[count($ilId)-1].'" class="blank mm-list mm-panel mm-opened mm-current '.$firstUl.'" >';    
            }

            if($menus[$i]->level < $menus[$i+1]->level)
                $loop[$loopC] .= '<li class="first_li '.$liActive.'"><a class="mm-subopen" href="#mm-'.($ilIdC+1).'" ></a><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';        
            else
                $loop[$loopC] .= '<li class="first_li '.$liActive.'" ><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';            

            $counter++;              
            if(count($menus) == 1){
                foreach ($loop as $lkey => $liVal) {
                    $loopD[] = $liVal.'</ul>';           
                }
            }
            continue;               
        }

        if($menus[$i]->level == $menus[$i-1]->level){    

            if($menus[$i]->level < $menus[$i+1]->level){                                            
                if(isset($loop[$loopC])){                
                    $loop[$loopC] .= '<li class="'.$liActive.'"><a class="mm-subopen " href="#mm-'.($ilIdC+1).'" ></a><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';
                }else{
                    $loop[$loopC] = '<li class="'.$liActive.'"><a class="mm-subopen " href="#mm-'.($ilIdC+1).'" ></a><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';
                }
            }else{    
                if(isset($loop[$loopC])){                         
                    $loop[$loopC] .= '<li class="'.$liActive.'"><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';              
                }else{
                    $loop[$loopC] = '<li class="'.$liActive.'"><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';              
                }
            }
        }

        if($menus[$i]->level > $menus[$i-1]->level){                
            $ct = '';
            $loopC++;
            $level++;        
            $ilIdC++;
            $ilId[count($ilId)] = 'mm-'.$ilIdC;
            if(isset($loop[$loopC]))
                $loop[$loopC] .= '<ul id="'.$ilId[count($ilId)-1].'" class="nav mm-list mm-panel mm-hidden">';     
            else
                 $loop[$loopC] = '<ul id="'.$ilId[count($ilId)-1].'" class="nav mm-list mm-panel mm-hidden">';     

            $aLink = '<a href="#'.$ilId[count($ilId)-2].'" class="mm-subclose" >';
            if(($viewtype == 2) && ($startlevel+1 == $level)){
                $aLink = '<a >';
            }

            $loop[$loopC] .= '<li class="mm-subtitle first_li" >'.$aLink.$menus[$i-1]->title.'</a></li>';            
            if($menus[$i]->level < $menus[$i+1]->level){                                
                $loop[$loopC] .= '<li class="'.$liActive.'"><a class="mm-subopen " href="#mm-'.($ilIdC+1).'" ></a><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';
            }else{
                $loop[$loopC] .= '<li class="'.$liActive.'"><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';              
            }
        }
        
        if($menus[$i]->level < $menus[$i-1]->level){

            for($j = 1; $j < $menus[$i-1]->level - $menus[$i]->level  ; $j++){            
                $loop[$loopC] .= '</ul>';
                unset($ilId[count($ilId)-1]);
                $loopD[] = $loop[$loopC];
                unset($loop[$loopC]);            
                $loopC--;
                $level--;            
            }
            $loop[$loopC] .= '</ul>';
            
            if($menus[$i]->level < $menus[$i+1]->level){            
                $loop[$loopC-1] .= '<li class="'.$liActive.'"><a class="mm-subopen" href="#mm-'.($ilIdC+1).'" ></a><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';
            }else
                $loop[$loopC-1] .= '<li class="'.$liActive.'"><a href="'.$menus[$i]->flink.'" >'.$menus[$i]->title.'</a></li>';        

            $loopD[] = $loop[$loopC];        
            unset($loop[$loopC]);
            unset($ilId[count($ilId)-1]);
            $loopC--;          
            $level--;        
        }

        if($i == count($menus)-1 && count($loop) > 0){        
            foreach ($loop as $lkey => $liVal) {
                $loopD[] = $liVal.'</ul>';           
            }
        } 
    } 
}

?>



<?php 
$possition = '';
if($params->get('mobile_menu_position') == 2){ 
    $possition = 'mobile_sticky';    
} 
?>
<div class="toggle-group <?php echo $possition;?>">
    <div class="categories-btn btn-area-part">
        <button id="sideviewtoggle1_start" class="sideviewtoggle1" style="display:none;">Categories</button>
        <button id="sideviewtoggle1_end" class="sideviewtoggle1">Categories</button>
    </div>
    <div class="mobile-menu-btn btn-area-part">  
        <div class="menu_button menu_icon" id="mobile_menu_show" style="display:none;">
            <div class="navicon-line"></div>
            <div class="navicon-line"></div>
            <div class="navicon-line"></div>
        </div>
    </div>
    <div class="moveplan-btn btn-area-part">
        <button id="sideviewtoggle2_start" class="sideviewtoggle2" style="display:none;">Move Plan</button>
        <button id="sideviewtoggle2_end" class="sideviewtoggle2" >Move Plan</button>
    </div>
</div>
<div id="yt-off-resmenu" class="mm-menu mm-horizontal mm-ismenu mm-offcanvas ">
    <div class="ul_header" id="ul_header">
        <div class="home_click"><a href="<?php echo JURI::base(); ?>">Home</a></div>
        <div id="mobile_menu_hide" class="close_button">
            <img src="<?php echo JURI::base(); ?>modules/<?php echo $module->module ?>/assets/images/close_btn.png">        
        </div>
    </div>
<?php     
foreach ($loopD as $key => $value) {
   echo $value;
}

?>
</div>
<!-- Generate menu for mobile view end -->
      
