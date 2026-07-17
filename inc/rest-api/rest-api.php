<?php
if(!defined('ABSPATH'))exit;
class ZC_REST_API{
  const NS='zincelestial/v1';
  public static function init(){
    add_action('rest_api_init',array('ZC_REST_API','register_routes'));
  }
  public static function register_routes(){
    // Theme options
    register_rest_route(self::NS,'/options',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_options'),'permission_callback'=>array('ZC_REST_API','admin_perm')),
      array('methods'=>'POST','callback'=>array('ZC_REST_API','save_options'),'permission_callback'=>array('ZC_REST_API','admin_perm')),
    ));
    // Color mode
    register_rest_route(self::NS,'/color-mode',array(
      array('methods'=>'POST','callback'=>array('ZC_REST_API','save_color_mode'),'permission_callback'=>'__return_true'),
    ));
    // Scheme
    register_rest_route(self::NS,'/scheme',array(
      array('methods'=>'POST','callback'=>array('ZC_REST_API','save_scheme'),'permission_callback'=>array('ZC_REST_API','logged_in')),
    ));
    // Reactions
    register_rest_route(self::NS,'/reactions/(?P<post_id>\d+)',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_reactions'),'permission_callback'=>'__return_true'),
      array('methods'=>'POST','callback'=>array('ZC_REST_API','add_reaction'),'permission_callback'=>array('ZC_REST_API','logged_in')),
    ));
    // GamiPress data
    register_rest_route(self::NS,'/gamipress/(?P<user_id>\d+)',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_gamipress'),'permission_callback'=>array('ZC_REST_API','logged_in')),
    ));
    // User profile
    register_rest_route(self::NS,'/profile/(?P<user_id>\d+)',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_profile'),'permission_callback'=>'__return_true'),
    ));
    // Trending posts
    register_rest_route(self::NS,'/trending',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_trending'),'permission_callback'=>'__return_true'),
    ));
    // Notifications
    register_rest_route(self::NS,'/notifications',array(
      array('methods'=>'GET','callback'=>array('ZC_REST_API','get_notifications'),'permission_callback'=>array('ZC_REST_API','logged_in')),
      array('methods'=>'POST','callback'=>array('ZC_REST_API','mark_read'),'permission_callback'=>array('ZC_REST_API','logged_in')),
    ));
  }
  public static function admin_perm($request){return current_user_can('edit_theme_options');}
  public static function logged_in($request){return is_user_logged_in();}
  public static function get_options($request){
    return rest_ensure_response(get_option('zincelestial_options',array()));
  }
  public static function save_options($request){
    $data=$request->get_json_params();
    $opts=get_option('zincelestial_options',array());
    foreach((array)$data as $k=>$v){$opts[sanitize_key($k)]=sanitize_text_field($v);}
    update_option('zincelestial_options',$opts);
    return rest_ensure_response(array('success'=>true,'options'=>$opts));
  }
  public static function save_color_mode($request){
    $mode=sanitize_key($request->get_param('mode')?:'dark');
    if(!in_array($mode,array('dark','light','auto','scheduled')))return new WP_Error('invalid','Invalid mode',array('status'=>400));
    if(is_user_logged_in())update_user_meta(get_current_user_id(),'zc_color_mode',$mode);
    return rest_ensure_response(array('mode'=>$mode));
  }
  public static function save_scheme($request){
    $scheme=sanitize_key($request->get_param('scheme')?:'cosmic');
    $premium=array('zenith','ember','twilight','nebula','solaris','quantum');
    if(in_array($scheme,$premium)&&!zc_user_is_premium())return new WP_Error('premium_required',__('Premium required','zincelestial'),array('status'=>403));
    update_user_meta(get_current_user_id(),'zc_template_scheme',$scheme);
    return rest_ensure_response(array('scheme'=>$scheme));
  }
  public static function get_reactions($request){
    $post_id=(int)$request['post_id'];
    $reactions=get_post_meta($post_id,'_zc_reactions',true)?:array();
    $user_reaction='';
    if(is_user_logged_in())$user_reaction=get_user_meta(get_current_user_id(),'_zc_reaction_'.$post_id,true)?:'';
    return rest_ensure_response(array('reactions'=>$reactions,'user_reaction'=>$user_reaction,'top'=>ZC_Reactions::get_top($reactions)));
  }
  public static function add_reaction($request){
    $post_id=(int)$request['post_id'];
    $type=sanitize_key($request->get_param('type')?:'');
    if(!in_array($type,ZC_Reactions::TYPES))return new WP_Error('invalid_type','Invalid reaction type',array('status'=>400));
    return rest_ensure_response(ZC_Reactions::save_reaction(get_current_user_id(),$post_id,$type));
  }
  public static function get_gamipress($request){
    $user_id=(int)$request['user_id'];
    return rest_ensure_response(ZC_GamiPress_Header::get_user_data($user_id));
  }
  public static function get_profile($request){
    $user_id=(int)$request['user_id'];
    $user=get_userdata($user_id);
    if(!$user)return new WP_Error('not_found','User not found',array('status'=>404));
    return rest_ensure_response(array(
      'id'=>$user_id,'display_name'=>$user->display_name,
      'avatar'=>get_avatar_url($user_id,array('size'=>80)),
      'url'=>get_author_posts_url($user_id),
    ));
  }
  public static function get_trending($request){
    $posts=get_posts(array('post_type'=>'post','posts_per_page'=>10,'meta_key'=>'_zc_reactions','orderby'=>'meta_value_num','order'=>'DESC'));
    $data=array();
    foreach($posts as $p){
      $reactions=get_post_meta($p->ID,'_zc_reactions',true)?:array();
      $top=ZC_Reactions::get_top($reactions);
      $data[]=array('id'=>$p->ID,'title'=>get_the_title($p),'url'=>get_permalink($p),'thumbnail'=>get_the_post_thumbnail_url($p,'zc-thumbnail'),'top_reaction'=>$top,'reaction_total'=>array_sum($reactions));
    }
    return rest_ensure_response($data);
  }
  public static function get_notifications($request){
    $user_id=get_current_user_id();
    if(function_exists('bp_notifications_get_notifications_for_user')){
      $notifs=bp_notifications_get_notifications_for_user($user_id,'array');
      return rest_ensure_response($notifs?:array());
    }
    return rest_ensure_response(array());
  }
  public static function mark_read($request){
    $user_id=get_current_user_id();
    if(function_exists('bp_notifications_mark_all_notifications_by_type')){
      bp_notifications_mark_all_notifications_by_type($user_id,'',0);
    }
    return rest_ensure_response(array('success'=>true));
  }
}
ZC_REST_API::init();
