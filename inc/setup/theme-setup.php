<?php
if(!defined('ABSPATH'))exit;
class ZC_Theme_Setup{
  public static function init(){
    add_action('after_setup_theme',array('ZC_Theme_Setup','setup'),1);
    add_action('after_setup_theme',array('ZC_Theme_Setup','image_sizes'),2);
    add_filter('body_class',array('ZC_Theme_Setup','body_classes'));
  }
  public static function setup(){
    // Load textdomain immediately in after_setup_theme (WP 6.7+ compatible)
    // Must happen before any __() calls — matches Twenty Twenty-Three pattern
    load_theme_textdomain(ZC_TEXT,ZC_DIR.'/languages');
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo',array('height'=>80,'width'=>260,'flex-height'=>true,'flex-width'=>true));
    add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_theme_support('post-formats',array('gallery','image','video','audio','quote','link','status','aside','chat'));
    add_theme_support('woocommerce',array('thumbnail_image_width'=>600,'single_image_width'=>800));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
  }
  public static function image_sizes(){
    add_image_size('zc-thumbnail',420,280,true);
    add_image_size('zc-medium',800,500,true);
    add_image_size('zc-wide',1440,600,true);
    add_image_size('zc-square',400,400,true);
    add_image_size('zc-portrait',400,560,true);
    add_image_size('zc-avatar',120,120,true);
    add_image_size('zc-cover',1200,350,true);
  }
  public static function body_classes($classes){
    $classes[]='zc-v3';
    $classes[]='zc-scheme-'.sanitize_html_class(zc_get_active_scheme());
    $classes[]='zc-layout-'.sanitize_html_class(zc_sidebar_layout());
    if(is_user_logged_in())$classes[]='zc-logged-in';
    if(zc_user_is_premium())$classes[]='zc-premium';
    if(is_multisite()&&!is_main_site())$classes[]='zc-subsite';
    return $classes;
  }
}
ZC_Theme_Setup::init();
