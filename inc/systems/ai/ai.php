<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_AI{
  public static function init(){
    add_action('wp_ajax_zc_ai_generate',array('ZC_System_AI','generate'));
    add_action('wp_ajax_zc_ai_summarize',array('ZC_System_AI','summarize'));
    add_action('wp_ajax_zc_ai_translate',array('ZC_System_AI','translate'));
    add_shortcode('zc_ai_summary',array('ZC_System_AI','summary_shortcode'));
    add_action('save_post',array('ZC_System_AI','auto_generate_meta'),20,2);
  }
  public static function generate(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error();return;}
    $prompt=sanitize_textarea_field($_POST['prompt']??'');
    if(!$prompt){wp_send_json_error(__('Prompt required','zincelestial'));return;}
    $api_key=zc_option('openai_api_key','');
    if(!$api_key){wp_send_json_error(__('AI not configured','zincelestial'));return;}
    $response=self::call_openai($api_key,$prompt);
    if(is_wp_error($response)){wp_send_json_error($response->get_error_message());return;}
    wp_send_json_success(array('text'=>$response));
  }
  public static function summarize(){
    check_ajax_referer('zc_nonce','nonce');
    $post_id=intval($_POST['post_id']??0);
    $cached=get_transient('zc_ai_summary_'.$post_id);
    if($cached){wp_send_json_success(array('summary'=>$cached));return;}
    $content=wp_strip_all_tags(get_post_field('post_content',$post_id));
    $content=substr($content,0,3000);
    $api_key=zc_option('openai_api_key','');
    if(!$api_key){wp_send_json_success(array('summary'=>wp_trim_words($content,50)));return;}
    $summary=self::call_openai($api_key,'Summarize this in 2-3 sentences: '.$content);
    if(!is_wp_error($summary)){
      set_transient('zc_ai_summary_'.$post_id,$summary,DAY_IN_SECONDS);
      wp_send_json_success(array('summary'=>$summary));
    } else {
      wp_send_json_success(array('summary'=>wp_trim_words($content,50)));
    }
  }
  public static function translate(){
    check_ajax_referer('zc_nonce','nonce');
    $text=sanitize_textarea_field($_POST['text']??'');
    $lang=sanitize_text_field($_POST['lang']??'en');
    $api_key=zc_option('openai_api_key','');
    if(!$api_key||!$text){wp_send_json_error();return;}
    $result=self::call_openai($api_key,'Translate to '.$lang.': '.$text);
    wp_send_json_success(array('translation'=>is_wp_error($result)?$text:$result));
  }
  private static function call_openai($api_key,$prompt){
    $resp=wp_remote_post('https://api.openai.com/v1/chat/completions',array(
      'headers'=>array('Authorization'=>'Bearer '.$api_key,'Content-Type'=>'application/json'),
      'body'=>json_encode(array('model'=>'gpt-3.5-turbo','messages'=>array(array('role'=>'user','content'=>$prompt)),'max_tokens'=>500)),
      'timeout'=>30,
    ));
    if(is_wp_error($resp))return $resp;
    $body=json_decode(wp_remote_retrieve_body($resp),true);
    return $body['choices'][0]['message']['content']??new WP_Error('ai_error','No response');
  }
  public static function auto_generate_meta($post_id,$post){
    if(!zc_option('ai_auto_excerpt','0')||$post->post_excerpt||$post->post_status!=='publish')return;
    if(!zc_option('openai_api_key',''))return;
    $content=wp_strip_all_tags($post->post_content);
    $summary=self::call_openai(zc_option('openai_api_key',''),'Write a 1-sentence excerpt: '.substr($content,0,500));
    if(!is_wp_error($summary)){
      wp_update_post(array('ID'=>$post_id,'post_excerpt'=>sanitize_textarea_field($summary)));
    }
  }
  public static function summary_shortcode($atts){
    $a=shortcode_atts(array('post_id'=>get_the_ID()),$atts);
    $cached=get_transient('zc_ai_summary_'.$a['post_id']);
    if($cached)return '<div class="zc-ai-summary">'.wp_kses_post($cached).'</div>';
    return '';
  }
}
ZC_System_AI::init();
