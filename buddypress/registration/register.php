<?php
/**
 * ZinCelestial v5.0.0 — BuddyPress Registration Page
 */
get_header();
$is_activated = false;
?>
<main id="primary" class="site-main">
<div class="zc-register-page py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">

        <div class="text-center mb-5">
          <?php if ( has_custom_logo() ) the_custom_logo(); ?>
          <h1 class="h2 fw-bold mt-3"><?php esc_html_e('Create Your Account','zincelestial'); ?></h1>
          <p class="text-muted"><?php esc_html_e('Join our community today.','zincelestial'); ?></p>
        </div>

        <?php if ( bp_registration_is_allowed() ) : ?>
        <div class="card border-0 shadow p-4 p-md-5">
          <?php do_action('bp_before_register_page'); ?>
          <form action="" name="signup_form" id="signup_form" class="needs-validation" novalidate method="post" enctype="multipart/form-data">

            <?php if ( bp_is_active('xprofile') ) : ?>
            <div class="zc-reg-step mb-4">
              <h5 class="fw-semibold mb-3 border-bottom pb-2"><?php esc_html_e('Profile Details','zincelestial'); ?></h5>
              <?php do_action('bp_before_account_details_fields'); ?>
              <div class="mb-3">
                <label for="signup_username" class="form-label fw-semibold"><?php esc_html_e('Username','zincelestial'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="signup_username" id="signup_username" class="form-control form-control-lg"
                  value="<?php bp_signup_username_value(); ?>" required autocomplete="username" autocorrect="off" autocapitalize="none">
                <?php bp_signup_username_errors(); ?>
              </div>
              <div class="mb-3">
                <label for="signup_email" class="form-label fw-semibold"><?php esc_html_e('Email Address','zincelestial'); ?> <span class="text-danger">*</span></label>
                <input type="email" name="signup_email" id="signup_email" class="form-control form-control-lg"
                  value="<?php bp_signup_email_value(); ?>" required autocomplete="email">
                <?php bp_signup_email_errors(); ?>
              </div>
              <div class="mb-3">
                <label for="signup_password" class="form-label fw-semibold"><?php esc_html_e('Password','zincelestial'); ?> <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" name="signup_password" id="signup_password" class="form-control form-control-lg"
                    autocomplete="new-password" required minlength="6">
                  <button class="btn btn-outline-secondary" type="button" id="togglePw">
                    <i class="bi bi-eye"></i>
                  </button>
                </div>
                <?php bp_signup_password_errors(); ?>
              </div>
              <div class="mb-3">
                <label for="signup_password_confirm" class="form-label fw-semibold"><?php esc_html_e('Confirm Password','zincelestial'); ?> <span class="text-danger">*</span></label>
                <input type="password" name="signup_password_confirm" id="signup_password_confirm" class="form-control form-control-lg"
                  autocomplete="new-password" required minlength="6">
                <?php bp_signup_password_confirm_errors(); ?>
              </div>
              <?php do_action('bp_after_account_details_fields'); ?>
            </div>
            <?php endif; ?>

            <?php if ( bp_is_active('xprofile') ) : ?>
            <div class="zc-reg-step mb-4">
              <h5 class="fw-semibold mb-3 border-bottom pb-2"><?php esc_html_e('Profile Information','zincelestial'); ?></h5>
              <?php do_action('bp_before_signup_profile_fields'); ?>
              <?php bp_signup_profile_fields(); ?>
              <?php do_action('bp_after_signup_profile_fields'); ?>
            </div>
            <?php endif; ?>

            <?php if ( bp_get_blog_signup_allowed() ) : ?>
            <div class="zc-reg-step mb-4">
              <h5 class="fw-semibold mb-3 border-bottom pb-2"><?php esc_html_e('My Site','zincelestial'); ?></h5>
              <?php do_action('bp_before_blog_details_fields'); ?>
              <div class="mb-3">
                <label for="signup_blog_url" class="form-label fw-semibold"><?php esc_html_e('Site URL','zincelestial'); ?></label>
                <input type="text" name="signup_blog_url" id="signup_blog_url" class="form-control">
                <?php bp_signup_blog_url_errors(); ?>
              </div>
              <div class="mb-3">
                <label for="signup_blog_title" class="form-label fw-semibold"><?php esc_html_e('Site Title','zincelestial'); ?></label>
                <input type="text" name="signup_blog_title" id="signup_blog_title" class="form-control">
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="signup_blog_privacy" id="signup_blog_privacy_public" value="1" checked>
                  <label class="form-check-label" for="signup_blog_privacy_public"><?php esc_html_e('Public','zincelestial'); ?></label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="signup_blog_privacy" id="signup_blog_privacy_private" value="0">
                  <label class="form-check-label" for="signup_blog_privacy_private"><?php esc_html_e('Private','zincelestial'); ?></label>
                </div>
              </div>
              <?php do_action('bp_after_blog_details_fields'); ?>
            </div>
            <?php endif; ?>

            <?php do_action('bp_before_registration_submit_buttons'); ?>
            <div class="d-grid">
              <button type="submit" name="signup_submit" id="signup_submit" class="btn btn-primary btn-lg fw-semibold">
                <?php esc_html_e('Create Account','zincelestial'); ?>
              </button>
            </div>
            <?php do_action('bp_after_registration_submit_buttons'); ?>
            <?php wp_nonce_field('bp_new_signup'); ?>

          </form>
          <p class="text-center mt-4 mb-0 small text-muted">
            <?php esc_html_e('Already have an account?','zincelestial'); ?>
            <a href="<?php echo esc_url(wp_login_url()); ?>"><?php esc_html_e('Sign In','zincelestial'); ?></a>
          </p>
          <?php do_action('bp_after_register_page'); ?>
        </div>

        <?php else : ?>
        <div class="alert alert-warning"><?php esc_html_e('Registration is not allowed.','zincelestial'); ?></div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
</main>
<script>
document.getElementById('togglePw')?.addEventListener('click', function() {
  var pw = document.getElementById('signup_password');
  pw.type = pw.type === 'password' ? 'text' : 'password';
  this.querySelector('i').className = pw.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
});
</script>
<?php get_footer(); ?>
