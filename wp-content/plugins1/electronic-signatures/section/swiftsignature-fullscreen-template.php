<?php
/*
 * Template Name: SwiftSignature Fullscreen
 */
get_header();
wp_enqueue_style('swiftsign-fullscreen', plugins_url('/css/swiftsignature-fullscreen.css', dirname(__FILE__)), '', '', '');
wp_enqueue_style('swiftsign-bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css');
wp_enqueue_script('swiftsign-bootstrap-js', "//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js", '', '', true);
wp_enqueue_script('swiftsign-bootstrap-js', "//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js", '', '', true);
?>
<?php while (have_posts()) : the_post(); ?>
    <section id="page-main-content" class="fullwidth swiftsign-fullscreen-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <header class="swiftsign-fullscreen-mob-header visible-xs m-t-15">
                        <div class="">
                            <div class="row">
                                <div class="col-xs-2 text-left">

                                </div>
                                <div class="col-xs-8">
                                    <div class="swiftsign-fullscreen-mob-logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo SWIFTSIGN_PLUGIN_URL; ?>/images/swift-signature-logo.png" /></a></div>
                                </div>
                                <div class="col-xs-2 text-right">
                                    <div class="btn swiftsign-fullscreen-btn-round"><a href="<?php echo home_url(); ?>"><i class="fa fa-power-off"></i></a></div>
                                </div>
                            </div>
                        </div>
                        <div class="swiftsign-fullscreen-mob-header-btns">
                            <div class="swiftsign-fullscreen-btn-container btn-container-two" id="mob-btn-container-two">
                                <button type="button" id="swiftsign-fullscreen-submitBtn" class="btn btn-success btn-lg">Sign and Send <i class="fa fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8 swiftsign-fullscreen-sign-right">
                    <div class="smarketing-page-content">
                        <div class="sign-content">
                            <div class="doc-content"><?php the_content(); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 swiftsign-fullscreen-sign-left hidden-xs">
                    <div class="affix">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="swiftsign-fullscreen-logo">
                                    <a href="<?php echo home_url(); ?>"><img src="<?php echo SWIFTSIGN_PLUGIN_URL; ?>/images/swift-signature-logo.png" /></a>
                                </div>
                            </div>
                            <div class="col-lg-12 m-t-10">
                                <div class="swiftsign-fullscreen-userinfo-right welcome-name pull-right">
                                    <div class="swiftsign-fullscreen-sign-in-as">Signing as Guest</div>
                                    <div class="swiftsign-fullscreen-user-img"><img src="<?php echo SWIFTSIGN_PLUGIN_URL; ?>/images/user_avatar.png"/></div>
                                    <div class="btn swiftsign-fullscreen-btn-round"><a href="<?php echo home_url(); ?>"><i class="fa fa-power-off"></i></a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <h1 class="swiftsign-fullscreen-envelop-title"><?php the_title(); ?></h1>
                                </div>
                            </div>
                            <div class="row" style="position: relative">
                                <div class="col-lg-12 align-items-end " id="swiftsign-fullscreen-fixed-row-1">
                                    <div class="swiftsign-fullscreen-btn-container">
                                        <button type="button" id="swiftsign-fullscreen-submitBtn" class="btn btn-success btn-lg">Sign and Send <i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
<?php endwhile; ?>
<?php get_footer(); ?>