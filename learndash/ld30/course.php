<?php
/**
 * ZinCelestial — LearnDash Course Template
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div id="zc-ld-course" class="zc-ld-wrap zc-ld-course-page">
	<div class="zc-container">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="zc-ld-course__header">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="zc-ld-course__hero-thumb">
						<?php the_post_thumbnail( 'large', [ 'class' => 'zc-ld-course__hero-img', 'loading' => 'eager' ] ); ?>
					</div>
				<?php endif; ?>
				<div class="zc-ld-course__header-content">
					<h1 class="zc-ld-course__title"><?php the_title(); ?></h1>
					<div class="zc-ld-course__meta">
						<?php if ( function_exists( 'learndash_get_course_steps_count' ) ) : ?>
							<span class="zc-chip">
								<i class="zc-icon zc-icon--book-open" aria-hidden="true"></i>
								<?php printf(
									esc_html( _n( '%d Lesson', '%d Lessons', learndash_get_course_steps_count( get_the_ID() ), 'zincelestial' ) ),
									learndash_get_course_steps_count( get_the_ID() )
								); ?>
							</span>
						<?php endif; ?>
						<?php if ( function_exists( 'learndash_get_course_enrolled_users_count' ) ) : ?>
							<span class="zc-chip">
								<i class="zc-icon zc-icon--users" aria-hidden="true"></i>
								<?php printf(
									esc_html( _n( '%d Student', '%d Students', learndash_get_course_enrolled_users_count( get_the_ID() ), 'zincelestial' ) ),
									learndash_get_course_enrolled_users_count( get_the_ID() )
								); ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="zc-ld-course__excerpt"><?php the_excerpt(); ?></div>
					<?php if ( function_exists( 'ld_course_access_button' ) ) : ?>
						<div class="zc-ld-course__cta">
							<?php ld_course_access_button( get_the_ID() ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="zc-ld-course__body">
				<div class="zc-ld-course__content">
					<?php the_content(); ?>
				</div>
				<aside class="zc-ld-course__sidebar">
					<?php do_action( 'learndash-course-infobar-access-button-cell', get_the_ID(), get_current_user_id() ); ?>
				</aside>
			</div>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer();
