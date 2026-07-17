<?php
if(!defined("ABSPATH"))exit;
if(!defined('ABSPATH'))exit;
class ZC_System_Support{
  public static function init(){
    add_action('init',array('ZC_System_Support','post_types'));
    add_action('wp_ajax_zc_submit_ticket',array('ZC_System_Support','submit_ticket'));
    add_shortcode('zc_support_form',array('ZC_System_Support','form_shortcode'));
    add_shortcode('zc_faq',array('ZC_System_Support','faq_shortcode'));
  }
  public static function post_types(){
    register_post_type('zc_ticket',array(
      'labels'=>array('name'=>__('Support Tickets','zincelestial'),'singular_name'=>__('Ticket','zincelestial')),
      'public'=>false,'show_ui'=>true,'capability_type'=>'post','menu_icon'=>'dashicons-sos',
      'supports'=>array('title','editor','comments'),'show_in_rest'=>false,
    ));
  }
  public static function submit_ticket(){
    check_ajax_referer('zc_nonce','nonce');
    if(!is_user_logged_in()){wp_send_json_error(__('Please log in','zincelestial'));return;}
    $title=sanitize_text_field($_POST['subject']??'');
    $message=sanitize_textarea_field($_POST['message']??'');
    if(!$title||!$message){wp_send_json_error(__('All fields required','zincelestial'));return;}
    $id=wp_insert_post(array('post_title'=>$title,'post_content'=>$message,'post_type'=>'zc_ticket','post_status'=>'publish','post_author'=>get_current_user_id()));
    if(is_wp_error($id)){wp_send_json_error($id->get_error_message());return;}
    do_action('zc_ticket_created',$id,get_current_user_id());
    wp_send_json_success(array('ticket_id'=>$id,'message'=>__('Ticket submitted successfully!','zincelestial')));
  }
  public static function form_shortcode($atts){
    if(!is_user_logged_in())return '<p>'.esc_html__('Please log in to submit a ticket.','zincelestial').'</p>';
    ob_start();?>
    <form class="zc-support-form" id="zc-support-form">
      <?php wp_nonce_field('zc_nonce','nonce');?>
      <div class="zc-form-field"><label><?php esc_html_e('Subject','zincelestial');?><input type="text" name="subject" class="zc-input" required></label></div>
      <div class="zc-form-field"><label><?php esc_html_e('Message','zincelestial');?><textarea name="message" class="zc-textarea" rows="6" required></textarea></label></div>
      <button type="submit" class="zc-btn zc-btn--primary"><?php esc_html_e('Submit Ticket','zincelestial');?></button>
      <div class="zc-form-response"></div>
    </form><?php
    return ob_get_clean();
  }
  public static function faq_shortcode($atts,$content=''){
    $a=shortcode_atts(array('category'=>''),$atts);
    $args=array('post_type'=>'faq','posts_per_page'=>20,'post_status'=>'publish');
    if($a['category'])$args['tax_query']=array(array('taxonomy'=>'faq_category','field'=>'slug','terms'=>$a['category']));
    $query=new WP_Query($args);
    if(!$query->have_posts())return '';
    ob_start();
    echo '<div class="zc-faq">';
    while($query->have_posts()){$query->the_post();
      echo '<div class="zc-faq__item"><button class="zc-faq__question">'.get_the_title().'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg></button>';
      echo '<div class="zc-faq__answer">'.wp_kses_post(get_the_content()).'</div></div>';
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
  }
}
ZC_System_Support::init();
