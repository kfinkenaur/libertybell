<?php
/*
Template Name: Display Authors
*/

// Get all users order by amount of posts
$allUsers = get_users('orderby=post_count&#038;order=DESC');

$users = array();

// Remove subscribers from the list as they won't write any articles
foreach($allUsers as $currentUser)
{
	if(!in_array( 'subscriber', $currentUser->roles ))
	{
		$users[] = $currentUser;
	}
}

?>

<?php get_header(); ?>
	<header class="entry-header">
    <div class="title-container">
		<h1 class="page-title"><?php the_title(); ?></h1><span class="breadcrumbs"><?php if (function_exists('formation_breadcrumbs')) formation_breadcrumbs(); ?></span>
        </div>
	</header><!-- .entry-header -->
<div id="primary_home" class="content-area">
<div id="content" class="fullwidth" role="main">
		<?php
		foreach($users as $user)
		{
			?>
			<div class="authorlist">
				<div class="authorAvatar">
					<?php echo get_avatar( $user->user_email, '128' ); ?>
				</div>
				<div class="authorInfo">
					<h2 class="authorName"><?php echo $user->display_name; ?></h2>
					<p class="authorDescrption"><?php echo get_user_meta($user->ID, 'description', true); ?></p>
					<p class="authorLinks"><a href="<?php echo get_author_posts_url( $user->ID ); ?>">Author Posts</a>
					<?php ?><div class="socialIcons">
						<ul class="socialIcons">
							<?php
								$website = $user->user_url;
								if($user->user_url != '')
								{
									printf('<li><a href="%s"class="genericon genericon-link" target="_blank"></a></li>', $user->user_url, 'Website');
								}

								$twitter = get_user_meta($user->ID, 'twitter_profile', true);
								if($twitter != '')
								{
									printf('<li><a href="%s"class="genericon genericon-twitter" target="_blank"></a></li>', $twitter, 'Twitter');
								}

								$facebook = get_user_meta($user->ID, 'facebook_profile', true);
								if($facebook != '')
								{
									printf('<li><a href="%s"class="genericon genericon-facebook-alt" target="_blank"></a></li>', $facebook, 'facebook');
								}

								$google = get_user_meta($user->ID, 'google_profile', true);
								if($google != '')
								{
									printf('<li><a href="%s"class="genericon genericon-googleplus" target="_blank"></a></li>', $google, 'Google');
								}

								$linkedin = get_user_meta($user->ID, 'linkedin_profile', true);
								if($linkedin != '')
								{
									printf('<li><a href="%s"class="genericon genericon-linkedin" target="_blank"></a></li>', $linkedin, 'LinkedIn');
								}
							?>
						</ul>
					</div><?php ?>
				</div>
			</div>
			<?php
		}
	?>
</div>
</div>

<?php get_footer(); ?>