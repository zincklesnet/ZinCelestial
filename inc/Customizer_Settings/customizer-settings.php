<?php
if(!defined('ABSPATH'))exit;
// ZinCelestial Customizer Settings Manager
class ZC_Customizer_Settings{
  public static function init(){
    add_action('customize_save_after',array('ZC_Customizer_Settings','sync_to_options'));
  }
  public static function sync_to_options($wp_customize){
    $keys=['default_color_mode','sidebar_layout','sticky_header','show_gamipress_bar','show_compose_bar','show_topbar','footer_cols','footer_copyright','reactions_enabled','reactions_overlay','font_body','font_display','font_size_base','header_height','topbar_announcement','color_primary','color_secondary','color_accent','color_bg','color_surface','color_card','color_border','color_text'];
    $opts=get_option('zincelestial_options',array());
    foreach($keys as$k){
      $val=get_theme_mod($k);
      if($val!==false&&$val!=='')$opts[$k]=$val;
    }
    update_option('zincelestial_options',$opts);
  }
}
ZC_Customizer_Settings::init();
