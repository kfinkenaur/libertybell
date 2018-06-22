<?php
  class reviews{
		 /* Saving and Updating Google API Key and Place Id into Database*/			 
             function nsgrp_google_reviews_on_pages()
             {
              global $wpdb;
              $table_name = $wpdb->prefix .'Google_Reviews_On_Pages';
              $query = $wpdb->get_results(@$wpdb->prepare("SELECT * FROM ".$table_name));
              //print_r($query);
              @$query=$query[0];
               if(@$query->placeid && $query->api_key)
                 {
                   //print_r($query); 
                  $file="https://maps.googleapis.com/maps/api/place/details/json?placeid=".$query->placeid."&key=".$query->api_key;
                  $data =  json_decode(file_get_contents($file));
                        $ch = curl_init( $file );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			$data1 = curl_exec( $ch ); // Google response
			curl_close( $ch );
			$response = json_decode( $data1, true );
 
                  $request_url = add_query_arg(
				array(
					'photoreference' => $response['result']['photos'][0]['photo_reference'],
					'key'            => $query->api_key,
					'maxwidth'       => '300',
					'maxheight'      => '300',
				),
				'https://maps.googleapis.com/maps/api/place/photo'
			                     );

			//$response = array_merge( $response, array( 'place_avatar' => $request_url ) );
                        //echo $request_url;
                        ?>
                   <div class="reviews">
                    <div class="business_logo" style="background-image: url('<?php echo $request_url; ?> ')"></div>
                     <div class="reviews_results">
                      <h2 class="author_name" >
                       <a target=_blank href='<?php echo $data->result->name; ?> '> <?php echo $data->result->name; ?> </a>
                      </h2>
                      <div class="ratings">
                       <center>
                        <img src="<?php echo plugins_url('images', __FILE__); ?>/<?php echo $data->result->rating; ?>stars.png">
                        <img src="<?php echo plugins_url('images', __FILE__); ?>/google_logo.png">
                       </center>
                       <center>
                        <h3><?php echo $data->result->rating; ?> Out of 5 Stars</h3>
                       </center>
                      </div>
                     </div>
                    </div>
                 <?php 
                for($i=0; $i<count($data->result->reviews); $i++)
                   {
                     $pp=@$data->result->reviews[$i]->profile_photo_url;
                     $pl=$data->result->reviews[$i]->author_url;
                     $desc = $data->result->reviews[$i]->text;
                     if (strlen($desc) > 250) 
                         {
                         $desc = substr($desc, 0, 250);
                         }
                      echo '<div class="reviews"><div class="review_area">';
                           if($pp=="")
                            {
                               echo '<center><img  src='.plugins_url('images', __FILE__).'/profil-pic_dummy.png></center>';
                            }
                           else
                              {
                               echo '<center><img src='.$pp.'></center>';
                              }
                              ?>
                           <div class="ratings">
                            <center>
                             <img src="<?php echo plugins_url('images', __FILE__); ?>/<?php echo $data->result->reviews[$i]->rating; ?>stars.png">
                            </center>
                           </div>
                           <h2 class="author_name" >
                            <a target=_blank href='<?php echo $pl; ?> '><?php echo $data->result->reviews[$i]->author_name; ?> </a>
                           </h2>
                           <span class="author_name">On &nbsp <?php echo date('m/d/Y', $data->result->reviews[$i]->time); ?></span>
                          </div>
                          <div class="reviews_results">
                           <p style="font-family:\'Trebuchet MS\',Sans-Serif;"><?php echo $desc; ?>... <a href=' <?php echo $pl; ?>' class="readme" target="_blank" style="">Read More</a><p>
                          </div>
                         </div>
                <?php   }

                }
            else
                {
                  echo "Please configue the Google API Settings in wp-admin panel";
                }
            }
				 }


?>