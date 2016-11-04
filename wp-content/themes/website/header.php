
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <link rel="icon" type="image/png" href="<?php echo nb_content('images', ''); ?>">
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no'"> 
        
        <title><?php wp_title('|', true, 'right'); ?></title>
        <?php
        wp_head();
        nb_header_includes();
        ?>
    </head>
  
    <body <?php body_class(header_sticky_classes('header-fixed')); ?>>
          
        <div class="header-down"></div>
        <div class="header row container">
             <a class="logo" href="<?php echo home_url(); ?>">
                <img src="<?php echo nb_content('images', 'logo.png'); ?>" />
                 <h1 style="font-family: 'Orbitron', sans-serif; ">Restore Watches</h1>  
            </a>
            
           
            <a href="javascript:;" class="menu-btn"><span class="menu-btn icon-open-menu"></span></a>
            <a href="javascript:;" class="menu-btn"><span class="menu-btn icon-close-menu"></span></a>
            <div class="header-menu-mobile">
                <?php
                wp_nav_menu(array(
                    'container' => false,
                    'sort_column' => 'menu_order',
                    'theme_location' => 'Header Menu',
                    'menu_class' => 'menu',
                ));
                ?>
            </div>
            <?php
            wp_nav_menu(array(
                'container' => false,
                'sort_column' => 'menu_order',
                'theme_location' => 'Header Menu',
                'menu_class' => 'menu',
            ));
            ?>
            <div class="lang">
                <?php get_language_switcher(); ?>
            </div>
            <div class="search-box">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php
        if (hasPagePicture()) {
            ?>
            <?php get_template_part('page-header'); ?>
        <?php }
        ?>
        <div class="push-footer-down">
            <script type="text/javascript">
                $(function () {
                    $('.header').sticky();
                });
            $(function () {
                $(".icon-open-menu").click(function () {
                    $(".header").addClass("open-menu");
                    $(".header").removeClass("close-menu");
                    return false;
                });
                $(".icon-close-menu").click(function () {
                    $(".header").addClass("close-menu");
                    $(".header").removeClass("open-menu");
                    return false;
                });
            });

        </script>

