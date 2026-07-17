<?php
if(!defined('ABSPATH'))exit;
class ZC_Menu_Icons{
  public static function init(){
    add_action('wp_nav_menu_item_custom_fields',array('ZC_Menu_Icons','fields'),10,4);
    add_action('wp_update_nav_menu_item',array('ZC_Menu_Icons','save'),10,3);
    add_filter('nav_menu_css_class',array('ZC_Menu_Icons','classes'),10,4);
  }
  public static function fields($item_id,$item,$depth,$args){
    $icon=get_post_meta($item_id,'_zc_menu_icon',true);
    echo '<div class="zc-menu-icon-field"><label>'.esc_html__('Icon class (Lucide/Feather)','zincelestial').'<br>';
    echo '<input type="text" name="zc_menu_icon['.$item_id.']" value="'.esc_attr($icon).'" class="widefat"></label></div>';
  }
  public static function save($menu_id,$item_id,$args){
    if(isset($_POST['zc_menu_icon'][$item_id])){
      update_post_meta($item_id,'_zc_menu_icon',sanitize_text_field($_POST['zc_menu_icon'][$item_id]));
    }
  }
  public static function classes($classes,$item,$args,$depth){
    $icon=get_post_meta($item->ID,'_zc_menu_icon',true);
    if($icon)$classes[]='zc-has-icon zc-icon-'.$icon;
    return$classes;
  }
}
ZC_Menu_Icons::init();
