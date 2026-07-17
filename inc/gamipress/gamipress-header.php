<?php
if(!defined('ABSPATH'))exit;
class ZC_GamiPress_Header{
  public static function init(){
    add_action('zc_gamipress_bar',array('ZC_GamiPress_Header','render_bar'));
    add_action('wp_ajax_zc_gamipress_data',array('ZC_GamiPress_Header','ajax_data'));
    add_shortcode('zc_gamipress_bar',array('ZC_GamiPress_Header','shortcode'));
    add_action('init',array('ZC_GamiPress_Header','register_shortcodes'));
  }
  public static function register_shortcodes(){
    add_shortcode('zc_user_points',array('ZC_GamiPress_Header','sc_points'));
    add_shortcode('zc_user_rank',array('ZC_GamiPress_Header','sc_rank'));
    add_shortcode('zc_user_level',array('ZC_GamiPress_Header','sc_level'));
    add_shortcode('zc_user_badges',array('ZC_GamiPress_Header','sc_badges'));
    add_shortcode('zc_xp_bar',array('ZC_GamiPress_Header','sc_xp_bar'));
  }
  public static function get_user_data($user_id=null){
    if(!$user_id)$user_id=get_current_user_id();
    if(!$user_id)return array();
    $data=array('user_id'=>$user_id);
    if(function_exists('gamipress_get_user_points')){
      $data['gzcreds']=gamipress_get_user_points($user_id,'gzcreds');
      $data['rubies']=gamipress_get_user_points($user_id,'rubies');
      $data['zcreds']=gamipress_get_user_points($user_id,'zcreds');
      $data['special_zcreds']=gamipress_get_user_points($user_id,'special-zcreds');
    } else {
      $data['gzcreds']=$data['rubies']=$data['zcreds']=$data['special_zcreds']=0;
    }
    if(function_exists('gamipress_get_user_rank')){
      $rank=gamipress_get_user_rank($user_id);
      $data['rank_label']=$rank?get_the_title($rank->ID):__('Newcomer','zincelestial');
      $data['rank_id']=$rank?$rank->ID:0;
    } else {
      $data['rank_label']=__('Newcomer','zincelestial');
      $data['rank_id']=0;
    }
    // XP / level from user meta fallback
    $data['xp']=(int)get_user_meta($user_id,'_gamipress_xp',true);
    $data['xp_next']=(int)get_user_meta($user_id,'_gamipress_xp_next',true)?:1000;
    $data['level']=(int)get_user_meta($user_id,'_gamipress_level',true)?:1;
    // Badges count
    $data['badges_count']=(int)get_user_meta($user_id,'_gamipress_badges_count',true)?:0;
    // Avatar
    $data['avatar']=get_avatar_url($user_id,array('size'=>40));
    $data['display_name']=get_userdata($user_id)->display_name;
    return $data;
  }
  public static function render_bar($user_id=null){
    if(!is_user_logged_in())return;
    if(!$user_id)$user_id=get_current_user_id();
    $d=self::get_user_data($user_id);
    $opts=array(
      'show_xp_bar'    =>zc_option('gp_show_xp_bar','1'),
      'show_gzcreds'   =>zc_option('gp_show_gzcreds','1'),
      'show_rubies'    =>zc_option('gp_show_rubies','1'),
      'show_zcreds'    =>zc_option('gp_show_zcreds','1'),
      'show_rank'      =>zc_option('gp_show_rank','1'),
      'show_badges'    =>zc_option('gp_show_badges','1'),
      'show_level'     =>zc_option('gp_show_level','1'),
    );
    $xp_pct=$d['xp_next']>0?round(($d['xp']/$d['xp_next'])*100,1):0;
    ?>
    <div class="zc-gamipress-bar bar-progress-info" data-user-id="<?php echo esc_attr($user_id);?>">
      <div class="zc-gp-bar__avatar">
        <img src="<?php echo esc_url($d['avatar']);?>" alt="<?php echo esc_attr($d['display_name']);?>" width="36" height="36" class="zc-gp-bar__avatar-img">
      </div>
      <?php if($opts['show_level']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__level" title="<?php esc_attr_e('Level','zincelestial');?>">
        <span class="zc-gp-bar__icon">🏅</span>
        <span class="zc-gp-bar__value"><?php echo esc_html($d['level']);?></span>
        <span class="zc-gp-bar__label"><?php esc_html_e('Lvl','zincelestial');?></span>
      </div>
      <?php endif; if($opts['show_xp_bar']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__xp" title="<?php printf(esc_attr__('%d / %d XP','zincelestial'),$d['xp'],$d['xp_next']);?>">
        <div class="zc-xp-track">
          <div class="zc-xp-fill" style="width:<?php echo esc_attr($xp_pct);?>%"></div>
        </div>
        <span class="zc-gp-bar__value"><?php echo esc_html(number_format_i18n($d['xp']));?> XP</span>
      </div>
      <?php endif; if($opts['show_rank']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__rank" title="<?php esc_attr_e('Rank','zincelestial');?>">
        <span class="zc-gp-bar__icon">⭐</span>
        <span class="zc-gp-bar__value"><?php echo esc_html($d['rank_label']);?></span>
      </div>
      <?php endif; if($opts['show_gzcreds']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__gzcreds" title="GZCreds">
        <span class="zc-gp-bar__icon">💎</span>
        <span class="zc-gp-bar__value"><?php echo esc_html(number_format_i18n($d['gzcreds']));?></span>
        <span class="zc-gp-bar__label">GZC</span>
      </div>
      <?php endif; if($opts['show_rubies']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__rubies" title="Rubies">
        <span class="zc-gp-bar__icon">💠</span>
        <span class="zc-gp-bar__value"><?php echo esc_html(number_format_i18n($d['rubies']));?></span>
        <span class="zc-gp-bar__label"><?php esc_html_e('Rubies','zincelestial');?></span>
      </div>
      <?php endif; if($opts['show_zcreds']): ?>
      <div class="zc-gp-bar__item zc-gp-bar__zcreds" title="ZCreds">
        <span class="zc-gp-bar__icon">🪙</span>
        <span class="zc-gp-bar__value"><?php echo esc_html(number_format_i18n($d['zcreds']));?></span>
        <span class="zc-gp-bar__label">ZC</span>
      </div>
      <?php endif; if($opts['show_badges']&&$d['badges_count']>0): ?>
      <div class="zc-gp-bar__item zc-gp-bar__badges" title="<?php esc_attr_e('Badges earned','zincelestial');?>">
        <span class="zc-gp-bar__icon">🏆</span>
        <span class="zc-gp-bar__value"><?php echo esc_html($d['badges_count']);?></span>
        <span class="zc-gp-bar__label"><?php esc_html_e('Badges','zincelestial');?></span>
      </div>
      <?php endif; ?>
    </div>
    <?php
  }
  public static function ajax_data(){
    check_ajax_referer('zc_nonce','nonce');
    $user_id=intval($_POST['user_id']??get_current_user_id());
    wp_send_json_success(self::get_user_data($user_id));
  }
  public static function shortcode($atts){
    ob_start();
    self::render_bar();
    return ob_get_clean();
  }
  public static function sc_points($atts){
    $a=shortcode_atts(array('type'=>'zcreds','user_id'=>get_current_user_id()),$atts);
    if(!function_exists('gamipress_get_user_points'))return '0';
    return number_format_i18n(gamipress_get_user_points($a['user_id'],$a['type']));
  }
  public static function sc_rank($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    if(!function_exists('gamipress_get_user_rank'))return __('Newcomer','zincelestial');
    $r=gamipress_get_user_rank($a['user_id']);
    return $r?esc_html(get_the_title($r->ID)):__('Newcomer','zincelestial');
  }
  public static function sc_level($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    return esc_html(get_user_meta($a['user_id'],'_gamipress_level',true)?:1);
  }
  public static function sc_badges($atts){
    $a=shortcode_atts(array('user_id'=>get_current_user_id()),$atts);
    return esc_html(get_user_meta($a['user_id'],'_gamipress_badges_count',true)?:0);
  }
  public static function sc_xp_bar($atts){
    ob_start();
    self::render_bar();
    return ob_get_clean();
  }
}
ZC_GamiPress_Header::init();
add_action('wp_head',function(){do_action('zc_gamipress_bar');},11);
