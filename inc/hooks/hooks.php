<?php
if(!defined('ABSPATH'))exit;
/**
 * ZinCelestial — Global Hooks
 * v3.3 Fix: meta_tags() no longer calls get_the_excerpt() (caused recursive
 *           the_content → lazy_load → excerpt fatal chain). Instead reads
 *           post_excerpt/post_content directly from global $post.
 */
class ZC_Hooks{
  public static function init(){
    add_action('wp_head',array('ZC_Hooks','meta_tags'),1);
    add_filter('excerpt_length',array('ZC_Hooks','excerpt_length'));
    add_filter('excerpt_more',array('ZC_Hooks','excerpt_more'));
    add_filter('wp_title',array('ZC_Hooks','page_title'),10,2);
    add_filter('the_content',array('ZC_Hooks','content_wrap'));
    add_action('wp_footer',array('ZC_Hooks','footer_scripts'));
    add_filter('get_avatar',array('ZC_Hooks','enhanced_avatar'),10,6);
    add_filter('comment_form_defaults',array('ZC_Hooks','comment_form'));
    add_action('save_post',array('ZC_Hooks','clear_post_cache'));
    add_filter('body_class',array('ZC_Hooks','add_body_class'));
    add_action('zc_after_post_content',array('ZC_Hooks','post_sharing_bar'));
    add_action('zc_reactions_bar',array('ZC_Hooks','render_reactions_bar'),10,2);
    // Trending reaction badge on thumbnails
    add_filter('post_thumbnail_html',array('ZC_Hooks','add_reaction_overlay'),10,5);
  }

  /**
   * Output <meta> tags in <head>.
   *
   * Bug fix v3.3: Never call get_the_excerpt() here — that triggers the_content
   * filter which triggers lazy_load which causes a fatal recursive chain.
   * Read $post->post_excerpt or $post->post_content directly instead.
   */
  public static function meta_tags(){
    echo '<meta name="generator" content="ZinCelestial v'.ZC_VERSION.'">'."\n";
    if(is_singular()){
      global $post;
      if($post instanceof WP_Post){
        $desc='';
        if(!empty($post->post_excerpt)){
          // Use manual excerpt — safe, no filters
          $desc=wp_strip_all_tags($post->post_excerpt);
        }elseif(!empty($post->post_content)){
          // Strip shortcodes + tags from raw content
          $desc=wp_strip_all_tags(strip_shortcodes($post->post_content));
        }
        if($desc){
          $desc=wp_trim_words($desc,25,'');
          echo '<meta name="description" content="'.esc_attr($desc).'">'."\n";
        }
        // Open Graph basics
        if($desc)echo '<meta property="og:description" content="'.esc_attr($desc).'">'."\n";
        echo '<meta property="og:title" content="'.esc_attr(get_the_title($post->ID)).'">'."\n";
        echo '<meta property="og:url" content="'.esc_attr(get_permalink($post->ID)).'">'."\n";
        if(has_post_thumbnail($post->ID)){
          $img=get_the_post_thumbnail_url($post->ID,'large');
          if($img)echo '<meta property="og:image" content="'.esc_url($img).'">'."\n";
        }
      }
    }
  }

  public static function excerpt_length(){return intval(zc_option('excerpt_length',30));}

  public static function excerpt_more($more){
    return '&hellip;<a class="zc-read-more" href="'.get_permalink().'">'.esc_html__('Read more','zincelestial').'</a>';
  }

  public static function page_title($title,$sep){return $title;}

  public static function content_wrap($content){
    if(!in_the_loop()||!is_main_query())return $content;
    return '<div class="zc-entry-body">'.$content.'</div>';
  }

  public static function footer_scripts(){
    echo "\n<!-- ZinCelestial v".ZC_VERSION." -->\n";
  }

  public static function enhanced_avatar($avatar,$id_or_email,$size,$default,$alt,$args){
    return str_replace("class='avatar","class='zc-avatar avatar",$avatar);
  }

  public static function comment_form($args){
    $args['class_form']='zc-comment-form';
    $args['submit_button']='<button name="%1$s" type="submit" id="%2$s" class="%3$s zc-btn zc-btn--primary" value="%4$s">%4$s</button>';
    return $args;
  }

  public static function clear_post_cache($post_id){
    delete_transient('zc_post_meta_'.$post_id);
  }

