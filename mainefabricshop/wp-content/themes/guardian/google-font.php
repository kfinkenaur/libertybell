<?php $wl_theme_options = weblizar_get_options(); ?>

<style>
.logo a{
	font-family: <?php echo $wl_theme_options['main_heading_font'] ?>;
}
.navbar .navbar-nav li a{
	font-family: <?php echo $wl_theme_options['menu_font'] ?>;
}
.carousel-caption p strong, .feature_section1 h2, h5.caps, .feature_section5 h2, .one_third h4, .footer1 h4.lmb,
.title h1, .page_title2 .pagenation, .sidebar_widget h4, .blog_post h3 a{
	font-family: <?php echo $wl_theme_options['theme_title'] ?>;
}
.feature_section1 h2 b, .carousel-caption p, .one_fourth p,.one_third p, a.lfour, .post_meta_links li,
.blog_postcontent p, #wblizar_nav, .content_left h4, .comment_author, .comment_text p, .comment_content .comment_text a,
.comment_submit, #comment_submit, .sidebar_widget ul a, .qlinks li a, .copyright_info a, .one_third,
.content_left p, .content_left h3, .recentcomments, .textwidget{
	font-family: <?php echo $wl_theme_options['desc_font_all'] ?>;
}
</style>