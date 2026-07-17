<?php
if(!defined('ABSPATH'))exit;

// Must be inside after_setup_theme — __() calls here would fire before
// textdomain loads if called at file-include time (WP 6.7+ notice fix).
add_action('after_setup_theme', function(){
  add_theme_support('starter-content', array(
    'widgets' => array(
      'zc-sidebar-right' => array('text_about','search','recent-posts','categories'),
      'zc-footer-1'      => array('text_about'),
      'zc-footer-2'      => array('recent-posts'),
      'zc-footer-3'      => array('recent-comments'),
      'zc-footer-4'      => array('tag_cloud'),
    ),
    'nav_menus' => array(
      'zc-primary'  => array('name' => __('Primary Nav','zincelestial'), 'items' => array(
        'link_home' => array(), 'page_blog' => array(), 'page_about' => array(),
      )),
      'zc-footer-1' => array('name' => __('Footer 1','zincelestial'), 'items' => array(
        'link_home' => array(), 'page_about' => array(),
      )),
    ),
    'options' => array(
      'blogname'        => __('My ZinCelestial Site','zincelestial'),
      'blogdescription' => __('A Zinckles Multisite Community','zincelestial'),
    ),
    'theme_mods' => array('custom_logo' => 0),
    'posts' => array(
      'home' => array(
        'post_type'    => 'page',
        'post_title'   => 'Home',
        'post_content' => '<!-- wp:paragraph --><p>Welcome to ZinCelestial!</p><!-- /wp:paragraph -->',
      ),
    ),
  ));
}, 3);
