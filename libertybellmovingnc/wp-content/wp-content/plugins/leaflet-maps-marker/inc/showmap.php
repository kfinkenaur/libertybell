<?php
    //info: remove filter from SEO Friendly Images for compatibility reasons
    include_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'plugin.php' );
    if (is_plugin_active('seo-image/seo-friendly-images.php') ) {
        if ( function_exists( 'seo_friendly_images_install' ) ) {
            remove_filter('the_content', 'seo_friendly_images', 100);
        }
    }
    global $wpdb, $wp_version;
    $lmm_options = get_option( 'leafletmapsmarker_options' );
	//info: set marker shadow url
	if ( $lmm_options['defaults_marker_icon_shadow_url_status'] == 'default' ) {
		if ( $lmm_options['defaults_marker_icon_shadow_url'] == NULL ) {
			$marker_shadow_url = '';
		} else {
			$marker_shadow_url = LEAFLET_PLUGIN_URL . 'leaflet-dist/images/marker-shadow.png';
		}
	} else {
		$marker_shadow_url = htmlspecialchars($lmm_options['defaults_marker_icon_shadow_url']);
	}	
    $uid = substr(md5(''.rand()), 0, 8);
    extract(shortcode_atts(array(
        'lat' => '', 'lon' => '',
        'mlat' => '', 'mlon' => '',
        'basemap' => $lmm_options[ 'defaults_marker_shortcode_basemap'],
        'mpopuptext' => '',
        'micon' => '',
        'zoom' => intval($lmm_options[ 'defaults_marker_shortcode_zoom' ]),
        'openpopup' => '',
        'geojson' => '',
        'geojsonurl' => '',
        'layer' => '',
        'marker' => '',
        'markername' => '',
        'panel' => '0',
        'mapwidth' => intval($lmm_options[ 'defaults_marker_shortcode_mapwidth' ]),
        'mapwidthunit' => $lmm_options[ 'defaults_marker_shortcode_mapwidthunit' ],
        'mapheight' => intval($lmm_options[ 'defaults_marker_shortcode_mapheight' ]),
        'mapname' => 'lmm_map_'.$uid
    ), $atts));
    $pname = 'pa'.$uid;
    //info: prepare layers
    if (!empty($layer)) {
        $table_name_layers = $wpdb->prefix.'leafletmapsmarker_layers';
        $row = $wpdb->get_row('SELECT id,name,basemap,mapwidth,mapheight,mapwidthunit,panel,layerzoom,layerviewlat,layerviewlon,controlbox,overlays_custom,overlays_custom2,overlays_custom3,overlays_custom4,wms,wms2,wms3,wms4,wms5,wms6,wms7,wms8,wms9,wms10,listmarkers,multi_layer_map,multi_layer_map_list FROM '.$table_name_layers.' WHERE id='.$layer, ARRAY_A);
        $id = $row['id'];
        $basemap = $row['basemap'];
        $lat = $row['layerviewlat'];
        $lon = $row['layerviewlon'];
        $zoom = $row['layerzoom'];
        $mapwidth = $row['mapwidth'];
        $mapheight = $row['mapheight'];
        $mapwidthunit = $row['mapwidthunit'];
        $panel = $row['panel'];
        $paneltext = ($row['name'] == NULL) ? '&nbsp;' : htmlspecialchars($row['name']);
        $controlbox = $row['controlbox'];
        $overlays_custom = $row['overlays_custom'];
        $overlays_custom2 = $row['overlays_custom2'];
        $overlays_custom3 = $row['overlays_custom3'];
        $overlays_custom4 = $row['overlays_custom4'];
        $wms = $row['wms'];
        $wms2 = $row['wms2'];
        $wms3 = $row['wms3'];
        $wms4 = $row['wms4'];
        $wms5 = $row['wms5'];
        $wms6 = $row['wms6'];
        $wms7 = $row['wms7'];
        $wms8 = $row['wms8'];
        $wms9 = $row['wms9'];
        $wms10 = $row['wms10'];
        $listmarkers = $row['listmarkers'];
        $multi_layer_map = $row['multi_layer_map'];
        $multi_layer_map_list = $row['multi_layer_map_list'];
        $multi_layer_map_list_exploded = explode(",", $multi_layer_map_list);
    }
    //info: prepare markers
    if (!empty($marker))  {
            $table_name_markers = $wpdb->prefix.'leafletmapsmarker_markers';
                $row = $wpdb->get_row('SELECT id,markername,basemap,layer,lat,lon,icon,popuptext,zoom,openpopup,mapwidth,mapwidthunit,mapheight,panel,controlbox,overlays_custom,overlays_custom2,overlays_custom3,overlays_custom4,wms,wms2,wms3,wms4,wms5,wms6,wms7,wms8,wms9,wms10,address FROM '.$table_name_markers.' WHERE id='.$marker, ARRAY_A);
                if(!empty($row)) {
                    $id = $row['id'];
                    $markername = $row['markername'];
                    $basemap = $row['basemap'];
                    $lon = $row['lon'];
                    $lat = $row['lat'];
                    $coords = $lat.', '.$lon;
                    $icon = $row['icon'];
                    $popuptext = $row['popuptext'];
                    $zoom = $row['zoom'];
                    $openpopup = ($row['openpopup'] == 1) ? '.openPopup()' : '';
                    $mopenpopup = $openpopup;
                    $layer = $row['layer'];
                    $mlat = $lat;
                    $mlon = $lon;
                    $mpopuptext = $popuptext;
                    $micon = $icon;
                    $mapwidth = $row['mapwidth'];
                    $mapwidthunit = $row['mapwidthunit'];
                    $mapheight = $row['mapheight'];
                    $panel = $row['panel'];
                    $paneltext = ($row['markername'] == NULL) ? '&nbsp;' : htmlspecialchars($row['markername']);
                    $controlbox = $row['controlbox'];
                    $overlays_custom = $row['overlays_custom'];
                    $overlays_custom2 = $row['overlays_custom2'];
                    $overlays_custom3 = $row['overlays_custom3'];
                    $overlays_custom4 = $row['overlays_custom4'];
                    $wms = $row['wms'];
                    $wms2 = $row['wms2'];
                    $wms3 = $row['wms3'];
                    $wms4 = $row['wms4'];
                    $wms5 = $row['wms5'];
                    $wms6 = $row['wms6'];
                    $wms7 = $row['wms7'];
                    $wms8 = $row['wms8'];
                    $wms9 = $row['wms9'];
                    $wms10 = $row['wms10'];
					$address = htmlspecialchars($row['address']);
					$listmarkers = 0;
                }
    }
    //info: prepare markers only added by shortcode and not defined in backend
    if (empty($layer) and empty($marker)) {
        $lat = $mlat;
        $lon = $mlon;
        $controlbox = $lmm_options[ 'defaults_marker_shortcode_controlbox' ];
        $overlays_custom = isset($lmm_options[ 'defaults_marker_shortcode_overlays_custom_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_overlays_custom_active' ] == 1 ) ? '1' : '0';
        $overlays_custom2 = isset($lmm_options[ 'defaults_marker_shortcode_overlays_custom2_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_overlays_custom2_active' ] == 1 ) ? '1' : '0';
        $overlays_custom3 = isset($lmm_options[ 'defaults_marker_shortcode_overlays_custom3_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_overlays_custom3_active' ] == 1 ) ? '1' : '0';
        $overlays_custom4 = isset($lmm_options[ 'defaults_marker_shortcode_overlays_custom4_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_overlays_custom4_active' ] == 1 ) ? '1' : '0';
        $wms = isset($lmm_options[ 'defaults_marker_shortcode_wms_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms_active' ] == 1 ) ? '1' : '0';
        $wms2 = isset($lmm_options[ 'defaults_marker_shortcode_wms2_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms2_active' ] == 1 ) ? '1' : '0';
        $wms3 = isset($lmm_options[ 'defaults_marker_shortcode_wms3_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms3_active' ] == 1 ) ? '1' : '0';
        $wms4 = isset($lmm_options[ 'defaults_marker_shortcode_wms4_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms4_active' ] == 1 ) ? '1' : '0';
        $wms5 = isset($lmm_options[ 'defaults_marker_shortcode_wms5_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms5_active' ] == 1 ) ? '1' : '0';
        $wms6 = isset($lmm_options[ 'defaults_marker_shortcode_wms6_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms6_active' ] == 1 ) ? '1' : '0';
        $wms7 = isset($lmm_options[ 'defaults_marker_shortcode_wms7_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms7_active' ] == 1 ) ? '1' : '0';
        $wms8 = isset($lmm_options[ 'defaults_marker_shortcode_wms8_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms8_active' ] == 1 ) ? '1' : '0';
        $wms9 = isset($lmm_options[ 'defaults_marker_shortcode_wms9_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms9_active' ] == 1 ) ? '1' : '0';
        $wms10 = isset($lmm_options[ 'defaults_marker_shortcode_wms10_active' ]) == TRUE && ($lmm_options[ 'defaults_marker_shortcode_wms10_active' ] == 1 ) ? '1' : '0';
        $mopenpopup = '';
		$listmarkers = 0;
    }

    //info: show static image with link in feeds
    if (is_feed()) {
        if ($lat != NULL) { //info: marker exists?
            if (empty($layer)) {
            $lmm_out = '<p>' . $paneltext . '<br/><a href="' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?marker=' . $id . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/map-rss-feed.png"/><br/>' . __('Show embedded map in full-screen mode','lmm') . '</a></p>';
            }
            if (empty($marker)) {
            $lmm_out = '<p>' . $paneltext . '<br/><a href="' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?layer=' . $id . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/map-rss-feed.png"/><br/>' . __('Show embedded map in full-screen mode','lmm') . '</a></p>';
            }
            //return $lmm_out;
        }
    } else {

    //info: check if layer/marker ID exists
    if ($lat == NULL) {
    $error_layer_not_exists = sprintf( esc_attr__('Error: a layer with the ID %1$s does not exist!','lmm'), $layer);
    $error_marker_not_exists = sprintf( esc_attr__('Error: a marker with the ID %1$s does not exist!','lmm'), $marker);
    $lmm_out = '<div id="lmm_error" style="margin:10px 0;">'.PHP_EOL;
        if (empty($layer)) {
            $lmm_out .= $error_marker_not_exists . '<br/>';
        }
        if (empty($marker)) {
            $lmm_out .= $error_layer_not_exists . '<br/>';
        }
    $lmm_out .= '<a href="http://www.mapsmarker.com" target="_blank" title="' . esc_attr__('Go to plugin website','lmm') . '"><img style="border:1px solid #ccc;" src="' . LEAFLET_PLUGIN_URL . 'inc/img/map-deleted-image.png"></a></div>';
    } else {
    //info: starting output on frontend
    $lmm_out = '';
    $lmm_out .= '<div id="lmm_'.$uid.'" style="width:' . $mapwidth.$mapwidthunit . ';" class="mapsmarker">'.PHP_EOL;
    //info: panel for layer/marker name and API URLs
    if ($panel == 1) {
        $lmm_out .= '<div id="lmm_panel_'.$uid.'" class="lmm-panel" style="background: ' . ((!empty($marker)) ? addslashes($lmm_options[ 'defaults_marker_panel_background_color' ]) : (!empty($layer)) ? addslashes($lmm_options[ 'defaults_layer_panel_background_color' ]) : '') . ';">'.PHP_EOL;
        if (!empty($marker))
        {
            $lmm_out .= '<div id="lmm_panel_api_'.$uid.'" class="lmm-panel-api">';
            if ( (isset($lmm_options[ 'defaults_marker_panel_directions' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_directions' ] == 1 ) ) {
                    if ($lmm_options['directions_provider'] == 'googlemaps') {
                        if ( isset($lmm_options['google_maps_base_domain_custom']) && ($lmm_options['google_maps_base_domain_custom'] == NULL) ) { $gmaps_base_domain_directions = $lmm_options['google_maps_base_domain']; } else { $gmaps_base_domain_directions = urlencode($lmm_options['google_maps_base_domain_custom']); }
						if ((isset($lmm_options[ 'directions_googlemaps_route_type_walking' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_walking' ] == 1 )) { $yours_transport_type_icon = 'icon-walk.png'; } else { $yours_transport_type_icon = 'icon-car.png'; }
                        if ( $address != NULL ) { $google_from = urlencode($address); } else { $google_from = $lat . ',' . $lon; }
						$avoidhighways = (isset($lmm_options[ 'directions_googlemaps_route_type_highways' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_highways' ] == 1 ) ? '&dirflg=h' : '';
                        $avoidtolls = (isset($lmm_options[ 'directions_googlemaps_route_type_tolls' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_tolls' ] == 1 ) ? '&dirflg=t' : '';
                        $publictransport = (isset($lmm_options[ 'directions_googlemaps_route_type_public_transport' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_public_transport' ] == 1 ) ? '&dirflg=r' : '';
                        $walking = (isset($lmm_options[ 'directions_googlemaps_route_type_walking' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_walking' ] == 1 ) ? '&dirflg=w' : '';
                        //info: Google language localization (directions)
                        if ($lmm_options['google_maps_language_localization'] == 'browser_setting') {
                            $google_language = '';
                        } else if ($lmm_options['google_maps_language_localization'] == 'wordpress_setting') {
                            if ( defined('WPLANG') ) { $google_language = '&hl=' . substr(WPLANG, 0, 2); } else { $google_language =  '&hl=en'; }
                        } else {
                            $google_language = '&hl=' . $lmm_options['google_maps_language_localization'];
                        }
                        $lmm_out .= '<a href="http://' . $gmaps_base_domain_directions . '/maps?daddr=' . $google_from . '&amp;t=' . $lmm_options[ 'directions_googlemaps_map_type' ] . '&amp;layer=' . $lmm_options[ 'directions_googlemaps_traffic' ] . '&amp;doflg=' . $lmm_options[ 'directions_googlemaps_distance_units' ] . $avoidhighways . $avoidtolls . $publictransport . $walking . $google_language . '&amp;om=' . $lmm_options[ 'directions_googlemaps_overview_map' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img alt="' . esc_attr__('Get directions','lmm') . '" src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
                    } else if ($lmm_options['directions_provider'] == 'yours') {
                        if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'motorcar') { $yours_transport_type_icon = 'icon-car.png'; } else if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'bicycle') { $yours_transport_type_icon = 'icon-bicycle.png'; } else if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'foot') { $yours_transport_type_icon = 'icon-walk.png'; }
                        $lmm_out .= '<a href="http://www.yournavigation.org/?tlat=' . $lat . '&amp;tlon=' . $lon . '&amp;v=' . $lmm_options[ 'directions_yours_type_of_transport' ] . '&amp;fast=' . $lmm_options[ 'directions_yours_route_type' ] . '&amp;layer=' . $lmm_options[ 'directions_yours_layer' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
                    } else if ($lmm_options['directions_provider'] == 'osrm') {
                        $lmm_out .= '<a href="http://map.project-osrm.org/?hl=' . $lmm_options[ 'directions_osrm_language' ] . '&amp;loc=' . $lat . ',' . $lon . '&amp;df=' . $lmm_options[ 'directions_osrm_units' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img alt="' . esc_attr__('Get directions','lmm') . '" src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-car.png" width="14" height="14" class="lmm-panel-api-images" /></a>';
                    } else if ($lmm_options['directions_provider'] == 'ors') {
                        if ($lmm_options[ 'directions_ors_route_preferences' ] == 'Pedestrian') { $yours_transport_type_icon = 'icon-walk.png'; } else if ($lmm_options[ 'directions_ors_route_preferences' ] == 'Bicycle') { $yours_transport_type_icon = 'icon-bicycle.png'; } else { $yours_transport_type_icon = 'icon-car.png'; }
                        $lmm_out .= '<a href="http://openrouteservice.org/index.php?end=' . $lon . ',' . $lat . '&amp;pref=' . $lmm_options[ 'directions_ors_route_preferences' ] . '&amp;lang=' . $lmm_options[ 'directions_ors_language' ] . '&amp;noMotorways=' . $lmm_options[ 'directions_ors_no_motorways' ] . '&amp;noTollways=' . $lmm_options[ 'directions_ors_no_tollways' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
                    }
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_kml' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_kml' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-kml.php?marker=' . $id . '&amp;name=' . $lmm_options[ 'misc_kml' ] . '" style="text-decoration:none;" title="' . esc_attr__('Export as KML for Google Earth/Google Maps','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-kml.png" width="14" height="14" alt="KML-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_fullscreen' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_fullscreen' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?marker=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Open standalone map in fullscreen mode','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-fullscreen.png" width="14" height="14" alt="Fullscreen-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_qr_code' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_qr_code' ] == 1 ) ) {
                $lmm_out .= '<a href="https://chart.googleapis.com/chart?chs=' . $lmm_options[ 'misc_qrcode_size' ] . 'x' . $lmm_options[ 'misc_qrcode_size' ] . '&amp;cht=qr&amp;chl=' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?marker=' . $id . '" target="_blank" title="' . esc_attr__('Create QR code image for standalone map in fullscreen mode','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-qr-code.png" width="14" height="14" alt="QR-code-logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_geojson' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_geojson' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?marker=' . $id . '&amp;callback=jsonp&amp;full=yes" style="text-decoration:none;" title="' . esc_attr__('Export as GeoJSON','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-json.png" width="14" height="14" alt="GeoJSON-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_georss' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_georss' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-georss.php?marker=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Export as GeoRSS','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-georss.png" width="14" height="14" alt="GeoRSS-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_marker_panel_wikitude' ] ) == TRUE ) && ( $lmm_options[ 'defaults_marker_panel_wikitude' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-wikitude.php?marker=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Export as ARML for Wikitude Augmented-Reality browser','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-wikitude.png" width="14" height="14" alt="Wikitude-Logo" class="lmm-panel-api-images" /></a>';
            }
        $lmm_out .= '</div><div id="lmm_panel_text_'.$uid.'" class="lmm-panel-text" style="padding-left:5px;' . addslashes($lmm_options[ 'defaults_marker_panel_paneltext_css' ]) . '">' . stripslashes($paneltext) . '</div>';
        }

        if (!empty($layer) && empty($marker)) //info: check if problems get reported - fix for marker name shown twice when layer+marker map on 1 page
        {
            $lmm_out .= '<div id="lmm_panel_api_'.$uid.'" class="lmm-panel-api">';
            if ( (isset($lmm_options[ 'defaults_layer_panel_kml' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_kml' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-kml.php?layer=' . $id . '&amp;name=' . $lmm_options[ 'misc_kml' ] . '" style="text-decoration:none;" title="' . esc_attr__('Export as KML for Google Earth/Google Maps','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-kml.png" width="14" height="14" alt="KML-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_layer_panel_fullscreen' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_fullscreen' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?layer=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Open standalone map in fullscreen mode','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-fullscreen.png" width="14" height="14" alt="Fullscreen-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_layer_panel_qr_code' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_qr_code' ] == 1 ) ) {
                $lmm_out .= '<a href="https://chart.googleapis.com/chart?chs=' . $lmm_options[ 'misc_qrcode_size' ] . 'x' . $lmm_options[ 'misc_qrcode_size' ] . '&amp;cht=qr&amp;chl=' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?layer=' . $id . '" target="_blank" title="' . esc_attr__('Create QR code image for standalone map in fullscreen mode','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-qr-code.png" width="14" height="14" alt="QR-code-logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_layer_panel_geojson' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_geojson' ] == 1 ) && ($multi_layer_map == 0 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?layer=' . $id . '&amp;callback=jsonp&amp;full=yes" style="text-decoration:none;" title="' . esc_attr__('Export as GeoJSON','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-json.png" width="14" height="14" alt="GeoJSON-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_layer_panel_georss' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_georss' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-georss.php?layer=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Export as GeoRSS','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-georss.png" width="14" height="14" alt="GeoRSS-Logo" class="lmm-panel-api-images" /></a>';
            }
            if ( (isset($lmm_options[ 'defaults_layer_panel_wikitude' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_panel_wikitude' ] == 1 ) ) {
                $lmm_out .= '<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-wikitude.php?layer=' . $id . '" style="text-decoration:none;" title="' . esc_attr__('Export as ARML for Wikitude Augmented-Reality browser','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-wikitude.png" width="14" height="14" alt="Wikitude-Logo" class="lmm-panel-api-images" /></a>';
            }
        $lmm_out .= '</div><div id="lmm_panel_text_'.$uid.'" class="lmm-panel-text" style="padding-left:5px;' . addslashes($lmm_options[ 'defaults_layer_panel_paneltext_css' ]) . '">' . stripslashes($paneltext) . '</div>'.PHP_EOL;
        }
    $lmm_out .= '</div>'.PHP_EOL; //info: <!--end lmm-panel-->
    }
	$admin_error_link = (current_user_can( 'manage_options' )) ? __('click here for troubleshooting','lmm') : '';
    $lmm_out .= '<div id="'.$mapname.'" style="background:#f6f6f6;border:1px solid #ccc;height:'.$mapheight.'px; overflow:hidden;padding:0;"><p style="font-size:80%;color:#9f9e9e;margin-left:5px;">' . __('loading map - please wait...','lmm') . '<br/><small><a href="http://mapsmarker.com/wp_footer" target="_blank" style="text-decoration:none;">' . $admin_error_link . '</a></small><noscript><br/><strong>' . __('Map could not be loaded - please enable Javascript!','lmm') . '</strong><br/><a style="text-decoration:none;" href="http://www.mapsmarker.com/js-disabled" target="_blank">&rarr; ' . __('more information','lmm') . '</a></noscript></p></div>'. PHP_EOL;
    //info: add geo microformats for layer maps
    if (!empty($layer) && empty($marker))
    {
    $table_name_markers = $wpdb->prefix.'leafletmapsmarker_markers';
    $table_name_layers = $wpdb->prefix.'leafletmapsmarker_layers';
    $layer_mark_list_microformats = $wpdb->get_results('SELECT l.id as lid,l.name as lname, m.lon as mlon, m.lat as mlat, m.markername as markername,m.id as markerid FROM '.$table_name_layers.' as l INNER JOIN '.$table_name_markers.' AS m ON l.id=m.layer WHERE l.id='.$layer, ARRAY_A);
        if (count($layer_mark_list_microformats) < 1) {
            $lmm_out .= '<div id="lmm_geo_tags_'.$uid.'" class="lmm-geo-tags geo">' . $paneltext . ': <span class="latitude">' . $lat . '</span>, <span class="longitude">' . $lon . '</span></div>'.PHP_EOL;
        } else {
            foreach ($layer_mark_list_microformats as $row){
                $lmm_out .= '<div id="lmm_geo_tags_'.$uid.'_'.$row['markerid'].'" class="lmm-geo-tags geo">' . htmlspecialchars($row['markername']) . ': <span class="latitude">' . $row['mlat'] . '</span>, <span class="longitude">' . $row['mlon'] . '</span></div>'.PHP_EOL;
            }
        }
    }
    //info: add geo microformats for marker maps
    if (!empty($marker))
    {
    //info: add geo microformats
    $lmm_out .= '<div id="lmm_geo_tags_'.$uid.'" class="lmm-geo-tags geo">'.PHP_EOL;
    $lmm_out .= '<span class="paneltext">' . $paneltext . '</span>'.PHP_EOL;
    $lmm_out .= '<span class="latitude">' . $lat . '</span>, <span class="longitude">' . $lon . '</span>'.PHP_EOL;
    $lmm_out .= '<span class="popuptext">' . strip_tags($popuptext) .'</span>'.PHP_EOL;
    $lmm_out .= '</div>'.PHP_EOL;
    }
    //info: add geo microformats for marker maps added directly via shortcode
    if (empty($layer) && empty($marker))
    {
    //info: add geo microformats
    $lmm_out .= '<div id="lmm_geo_tags_'.$uid.'" class="lmm-geo-tags geo">'.PHP_EOL;
    $lmm_out .= '<span class="latitude">' . $mlat . '</span>, <span class="longitude">' . $mlon . '</span>'.PHP_EOL;
    $lmm_out .= '</div>'.PHP_EOL;
    }
    //info: display a list of markers under the map
    if ( !empty($layer) && empty($marker) && ($listmarkers == 1) )
    {
    //info: sqls for singe and multi-layer-maps
    if ($multi_layer_map == 0) {
        $layer_marker_list = $wpdb->get_results('SELECT l.id as lid, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid, m.createdon as mcreatedon, m.updatedon as mupdatedon, m.address as maddress FROM '.$table_name_layers.' as l INNER JOIN '.$table_name_markers.' AS m ON l.id=m.layer WHERE l.id='.$id.' ORDER BY ' . $lmm_options[ 'defaults_layer_listmarkers_order_by' ] . ' ' . $lmm_options[ 'defaults_layer_listmarkers_sort_order' ] . ' LIMIT ' . intval($lmm_options[ 'defaults_layer_listmarkers_limit' ]), ARRAY_A);
    } else if ($multi_layer_map == 1) {

			//info: set sort order for multi-layer-maps based on list-marker-setting
			if ( $lmm_options['defaults_layer_listmarkers_order_by'] == 'm.id') {
				$sort_order_mlm = 'markerid';
			} else if ( $lmm_options['defaults_layer_listmarkers_order_by'] == 'm.markername') {
				$sort_order_mlm = 'markername';
			} else if ( $lmm_options['defaults_layer_listmarkers_order_by'] == 'm.createdon') {
				$sort_order_mlm = 'mcreatedon';
			} else if ( $lmm_options['defaults_layer_listmarkers_order_by'] == 'm.updatedon') {
				$sort_order_mlm = 'mupdatedon';
			} else if ( $lmm_options['defaults_layer_listmarkers_order_by'] == 'm.layer') {
				$sort_order_mlm = 'mlayer';
			}
		
			if ( (count($multi_layer_map_list_exploded) == 1) && ($multi_layer_map_list != 'all') && ($multi_layer_map_list != NULL) ) { //info: only 1 layer selected
				$mlm_query = "(SELECT l.id as lid,l.name as lname,l.mapwidth as lmapwidth,l.mapheight as lmapheight,l.mapwidthunit as lmapwidthunit,l.layerzoom as llayerzoom,l.layerviewlat as llayerviewlat,l.layerviewlon as llayerviewlon, l.address as laddress, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid,m.mapwidth as mmapwidth,m.mapwidthunit as mmapwidthunit,m.mapheight as mmapheight,m.zoom as mzoom,m.openpopup as mopenpopup, m.basemap as mbasemap, m.controlbox as mcontrolbox, m.createdby as mcreatedby, m.createdon as mcreatedon, m.updatedby as mupdatedby, m.updatedon as mupdatedon, m.address as maddress, m.layer as mlayer FROM " . $table_name_layers . " as l INNER JOIN " . $table_name_markers . " AS m ON l.id=m.layer WHERE l.id='" . $multi_layer_map_list . "' ORDER BY " . $lmm_options[ 'defaults_layer_listmarkers_order_by' ] . " " . $lmm_options[ 'defaults_layer_listmarkers_sort_order' ] . " LIMIT " . intval($lmm_options[ 'defaults_layer_listmarkers_limit' ]) . ")";
				$mlm_query .= " ORDER BY " . $sort_order_mlm . " " . $lmm_options['defaults_layer_listmarkers_sort_order'] . " LIMIT " . $lmm_options['defaults_layer_listmarkers_limit'] . "";
				$layer_marker_list = $wpdb->get_results($mlm_query, ARRAY_A);
			} //info: end (count($multi_layer_map_list_exploded) == 1) && ($multi_layer_map_list != 'all') && ($multi_layer_map_list != NULL)
			else if ( (count($multi_layer_map_list_exploded) > 1 ) && ($multi_layer_map_list != 'all') ) { 
				$first_mlm_id = $multi_layer_map_list_exploded[0];
				$other_mlm_ids = array_slice($multi_layer_map_list_exploded,1); 
				$mlm_query = "(SELECT l.id as lid,l.name as lname,l.mapwidth as lmapwidth,l.mapheight as lmapheight,l.mapwidthunit as lmapwidthunit,l.layerzoom as llayerzoom,l.layerviewlat as llayerviewlat,l.layerviewlon as llayerviewlon, l.address as laddress, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid,m.mapwidth as mmapwidth,m.mapwidthunit as mmapwidthunit,m.mapheight as mmapheight,m.zoom as mzoom,m.openpopup as mopenpopup, m.basemap as mbasemap, m.controlbox as mcontrolbox, m.createdby as mcreatedby, m.createdon as mcreatedon, m.updatedby as mupdatedby, m.updatedon as mupdatedon, m.address as maddress, m.layer as mlayer FROM " . $table_name_layers . " as l INNER JOIN " . $table_name_markers . " AS m ON l.id=m.layer WHERE l.id='" . $first_mlm_id . "')";
				foreach ($other_mlm_ids as $row) {		
					$mlm_query .= " UNION (SELECT l.id as lid,l.name as lname,l.mapwidth as lmapwidth,l.mapheight as lmapheight,l.mapwidthunit as lmapwidthunit,l.layerzoom as llayerzoom,l.layerviewlat as llayerviewlat,l.layerviewlon as llayerviewlon, l.address as laddress, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid,m.mapwidth as mmapwidth,m.mapwidthunit as mmapwidthunit,m.mapheight as mmapheight,m.zoom as mzoom,m.openpopup as mopenpopup, m.basemap as mbasemap, m.controlbox as mcontrolbox, m.createdby as mcreatedby, m.createdon as mcreatedon, m.updatedby as mupdatedby, m.updatedon as mupdatedon, m.address as maddress, m.layer as mlayer FROM " . $table_name_layers . " as l INNER JOIN " . $table_name_markers . " AS m ON l.id=m.layer WHERE l.id='" . $row . "')";
				}
				$mlm_query .= " ORDER BY " . $sort_order_mlm . " " . $lmm_options['defaults_layer_listmarkers_sort_order'] . " LIMIT " . $lmm_options['defaults_layer_listmarkers_limit'] . "";
				$layer_marker_list = $wpdb->get_results($mlm_query, ARRAY_A);
			} //info: end else if ( (count($multi_layer_map_list_exploded) > 1 ) && ($multi_layer_map_list != 'all')
			else if ($multi_layer_map_list == 'all') {
				$first_mlm_id = '0'; 
				$mlm_all_layers = $wpdb->get_results( "SELECT id FROM $table_name_layers", ARRAY_A );
				$other_mlm_ids = array_slice($mlm_all_layers,1);  
				$mlm_query = "(SELECT l.id as lid,l.name as lname,l.mapwidth as lmapwidth,l.mapheight as lmapheight,l.mapwidthunit as lmapwidthunit,l.layerzoom as llayerzoom,l.layerviewlat as llayerviewlat,l.layerviewlon as llayerviewlon, l.address as laddress, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid,m.mapwidth as mmapwidth,m.mapwidthunit as mmapwidthunit,m.mapheight as mmapheight,m.zoom as mzoom,m.openpopup as mopenpopup, m.basemap as mbasemap, m.controlbox as mcontrolbox, m.createdby as mcreatedby, m.createdon as mcreatedon, m.updatedby as mupdatedby, m.updatedon as mupdatedon, m.address as maddress, m.layer as mlayer FROM " . $table_name_layers . " as l INNER JOIN " . $table_name_markers . " AS m ON l.id=m.layer WHERE l.id='" . $first_mlm_id . "')";
				foreach ($other_mlm_ids as $row) {		
					$mlm_query .= " UNION (SELECT l.id as lid,l.name as lname,l.mapwidth as lmapwidth,l.mapheight as lmapheight,l.mapwidthunit as lmapwidthunit,l.layerzoom as llayerzoom,l.layerviewlat as llayerviewlat,l.layerviewlon as llayerviewlon, l.address as laddress, m.lon as mlon, m.lat as mlat, m.icon as micon, m.popuptext as mpopuptext,m.markername as markername,m.id as markerid,m.mapwidth as mmapwidth,m.mapwidthunit as mmapwidthunit,m.mapheight as mmapheight,m.zoom as mzoom,m.openpopup as mopenpopup, m.basemap as mbasemap, m.controlbox as mcontrolbox, m.createdby as mcreatedby, m.createdon as mcreatedon, m.updatedby as mupdatedby, m.updatedon as mupdatedon, m.address as maddress, m.layer as mlayer FROM " . $table_name_layers . " as l INNER JOIN " . $table_name_markers . " AS m ON l.id=m.layer WHERE l.id='" . $row['id'] . "')";
				}
				$mlm_query .= " ORDER BY " . $sort_order_mlm . " " . $lmm_options['defaults_layer_listmarkers_sort_order'] . " LIMIT " . $lmm_options['defaults_layer_listmarkers_limit'] . "";
				$layer_marker_list = $wpdb->get_results($mlm_query, ARRAY_A);
			} //info: end else if ($multi_layer_map_list == 'all')
			else { //info: if ($multi_layer_map == 1) but no layers selected
				$layer_marker_list = array(); 
			}
    } //info: end main - else if ($multi_layer_map == 1)

	//info: set list markers width to be 100% of maps width
	if ($mapwidthunit == '%') {
		$layer_marker_list_width = '100%';
	} else {
		$layer_marker_list_width = $mapwidth.$mapwidthunit;
	}
    $lmm_out .= '<div id="lmm-listmarkers-'.$uid.'" class="lmm-listmarkers" style="width:' . $layer_marker_list_width . ';">'.PHP_EOL;
    $lmm_out .= '<table style="width:' . $layer_marker_list_width . ';" id="lmm-listmarkers-table-'.$uid.'">';
    foreach ($layer_marker_list as $row){
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_show_icon' ]) == TRUE ) && ($lmm_options[ 'defaults_layer_listmarkers_show_icon' ] == 1 ) ) {
            $lmm_out .= '<tr><td style="width:35px;vertical-align:top;text-align:center;' . $lmm_options[ 'defaults_layer_listmarkers_extracss' ] . '">';
            if ($row['micon'] != null) {
                $lmm_out .= '<img style="border-radius:0;box-shadow:none;" alt="marker icon" src="' . LEAFLET_PLUGIN_ICONS_URL . '/'.$row['micon'].'" title="' . stripslashes($row['markername']) . '" />';
            } else {
                $lmm_out .= '<img style="border-radius:0;box-shadow:none;" alt="marker icon" src="' . LEAFLET_PLUGIN_URL . 'leaflet-dist/images/marker.png" title="' . stripslashes($row['markername']) . '" />';
            };
        } else {
            $lmm_out .= '<tr><td style="' . $lmm_options[ 'defaults_layer_listmarkers_extracss' ] . '">';
        };
        $lmm_out .= '</td><td style="' . $lmm_options[ 'defaults_layer_listmarkers_extracss' ] . '"><div class="lmm-listmarkers-panel-icons">';
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_directions' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_directions' ] == 1 ) ) {
            if ($lmm_options['directions_provider'] == 'googlemaps') {
                if ( isset($lmm_options['google_maps_base_domain_custom']) && ($lmm_options['google_maps_base_domain_custom'] == NULL) ) { $gmaps_base_domain_directions = $lmm_options['google_maps_base_domain']; } else { $gmaps_base_domain_directions = urlencode($lmm_options['google_maps_base_domain_custom']); }
				if ((isset($lmm_options[ 'directions_googlemaps_route_type_walking' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_walking' ] == 1 )) { $yours_transport_type_icon = 'icon-walk.png'; } else { $yours_transport_type_icon = 'icon-car.png'; }
                if ( $row['maddress'] != NULL ) { $google_from = urlencode($row['maddress']); } else { $google_from = $row['mlat'] . ',' . $row['mlon']; }
				$avoidhighways = (isset($lmm_options[ 'directions_googlemaps_route_type_highways' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_highways' ] == 1 ) ? '&dirflg=h' : '';
                $avoidtolls = (isset($lmm_options[ 'directions_googlemaps_route_type_tolls' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_tolls' ] == 1 ) ? '&dirflg=t' : '';
                $publictransport = (isset($lmm_options[ 'directions_googlemaps_route_type_public_transport' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_public_transport' ] == 1 ) ? '&dirflg=r' : '';
                $walking = (isset($lmm_options[ 'directions_googlemaps_route_type_walking' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_walking' ] == 1 ) ? '&dirflg=w' : '';
                //info: Google language localization (directions)
                if ($lmm_options['google_maps_language_localization'] == 'browser_setting') {
                    $google_language = '';
                } else if ($lmm_options['google_maps_language_localization'] == 'wordpress_setting') {
                    if ( defined('WPLANG') ) { $google_language = '&hl=' . substr(WPLANG, 0, 2); } else { $google_language =  '&hl=en'; }
                } else {
                    $google_language = '&hl=' . $lmm_options['google_maps_language_localization'];
                }
                $lmm_out .= '<a href="http://' . $gmaps_base_domain_directions . '/maps?daddr=' . $google_from . '&amp;t=' . $lmm_options[ 'directions_googlemaps_map_type' ] . '&amp;layer=' . $lmm_options[ 'directions_googlemaps_traffic' ] . '&amp;doflg=' . $lmm_options[ 'directions_googlemaps_distance_units' ] . $avoidhighways . $avoidtolls . $publictransport . $walking . $google_language . '&amp;om=' . $lmm_options[ 'directions_googlemaps_overview_map' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img alt="' . esc_attr__('Get directions','lmm') . '" src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
            } else if ($lmm_options['directions_provider'] == 'yours') {
                if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'motorcar') { $yours_transport_type_icon = 'icon-car.png'; } else if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'bicycle') { $yours_transport_type_icon = 'icon-bicycle.png'; } else if ($lmm_options[ 'directions_yours_type_of_transport' ] == 'foot') { $yours_transport_type_icon = 'icon-walk.png'; }
                $lmm_out .= '<a href="http://www.yournavigation.org/?tlat=' . $row['mlat'] . '&amp;tlon=' . $row['mlon'] . '&amp;v=' . $lmm_options[ 'directions_yours_type_of_transport' ] . '&amp;fast=' . $lmm_options[ 'directions_yours_route_type' ] . '&amp;layer=' . $lmm_options[ 'directions_yours_layer' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
            } else if ($lmm_options['directions_provider'] == 'osrm') {
                $lmm_out .= '<a href="http://map.project-osrm.org/?hl=' . $lmm_options[ 'directions_osrm_language' ] . '&amp;loc=' . $row['mlat'] . ',' . $row['mlon'] . '&amp;df=' . $lmm_options[ 'directions_osrm_units' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
            } else if ($lmm_options['directions_provider'] == 'ors') {
                if ($lmm_options[ 'directions_ors_route_preferences' ] == 'Pedestrian') { $yours_transport_type_icon = 'icon-walk.png'; } else if ($lmm_options[ 'directions_ors_route_preferences' ] == 'Bicycle') { $yours_transport_type_icon = 'icon-bicycle.png'; } else { $yours_transport_type_icon = 'icon-car.png'; }
                $lmm_out .= '<a href="http://openrouteservice.org/index.php?end=' . $row['mlon'] . ',' . $row['mlat'] . '&amp;pref=' . $lmm_options[ 'directions_ors_route_preferences' ] . '&amp;lang=' . $lmm_options[ 'directions_ors_language' ] . '&amp;noMotorways=' . $lmm_options[ 'directions_ors_no_motorways' ] . '&amp;noTollways=' . $lmm_options[ 'directions_ors_no_tollways' ] . '" target="_blank" title="' . esc_attr__('Get directions','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/' . $yours_transport_type_icon . '" width="14" height="14" class="lmm-panel-api-images" /></a>';
            }
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_fullscreen' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_fullscreen' ] == 1 ) ) {
            $lmm_out .= '&nbsp;<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?marker=' . $row['markerid'] . '" style="text-decoration:none;" title="' . esc_attr__('Open standalone map in fullscreen mode','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-fullscreen.png" width="14" height="14" alt="Fullscreen-Logo" class="lmm-panel-api-images" /></a>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_kml' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_kml' ] == 1 ) ) {
            $lmm_out .= '&nbsp;<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-kml.php?marker=' . $row['markerid'] . '&amp;name=' . $lmm_options[ 'misc_kml' ] . '" style="text-decoration:none;" title="' . esc_attr__('Export as KML for Google Earth/Google Maps','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-kml.png" width="14" height="14" alt="KML-Logo" class="lmm-panel-api-images" /></a>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_qr_code' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_qr_code' ] == 1 ) ) {
            $lmm_out .= '&nbsp;<a href="https://chart.googleapis.com/chart?chs=' . $lmm_options[ 'misc_qrcode_size' ] . 'x' . $lmm_options[ 'misc_qrcode_size' ] . '&amp;cht=qr&chl=' . LEAFLET_PLUGIN_URL . 'leaflet-fullscreen.php?marker=' . $row['markerid'] . '" target="_blank" title="' . esc_attr__('Create QR code image for standalone map in fullscreen mode','lmm') . '"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-qr-code.png" width="14" height="14" alt="QR-code-logo" class="lmm-panel-api-images" /></a>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_geojson' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_geojson' ] == 1 ) && ($multi_layer_map == 0 ) ) {
            $lmm_out .= '&nbsp;<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?marker=' . $row['markerid'] . '&amp;callback=jsonp&amp;full=yes" style="text-decoration:none;" title="' . esc_attr__('Export as GeoJSON','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-json.png" width="14" height="14" alt="GeoJSON-Logo" class="lmm-panel-api-images" /></a>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_georss' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_georss' ] == 1 ) ) {
            $lmm_out .= '&nbsp;<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-georss.php?marker=' . $row['markerid'] . '" style="text-decoration:none;" title="' . esc_attr__('Export as GeoRSS','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-georss.png" width="14" height="14" alt="GeoRSS-Logo" class="lmm-panel-api-images" /></a>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_api_wikitude' ] ) == TRUE ) && ( $lmm_options[ 'defaults_layer_listmarkers_api_wikitude' ] == 1 ) ) {
            $lmm_out .= '&nbsp;<a href="' . LEAFLET_PLUGIN_URL . 'leaflet-wikitude.php?marker=' . $row['markerid'] . '" style="text-decoration:none;" title="' . esc_attr__('Export as ARML for Wikitude Augmented-Reality browser','lmm') . '" target="_blank"><img src="' . LEAFLET_PLUGIN_URL . 'inc/img/icon-wikitude.png" width="14" height="14" alt="Wikitude-Logo" class="lmm-panel-api-images" /></a>';
        }
        $lmm_out .= '</div>';
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_show_markername' ]) == TRUE ) && ($lmm_options[ 'defaults_layer_listmarkers_show_markername' ] == 1 ) ) {
            $lmm_out .= '<strong>' . stripslashes(htmlspecialchars($row['markername'])) . '</strong>';
        }
        if ( (isset($lmm_options[ 'defaults_layer_listmarkers_show_popuptext' ]) == TRUE ) && ($lmm_options[ 'defaults_layer_listmarkers_show_popuptext' ] == 1 ) ) {
            $lmm_out .= '<br/>' . nl2br(stripslashes($row['mpopuptext']));
        }
		if ( (isset($lmm_options[ 'defaults_layer_listmarkers_show_address' ]) == TRUE ) && ($lmm_options[ 'defaults_layer_listmarkers_show_address' ] == 1 ) ) {
			if ( $row['mpopuptext'] == NULL ) {
				$lmm_out .= stripslashes(htmlspecialchars($row['maddress']));
			} else if ( ($row['mpopuptext'] != NULL) && ($row['maddress'] != NULL) ) {
				$lmm_out .= '<br/><div style="border-top:1px solid #f0f0e7;padding-top:5px;margin-top:5px;">' . stripslashes(htmlspecialchars($row['maddress'])) . '</div>';
			}
		}
        $lmm_out .= '</td></tr>';
    } //info: end foreach

   //info: adding info if more markers are available than listed in markers list
   $markercount = 0;
   if ($multi_layer_map == 0) {
	    $markercount = $wpdb->get_var('SELECT count(*) FROM '.$table_name_layers.' as l INNER JOIN '.$table_name_markers.' AS m ON l.id=m.layer WHERE l.id='.$id);
   } else if ( ($multi_layer_map == 1) && ( $multi_layer_map_list == 'all' ) ) {
		$markercount = intval($wpdb->get_var('SELECT COUNT(*) FROM '.$table_name_markers));
   } else if ( ($multi_layer_map == 1) && ( $multi_layer_map_list != NULL ) && ($multi_layer_map_list != 'all') ) {
		foreach ($multi_layer_map_list_exploded as $mlmrowcount){
		$mlm_count_temp{$mlmrowcount} = $wpdb->get_var('SELECT count(*) FROM '.$table_name_layers.' as l INNER JOIN '.$table_name_markers.' AS m ON l.id=m.layer WHERE l.id='.$mlmrowcount);
		}
		$markercount = array_sum($mlm_count_temp); 
   } else if ( ($multi_layer_map == 1) && ( $multi_layer_map_list == NULL ) ) {
		$markercount = 0;
   }
   if ($markercount > $lmm_options[ 'defaults_layer_listmarkers_limit' ]) {
	$asc_desc = ($lmm_options['defaults_layer_listmarkers_sort_order'] == 'ASC') ? __('ascending','lmm') : __('descending','lmm');
	if ($lmm_options['defaults_layer_listmarkers_order_by'] == 'm.id') {
		$orderby = 'ID';
	} else if ($lmm_options['defaults_layer_listmarkers_order_by'] == 'm.markername') {
		$orderby = __('marker name','lmm');
	} else if ($lmm_options['defaults_layer_listmarkers_order_by'] == 'm.createdon') {
		$orderby = __('created on','lmm');
	} else if ($lmm_options['defaults_layer_listmarkers_order_by'] == 'm.updatedon') {
		$orderby = __('updated on','lmm');
	} else if ($lmm_options['defaults_layer_listmarkers_order_by'] == 'm.layer') {
		$orderby = __('layer ID','lmm');
	}
	$lmm_out .= '<tr><td colspan="2" style="text-align:center">' . sprintf(__('The table above is listing %1s out of %2s markers (sorted by %3s %4s)','lmm'), $lmm_options[ 'defaults_layer_listmarkers_limit' ], $markercount, $orderby, $asc_desc) . '</td></tr>';
    }
    $lmm_out .= '</table></div>';
    } //info: end display a list of markers under the map
	
	//info: fallback for adding js to footer 1
	if ( (version_compare( $wp_version, '3.3', '>=' )) && ($lmm_options['misc_javascript_header_footer'] == 'footer')) {
	    $lmm_out .= '</div>'; //info: end leaflet_maps_marker_$uid
		global $lmmjs_out; //info: dont add to WP<3.3 as js gets duplicated!
	//info: fallback for adding js to footer 2
	} else if ( (version_compare( $wp_version, '3.3', '<' )) || ((version_compare( $wp_version, '3.3', '>=' )) && ($lmm_options['misc_javascript_header_footer'] == 'header')) ) {
		$lmmjs_out = '<script type="text/javascript">'.PHP_EOL;
 	}
    $plugin_version = get_option('leafletmapsmarker_version');

    //info: start workaround for incompatibility with jetpack plugin
    $lmmjs_out .= "if ( document.getElementById('lmm_".$uid."') != undefined ) {".PHP_EOL; 
    $lmmjs_out .= '/* Maps created with MapsMarker.com WordPress plugin - version '.$plugin_version.' */'.PHP_EOL;

	//info: support for responsive templates
    if ( ($mapwidthunit != '%') && ($lmm_options['misc_responsive_support'] == 'enabled') ) {
		$lmmjs_out .= "jQuery(document).ready( function($) {
				function resizeMap() {
					var map = $('#lmm_".$uid."');
					";
					if ($listmarkers == 1) {
						$lmmjs_out .= "var map_list_markers_div = $('#lmm-listmarkers-".$uid."');".PHP_EOL;
						$lmmjs_out .= "\t\t\t\t\t" . "var map_list_markers_table = $('#lmm-listmarkers-table-".$uid."');".PHP_EOL;
					}
					$lmmjs_out .= "\t\t\t\t\t" . "var map_parent_size = $('#lmm_".$uid."').parent().width();
					if( map_parent_size < ".$mapwidth." ) {
						map.css({ 'width': '100%'});".PHP_EOL;
						if ($listmarkers == 1) {
							$lmmjs_out .= "\t\t\t\t\t\t" . "map_list_markers_div.css({ 'width': '100%'});".PHP_EOL;
							$lmmjs_out .= "\t\t\t\t\t\t" . "map_list_markers_table.css({ 'width': '100%'});".PHP_EOL;
						}
					$lmmjs_out .= "\t\t\t\t\t\t" . $mapname.".invalidateSize();
					}";
		$lmmjs_out .= "
				}
				resizeMap();".PHP_EOL;
		if ($lmm_options['misc_map_osm_editlink'] == 'show') {
				$lmmjs_out .= "
				$(window).resize(resizeMap);
				function appendeditlink() {
					var boundingbox = ".$mapname.".getBounds().toBBoxString();
					var editlink = ' (<a href=\"http://www.openstreetmap.org/edit?editor=potlatch2&bbox='+boundingbox+'\" target=\"_blank\" title=\"" . esc_attr__('help OpenStreetMap.org to improve map details','lmm') . "\">" . __('edit','lmm') . "</a>)';
					$('#editlink_" . $uid . "').append(editlink);	
				}
				appendeditlink();".PHP_EOL;
		}
		$lmmjs_out .= "});".PHP_EOL;
	}

    $lmmjs_out .= 'var layers = {};'.PHP_EOL;
    $lmmjs_out .= 'var markers = {};'.PHP_EOL;
    $lmmjs_out .= 'var lmm_map_'.$uid.' = {};'.PHP_EOL;
    //info: define attribution links as variables to allow dynamic change through layer control box
    $attrib_prefix = '<a href=\"http://mapsmarker.com/go\" target=\"_blank\" title=\"powered by \'Leaflet Maps Marker\'-Plugin for WordPress\">MapsMarker.com</a> (<a href=\"http://www.leafletjs.com\" target=\"_blank\" title=\"\'Leaflet Maps Marker\' uses the JavaScript library \'Leaflet\' for interactive maps by CloudMade\">Leaflet</a>, <a href=\"http://mapicons.nicolasmollet.com\" target=\"_blank\" title=\"\'Leaflet Maps Marker\' uses icons from the \'Maps Icons Collection\'\">Icons</a>)';
    $attrib_osm_mapnik = __("Map",'lmm').': &copy; ' . date("Y") . ' <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap contributors</a>, <a id=\"editlink_'.$uid.'\" href=\"http://creativecommons.org/licenses/by-sa/2.0/\" target=\"_blank\">CC-BY-SA</a>';
    $attrib_mapquest_osm = __("Map",'lmm').': Tiles Courtesy of <a href=\"http://www.mapquest.com/\" target=\"_blank\">MapQuest</a> <img src=\"' . LEAFLET_PLUGIN_URL . 'inc/img/logo-mapquest.png\" style=\"display:inline;\" /> - <a href=\"http://www.openstreetmap.org\" target=\"_blank\">OpenStreetMap</a>, <a id=\"editlink_'.$uid.'\" href=\"http://creativecommons.org/licenses/by-sa/2.0/\" target=\"_blank\">CC-BY-SA</a>';
    $attrib_mapquest_aerial = __("Map",'lmm').': <a href=\"http://www.mapquest.com/\" target=\"_blank\">MapQuest</a> <img src=\"' . LEAFLET_PLUGIN_URL . 'inc/img/logo-mapquest.png\" style=\"display:inline;\" />, Portions Courtesy NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency';
    $attrib_ogdwien_basemap = __("Map",'lmm').': ' . __("City of Vienna","lmm") . ' (<a href=\"http://data.wien.gv.at\" target=\"_blank\" style=\"\">data.wien.gv.at</a>)';
    $attrib_ogdwien_satellite = __("Map",'lmm').': ' . __("City of Vienna","lmm") . ' (<a href=\"http://data.wien.gv.at\" target=\"_blank\">data.wien.gv.at</a>)';
    $attrib_cloudmade = __("Map",'lmm').': &copy; ' . date("Y") . ' <a href=\"http://www.openstreetmap.org\" target=\"_blank\" style=\"\">OpenStreetMap contributors</a>, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\" target=\"_blank\">CC-BY-SA</a>, Imagery &copy; <a href=\"http://cloudmade.com\" target=\"_blank\">CloudMade</a>';
    $attrib_custom_basemap = __("Map",'lmm').': ' . addslashes($lmm_options[ 'custom_basemap_attribution' ]);
    $attrib_custom_basemap2 = __("Map",'lmm').': ' . addslashes($lmm_options[ 'custom_basemap2_attribution' ]);
    $attrib_custom_basemap3 = __("Map",'lmm').': ' . addslashes($lmm_options[ 'custom_basemap3_attribution' ]);
    $lmmjs_out .= '(function($) {'.PHP_EOL;
    $lmmjs_out .= $mapname.' = new L.Map("'.$mapname.'", { dragging: ' . $lmm_options['misc_map_dragging'] . ', touchZoom: ' . $lmm_options['misc_map_touchzoom'] . ', scrollWheelZoom: ' . $lmm_options['misc_map_scrollwheelzoom'] . ', doubleClickZoom: ' . $lmm_options['misc_map_doubleclickzoom'] . ', boxzoom: ' . $lmm_options['map_interaction_options_boxzoom'] . ', trackResize: ' . $lmm_options['misc_map_trackresize'] . ', worldCopyJump: ' . $lmm_options['map_interaction_options_worldcopyjump'] . ', closePopupOnClick: ' . $lmm_options['misc_map_closepopuponclick'] . ', keyboard: ' . $lmm_options['map_keyboard_navigation_options_keyboard'] . ', keyboardPanOffset: ' . intval($lmm_options['map_keyboard_navigation_options_keyboardpanoffset']) . ', keyboardZoomOffset: ' . intval($lmm_options['map_keyboard_navigation_options_keyboardzoomoffset']) . ', inertia: ' . $lmm_options['map_panning_inertia_options_inertia'] . ', inertiaDeceleration: ' . intval($lmm_options['map_panning_inertia_options_inertiadeceleration']) . ', inertiaMaxSpeed: ' . intval($lmm_options['map_panning_inertia_options_inertiamaxspeed']) . ', zoomControl: ' . $lmm_options['misc_map_zoomcontrol'] . ', crs: ' . $lmm_options['misc_projections'] . ' });'.PHP_EOL;
    $lmmjs_out .= $mapname.'.attributionControl.setPrefix("' . $attrib_prefix . '");'.PHP_EOL;
    //info: define basemaps
    $lmmjs_out .= 'var osm_mapnik = new L.TileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {maxZoom: 18, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_osm_mapnik . '", detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var mapquest_osm = new L.TileLayer("http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {maxZoom: 18, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_mapquest_osm . '", subdomains: ["otile1","otile2","otile3","otile4"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var mapquest_aerial = new L.TileLayer("http://{s}.mqcdn.com/naip/{z}/{x}/{y}.png", {maxZoom: 18, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_mapquest_aerial . '", subdomains: ["oatile1","oatile2","oatile3","oatile4"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var googleLayer_roadmap = new L.Google("ROADMAP", {detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var googleLayer_satellite = new L.Google("SATELLITE", {detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var googleLayer_hybrid = new L.Google("HYBRID", {detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var googleLayer_terrain = new L.Google("TERRAIN", {detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    if ( isset($lmm_options['bingmaps_api_key']) && ($lmm_options['bingmaps_api_key'] != NULL ) ) {
        $lmmjs_out .= 'var bingaerial = new L.BingLayer("' . $lmm_options[ 'bingmaps_api_key' ] . '", {type: "Aerial", maxZoom: 21, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
        $lmmjs_out .= 'var bingaerialwithlabels = new L.BingLayer("' . $lmm_options[ 'bingmaps_api_key' ] . '", {type: "AerialWithLabels", maxZoom: 21, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
        $lmmjs_out .= 'var bingroad = new L.BingLayer("' . $lmm_options[ 'bingmaps_api_key' ] . '", {type: "Road", maxZoom: 21, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    };
    $lmmjs_out .= 'var ogdwien_basemap = new L.TileLayer("http://{s}.wien.gv.at/wmts/fmzk/pastell/google3857/{z}/{y}/{x}.jpeg", {maxZoom: 19, minZoom: 11, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_ogdwien_basemap . '", subdomains: ["maps","maps1", "maps2", "maps3"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var ogdwien_satellite = new L.TileLayer("http://{s}.wien.gv.at/wmts/lb/farbe/google3857/{z}/{y}/{x}.jpeg", {maxZoom: 19, minZoom: 11, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_ogdwien_satellite . '", subdomains: ["maps","maps1", "maps2", "maps3"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    //info: create Cloudmade TileURLs
    $cloudmade_double_resolution = ($lmm_options[ 'cloudmade_double_resolution' ] == 'enabled') ? "@2x" : "";
    $cloudmade2_double_resolution = ($lmm_options[ 'cloudmade2_double_resolution' ] == 'enabled') ? "@2x" : "";
    $cloudmade3_double_resolution = ($lmm_options[ 'cloudmade3_double_resolution' ] == 'enabled') ? "@2x" : "";
    $cloudmade_tileurl = "http://{s}.tile.cloudmade.com/" . $lmm_options[ 'cloudmade_api_key' ] . "/" . $lmm_options[ 'cloudmade_styleid' ] . $cloudmade_double_resolution . "/256/{z}/{x}/{y}.png";
    $cloudmade2_tileurl = "http://{s}.tile.cloudmade.com/" . $lmm_options[ 'cloudmade2_api_key' ] . "/" . $lmm_options[ 'cloudmade2_styleid' ] . $cloudmade2_double_resolution . "/256/{z}/{x}/{y}.png";
    $cloudmade3_tileurl = "http://{s}.tile.cloudmade.com/" . $lmm_options[ 'cloudmade3_api_key' ] . "/" . $lmm_options[ 'cloudmade3_styleid' ] . $cloudmade3_double_resolution . "/256/{z}/{x}/{y}.png";
    $lmmjs_out .= 'var cloudmade = new L.TileLayer("' . $cloudmade_tileurl . '", {maxZoom: 19, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_cloudmade . '", subdomains: ["a","b","c"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var cloudmade2 = new L.TileLayer("' . $cloudmade2_tileurl . '", {maxZoom: 19, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_cloudmade . '", subdomains: ["a","b","c"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var cloudmade3 = new L.TileLayer("' . $cloudmade3_tileurl . '", {maxZoom: 19, minZoom: 1, errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . $attrib_cloudmade . '", subdomains: ["a","b","c"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    //info: MapBox basemaps
    $lmmjs_out .= 'var mapbox = new L.TileLayer("http://{s}.tiles.mapbox.com/v3/' . $lmm_options[ 'mapbox_user' ] . '.' . $lmm_options[ 'mapbox_map' ] . '/{z}/{x}/{y}.png", {minZoom: ' . intval($lmm_options[ 'mapbox_minzoom' ]) . ', maxZoom: ' . intval($lmm_options[ 'mapbox_maxzoom' ]) . ', errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . addslashes($lmm_options[ 'mapbox_attribution' ]) . '", subdomains: ["a","b","c","d"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var mapbox2 = new L.TileLayer("http://{s}.tiles.mapbox.com/v3/' . $lmm_options[ 'mapbox2_user' ] . '.' . $lmm_options[ 'mapbox2_map' ] . '/{z}/{x}/{y}.png", {minZoom: ' . intval($lmm_options[ 'mapbox2_minzoom' ]) . ', maxZoom: ' . intval($lmm_options[ 'mapbox2_maxzoom' ]) . ', errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . addslashes($lmm_options[ 'mapbox2_attribution' ]) . '", subdomains: ["a","b","c","d"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var mapbox3 = new L.TileLayer("http://{s}.tiles.mapbox.com/v3/' . $lmm_options[ 'mapbox3_user' ] . '.' . $lmm_options[ 'mapbox3_map' ] . '/{z}/{x}/{y}.png", {minZoom: ' . intval($lmm_options[ 'mapbox3_minzoom' ]) . ', maxZoom: ' . intval($lmm_options[ 'mapbox3_maxzoom' ]) . ', errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", attribution: "' . addslashes($lmm_options[ 'mapbox3_attribution' ]) . '", subdomains: ["a","b","c","d"], detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    //info: check if subdomains are set for custom basemaps
    $custom_basemap_subdomains = ((isset($lmm_options[ 'custom_basemap_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'custom_basemap_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'custom_basemap_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $custom_basemap2_subdomains = ((isset($lmm_options[ 'custom_basemap2_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'custom_basemap2_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'custom_basemap2_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $custom_basemap3_subdomains = ((isset($lmm_options[ 'custom_basemap3_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'custom_basemap3_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'custom_basemap3_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    //info: define custom basemaps
    $error_tile_url_custom_basemap = ($lmm_options['custom_basemap_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $error_tile_url_custom_basemap2 = ($lmm_options['custom_basemap2_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $error_tile_url_custom_basemap3 = ($lmm_options['custom_basemap3_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $lmmjs_out .= 'var custom_basemap = new L.TileLayer("' . $lmm_options[ 'custom_basemap_tileurl' ] . '", {maxZoom: ' . intval($lmm_options[ 'custom_basemap_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'custom_basemap_minzoom' ]) . ', tms: ' . $lmm_options[ 'custom_basemap_tms' ] . ', ' . $error_tile_url_custom_basemap . 'attribution: "' . $attrib_custom_basemap . '"' . $custom_basemap_subdomains . ', continuousWorld: ' . $lmm_options[ 'custom_basemap_continuousworld_enabled' ] . ', noWrap: ' . $lmm_options[ 'custom_basemap_nowrap_enabled' ] . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var custom_basemap2 = new L.TileLayer("' . $lmm_options[ 'custom_basemap2_tileurl' ] . '", {maxZoom: ' . intval($lmm_options[ 'custom_basemap2_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'custom_basemap2_minzoom' ]) . ', tms: ' . $lmm_options[ 'custom_basemap2_tms' ] . ', ' . $error_tile_url_custom_basemap2 . 'attribution: "' . $attrib_custom_basemap2 . '"' . $custom_basemap2_subdomains . ', continuousWorld: ' . $lmm_options[ 'custom_basemap2_continuousworld_enabled' ] . ', noWrap: ' . $lmm_options[ 'custom_basemap2_nowrap_enabled' ] . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var custom_basemap3 = new L.TileLayer("' . $lmm_options[ 'custom_basemap3_tileurl' ] . '", {maxZoom: ' . intval($lmm_options[ 'custom_basemap3_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'custom_basemap3_minzoom' ]) . ', tms: ' . $lmm_options[ 'custom_basemap3_tms' ] . ', ' . $error_tile_url_custom_basemap3 . 'attribution: "' . $attrib_custom_basemap3 . '"' . $custom_basemap3_subdomains . ', continuousWorld: ' . $lmm_options[ 'custom_basemap3_continuousworld_enabled' ] . ', noWrap: ' . $lmm_options[ 'custom_basemap3_nowrap_enabled' ] . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
	$lmmjs_out .= 'var empty_basemap = new L.TileLayer("");'.PHP_EOL;

    //info: check if subdomains are set for custom overlays
    $overlays_custom_subdomains = ((isset($lmm_options[ 'overlays_custom_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'overlays_custom_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'overlays_custom_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $overlays_custom2_subdomains = ((isset($lmm_options[ 'overlays_custom2_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'overlays_custom2_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'overlays_custom2_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $overlays_custom3_subdomains = ((isset($lmm_options[ 'overlays_custom3_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'overlays_custom3_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'overlays_custom3_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $overlays_custom4_subdomains = ((isset($lmm_options[ 'overlays_custom4_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'overlays_custom4_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'overlays_custom4_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $error_tile_url_overlays_custom = ($lmm_options['overlays_custom_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $error_tile_url_overlays_custom2 = ($lmm_options['overlays_custom2_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $error_tile_url_overlays_custom3 = ($lmm_options['overlays_custom3_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';
    $error_tile_url_overlays_custom4 = ($lmm_options['overlays_custom4_errortileurl'] == 'true') ? 'errorTileUrl: "' . LEAFLET_PLUGIN_URL . 'inc/img/error-tile-image.png", ' : '';

    //info: define overlays
    $lmmjs_out .= 'var overlays_custom = new L.TileLayer("' . $lmm_options[ 'overlays_custom_tileurl' ] . '", {tms: ' . $lmm_options[ 'overlays_custom_tms' ] . ', ' . $error_tile_url_overlays_custom . 'attribution: "' . addslashes($lmm_options[ 'overlays_custom_attribution' ]) . '", opacity: ' . floatval($lmm_options[ 'overlays_custom_opacity' ]) . ', maxZoom: ' . intval($lmm_options[ 'overlays_custom_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'overlays_custom_minzoom' ]) . $overlays_custom_subdomains . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var overlays_custom2 = new L.TileLayer("' . $lmm_options[ 'overlays_custom2_tileurl' ] . '", {tms: ' . $lmm_options[ 'overlays_custom2_tms' ] . ', ' . $error_tile_url_overlays_custom2 . 'attribution: "' . addslashes($lmm_options[ 'overlays_custom2_attribution' ]) . '", opacity: ' . floatval($lmm_options[ 'overlays_custom2_opacity' ]) . ', maxZoom: ' . intval($lmm_options[ 'overlays_custom2_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'overlays_custom2_minzoom' ]) . $overlays_custom2_subdomains . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var overlays_custom3 = new L.TileLayer("' . $lmm_options[ 'overlays_custom3_tileurl' ] . '", {tms: ' . $lmm_options[ 'overlays_custom3_tms' ] . ', ' . $error_tile_url_overlays_custom3 . 'attribution: "' . addslashes($lmm_options[ 'overlays_custom3_attribution' ]) . '", opacity: ' . floatval($lmm_options[ 'overlays_custom3_opacity' ]) . ', maxZoom: ' . intval($lmm_options[ 'overlays_custom3_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'overlays_custom3_minzoom' ]) . $overlays_custom3_subdomains . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    $lmmjs_out .= 'var overlays_custom4 = new L.TileLayer("' . $lmm_options[ 'overlays_custom4_tileurl' ] . '", {tms: ' . $lmm_options[ 'overlays_custom4_tms' ] . ', ' . $error_tile_url_overlays_custom4 . 'attribution: "' . addslashes($lmm_options[ 'overlays_custom4_attribution' ]) . '", opacity: ' . floatval($lmm_options[ 'overlays_custom4_opacity' ]) . ', maxZoom: ' . intval($lmm_options[ 'overlays_custom4_maxzoom' ]) . ', minZoom: ' . intval($lmm_options[ 'overlays_custom4_minzoom' ]) . $overlays_custom_subdomains . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;

    //info: check if subdomains are set for wms layers
    $wms_subdomains = ((isset($lmm_options[ 'wms_wms_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms2_subdomains = ((isset($lmm_options[ 'wms_wms2_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms2_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms2_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms3_subdomains = ((isset($lmm_options[ 'wms_wms3_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms3_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms3_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms4_subdomains = ((isset($lmm_options[ 'wms_wms4_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms4_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms4_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms5_subdomains = ((isset($lmm_options[ 'wms_wms5_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms5_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms5_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms6_subdomains = ((isset($lmm_options[ 'wms_wms6_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms6_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms6_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms7_subdomains = ((isset($lmm_options[ 'wms_wms7_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms7_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms7_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms8_subdomains = ((isset($lmm_options[ 'wms_wms8_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms8_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms8_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms9_subdomains = ((isset($lmm_options[ 'wms_wms9_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms9_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms9_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    $wms10_subdomains = ((isset($lmm_options[ 'wms_wms10_subdomains_enabled' ]) == TRUE ) && ($lmm_options[ 'wms_wms10_subdomains_enabled' ] == 'yes' )) ? ", subdomains: [" . htmlspecialchars_decode($lmm_options[ 'wms_wms10_subdomains_names' ], ENT_QUOTES) . "]" :  "";
    //info: define wms legends
    $wms_attribution = addslashes($lmm_options[ 'wms_wms_attribution' ]) . ( ($lmm_options[ 'wms_wms_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms2_attribution = addslashes($lmm_options[ 'wms_wms2_attribution' ]) . ( ($lmm_options[ 'wms_wms2_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms2_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms3_attribution = addslashes($lmm_options[ 'wms_wms3_attribution' ]) . ( ($lmm_options[ 'wms_wms3_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms3_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms4_attribution = addslashes($lmm_options[ 'wms_wms4_attribution' ]) . ( ($lmm_options[ 'wms_wms4_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms4_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms5_attribution = addslashes($lmm_options[ 'wms_wms5_attribution' ]) . ( ($lmm_options[ 'wms_wms5_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms5_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms6_attribution = addslashes($lmm_options[ 'wms_wms6_attribution' ]) . ( ($lmm_options[ 'wms_wms6_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms6_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms7_attribution = addslashes($lmm_options[ 'wms_wms7_attribution' ]) . ( ($lmm_options[ 'wms_wms7_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms7_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms8_attribution = addslashes($lmm_options[ 'wms_wms8_attribution' ]) . ( ($lmm_options[ 'wms_wms8_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms8_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms9_attribution = addslashes($lmm_options[ 'wms_wms9_attribution' ]) . ( ($lmm_options[ 'wms_wms9_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms9_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    $wms10_attribution = addslashes($lmm_options[ 'wms_wms10_attribution' ]) . ( ($lmm_options[ 'wms_wms10_legend_enabled' ] == 'yes' ) ? " (<a href=" . $lmm_options[ 'wms_wms10_legend' ] . " target='_blank'>" . __('Legend','lmm') . "</a>)" : '') .'';
    //info: define wms layers
    if ($wms == 1) {
    $lmmjs_out .= 'var wms = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms_baseurl' ] . '", {wmsid: "wms", layers: "' . addslashes($lmm_options[ 'wms_wms_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms_format' ]) . '", attribution: "' . $wms_attribution . '", transparent: "' . $lmm_options[ 'wms_wms_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms_version' ]) . '"' . $wms_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms2 == 1) {
    $lmmjs_out .= 'var wms2 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms2_baseurl' ] . '", {wmsid: "wms2", layers: "' . addslashes($lmm_options[ 'wms_wms2_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms2_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms2_format' ]) . '", attribution: "' . $wms2_attribution . '", transparent: "' . $lmm_options[ 'wms_wms2_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms2_version' ]) . '"' . $wms2_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms3 == 1) {
    $lmmjs_out .= 'var wms3 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms3_baseurl' ] . '", {wmsid: "wms3", layers: "' . addslashes($lmm_options[ 'wms_wms3_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms3_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms3_format' ]) . '", attribution: "' . $wms3_attribution . '", transparent: "' . $lmm_options[ 'wms_wms3_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms3_version' ]) . '"' . $wms3_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms4 == 1) {
    $lmmjs_out .= 'var wms4 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms4_baseurl' ] . '", {wmsid: "wms4", layers: "' . addslashes($lmm_options[ 'wms_wms4_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms4_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms4_format' ]) . '", attribution: "' . $wms4_attribution . '", transparent: "' . $lmm_options[ 'wms_wms4_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms4_version' ]) . '"' . $wms4_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms5 == 1) {
    $lmmjs_out .= 'var wms5 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms5_baseurl' ] . '", {wmsid: "wms5", layers: "' . addslashes($lmm_options[ 'wms_wms5_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms5_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms5_format' ]) . '", attribution: "' . $wms5_attribution . '", transparent: "' . $lmm_options[ 'wms_wms5_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms5_version' ]) . '"' . $wms5_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms6 == 1) {
    $lmmjs_out .= 'var wms6 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms6_baseurl' ] . '", {wmsid: "wms6", layers: "' . addslashes($lmm_options[ 'wms_wms6_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms6_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms6_format' ]) . '", attribution: "' . $wms6_attribution . '", transparent: "' . $lmm_options[ 'wms_wms6_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms6_version' ]) . '"' . $wms6_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms7 == 1) {
    $lmmjs_out .= 'var wms7 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms7_baseurl' ] . '", {wmsid: "wms7", layers: "' . addslashes($lmm_options[ 'wms_wms7_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms7_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms7_format' ]) . '", attribution: "' . $wms7_attribution . '", transparent: "' . $lmm_options[ 'wms_wms7_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms7_version' ]) . '"' . $wms7_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms8 == 1) {
    $lmmjs_out .= 'var wms8 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms8_baseurl' ] . '", {wmsid: "wms8", layers: "' . addslashes($lmm_options[ 'wms_wms8_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms8_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms8_format' ]) . '", attribution: "' . $wms8_attribution . '", transparent: "' . $lmm_options[ 'wms_wms8_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms8_version' ]) . '"' . $wms8_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms9 == 1) {
    $lmmjs_out .= 'var wms9 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms9_baseurl' ] . '", {wmsid: "wms9", layers: "' . addslashes($lmm_options[ 'wms_wms9_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms9_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms9_format' ]) . '", attribution: "' . $wms9_attribution . '", transparent: "' . $lmm_options[ 'wms_wms9_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms9_version' ]) . '"' . $wms9_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    if ($wms10 == 1) {
    $lmmjs_out .= 'var wms10 = new L.TileLayer.WMS("' . $lmm_options[ 'wms_wms10_baseurl' ] . '", {wmsid: "wms10", layers: "' . addslashes($lmm_options[ 'wms_wms10_layers' ]) . '", styles: "' . addslashes($lmm_options[ 'wms_wms10_styles' ]) . '", format: "' . addslashes($lmm_options[ 'wms_wms10_format' ]) . '", attribution: "' . $wms10_attribution . '", transparent: "' . $lmm_options[ 'wms_wms10_transparent' ] . '", errorTileUrl: "' . LEAFLET_PLUGIN_URL  . 'inc/img/error-tile-image.png", version: "' . addslashes($lmm_options[ 'wms_wms10_version' ]) . '"' . $wms10_subdomains  . ', detectRetina: ' . $lmm_options['map_retina_detection'] . '});'.PHP_EOL;
    }
    //info: controlbox - basemaps
    $lmmjs_out .= 'var layersControl = new L.Control.Layers('.PHP_EOL;
    $lmmjs_out .= '{';
    $basemaps_available = '';
    if ( (isset($lmm_options[ 'controlbox_osm_mapnik' ]) == TRUE ) && ($lmm_options[ 'controlbox_osm_mapnik' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_osm_mapnik' ]) . "': osm_mapnik,";
    if ( (isset($lmm_options[ 'controlbox_mapquest_osm' ]) == TRUE ) && ($lmm_options[ 'controlbox_mapquest_osm' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_mapquest_osm' ]) . "': mapquest_osm,";
    if ( (isset($lmm_options[ 'controlbox_mapquest_aerial' ]) == TRUE ) && ($lmm_options[ 'controlbox_mapquest_aerial' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_mapquest_aerial' ]) . "': mapquest_aerial,";
    if ( (isset($lmm_options[ 'controlbox_googleLayer_roadmap' ]) == TRUE ) && ($lmm_options[ 'controlbox_googleLayer_roadmap' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_googleLayer_roadmap' ]) . "': googleLayer_roadmap,";
    if ( (isset($lmm_options[ 'controlbox_googleLayer_satellite' ]) == TRUE ) && ($lmm_options[ 'controlbox_googleLayer_satellite' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_googleLayer_satellite' ]) . "': googleLayer_satellite,";
    if ( (isset($lmm_options[ 'controlbox_googleLayer_hybrid' ]) == TRUE ) && ($lmm_options[ 'controlbox_googleLayer_hybrid' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_googleLayer_hybrid' ]) . "': googleLayer_hybrid,";
    if ( (isset($lmm_options[ 'controlbox_googleLayer_terrain' ]) == TRUE ) && ($lmm_options[ 'controlbox_googleLayer_terrain' ] == 1 ) )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_googleLayer_terrain' ]) . "': googleLayer_terrain,";
    if ( isset($lmm_options['bingmaps_api_key']) && ($lmm_options['bingmaps_api_key'] != NULL ) ) {
        if ( (isset($lmm_options[ 'controlbox_bingaerial' ]) == TRUE ) && ($lmm_options[ 'controlbox_bingaerial' ] == 1 ) )
            $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_bingaerial' ]) . "': bingaerial,";
        if ( (isset($lmm_options[ 'controlbox_bingaerialwithlabels' ]) == TRUE ) && ($lmm_options[ 'controlbox_bingaerialwithlabels' ] == 1 ) )
            $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_bingaerialwithlabels' ]) . "': bingaerialwithlabels,";
        if ( (isset($lmm_options[ 'controlbox_bingroad' ]) == TRUE ) && ($lmm_options[ 'controlbox_bingroad' ] == 1 ) )
            $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_bingroad' ]) . "': bingroad,";
    };
    if ( (((isset($lmm_options[ 'controlbox_ogdwien_basemap' ]) == TRUE ) && ($lmm_options[ 'controlbox_ogdwien_basemap' ] == 1 )) && ((($lat <= '48.326583')  && ($lat >= '48.114308')) && (($lon <= '16.55056')  && ($lon >= '16.187325')) )) || ($basemap == 'ogdwien_basemap') )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_ogdwien_basemap' ]) . "': ogdwien_basemap,";
    if ( (((isset($lmm_options[ 'controlbox_ogdwien_satellite' ]) == TRUE ) && ($lmm_options[ 'controlbox_ogdwien_satellite' ] == 1 )) && ((($lat <= '48.326583')  && ($lat >= '48.114308')) && (($lon <= '16.55056')  && ($lon >= '16.187325')) )) || ($basemap == 'ogdwien_satellite') )
        $basemaps_available .= "'" . addslashes($lmm_options[ 'default_basemap_name_ogdwien_satellite' ]) . "': ogdwien_satellite,";
    if ( (isset($lmm_options[ 'controlbox_cloudmade' ]) == TRUE ) && ($lmm_options[ 'controlbox_cloudmade' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'cloudmade_name' ])."': cloudmade,";
    if ( (isset($lmm_options[ 'controlbox_cloudmade2' ]) == TRUE ) && ($lmm_options[ 'controlbox_cloudmade2' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'cloudmade2_name' ])."': cloudmade2,";
    if ( (isset($lmm_options[ 'controlbox_cloudmade3' ]) == TRUE ) && ($lmm_options[ 'controlbox_cloudmade3' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'cloudmade3_name' ])."': cloudmade3,";
    if ( (isset($lmm_options[ 'controlbox_mapbox' ]) == TRUE ) && ($lmm_options[ 'controlbox_mapbox' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'mapbox_name' ])."': mapbox,";
    if ( (isset($lmm_options[ 'controlbox_mapbox2' ]) == TRUE ) && ($lmm_options[ 'controlbox_mapbox2' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'mapbox2_name' ])."': mapbox2,";
    if ( (isset($lmm_options[ 'controlbox_mapbox3' ]) == TRUE ) && ($lmm_options[ 'controlbox_mapbox3' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'mapbox3_name' ])."': mapbox3,";
    if ( (isset($lmm_options[ 'controlbox_custom_basemap' ]) == TRUE ) && ($lmm_options[ 'controlbox_custom_basemap' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'custom_basemap_name' ])."': custom_basemap,";
    if ( (isset($lmm_options[ 'controlbox_custom_basemap2' ]) == TRUE ) && ($lmm_options[ 'controlbox_custom_basemap2' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'custom_basemap2_name' ])."': custom_basemap2,";
    if ( (isset($lmm_options[ 'controlbox_custom_basemap3' ]) == TRUE ) && ($lmm_options[ 'controlbox_custom_basemap3' ] == 1 ) )
        $basemaps_available .= "'".addslashes($lmm_options[ 'custom_basemap3_name' ])."': custom_basemap3,";
	if ( (isset($lmm_options[ 'controlbox_empty_basemap' ]) == TRUE ) && ($lmm_options[ 'controlbox_empty_basemap' ] == 1 ) )
		$basemaps_available .= "'".addslashes($lmm_options[ 'empty_basemap_name' ])."': empty_basemap,";
    //info: needed for IE7 compatibility
    $lmmjs_out .= substr($basemaps_available, 0, -1);
    $lmmjs_out .= '},'.PHP_EOL;

    //info: controlbox - add available overlays
    $lmmjs_out .= '{';
    $overlays_custom_available = '';
    if ( ((isset($lmm_options[ 'overlays_custom' ] ) == TRUE ) && ( $lmm_options[ 'overlays_custom' ] == 1 )) || ($overlays_custom == 1) )
        $overlays_custom_available .= "'".addslashes($lmm_options[ 'overlays_custom_name' ])."': overlays_custom,";
    if ( ((isset($lmm_options[ 'overlays_custom2' ] ) == TRUE ) && ( $lmm_options[ 'overlays_custom2' ] == 1 )) || ($overlays_custom2 == 1) )
        $overlays_custom_available .= "'".addslashes($lmm_options[ 'overlays_custom2_name' ])."': overlays_custom2,";
    if ( ((isset($lmm_options[ 'overlays_custom3' ] ) == TRUE ) && ( $lmm_options[ 'overlays_custom3' ] == 1 )) || ($overlays_custom3 == 1) )
        $overlays_custom_available .= "'".addslashes($lmm_options[ 'overlays_custom3_name' ])."': overlays_custom3,";
    if ( ((isset($lmm_options[ 'overlays_custom4' ] ) == TRUE ) && ( $lmm_options[ 'overlays_custom4' ] == 1 )) || ($overlays_custom4 == 1) )
    	$overlays_custom_available .= "'".addslashes($lmm_options[ 'overlays_custom4_name' ])."': overlays_custom4,";
    //info: needed for IE7 compatibility
    $lmmjs_out .= substr($overlays_custom_available, 0, -1);
    $lmmjs_out .= '},'.PHP_EOL;

    //info: controlbox - hidden / collapsed / expanded status
    if ( (isset($controlbox) == TRUE ) && ( $controlbox == 0 ) )
        $lmmjs_out .= '{ } );'.PHP_EOL;
    if ( (isset($controlbox) == TRUE ) && ( $controlbox == 1 ) )
        $lmmjs_out .= '{ collapsed: true } );'.PHP_EOL;
    if ( (isset($controlbox) == TRUE ) && ( $controlbox == 2 ) )
        $lmmjs_out .= '{ collapsed: false } );'.PHP_EOL;
    $lmmjs_out .= $mapname.'.setView(new L.LatLng('.$lat.', '.$lon.'), '.$zoom.');'.PHP_EOL;
    $lmmjs_out .= $mapname.'.addLayer(' . $basemap . ')';
    //info: controlbox - check active overlays on marker/layer level
    if ( (isset($overlays_custom) == TRUE) && ($overlays_custom == 1) )
        $lmmjs_out .= ".addLayer(overlays_custom)";
    if ( (isset($overlays_custom2) == TRUE) && ($overlays_custom2 == 1) )
        $lmmjs_out .= ".addLayer(overlays_custom2)";
    if ( (isset($overlays_custom3) == TRUE) && ($overlays_custom3 == 1) )
        $lmmjs_out .= ".addLayer(overlays_custom3)";
    if ( (isset($overlays_custom4) == TRUE) && ($overlays_custom4 == 1) )
        $lmmjs_out .= ".addLayer(overlays_custom4)";
    //info: controlbox - add active overlays on marker level
    if ( $wms == 1 )
        $lmmjs_out .= ".addLayer(wms)";
    if ( $wms2 == 1 )
        $lmmjs_out .= ".addLayer(wms2)";
    if ( $wms3 == 1 )
        $lmmjs_out .= ".addLayer(wms3)";
    if ( $wms4 == 1 )
        $lmmjs_out .= ".addLayer(wms4)";
    if ( $wms5 == 1 )
        $lmmjs_out .= ".addLayer(wms5)";
    if ( $wms6 == 1 )
        $lmmjs_out .= ".addLayer(wms6)";
    if ( $wms7 == 1 )
        $lmmjs_out .= ".addLayer(wms7)";
    if ( $wms8 == 1 )
        $lmmjs_out .= ".addLayer(wms8)";
    if ( $wms9 == 1 )
        $lmmjs_out .= ".addLayer(wms9)";
    if ( $wms10 == 1 )
        $lmmjs_out .= ".addLayer(wms10)";
    $lmmjs_out .= ( (isset($controlbox) == TRUE) && ($controlbox != 0) ) ? ".addControl(layersControl);" : ";".PHP_EOL;
    //info: add scale control
    if ( $lmm_options['map_scale_control'] == 'enabled' ) {
    $lmmjs_out .= "L.control.scale({position:'" . $lmm_options['map_scale_control_position'] . "', maxWidth: " . intval($lmm_options['map_scale_control_maxwidth']) . ", metric: " . $lmm_options['map_scale_control_metric'] . ", imperial: " . $lmm_options['map_scale_control_imperial'] . ", updateWhenIdle: " . $lmm_options['map_scale_control_updatewhenidle'] . "}).addTo(" . $mapname . ");".PHP_EOL;
    }
    if (!(empty($mlat) or empty($mlon)) ) {
    if ($lmm_options[ 'defaults_marker_icon_title' ] == 'show') { $defaults_marker_icon_title = "title: '" . htmlspecialchars($markername) . "', "; } else { $defaults_marker_icon_title = ""; };
    $lmmjs_out .= 'var marker = new L.Marker(new L.LatLng('.$mlat.', '.$mlon.'),{ ' . $defaults_marker_icon_title . ' opacity: ' . floatval($lmm_options[ 'defaults_marker_icon_opacity' ]) . '});'.PHP_EOL;
     if ($micon == NULL) {
          $lmmjs_out .= "marker.options.icon = new L.Icon({iconUrl: '" . LEAFLET_PLUGIN_URL . "leaflet-dist/images/marker.png',iconSize: [" . intval($lmm_options[ 'defaults_marker_icon_iconsize_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_iconsize_y' ]) . "],iconAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_iconanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_iconanchor_y' ]) . "],popupAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_popupanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_popupanchor_y' ]) . "],shadowUrl: '" . $marker_shadow_url . "',shadowSize: [" . intval($lmm_options[ 'defaults_marker_icon_shadowsize_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_shadowsize_y' ]) . "],shadowAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_y' ]) . "],className: 'lmm_marker_icon_default'});".PHP_EOL;
      } else {
          $lmmjs_out .= "marker.options.icon = new L.Icon({iconUrl: '" . LEAFLET_PLUGIN_ICONS_URL . "/" . $icon . "',iconSize: [" . intval($lmm_options[ 'defaults_marker_icon_iconsize_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_iconsize_y' ]) . "],iconAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_iconanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_iconanchor_y' ]) . "],popupAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_popupanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_popupanchor_y' ]) . "],shadowUrl: '" . $marker_shadow_url . "',shadowSize: [" . intval($lmm_options[ 'defaults_marker_icon_shadowsize_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_shadowsize_y' ]) . "],shadowAnchor: [" . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_x' ]) . ", " . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_y' ]) . "],className: 'lmm_marker_icon_" . substr($icon, 0, -4) . "'});".PHP_EOL;
    };
    if ( (empty($mpopuptext)) && ($lmm_options['directions_popuptext_panel'] == 'no') ) $lmmjs_out .= 'marker.options.clickable = false;'.PHP_EOL;
    $lmmjs_out .= $mapname.'.addLayer(marker);'.PHP_EOL;

    if ($lmm_options['directions_popuptext_panel'] == 'yes') {

	 	$mpopuptext_css = ($mpopuptext != NULL) ? "border-top:1px solid #f0f0e7;padding-top:5px;margin-top:5px;" : "";
		$mpopuptext = $mpopuptext . '<div style=\'' . $mpopuptext_css . '\'>' . $address . ' (';

		if ($lmm_options['directions_provider'] == 'googlemaps') {
			if ( isset($lmm_options['google_maps_base_domain_custom']) && ($lmm_options['google_maps_base_domain_custom'] == NULL) ) { $gmaps_base_domain_directions = $lmm_options['google_maps_base_domain']; } else { $gmaps_base_domain_directions = urlencode($lmm_options['google_maps_base_domain_custom']); }
			if ( $address != NULL ) { $google_from = urlencode($address); } else { $google_from = $lat . ',' . $lon; }
			$avoidhighways = (isset($lmm_options[ 'directions_googlemaps_route_type_highways' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_highways' ] == 1 ) ? '&dirflg=h' : '';
			$avoidtolls = (isset($lmm_options[ 'directions_googlemaps_route_type_tolls' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_tolls' ] == 1 ) ? '&dirflg=t' : '';
			$publictransport = (isset($lmm_options[ 'directions_googlemaps_route_type_public_transport' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_public_transport' ] == 1 ) ? '&dirflg=r' : '';
			$walking = (isset($lmm_options[ 'directions_googlemaps_route_type_walking' ] ) == TRUE ) && ( $lmm_options[ 'directions_googlemaps_route_type_walking' ] == 1 ) ? '&dirflg=w' : '';
			//info: Google language localization (directions)
			if ($lmm_options['google_maps_language_localization'] == 'browser_setting') {
				$google_language = '';
			} else if ($lmm_options['google_maps_language_localization'] == 'wordpress_setting') {
				if ( defined('WPLANG') ) { $google_language = '&hl=' . substr(WPLANG, 0, 2); } else { $google_language =  '&hl=en'; }
			} else {
				$google_language = '&hl=' . $lmm_options['google_maps_language_localization'];
			}
			$mpopuptext = $mpopuptext . "<a href=http://" . $gmaps_base_domain_directions . "/maps?daddr=" . $google_from . "&t=" . $lmm_options[ 'directions_googlemaps_map_type' ] . "&layer=" . $lmm_options[ 'directions_googlemaps_traffic' ] . "&doflg=" . $lmm_options[ 'directions_googlemaps_distance_units' ] . $avoidhighways . $avoidtolls . $publictransport . $walking . $google_language . "&om=" . $lmm_options[ 'directions_googlemaps_overview_map' ] . " target='_blank' title='" . esc_attr__('Get directions','lmm') . "'>" . __('Directions','lmm') . "</a>";
		} else if ($lmm_options['directions_provider'] == 'yours') {
			$mpopuptext = $mpopuptext . "<a href=http://www.yournavigation.org/?tlat=" . $lat . "&tlon=" . $lon . "&v=" . $lmm_options[ 'directions_yours_type_of_transport' ] . "&fast=" . $lmm_options[ 'directions_yours_route_type' ] . "&layer=" . $lmm_options[ 'directions_yours_layer' ] . " target='_blank' title='" . esc_attr__('Get directions','lmm') . "'>" . __('Directions','lmm') . "</a>";
		} else if ($lmm_options['directions_provider'] == 'osrm') {
			$mpopuptext = $mpopuptext . "<a href=http://map.project-osrm.org/?hl=" . $lmm_options[ 'directions_osrm_language' ] . "&loc=" . $lat . "," . $lon . "&df=" . $lmm_options[ 'directions_osrm_units' ] . " target='_blank' title='" . esc_attr__('Get directions','lmm') . "'>" . __('Directions','lmm') . "</a>";
		} else if ($lmm_options['directions_provider'] == 'ors') {
			$mpopuptext = $mpopuptext . "<a href=http://openrouteservice.org/index.php?end=" . $lon . "," . $lat . "&pref=" . $lmm_options[ 'directions_ors_route_preferences' ] . "&lang=" . $lmm_options[ 'directions_ors_language' ] . "&noMotorways=" . $lmm_options[ 'directions_ors_no_motorways' ] . "&noTollways=" . $lmm_options[ 'directions_ors_no_tollways' ] . " target='_blank' title='" . esc_attr__('Get directions','lmm') . "'>" . __('Directions','lmm') . "</a>";
		}
		$mpopuptext = $mpopuptext . ')</div>';
	}
    if (!empty($mpopuptext)) $lmmjs_out .= 'marker.bindPopup("' . preg_replace('/(\015\012)|(\015)|(\012)/','<br/>',$mpopuptext) . '", {maxWidth: ' . intval($lmm_options['defaults_marker_popups_maxwidth']) . ', minWidth: ' . intval($lmm_options['defaults_marker_popups_minwidth']) . ', maxHeight: ' . intval($lmm_options['defaults_marker_popups_maxheight']) . ', autoPan: ' . $lmm_options['defaults_marker_popups_autopan'] . ', closeButton: ' . $lmm_options['defaults_marker_popups_closebutton'] . ', autoPanPadding: new L.Point(' . intval($lmm_options['defaults_marker_popups_autopanpadding_x']) . ', ' . intval($lmm_options['defaults_marker_popups_autopanpadding_y']) . ')})'.$mopenpopup.';'.PHP_EOL;
    } else if (!empty($geojson) or !empty($geojsonurl) or !empty($layer) ) {
        $lmmjs_out .= 'var geojsonObj, mapIcon, marker_clickable, marker_title;'.PHP_EOL;
        //info: added for next versions
        if (!empty($geojson)) {
        $lmmjs_out .= 'geojsonObj = eval("'.$geojson.'");'.PHP_EOL;
        }
        if (!empty($geojsonurl)) {
        $lmmjs_out .= 'geojsonObj = eval("(" + jQuery.ajax({url: "'.$geojsonurl.'", async: false, cache: true}).responseText + ")");'.PHP_EOL;
        }
        //2do: check if loading marker via GeoJSON has advantages
        /*
        if ( !empty($marker) ) {
        $lmmjs_out .= 'geojsonObj = eval("(" + jQuery.ajax({url: "' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?marker='.$marker.'", async: false, cache: true}).responseText + ")");'.PHP_EOL;
        }
        */
        //info: load GeoJSON for layer maps
        if (!empty($layer) && ($multi_layer_map == 0) ) {
            $lmmjs_out .= 'geojsonObj = eval("(" + jQuery.ajax({url: "' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?layer=' . $id . '", async: false, cache: true}).responseText + ")");'.PHP_EOL;
        } else if (!empty($layer) && ($multi_layer_map == 1) ) {
            $lmmjs_out .= 'geojsonObj = eval("(" + jQuery.ajax({url: "' . LEAFLET_PLUGIN_URL . 'leaflet-geojson.php?layer=' . $multi_layer_map_list . '", async: false, cache: true}).responseText + ")");'.PHP_EOL;
        }
        $lmmjs_out .= 'L.geoJson(geojsonObj, {'.PHP_EOL;
        $lmmjs_out .= '        onEachFeature: function(feature, marker) {'.PHP_EOL;
        $lmmjs_out .= "            if (feature.properties.text != '') {".PHP_EOL;
        $lmmjs_out .= '            marker.bindPopup(feature.properties.text, {'.PHP_EOL;
        $lmmjs_out .= '            maxWidth: ' . intval($lmm_options['defaults_marker_popups_maxwidth']) . ', '.PHP_EOL;
        $lmmjs_out .= '            minWidth: ' . intval($lmm_options['defaults_marker_popups_minwidth']) . ', '.PHP_EOL;
        $lmmjs_out .= '            maxHeight: ' . intval($lmm_options['defaults_marker_popups_maxheight']) . ', '.PHP_EOL;
        $lmmjs_out .= '            autoPan: ' . $lmm_options['defaults_marker_popups_autopan'] . ', '.PHP_EOL;
        $lmmjs_out .= '            closeButton: ' . $lmm_options['defaults_marker_popups_closebutton'] . ', '.PHP_EOL;
        $lmmjs_out .= '            autoPanPadding: new L.Point(' . intval($lmm_options['defaults_marker_popups_autopanpadding_x']) . ', ' . intval($lmm_options['defaults_marker_popups_autopanpadding_y']) . ')'.PHP_EOL;
        $lmmjs_out .= '            });'.PHP_EOL;
        $lmmjs_out .= '            }'.PHP_EOL;
        $lmmjs_out .= '        },'.PHP_EOL;
        $lmmjs_out .= 'pointToLayer: function (feature, latlng) {'.PHP_EOL;
        $lmmjs_out .= '    mapIcon = L.icon({ '.PHP_EOL;
        $lmmjs_out .= "        iconUrl: (feature.properties.icon != '') ? '" . LEAFLET_PLUGIN_ICONS_URL . "/' + feature.properties.icon : '" . LEAFLET_PLUGIN_URL . "leaflet-dist/images/marker.png" . "',".PHP_EOL;
        $lmmjs_out .= '        iconSize: [' . intval($lmm_options[ 'defaults_marker_icon_iconsize_x' ]) . ', ' . intval($lmm_options[ 'defaults_marker_icon_iconsize_y' ]) . '],'.PHP_EOL;
        $lmmjs_out .= '        iconAnchor: [' . intval($lmm_options[ 'defaults_marker_icon_iconanchor_x' ]) . ', ' . intval($lmm_options[ 'defaults_marker_icon_iconanchor_y' ]) . '],'.PHP_EOL;
        $lmmjs_out .= '        popupAnchor: [' . intval($lmm_options[ 'defaults_marker_icon_popupanchor_x' ]) . ', ' . intval($lmm_options[ 'defaults_marker_icon_popupanchor_y' ]) . '],'.PHP_EOL;
        $lmmjs_out .= "        shadowUrl: '" . $marker_shadow_url . "',".PHP_EOL;
        $lmmjs_out .= '        shadowSize: [' . intval($lmm_options[ 'defaults_marker_icon_shadowsize_x' ]) . ', ' . intval($lmm_options[ 'defaults_marker_icon_shadowsize_y' ]) . '],'.PHP_EOL;
        $lmmjs_out .= '        shadowAnchor: [' . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_x' ]) . ', ' . intval($lmm_options[ 'defaults_marker_icon_shadowanchor_y' ]) . '],'.PHP_EOL;
        $lmmjs_out .= "        className: (feature.properties.icon == '') ? 'lmm_marker_icon_default' : 'lmm_marker_icon_'+ feature.properties.icon.slice(0,-4)".PHP_EOL;
        $lmmjs_out .= '    });'.PHP_EOL;
        $lmmjs_out .= "if (feature.properties.text == '') { marker_clickable = false } else { marker_clickable = true };".PHP_EOL;
        if ($lmm_options[ 'defaults_marker_icon_title' ] == 'show') {
        $lmmjs_out .= "if (feature.properties.markername == '') { marker_title = '' } else { marker_title = feature.properties.markername };".PHP_EOL;
        }
        $lmmjs_out .= 'return L.marker(latlng, {icon: mapIcon, clickable: marker_clickable, title: marker_title, opacity: ' . floatval($lmm_options[ 'defaults_marker_icon_opacity' ]) . '});'.PHP_EOL;
        $lmmjs_out .= '}'.PHP_EOL;
        $lmmjs_out .= '}).addTo(' . $mapname . ');'.PHP_EOL;
    }
    $lmmjs_out .= '})(jQuery);'.PHP_EOL;

    //info: end workaround for incompatibility with jetpack plugin
    $lmmjs_out .= '}'.PHP_EOL;

	//info: fallback for adding js to footer 3
	if ( (version_compare( $wp_version, '3.3', '>=' )) && ($lmm_options['misc_javascript_header_footer'] == 'footer')) {
		//info: enqueue map js to footer
		global $wp_scripts;
		wp_enqueue_script( 'show_map' );
		$wp_scripts->add_data( 'show_map', 'data', $lmmjs_out );
	} else if ( (version_compare( $wp_version, '3.3', '<' )) || ((version_compare( $wp_version, '3.3', '>=' )) && ($lmm_options['misc_javascript_header_footer'] == 'header')) ) {
		$lmmjs_out .= '</script>'.PHP_EOL;
		$lmmjs_out .= '</div>'; //info: end leaflet_maps_marker_$uid
		$lmm_out = $lmm_out . $lmmjs_out;
	}

	//info: if do_shortcode() within template files is used to show maps or for shortcodes in widgets
	global $wp_styles;
	if ( (!wp_style_is( 'leafletmapsmarker', 'done' )) || (!wp_style_is( 'leafletmapsmarker-ie-only', 'done' )) ) {
		global $wp_styles, $wp_version;
		wp_enqueue_style('leafletmapsmarker');
		wp_enqueue_style('leafletmapsmarker-ie-only');
		$wp_styles->add_data('leafletmapsmarker-ie-only', 'conditional', 'lt IE 9');
		//info: override max image width in popups
		if ( version_compare( $wp_version, '3.3', '>=' ) ) {
			$lmm_custom_css = ".leaflet-popup-content img { max-width:" . intval($lmm_options['defaults_marker_popups_image_max_width']) . "px !important; height:auto; margin: 0px !important; padding: 0px !important; box-shadow:none !important; width:auto !important; }";
			wp_add_inline_style('leafletmapsmarker',$lmm_custom_css);
		}
	}
  } //info: end (!is_feed())
}
?>
