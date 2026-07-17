<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Identity{
  public static function init(){
    add_action('init',array('ZC_System_Identity','setup'));
    add_action('show_user_profile',array('ZC_System_Identity','profile_fields'));
    add_action('edit_user_profile',array('ZC_System_Identity','profile_fields'));
    add_action('personal_options_update',array('ZC_System_Identity','save_fields'));
    add_action('edit_user_profile_update',array('ZC_System_Identity','save_fields'));
    add_filter('avatar_defaults',array('ZC_System_Identity','avatar_defaults'));
    add_shortcode('zc_user_card',array('ZC_System_Identity','user_card_shortcode'));
  }
  public static function setup(){
    // Register custom user roles
    if(!get_role('premium_member')){
      add_role('premium_member',__('Premium Member','zincelestial'),array('read'=>true,'upload_files'=>true));
    }
  }
  public static function profile_fields($user){
    ?>
    <div class="zc-profile-fields">
      <h3><?php esc_html_e('ZinCelestial Profile','zincelestial');?></h3>
      <table class="form-table">
        <tr><th><label for="zc_bio_extended"><?php esc_html_e('Extended Bio','zincelestial');?></label></th>
          <td><textarea name="zc_bio_extended" id="zc_bio_extended" rows="4" class="large-text"><?php echo esc_textarea(get_user_meta($user->ID,'zc_bio_extended',true));?></textarea></td>
        </tr>
        <tr><th><label for="zc_social_twitter"><?php esc_html_e('Twitter/X URL','zincelestial');?></label></th>
          <td><input type="url" name="zc_social_twitter" id="zc_social_twitter" value="<?php echo esc_attr(get_user_meta($user->ID,'zc_social_twitter',true));?>" class="regular-text"></td>
        </tr>
        <tr><th><label for="zc_verified"><?php esc_html_e('Verified Badge','zincelestial');?></label></th>
          <td><input type="checkbox" name="zc_verified" id="zc_verified" value="1" <?php checked(get_user_meta($user->ID,'zc_verified',true),'1');?>></td>
        </tr>
      </table>
    </div>
    <?php
  }
  public static function save_fields($user_id){
    if(!current_user_can('edit_user',$user_id))return;
    update_user_meta($user_id,'zc_bio_extended',sanitize_textarea_field($_POST['zc_bio_extended']??''));
    update_user_meta($user_id,'zc_social_twitter',esc_url_raw($_POST['zc_social_twitter']??''));
    update_user_meta($user_id,'zc_verified',isset($_POST['zc_verified'])?'1':'0');
  }
  public static function avatar_defaults($defaults){
    $defaults[ZC_URI.'/assets/img/default-avatar.svg']=__('ZinCelestial Default','zincelestial');
    return $defaults;
  }
  public static function user_card_shortcode($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    $u=get_userdata($a['user_id']);
    if(!$u)return '';
    ob_start();
    ?>
    <div class="zc-user-card">
      <img src="<?php echo esc_url(get_avatar_url($a['user_id'],array('size'=>60)));?>" class="zc-user-card__avatar" alt="<?php echo esc_attr($u->display_name);?>">
      <div class="zc-user-card__info">
        <span class="zc-user-card__name"><?php echo esc_html($u->display_name);?></span>
        <?php if(get_user_meta($a['user_id'],'zc_verified',true)==='1'): ?>
          <span class="zc-verified-badge" title="<?php esc_attr_e('Verified','zincelestial');?>">✓</span>
        <?php endif; ?>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }
}
ZC_System_Identity::init();
