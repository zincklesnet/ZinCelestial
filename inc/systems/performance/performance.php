<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Performance{
  public static function init(){
    add_action('wp_head',array('ZC_System_Performance','preload_assets'),2);
    add_action('wp_head',array('ZC_System_Performance','dns_prefetch'),1);
    add_filter('wp_resource_hints',array('ZC_System_Performance','resource_hints'),10,2);
    add_action('save_post',array('ZC_System_Performance','purge_cache'));
    add_action('switch_theme',array('ZC_System_Performance','purge_all_caches'));
    add_filter('script_loader_tag',array('ZC_System_Performance','defer_scripts'),10,3);
  }
  public static function preload_assets(){
    if(zc_option('enable_preload','1')!=='1')return;
    $font_url='https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Syne:wght@700&display=swap';
    echo '<link rel="preload" href="'.esc_url(ZC_ASSETS.'/css/core.css').'" as="style">'."
";
    echo '<link rel="preload" href="'.esc_url(ZC_ASSETS.'/js/core.js').'" as="script">'."
";
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>'."
";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'."
";
  }
  public static function dns_prefetch(){
    echo '<link rel="dns-prefetch" href="//ajax.googleapis.com">'."
";
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">'."
";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">'."
";
  }
  public static function resource_hints($hints,$type){
    if($type==='preconnect'){
      $hints[]=array('href'=>'https://fonts.googleapis.com','crossorigin'=>'anonymous');
      $hints[]=array('href'=>'https://fonts.gstatic.com','crossorigin'=>'anonymous');
    }
    return $hints;
  }
  public static function purge_cache($post_id){
    delete_transient('zc_trending');
    delete_transient('zc_post_meta_'.$post_id);
    do_action('zc_cache_purged',$post_id);
  }
  public static function purge_all_caches(){
    global $wpdb;
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_zc_%'");
  }
  public static function defer_scripts($tag,$handle,$src){
    $defer=array('zincelestial-core','zincelestial-reactions','zincelestial-gamipress');
    if(in_array($handle,$defer))return str_replace('<script ','<script defer ',$tag);
    return $tag;
  }
}
ZC_System_Performance::init();
