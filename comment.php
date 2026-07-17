<?php
/**
 * ZinCelestial — comment.php
 * Callback for a single comment.
 */
if ( ! function_exists( 'zc_comment_callback' ) ) :
function zc_comment_callback( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'zc-comment', $comment ); ?>>
      <article class="zc-comment__inner">
        <div class="zc-comment__avatar"><?php echo get_avatar( $comment, 48, '', '', array('class'=>'zc-comment__avatar-img') ); ?></div>
        <div class="zc-comment__body">
          <header class="zc-comment__header">
            <div class="zc-comment__author"><?php echo get_comment_author_link( $comment ); ?></div>
            <time class="zc-comment__time" datetime="<?php comment_time('c'); ?>">
              <a href="<?php echo esc_url( get_comment_link($comment) ); ?>"><?php printf( esc_html__('%1$s at %2$s','zincelestial'), get_comment_date('',  $comment), get_comment_time() ); ?></a>
            </time>
          </header>
          <div class="zc-comment__content"><?php comment_text(); ?></div>
          <footer class="zc-comment__footer">
            <?php comment_reply_link( array_merge($args, array('add_below'=>'comment','depth'=>$depth,'max_depth'=>$args['max_depth'],'before'=>'<div class="zc-comment__reply">','after'=>'</div>')) ); ?>
          </footer>
        </div>
      </article>
    <?php
}
endif;
