<?php
/**
 * ZinCelestial — LifterLMS Course Loop Item
 *
 * @package ZinCelestial
 */
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'llms_get_post' ) ) return;

$course = llms_get_post( get_the_ID() );
if ( ! $course ) return;
?>
<div class="zc-llms-course-card" itemscope itemtype="https://schema.org/Course">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="zc-llms-course-card__thumb">
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'medium', [ 'class' => 'zc-llms-course-card__img', 'loading' => 'lazy' ] ); ?>
			</a>
		</div>
	<?php endif; ?>
	<div class="zc-llms-course-card__body">
		<h3 class="zc-llms-course-card__title" itemprop="name">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<div class="zc-llms-course-card__meta">
			<span class="zc-chip">
				<i class="zc-icon zc-icon--book-open" aria-hidden="true"></i>
				<?php echo esc_html( $course->get( 'lesson_count' ) ); ?> <?php esc_html_e( 'lessons', 'zincelestial' ); ?>
			</span>
			<?php if ( $course->get( 'students_count' ) ) : ?>
				<span class="zc-chip">
					<i class="zc-icon zc-icon--users" aria-hidden="true"></i>
					<?php echo esc_html( $course->get( 'students_count' ) ); ?> <?php esc_html_e( 'students', 'zincelestial' ); ?>
				</span>
			<?php endif; ?>
		</div>
		<p class="zc-llms-course-card__excerpt"><?php the_excerpt(); ?></p>
		<div class="zc-llms-course-card__footer">
			<?php if ( function_exists( 'llms_get_enrollment_status' ) && llms_get_enrollment_status( get_current_user_id(), get_the_ID() ) ) : ?>
				<a href="<?php the_permalink(); ?>" class="zc-btn zc-btn--success zc-btn--sm">
					<i class="zc-icon zc-icon--play-circle" aria-hidden="true"></i>
					<?php esc_html_e( 'Continue', 'zincelestial' ); ?>
				</a>
			<?php else : ?>
				<a href="<?php the_permalink(); ?>" class="zc-btn zc-btn--primary zc-btn--sm">
					<?php esc_html_e( 'Enroll Now', 'zincelestial' ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
