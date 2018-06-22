<?php







    // calling the header.php



    get_header();







    // action hook for placing content above #container



    thematic_abovecontainer();







?>







<div id="pitch">



<table width="907" border="0">



    <tr>



      <td width="550px" valign="top"><h1><br />Professional Maine Moving and Storage Company</h1>



      <table width="550px" border="0">



          <tr>



            <td width="100%" height="237" valign="top"><br /><div id="intrograph"><img src="http://libertybellmoving.com/wp-content/uploads/2011/12/libertybellmoving.gif" class="alignright">Liberty Bell Moving Company provides free moving quotes for  residential moving services all over Maine and New Hampshire. We also help Maine businesses by offering trained commercial movers, storage  and small office moving services. Accredited by the <a href="http://boston.bbb.org/Find-Business-Reviews/"> Maine Better Business Bureau</a>, Liberty Bell is known to be Portland’s BEST Maine residential movers.</div>



             </span></td>



                             </td>



          </tr>



        </table></td>



      <td width="250" valign="top"><div align="left">



        <h2 class="style44"><br />Get a Free Moving Quote Today!</h2>



<div class="style4677">You will receive an email response within 30 minutes*</div>



      </div>







<form id="form2" method="post" action="http://libertybellmoving.com/movingquote.php">







        <table width="100%" border="0" cellpadding="1" cellspacing="1">



          <tr>



            <td class="style46"><div align="right">Name:</div></td>



            <td colspan="2"><input name="name" type="text" id="name" /></td>



          </tr>



          <tr>



            <td class="style46"><div align="right">Email:</div></td>



            <td colspan="2"><input name="email" type="text" id="email" /></td>



          </tr>



          <tr>



            <td class="style46"><div align="right">Phone:</div></td>



            <td colspan="2"><input name="phone" type="text" id="phone" /></td>



          </tr>



          <tr>



            <td class="style46"><div align="right">Date:</div></td>



            <td colspan="2"><input name="movedate" type="text" id="movedate" /></td>



</tr>

<br />

          <tr>



            <td height="59" class="style46"><div align="right">Details:</div></td>



            <td colspan="2"><span class="style47">



              <label>



              <textarea name="comments" id="comments"></textarea><br>



              <input name="button" type="submit" class="style27" id="button" value"SUBMIT" />



              </label>



            </span></td>



          </tr>



        </table>



      </form></td>



    </tr>



  </table>



</div><br /><br />







		<div id="container">



		



			<?php thematic_abovecontent(); ?>



		



			<div id="content">



	



	            <?php



	        



	            // calling the widget area 'page-top'



	            get_sidebar('page-top');



	



	            the_post();



	            



	            thematic_abovepost();



	        



	            ?>



	            



				<div id="post-<?php the_ID();



					echo '" ';



					if (!(THEMATIC_COMPATIBLE_POST_CLASS)) {



						post_class();



						echo '>';



					} else {



						echo 'class="';



						thematic_post_class();



						echo '">';



					}



	                



	                



	                



	                ?>



	                



					<div class="entry-content">



	



	                    <?php



	                    



	                    the_content();



	                    



	                    wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number');



	                    



	                     ?>



	



					</div><!-- .entry-content -->



				</div><!-- #post -->



	



	        <?php



	        



	        thematic_belowpost();



	        



	        // calling the comments template



       		if (THEMATIC_COMPATIBLE_COMMENT_HANDLING) {



				if ( get_post_custom_values('comments') ) {



					// Add a key/value of "comments" to enable comments on pages!



					thematic_comments_template();



				}



			} else {



				thematic_comments_template();



			}



	        



	        // calling the widget area 'page-bottom'



	        get_sidebar('page-bottom');



	        



	        ?>



	



			</div><!-- #content -->



			



			<?php thematic_belowcontent(); ?> 



			



		</div><!-- #container -->







<?php 







    // action hook for placing content below #container



    thematic_belowcontainer();







    // calling the standard sidebar 



    thematic_sidebar();



    



    // calling footer.php



    get_footer();







?>