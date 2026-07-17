<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Creation{
  public static function init(){
    add_action('init',array('ZC_System_Creation','post_types'));
    add_action('add_meta_boxes',array('ZC_System_Creation','meta_boxes'));
    add_action('save_post',array('ZC_System_Creation','save_meta'),10,2);
  }
  public static function post_types(){
    register_post_type('zc_gallery',array(
      'labels'=>array('name'=>__('Galleries','zincelestial'),'singular_name'=>__('Gallery','zincelestial')),
      'public'=>true,'show_in_rest'=>true,'supports'=>array('title','editor','thumbnail','excerpt'),
      'menu_icon'=>'dashicons-format-gallery','rewrite'=>array('slug'=>'gallery'),
    ));
    register_post_type('zc_showcase',array(
      'labels'=>array('name'=>__('Showcases','zincelestial'),'singular_name'=>__('Showcase','zincelestial')),
      'public'=>true,'show_in_rest'=>true,'supports'=>array('title','editor','thumbnail'),
      'menu_icon'=>'dashicons-portfolio','rewrite'=>array('slug'=>'showcase'),
    ));
  }
  public static function meta_boxes(){
    add_meta_box('zc_layout_meta',__('ZinCelestial Layout','zincelestial'),array('ZC_System_Creation','render_layout_meta'),array('post','page','zc_gallery','zc_showcase'),'side','default');
    add_meta_box('zc_membership_meta',__('ZinCelestial Access','zincelestial'),array('ZC_System_Creation','render_membership_meta'),array('post','page'),'side','default');
  }
  public static function render_layout_meta($post){
    wp_nonce_field('zc_meta_save','zc_meta_nonce');
    $layout=get_post_meta($post->ID,'_zc_sidebar_layout',true)?:'inherit';
    $scheme=get_post_meta($post->ID,'_zc_post_scheme',true)?:'';
    echo '<p><label>'.__('Sidebar Layout','zincelestial').'<br>';
    echo '<select name="_zc_sidebar_layout" class="widefat">';
    foreach(array('inherit'=>__('Inherit','zincelestial'),'right'=>__('Right','zincelestial'),'left'=>__('Left','zincelestial'),'both'=>__('Both','zincelestial'),'none'=>__('None','zincelestial')) as $v=>$l){
      echo '<option value="'.esc_attr($v).'" '.selected($layout,$v,false).'>'.esc_html($l).'</option>';
    }
    echo '</select></label></p>';
    echo '<p><label>'.__('Color Scheme','zincelestial').'<br><input type="text" name="_zc_post_scheme" value="'.esc_attr($scheme).'" class="widefat" placeholder="cosmic"></label></p>';
  }
  public static function render_membership_meta($post){
    $required=get_post_meta($post->ID,'_zc_membership_required',true);
    echo '<p><label>'.__('Access Level','zincelestial').'<br>';
    echo '<select name="_zc_membership_required" class="widefat">';
    foreach(array(''=>__('Open (All)','zincelestial'),'logged_in'=>__('Logged In','zincelestial'),'premium'=>__('Premium Only','zincelestial')) as $v=>$l){
      echo '<option value="'.esc_attr($v).'" '.selected($required,$v,false).'>'.esc_html($l).'</option>';
    }
    echo '</select></label></p>';
  }
  public static function save_meta($post_id,$post){
    if(!isset($_POST['zc_meta_nonce'])||!wp_verify_nonce($_POST['zc_meta_nonce'],'zc_meta_save'))return;
    if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE)return;
    if(!current_user_can('edit_post',$post_id))return;
    if(isset($_POST['_zc_sidebar_layout']))update_post_meta($post_id,'_zc_sidebar_layout',sanitize_key($_POST['_zc_sidebar_layout']));
    if(isset($_POST['_zc_post_scheme']))update_post_meta($post_id,'_zc_post_scheme',sanitize_key($_POST['_zc_post_scheme']));
    if(isset($_POST['_zc_membership_required']))update_post_meta($post_id,'_zc_membership_required',sanitize_key($_POST['_zc_membership_required']));
  }
}
ZC_System_Creation::init();
