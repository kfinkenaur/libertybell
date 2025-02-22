<?php



    // calling the header.php

    get_header();



    // action hook for placing content above #container

    thematic_abovecontainer();



?>



		<div id="container">

		

			<?php thematic_abovecontent(); ?>

		

			<div id="content">

	

	            <?php 

	            

	            if (have_posts()) {

	

	                // displays the page title

	                thematic_page_title();

	

	                // create the navigation above the content

	                thematic_navigation_above();

				

	                // action hook for placing content above the search loop

	                thematic_above_searchloop();			

	

	                // action hook creating the search loop

	                thematic_searchloop();

	

	                // action hook for placing content below the search loop

	                thematic_below_searchloop();			

	

	                // create the navigation below the content

	                thematic_navigation_below();

	

	            } else {

	            	

	           		thematic_abovepost();

	                

	                ?>

	

				<div id="post-0" class="post noresults">

					<h1 class="entry-title"><?php _e('Nothing Found', 'thematic') ?></h1>

					<div class="entry-content">

						<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'thematic') ?></p>

					</div><!-- .entry-content -->

					<form id="noresults-searchform" method="get" action="<?php bloginfo('url') ?>/">

						<div>

							<input id="noresults-s" name="s" type="text" value="<?php echo esc_html(stripslashes($_GET['s'])) ?>" size="40" />

							<input id="noresults-searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'thematic') ?>" />

						</div>

					</form>

				</div><!-- #post -->

	

	            <?php

	            

	            	thematic_belowpost();

	            

	            }

	            

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