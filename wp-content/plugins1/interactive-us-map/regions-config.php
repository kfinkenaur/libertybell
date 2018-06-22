﻿<?php 
$wp_r_map = $this->options; ?>
var re_config = {
	'default':{
		'bordercolor':'<?php echo $wp_r_map['border_color']; ?>',
		'namescolor':'<?php echo $wp_r_map['short_names']; ?>',
		'shadowcolor':'<?php echo $wp_r_map['shadow_color']; ?>',
		'lakesfill':'<?php echo $wp_r_map['lake_fill']; ?>',
		'lakesoutline':'<?php echo $wp_r_map['lake_outline']; ?>',
	},
	're_1':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_1']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_1']) : stripslashes($wp_r_map['hover_content_1'])); ?>',
		'url':'<?php echo $wp_r_map['url_1']; ?>',
		'target':'<?php echo $wp_r_map['open_url_1']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_1']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_1']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_1']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_1']=='1'?'true':'false'; ?>,
		'reg':'reg_1',
	},
	're_2':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_2']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_2']) : stripslashes($wp_r_map['hover_content_2'])); ?>',
		'url':'<?php echo $wp_r_map['url_2']; ?>',
		'target':'<?php echo $wp_r_map['open_url_2']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_2']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_2']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_2']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_2']=='1'?'true':'false'; ?>,
		'reg':'reg_2',
	},
	're_3':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_3']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_3']) : stripslashes($wp_r_map['hover_content_3'])); ?>',
		'url':'<?php echo $wp_r_map['url_3']; ?>',
		'target':'<?php echo $wp_r_map['open_url_3']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_3']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_3']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_3']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_3']=='1'?'true':'false'; ?>,
		'reg':'reg_3',
	},
	're_4':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_4']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_4']) : stripslashes($wp_r_map['hover_content_4'])); ?>',
		'url':'<?php echo $wp_r_map['url_4']; ?>',
		'target':'<?php echo $wp_r_map['open_url_4']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_4']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_4']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_4']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_4']=='1'?'true':'false'; ?>,
		'reg':'reg_4',
	},
	're_5':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_5']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_5']) : stripslashes($wp_r_map['hover_content_5'])); ?>',
		'url':'<?php echo $wp_r_map['url_5']; ?>',
		'target':'<?php echo $wp_r_map['open_url_5']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_5']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_5']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_5']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_5']=='1'?'true':'false'; ?>,
		'reg':'reg_5',
	},
	're_6':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_6']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_6']) : stripslashes($wp_r_map['hover_content_6'])); ?>',
		'url':'<?php echo $wp_r_map['url_6']; ?>',
		'target':'<?php echo $wp_r_map['open_url_6']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_6']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_6']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_6']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_6']=='1'?'true':'false'; ?>,
		'reg':'reg_6',
	},
	're_7':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_7']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_7']) : stripslashes($wp_r_map['hover_content_7'])); ?>',
		'url':'<?php echo $wp_r_map['url_7']; ?>',
		'target':'<?php echo $wp_r_map['open_url_7']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_7']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_7']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_7']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_7']=='1'?'true':'false'; ?>,
		'reg':'reg_7',
	},
	're_8':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_8']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_8']) : stripslashes($wp_r_map['hover_content_8'])); ?>',
		'url':'<?php echo $wp_r_map['url_8']; ?>',
		'target':'<?php echo $wp_r_map['open_url_8']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_8']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_8']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_8']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_8']=='1'?'true':'false'; ?>,
		'reg':'reg_8',
	},
	're_9':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_9']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_9']) : stripslashes($wp_r_map['hover_content_9'])); ?>',
		'url':'<?php echo $wp_r_map['url_9']; ?>',
		'target':'<?php echo $wp_r_map['open_url_9']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_9']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_9']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_9']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_9']=='1'?'true':'false'; ?>,
		'reg':'reg_9',
	},
	're_10':{
		'hover': '<?php echo str_replace(array("\n","\r","\r\n"),'', is_array($wp_r_map['hover_content_10']) ?
				array_map('stripslashes_deep', $wp_r_map['hover_content_10']) : stripslashes($wp_r_map['hover_content_10'])); ?>',
		'url':'<?php echo $wp_r_map['url_10']; ?>',
		'target':'<?php echo $wp_r_map['open_url_10']; ?>',
		'upcolor':'<?php echo $wp_r_map['up_color_10']; ?>',
		'overcolor':'<?php echo $wp_r_map['over_color_10']; ?>',
		'downcolor':'<?php echo $wp_r_map['down_color_10']; ?>',
		'enable':<?php echo $wp_r_map['enable_region_10']=='1'?'true':'false'; ?>,
		'reg':'reg_10',
	},
}
