<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial — Template Loader
 * v3.3 Fix: WooCommerce / BuddyPress / bbPress templates are only returned
 *           when the theme file actually EXISTS on disk. Otherwise the original
 *           $template is passed through so WC/BP handle their own rendering.
 *           This prevents a blank white screen when woocommerce.php is missing.
 */
class ZC_Template_Loader{
  public static function init(){
    add_filter('template_include',array('ZC_Template_Loader','load'),99);
    add_filter('page_template',array('ZC_Template_Loader','page_template_chooser'));
  }

  public static function load($template){
    // BuddyPress
    if(function_exists('is_buddypress')&&is_buddypress()){
      return self::locate('buddypress',$template);
    }
    // bbPress
    if(function_exists('is_bbpress')&&is_bbpress()){
      return self::locate('bbpress',$template);
    }
    // WooCommerce — only intercept if our wrapper file actually exists
    // Bug fix v3.3: removed unconditional return that caused blank pages when
    // woocommerce.php was missing from the theme directory.
    if(function_exists('is_woocommerce')&&(is_woocommerce()||is_cart()||is_checkout()||is_account_page())){
      return self::locate('woocommerce',$template);
    }
    // Dokan
    if(function_exists('is_dokan_store_page')&&is_dokan_store_page()){
      return self::locate('dokan',$template);
    }
    return $template;
  }

  /**
   * Return theme file if it exists, otherwise the original $fallback.
   * This is the critical bug fix — never return a non-existent file path.
   */
  public static function locate($type,$fallback){
    $file=get_template_directory().'/'.$type.'.php';
    return file_exists($file)?$file:$fallback;
  }

  public static function page_template_chooser($template){
    global $post;
    if(!$post)return $template;
    $zc_template=get_post_meta($post->ID,'_wp_page_template',true);
    if($zc_template&&$zc_template!=='default'){
      $file=get_template_directory().'/'.$zc_template;
      if(file_exists($file))return $file;
    }
    return $template;
  }

  /**
   * Include a template part by slug + optional name, with $args extracted.
   *
   * @param string $slug  Template slug (without .php)
   * @param string $name  Optional variation name
   * @param array  $args  Variables to extract into template scope
   */
  public static function get($slug,$name='',$args=array()){
    $templates=array();
    if($name)$templates[]=$slug.'-'.$name.'.php';
    $templates[]=$slug.'.php';
    foreach($templates as $t){
      $file=get_template_directory().'/template-parts/'.$t;
      if(file_exists($file)){
        if(!empty($args)){
          // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
          extract($args,EXTR_SKIP);
        }
        include $file;
        return;
      }
    }
  }
}
ZC_Template_Loader::init();