  public static function add_body_class($classes){
    global $post;
    if(isset($post)){
      $layout=get_post_meta($post->ID,'_zc_sidebar_layout',true);
      if($layout)$classes[]='zc-post-layout-'.$layout;
    }
    // Reaction class for js targeting
    if(zc_option('reactions_enabled','1')==='1')$classes[]='zc-reactions-enabled';
    return $classes;
  }

  public static function post_sharing_bar($post_id){
    if(!zc_option('show_sharing_bar','1'))return;
    $url=urlencode(get_permalink($post_id));
    $title=urlencode(get_the_title($post_id));
    echo '<div class="zc-sharing-bar">';
    echo '<span class="zc-sharing-bar__label">'.esc_html__('Share','zincelestial').'</span>';
    // Twitter/X
    echo '<a class="zc-share-btn zc-share-btn--twitter" href="https://twitter.com/intent/tweet?url='.$url.'&text='.$title.'" target="_blank" rel="noopener" title="Twitter">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>';
    echo '</a>';
    // Facebook
    echo '<a class="zc-share-btn zc-share-btn--facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$url.'" target="_blank" rel="noopener" title="Facebook">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>';
    echo '</a>';
    // Copy link
    echo '<button class="zc-share-btn zc-share-btn--copy" data-url="'.esc_attr(get_permalink($post_id)).'" title="'.esc_attr__('Copy link','zincelestial').'">';
    echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>';
    echo '</button>';
    echo '</div>';
  }

  /**
   * Overlay badge showing top reaction on post thumbnails (Boombox/VBuzz style).
   */
  public static function add_reaction_overlay($html,$post_id,$post_thumbnail_id,$size,$attr){
    if(!zc_option('reactions_overlay_enabled','1'))return $html;
    if(is_admin())return $html;
    $top=function_exists('zc_get_top_reaction')?zc_get_top_reaction($post_id):null;
    if(!$top)return $html;
    $emojis=array(
      'fire'=>'🔥','star'=>'⭐','love'=>'❤️','wow'=>'😮',
      'laugh'=>'😂','sad'=>'😢','angry'=>'😡','rocket'=>'🚀',
    );
    $emoji=isset($emojis[$top['type']])?$emojis[$top['type']]:'👍';
    $overlay='<span class="zc-reaction-overlay" aria-hidden="true">'
      .'<span class="zc-reaction-overlay__emoji">'.$emoji.'</span>'
      .'<span class="zc-reaction-overlay__count">'.intval($top['count']).'</span>'
      .'</span>';
    return $html.$overlay;
  }

  public static function render_reactions_bar($post_id,$post_type){
    if(!zc_option('reactions_enabled','1'))return;
    $types=array('fire'=>'🔥','star'=>'⭐','love'=>'❤️','wow'=>'😮','laugh'=>'😂','sad'=>'😢','angry'=>'😡','rocket'=>'🚀');
    $counts=get_post_meta($post_id,'_zc_reactions',true);
    if(!$counts)$counts=array();
    $user_reaction='';
    if(is_user_logged_in()){
      $user_reaction=get_user_meta(get_current_user_id(),'_zc_reaction_'.$post_id,true);
    }
    $total=array_sum($counts);
    echo '<div class="zc-reactions" data-post-id="'.intval($post_id).'" data-post-type="'.esc_attr($post_type).'">';
    echo '<div class="zc-reactions__toggle">';
    echo '<span class="zc-reactions__icon">👍</span>';
    echo '<span class="zc-reactions__label">'.esc_html__('React','zincelestial').'</span>';
    if($total>0)echo '<span class="zc-reactions__total">'.intval($total).'</span>';
    echo '</div>';
    echo '<div class="zc-reactions__picker" role="dialog" aria-label="'.esc_attr__('Choose reaction','zincelestial').'">';
    foreach($types as $key=>$emoji){
      $count=isset($counts[$key])?(int)$counts[$key]:0;
      $active=$user_reaction===$key?' zc-reaction--active':'';
      echo '<button class="zc-reaction'.$active.'" data-type="'.esc_attr($key).'" title="'.esc_attr(ucfirst($key)).'">';
      echo '<span class="zc-reaction__emoji">'.$emoji.'</span>';
      if($count>0)echo '<span class="zc-reaction__count">'.intval($count).'</span>';
      echo '</button>';
    }
    echo '</div></div>';
  }
}
ZC_Hooks::init();
