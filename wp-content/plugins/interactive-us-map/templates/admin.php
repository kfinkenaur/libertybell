<?php 
$wp_r_map = $this->options; ?>
<form method="post" action="<?php echo admin_url( '/' ); ?>admin.php?page=wp-r-map">
<div id="wp-map-wrapper">
  <div id="map-header">
    <p class="map-shortcode">Insert this shortcode <input type="text" value="[us_regional_map]" readonly> into any page or post to display the map.</p>
    <p style="margin-left: 14px;"><strong><a href="https://wordpress.org/plugins/interactive-us-map/faq/">FAQ</a></strong></p>
    <p class="map-btns"><span class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save changes"></span></p>
  </div>
  <div id="wp-map-main">
    <div class="map-col map-col-lt">
      <div id="map-preview">
        <?php include 'map.php'; ?>
      </div>
      <div class="map-parameters">
        <div class="map-box-header regions-icon">Regions Parameters</div>
        <div class="map-box-body region-field">

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ I</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_1" value="1" <?php if ($wp_r_map['enable_region_1'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_1" value="<?php echo $wp_r_map['up_color_1']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_1" value="<?php echo $wp_r_map['over_color_1']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_1" value="<?php echo $wp_r_map['down_color_1']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_1" value="<?php echo $wp_r_map['url_1']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_1">
                    <option value="_self" <?php if($wp_r_map['open_url_1'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_1'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_1'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_1"><?php echo $wp_r_map['hover_content_1']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ II</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_2" value="1" <?php if ($wp_r_map['enable_region_2'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_2" value="<?php echo $wp_r_map['up_color_2']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_2" value="<?php echo $wp_r_map['over_color_2']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_2" value="<?php echo $wp_r_map['down_color_2']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_2" value="<?php echo $wp_r_map['url_2']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_2">
                    <option value="_self" <?php if($wp_r_map['open_url_2'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_2'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_2'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_2"><?php echo $wp_r_map['hover_content_2']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ III</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_3" value="1" <?php if ($wp_r_map['enable_region_3'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_3" value="<?php echo $wp_r_map['up_color_3']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_3" value="<?php echo $wp_r_map['over_color_3']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_3" value="<?php echo $wp_r_map['down_color_3']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_3" value="<?php echo $wp_r_map['url_3']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_3">
                    <option value="_self" <?php if($wp_r_map['open_url_3'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_3'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_3'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_3"><?php echo $wp_r_map['hover_content_3']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ IV</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_4" value="1" <?php if ($wp_r_map['enable_region_4'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_4" value="<?php echo $wp_r_map['up_color_4']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_4" value="<?php echo $wp_r_map['over_color_4']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_4" value="<?php echo $wp_r_map['down_color_4']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_4" value="<?php echo $wp_r_map['url_4']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_4">
                    <option value="_self" <?php if($wp_r_map['open_url_4'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_4'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_4'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_4"><?php echo $wp_r_map['hover_content_4']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ V</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_5" value="1" <?php if ($wp_r_map['enable_region_5'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_5" value="<?php echo $wp_r_map['up_color_5']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_5" value="<?php echo $wp_r_map['over_color_5']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_5" value="<?php echo $wp_r_map['down_color_5']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_5" value="<?php echo $wp_r_map['url_5']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_5">
                    <option value="_self" <?php if($wp_r_map['open_url_5'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_5'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_5'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_5"><?php echo $wp_r_map['hover_content_5']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ VI</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_6" value="1" <?php if ($wp_r_map['enable_region_6'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_6" value="<?php echo $wp_r_map['up_color_6']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_6" value="<?php echo $wp_r_map['over_color_6']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_6" value="<?php echo $wp_r_map['down_color_6']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_6" value="<?php echo $wp_r_map['url_6']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_6">
                    <option value="_self" <?php if($wp_r_map['open_url_6'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_6'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_6'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_6"><?php echo $wp_r_map['hover_content_6']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ VII</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_7" value="1" <?php if ($wp_r_map['enable_region_7'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_7" value="<?php echo $wp_r_map['up_color_7']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_7" value="<?php echo $wp_r_map['over_color_7']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_7" value="<?php echo $wp_r_map['down_color_7']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_7" value="<?php echo $wp_r_map['url_7']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_7">
                    <option value="_self" <?php if($wp_r_map['open_url_7'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_7'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_7'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_7"><?php echo $wp_r_map['hover_content_7']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ VIII</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_8" value="1" <?php if ($wp_r_map['enable_region_8'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_8" value="<?php echo $wp_r_map['up_color_8']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_8" value="<?php echo $wp_r_map['over_color_8']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_8" value="<?php echo $wp_r_map['down_color_8']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_8" value="<?php echo $wp_r_map['url_8']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_8">
                    <option value="_self" <?php if($wp_r_map['open_url_8'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_8'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_8'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_8"><?php echo $wp_r_map['hover_content_8']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ IX</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_9" value="1" <?php if ($wp_r_map['enable_region_9'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_9" value="<?php echo $wp_r_map['up_color_9']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_9" value="<?php echo $wp_r_map['over_color_9']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_9" value="<?php echo $wp_r_map['down_color_9']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_9" value="<?php echo $wp_r_map['url_9']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_9">
                    <option value="_self" <?php if($wp_r_map['open_url_9'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_9'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_9'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_9"><?php echo $wp_r_map['hover_content_9']; ?></textarea></p></div>
            </div>
          </div>

          <div class="region">
            <div class="region-name"><a href="#">Standard Federal Region​ X</a></div>
            <span class="checkbox"><input type="checkbox" name="enable_region_10" value="1" <?php if ($wp_r_map['enable_region_10'] == '1'){echo " checked";} ?>>&nbsp;Active</span>
            <div class="inner-content">
              <div class="state-colors">
                <p class="form-field"><label>Up Color</label><input type="text" name="up_color_10" value="<?php echo $wp_r_map['up_color_10']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Hover Color</label><input type="text" name="over_color_10" value="<?php echo $wp_r_map['over_color_10']; ?>" class="color-field" /></p>              
                <p class="form-field"><label>Click Color</label><input type="text" name="down_color_10" value="<?php echo $wp_r_map['down_color_10']; ?>" class="color-field" /></p>             
              </div>
              <div class="state-url">
                <p class="form-field link-field"><label>Link</label><input type="text" name="url_10" value="<?php echo $wp_r_map['url_10']; ?>" /></p>
                <p class="form-field"><label>Target</label>
                  <select name="open_url_10">
                    <option value="_self" <?php if($wp_r_map['open_url_10'] == '_self'){echo "selected";} ?>>Same Page</option>
                    <option value="_blank" <?php if($wp_r_map['open_url_10'] == '_blank'){echo "selected";} ?>>New Page</option>
                    <option value="none" <?php if($wp_r_map['open_url_10'] == 'none'){echo "selected";} ?>>None</option>
                  </select>
                </p>
              </div>
              <div class="hover-content"><p class="form-field"><label>Hover Content</label><textarea rows="5" name="hover_content_10"><?php echo $wp_r_map['hover_content_10']; ?></textarea></p></div>
            </div>
          </div>


        </div><!-- map-box-body -->
      </div><!-- map-parameters -->
    </div><!-- map-col-lt -->


    <!-- General Map Colors -->
    <div id="submitdiv" class="map-col map-col-rt">
      <div class="map-parameters">
        <div class="map-box-header map-icon">General Map Colors</div>
        <div class="map-box-body">
          <div class="map-field"><span class="map-parameter icon-border">Border Color</span><input type="text" name="border_color" value="<?php echo $wp_r_map['border_color']; ?>" class="color-field" /></div>
          <div class="map-field"><span class="map-parameter icon-abbs">Short Names</span><input type="text" name="short_names" value="<?php echo $wp_r_map['short_names']; ?>" class="color-field" /></div>
          <div class="map-field"><span class="map-parameter icon-shadow">Shadow Color</span><input type="text" name="shadow_color" value="<?php echo $wp_r_map['shadow_color']; ?>" class="color-field" /></div>
          <div class="map-field"><span class="map-parameter icon-lakes">Lakes Fill</span><input type="text" name="lake_fill" value="<?php echo $wp_r_map['lake_fill']; ?>" class="color-field" /></div>
          <div class="map-field"><span class="map-parameter icon-lakes-out">Lakes Outline</span><input type="text" name="lake_outline" value="<?php echo $wp_r_map['lake_outline']; ?>" class="color-field" /></div>
        </div><!-- map-box-body -->
      </div><!-- map-parameters -->
      <p class="color-hint"><strong>Hint:</strong> you can set any color as <strong>transparent</strong></p>
      <a href="http://codecanyon.net/item/interactive-us-map-wordpress-plugin/10359489?ref=clickmaps"><img src="<?php echo WPMMAPR_URL . 'images/us-states-map.png'; ?>" alt="US Map with Clickable States"></a>
    </div><!-- map-col-rt -->

    <input type="hidden" name="wp_r_map">
      <?php
      settings_fields(__FILE__);
      do_settings_sections(__FILE__);
      ?>
    <p class="map-btns"><span class="submit"><input type="submit" name="restore_default" id="submit" class="button" value="Restore default"></span></p>


  </div><!-- wp-map-main -->
</div><!-- wp-map-wrapper -->
</form>
