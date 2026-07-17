<?php
/**
 * ZinCelestial v5.0.0 — Comments Template
 */
if ( post_password_required() ) return;
?>
<div id="comments" class="zc-comments-area mt-5 pt-4 border-top">

  <?php if ( have_comments() ) : ?>
    <h2 class="zc-comments-title h4 fw-bold mb-4">
      <?php
      $count = get_comments_number();
      printf(
          esc_html( _nx( '%1$s Comment on "%2$s"', '%1$s Comments on "%2$s"', $count, 'comments title', 'zincelestial' ) ),
          number_format_i18n( $count ),
          '<span>' . get_the_title() . '</span>'
      );
      ?>
    </h2>

    <ol class="zc-comment-list list-unstyled">
      <?php
      wp_list_comments([
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 48,
          'callback'    => function( $comment, $args, $depth ) {
              ?>
              <li id="comment-<?php comment_ID(); ?>" <?php comment_class('zc-comment d-flex gap-3 mb-4'); ?>>
                <div class="flex-shrink-0">
                  <?php echo get_avatar( $comment, 48, '', '', ['class'=>'rounded-circle'] ); ?>
                </div>
                <div class="flex-grow-1">
                  <div class="zc-comment-body card border-0 bg-opacity-10 bg-secondary p-3 rounded-3">
                    <div class="zc-comment-meta d-flex align-items-center gap-2 mb-2">
                      <strong class="zc-comment-author"><?php comment_author_link(); ?></strong>
                      <time class="text-muted small" datetime="<?php comment_time('c'); ?>"><?php comment_date(); ?></time>
                      <?php if ( '0' === $comment->comment_approved ) : ?>
                      <span class="badge bg-warning text-dark"><?php esc_html_e('Awaiting Moderation','zincelestial'); ?></span>
                      <?php endif; ?>
                    </div>
                    <div class="zc-comment-text">
                      <?php comment_text(); ?>
                    </div>
                    <div class="zc-comment-actions mt-2">
                      <?php comment_reply_link( array_merge( $args, ['depth'=>$depth,'max_depth'=>$args['max_depth']] ) ); ?>
                      <?php edit_comment_link( __('Edit','zincelestial'), '<span class="ms-2 text-muted small">',' </span>' ); ?>
                    </div>
                  </div>
                </div>
              </li>
              <?php
          },
      ]);
      ?>
    </ol>

    <?php the_comments_pagination([
        'prev_text' => '<i class="bi bi-chevron-left"></i>',
        'next_text' => '<i class="bi bi-chevron-right"></i>',
    ]); ?>

  <?php endif; ?>

  <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
  <p class="text-muted"><?php esc_html_e('Comments are closed.','zincelestial'); ?></p>
  <?php endif; ?>

  <?php
  comment_form([
      'class_form'       => 'zc-comment-form mt-4',
      'title_reply'      => '<h3 class="h5 fw-bold">' . esc_html__('Leave a Reply','zincelestial') . '</h3>',
      'label_submit'     => __('Post Comment','zincelestial'),
      'class_submit'     => 'btn btn-primary',
      'comment_field'    => '<div class="mb-3"><label for="comment" class="form-label fw-semibold">' . esc_html__('Comment','zincelestial') . ' <span class="text-danger">*</span></label><textarea id="comment" name="comment" class="form-control" rows="5" required placeholder="' . esc_attr__('Share your thoughts…','zincelestial') . '"></textarea></div>',
  ]);
  ?>

</div>
