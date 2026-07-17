<?php
if(!defined('ABSPATH'))exit;
class ZC_Integrations{
  public static function init(){
    add_action('after_setup_theme',array('ZC_Integrations','load_integrations'),20);
    add_filter('zc_integration_active',array('ZC_Integrations','check_active'),10,2);
  }
  public static function load_integrations(){
    self::elementor();
    self::dokan();
    self::wcfm();
    self::rtmedia();
    self::peepso();
    self::learndash();
    self::lifterlms();
    self::better_messages();
    self::youzify();
    self::aam();
    self::pmpro();
    self::ump();
    self::ads_pro();
  }
  public static function check_active($active,$plugin){
    return class_exists($plugin)||function_exists($plugin)||is_plugin_active($plugin.'.php');
  }
  public static function elementor(){
    if(!defined('ELEMENTOR_VERSION'))return;
    add_action('elementor/widgets/register',function($widgets_manager){do_action('zc_elementor_widgets',$widgets_manager);});
    add_action('elementor/documents/register',function(){do_action('zc_elementor_documents');});
    add_action('elementor/theme/register_locations',function($manager){
      $manager->register_location('header');
      $manager->register_location('footer');
      $manager->register_location('single');
    });
    // Let Elementor control page layout if Elementor template is used
    add_filter('zincelestial_page_layout',function($layout,$post_id){
      if(get_post_meta($post_id,'_elementor_edit_mode',true)==='builder')return'full-width';
      return $layout;
    },10,2);
  }
  public static function dokan(){
    if(!function_exists('dokan'))return;
    add_filter('dokan_force_load_scripts',function(){return true;});
    add_action('dokan_dashboard_wrap_start',function(){echo '<div class="zc-dokan-wrap">';});
    add_action('dokan_dashboard_wrap_end',function(){echo '</div>';});
  }
  public static function wcfm(){
    if(!defined('WCFM_VERSION'))return;
    add_action('wcfm_after_init',function(){do_action('zc_wcfm_init');});
  }
  public static function rtmedia(){
    if(!class_exists('RTMedia'))return;
    add_filter('rtmedia_activity_view_media',function($view){return $view;});
  }
  public static function peepso(){
    if(!class_exists('PeepSo'))return;
    add_action('peepso_template_part',function($part){get_template_part('peepso/'.$part);},10,1);
  }
  public static function learndash(){
    if(!defined('LEARNDASH_VERSION'))return;
    add_filter('learndash-course-steps-all',function($steps){return $steps;});
    add_action('learndash_content_tabs_before',function(){echo '<div class="zc-ld-wrap">';});
    add_action('learndash_content_tabs_after',function(){echo '</div>';});
  }
  public static function lifterlms(){
    if(!class_exists('LifterLMS'))return;
    add_action('lifterlms_content_wrapper_start',function(){echo '<div class="zc-llms-wrap">';});
    add_action('lifterlms_content_wrapper_end',function(){echo '</div>';});
  }
  public static function better_messages(){
    if(!function_exists('Better_Messages'))return;
    add_filter('better_messages_options',function($opts){
      $opts['skin']='zincelestial';
      return $opts;
    });
  }
  public static function youzify(){
    if(!function_exists('youzify'))return;
    add_filter('youzify_profile_tabs',function($tabs){return $tabs;});
  }
  public static function aam(){
    if(!class_exists('AAM'))return;
    add_action('aam_init',function(){do_action('zc_aam_init');});
  }
  public static function pmpro(){
    if(!function_exists('pmpro_hasMembershipLevel'))return;
    add_action('pmpro_checkout_after_html',function(){do_action('zc_pmpro_after_checkout');});
  }
  public static function ump(){
    if(!class_exists('Membership_Ultra_Pro'))return;
    add_action('ump_registration_form',function(){do_action('zc_ump_reg_form');});
  }
  public static function ads_pro(){
    if(!function_exists('ap_option'))return;
    add_action('zc_ad_slot',function($slot,$size='728x90'){
      if(function_exists('ap_ad_zone'))echo ap_ad_zone($slot);
    },10,2);
  }
}
ZC_Integrations::init();
