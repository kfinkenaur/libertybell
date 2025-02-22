<?php
/*
    Help and credits page - Leaflet Maps Marker Plugin
*/
//info prevent file from being accessed directly
if (basename($_SERVER['SCRIPT_FILENAME']) == 'leaflet-help-credits.php') { die ("Please do not access this file directly. Thanks!<br/><a href='http://www.mapsmarker.com/go'>www.mapsmarker.com</a>"); }
?>
<div class="wrap">
	<?php $lmm_options = get_option( 'leafletmapsmarker_options' ); ?>
	<?php include('inc' . DIRECTORY_SEPARATOR . 'admin-header.php'); ?>
	<p>
	<h3 style="font-size:23px;"><?php _e('Help','lmm') ?></h3>
	<p>
		<?php _e('Do you have questions or issues with Leaflet Maps Marker? Please use the following support channels appropriately.','lmm') ?>
	</p>
	<p>
		<strong><?php _e('One personal request: before you post a new support ticket in the <a href="http://wordpress.org/support/plugin/leaflet-maps-marker" target="_blank">Wordpress Support Forum</a>, please follow the instructions from <a href="http://www.mapsmarker.com/readme-first" target="_blank">http://www.mapsmarker.com/readme-first</a> which give you a guideline on how to deal with the most common issues.','lmm') ?></strong>
	</p>
	<ul>
		<li>- <a href="http://www.mapsmarker.com/faq/" target="_blank"><?php _e('FAQ','lmm') ?></a>	<?php _e('(frequently asked questions)','lmm') ?></li>
		<li>- <a href="http://www.mapsmarker.com/docs/" target="_blank"><?php _e('Documentation','lmm') ?></a></li>
		<li>- <a href="http://www.mapsmarker.com/docs/changelog/" target="_blank"><?php _e('Changelog','lmm') ?></a></li>
		<li>- <a href="http://wordpress.org/support/plugin/leaflet-maps-marker" target="_blank">WordPress Support Forum</a> <?php _e('(free community support)','lmm') ?></li>
		<li>- <a href="http://wpquestions.com/affiliates/register/name/robertharm" target="_blank">WP Questions</a>	<?php _e('(paid community support)','lmm') ?></li>
		<li>- <a href="http://wphelpcenter.com/" target="_blank">WordPress HelpCenter</a> <?php _e('(paid professional support)','lmm') ?></li>
	</ul>
	<p>
		<?php _e('More information on support','lmm') ?>: <a href="http://www.mapsmarker.com/support/" target="_blank">http://www.mapsmarker.com/support</a></p>
	<h3 style="font-size:23px;"><?php _e('Licence','lmm') ?></h3>
	<p>
		<?php _e('Good news, this plugin is free for everyone! Since it is released under the GPL2, you can use it free of charge on your personal or commercial blog.<br/>But if you enjoy this plugin, you can thank me and leave a small donation for the time I have spent writing and supporting this plugin.<br/>Please see <a href="http://www.mapsmarker.com/donations" target="_blank">http://www.mapsmarker.com/donations</a> for details.','lmm') ?>
	</p>
	<h3 style="font-size:23px;"><?php _e('Trademarks and copyright','lmm') ?></h3>
	<p>
	MapsMarker<sup style="font-size:75%;">&reg;</sup> - registration pending<br/>
	Copyright &copy; 2011-2012, Robert Harm, All Rights Reserved
	</p>
	<h3 style="font-size:23px;"><?php _e('Licenses for used libraries, services and images','lmm') ?></h3>
	<ul>
		<li>- Leaflet by Cloudmade, <a href="http://www.leafletjs.com" target="_blank">http://www.leafletjs.com</a>, Copyright (c) 2010-2012, CloudMade, Vladimir Agafonkin</li>
		<li>- OpenStreetMap: <a href="http://wiki.openstreetmap.org/wiki/OpenStreetMap_License" target="_blank">OpenStreetMap License</a></li>
		<li>- Datasource OGD Vienna maps: Stadt Wien - <a href="http://data.wien.gv.at" target="_blank">http://data.wien.gv.at</a></li>
		<li>- Address autocompletion powered by <a href="http://code.google.com/intl/de-AT/apis/maps/documentation/places/autocomplete.html" target="_blank">Google Places API</a></li>
		<li>- Jquery TimePicker by Trent Richardson, <a href="http://trentrichardson.com/examples/timepicker/" target="_blank">http://trentrichardson.com/examples/timepicker/</a>, licence: GPL</li>
		<li>- <a href="http://mapicons.nicolasmollet.com" target="_blank">Map Icons Collection</a> by Nicolas Mollet</li>
		<li>- Map center icon by <a href="http://glyphish.com/" target="_blank">Joseph Wain</a>, licence: Creative Commons Attribution (by)</li>
		<li>- Question Mark Icon by <a href="http://www.randomjabber.com/" target="_blank">RandomJabber</a></li>
		<li>- Images for changelog from <a href="http://www.mozilla.org/en-US/firefox/11.0/releasenotes/">Firefox release notes</a>, licence: Creative Commons Attribution ShareAlike (CC BY-SA 3.0)</li> 
		<li>- Plus-, json-, layer-, language- &amp; csv-export-icon from <a href="http://p.yusukekamiyamane.com/" target="_blank">Yusuke Kamiyamane</a>, licence: Creative Commons Attribution (by)</li>
		<li>- Home-Icon from <a href="http://prothemedesign.com/" target="_blank">Pro Theme Design</a>, licence: Creative Commons Attribution (by)</li>
		<li>- Editor-Switch-Icon by AMAZIGH Aneglus, license: GNU/GPL</li>
		<li>- Submenu icons from <a href="http://bijou.im/" target="_blank">Bijou</a> and <a href="http://somerandomdude.com/work/iconic/" target="_blank">Iconic</a> icon sets (GPL)</li>
	</ul>
	<h3 style="font-size:23px;"><?php _e('Translations','lmm') ?></h3>
	<p>
	<?php 
	$translation_website = '<a href="http://translate.mapsmarker.com/projects/lmm" target="_blank">http://translate.mapsmarker.com/projects/lmm</a>';
	$translation_output = sprintf(__('Adding a new translation or updating an existing one is quite easy - please visit %s for more information!','lmm'),$translation_website); 
	echo $translation_output;
	?>	
	</p>
	<ul>
		<li>- Bengali (ba_BD) thanks to Nur Hasan, <a href="http://www.answersbd.com" target="_blank">http://www.answersbd.com</a></li>
		<li>- Bosnian (bs_BA) thanks to Kenan Dervišević, <a href="http://dkenan.com" target="_blank">http://dkenan.com</a></li>
		<li>- Bulgarian (bg_BG) thanks to Andon Ivanov, <a href="http://coffebreak.info" target="_blank">http://coffebreak.info</a></li>
		<li>- Catalan (ca) by Vicent Cubells, <a href="http://vcubells.net" target="_blank">http://vcubells.net</a></li>
		<li>- Chinese (zh_CN) by John Shen, <a href="http://www.synyan.net" target="_blank">http://www.synyan.net</a></li>
		<li>- Chinese (zh_TW) by jamesho Ho, <a href="http://outdooraccident.org" target="_blank">http://outdooraccident.org</a></li>
		<li>- Croatian (hr) by Neven Pausic, <a href="http://www.airsoft-hrvatska.com" target="_blank">http://www.airsoft-hrvatska.com</a> and Alan Benic</li>
		<li>- Czech (cs_CZ) by Viktor Kleiner</li>
		<li>- Danish (da_DK) by Mads Dyrmann Larsen</li>
		<li>- Dutch (nl_NL) by Marijke Metz, <a href="http://www.mergenmetz.nl" target="_blank">http://www.mergenmetz.nl</a> and Patrick Ruers, <a href="http://www.stationskwartiersittard.nl" target="_blank">http://www.stationskwartiersittard.nl</a></li>
		<li>- English (en_US) by <a href="http://twitter.com/robertharm" target="_blank">@RobertHarm</a></li>
		<li>- French (fr_FR) by Vincèn Pujol, <a href="http://www.skivr.com" target="_blank">http://www.skivr.com</a></li>
		<li>- German (de_DE) by <a href="http://twitter.com/robertharm" target="_blank">@RobertHarm</a></li>
		<li>- Hindi (hi_IN) by Outshine Solutions, <a href="http://outshinesolutions.com" target="_blank">http://outshinesolutions.com</a> and Guntupalli Karunakar, <a href="http://indlinux.org" target="_blank">http://indlinux.org</a></li>
		<li>- Hungarian (hu_HU) thanks to István Pintér, <a href="http://www.logicit.hu" target="_blank">http://www.logicit.hu</a></li>
		<li>- Indonesian (id_ID) thanks to Emir Hartato, <a href="http://whateverisaid.wordpress.com" target="_blank">http://whateverisaid.wordpress.com</a></li>
		<li>- Italian (it_IT) by <a href="mailto:lucabarbetti@gmail.com">Luca Barbetti</a></li>
		<li>- Japanese (ja) by Shu Higashi, <a href="http://twitter.com/higa4" target="_blank">@higa4</a></li>
		<li>- Polish (pl_PL) thanks to Pawel Wyszy&#324;ski, <a href="http://injit.pl" target="_blank">http://injit.pl</a></li>
		<li>- Portuguese (pt_BR) thanks to Andre Santos, <a href="http://pelaeuropa.com.br" target="_blank">http://pelaeuropa.com.br</a> and Antonio Hammerl</li>
		<li>- Portuguese (pt_PT) thanks to Joao Campos, <a href="http://www.all-about-portugal.com" target="_blank">http://www.all-about-portugal.com</a></li>
		<li>- Romanian (ro) thanks to Daniel Codrea, <a href="http://www.inadcod.com" target="_blank">http://www.inadcod.com</a></li>
		<li>- Russian (ru_RU) thanks to Ekaterina Golubina, , supported by Teplitsa of Social Technologies - <a href="http://te-st.ru" target="_blank">http://te-st.ru</a></li>
		<li>- Slovak (sk_SK) thanks to Zdenko Podobny</a></li>
		<li>- Spanish (es_ES) by David Ramírez, <a href="http://www.hiperterminal.com" target="_blank">http://www.hiperterminal.com</a> &amp; Alvaro Lara, <a href="http://www.alvarolara.com" target="_blank">http://www.alvarolara.com</a>, Ricardo Viteri, <a href="http://www.labviteri.com" target="_blank">http://www.labviteri.com</a> and Victor Guevara, <a href="http://1sistemas.net" target="_blank">http://1sistemas.net</a></li>
		<li>- Turkish (tr_TR) thanks to Emre Erkan, <a href="http://www.karalamalar.net" target="_blank">http://www.karalamalar.net</a></li>
		<li>- Ukrainian (uk_UK) thanks to Andrexj, <a href="http://all3d.com.ua" target="_blank">http://all3d.com.ua</a></li>
		<li>- Yiddish (yi) thanks to Raphael Finkel, <a href="http://www.cs.uky.edu/~raphael/yiddish.html" target="_blank">http://www.cs.uky.edu/~raphael/yiddish.html</a></li>
	</ul>
	<h3 style="font-size:23px;"><?php _e('Credits & special thanks','lmm') ?></h3>
	<ul>
		<li>- <a href="http://psha.org.ru/b/leaflet-plugins.html" target="_blank">shramov</a> for bing and google maps plugins for leaflet</li>
		<li>- Sindre Wimberger (<a href="http://www.sindre.at" target="_blank">http://www.sindre.at</a>) - bugfixing &amp; geo-consulting</li>
		<li>- Julia Loew (<a href="http://www.weiderand.net" target="_blank">http://www.weiderand.net</a>) - logo &amp; corporate design</li>
		<li>- <a href="http://alisothegeek.com/2011/01/wordpress-settings-api-tutorial-1/" target="_blank">WordPress-Settings-API-Class</a> by Aliso the geek</li>
		<li>- Hind who originally released a basic Leaflet plugin (not available anymore) which I used partly as a basis for Leaflet Maps Marker plugin</li>
	</ul>
	</p>
</div>
<?php include('inc' . DIRECTORY_SEPARATOR . 'admin-footer.php'); ?>
