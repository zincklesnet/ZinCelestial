<?php
/**
 * Title: ZinCelestial Hero — Full Width
 * Slug: zincelestial/hero-full-width
 * Description: A full-width hero section with gradient headline, tagline, and CTA buttons.
 * Categories: zincelestial-hero
 * Keywords: hero, banner, header, cta, gradient
 * Viewport Width: 1200
 */
?>
<!-- wp:group {"className":"zc-pattern-hero","style":{"spacing":{"padding":{"top":"6rem","bottom":"6rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group zc-pattern-hero" style="padding-top:6rem;padding-bottom:6rem">

    <!-- wp:group {"style":{"spacing":{"blockGap":"1.5rem"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
    <div class="wp-block-group" style="text-align:center">

        <!-- wp:paragraph {"className":"zc-hero-eyebrow","style":{"typography":{"fontSize":"0.8rem","letterSpacing":"4px","textTransform":"uppercase","fontWeight":"700"},"color":{"text":"#7c6ff7"}}} -->
        <p class="zc-hero-eyebrow" style="font-size:.8rem;letter-spacing:4px;text-transform:uppercase;font-weight:700;color:#7c6ff7">Welcome to the Community</p>
        <!-- /wp:paragraph -->

        <!-- wp:heading {"level":1,"className":"zc-hero-title","style":{"typography":{"fontSize":"clamp(2.4rem,5vw,4rem)","fontWeight":"900","lineHeight":"1.1"}}} -->
        <h1 class="zc-hero-title" style="font-size:clamp(2.4rem,5vw,4rem);font-weight:900;line-height:1.1">Connect. Create. <span style="background:linear-gradient(135deg,#a78bfa,#00d4ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Thrive Together.</span></h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph {"className":"zc-hero-sub","style":{"typography":{"fontSize":"1.15rem"},"color":{"text":"#94a3b8"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
        <p class="zc-hero-sub" style="font-size:1.15rem;color:#94a3b8;max-width:640px;margin:0 auto">Your go-to platform for creators, builders, and visionaries. Share your world, grow your network, and access everything in one place.</p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"blockGap":"1rem","margin":{"top":"2.5rem"}}}} -->
        <div class="wp-block-buttons" style="margin-top:2.5rem">
            <!-- wp:button {"className":"is-style-zc-gradient","style":{"border":{"radius":"100px"},"spacing":{"padding":{"top":"0.85rem","bottom":"0.85rem","left":"2.2rem","right":"2.2rem"}},"typography":{"fontWeight":"700"}}} -->
            <div class="wp-block-button is-style-zc-gradient"><a class="wp-block-button__link wp-element-button" style="border-radius:100px;padding:.85rem 2.2rem;font-weight:700"><?php esc_html_e( 'Join Now — It\'s Free', 'zincelestial' ); ?></a></div>
            <!-- /wp:button -->

            <!-- wp:button {"className":"is-style-zc-ghost","style":{"border":{"radius":"100px"},"spacing":{"padding":{"top":"0.85rem","bottom":"0.85rem","left":"2.2rem","right":"2.2rem"}}}} -->
            <div class="wp-block-button is-style-zc-ghost"><a class="wp-block-button__link wp-element-button" style="border-radius:100px;padding:.85rem 2.2rem"><?php esc_html_e( 'Explore Features', 'zincelestial' ); ?></a></div>
            <!-- /wp:button -->
        </div>
        <!-- /wp:buttons -->

        <!-- wp:group {"className":"zc-hero-stats","style":{"spacing":{"margin":{"top":"3.5rem"},"blockGap":"2rem"}},"layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
        <div class="wp-block-group zc-hero-stats" style="margin-top:3.5rem">
            <!-- wp:group {"className":"zc-hero-stat","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group zc-hero-stat">
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2rem","fontWeight":"900"},"color":{"text":"#a78bfa"}}} --><h3 style="font-size:2rem;font-weight:900;color:#a78bfa">10K+</h3><!-- /wp:heading -->
                <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.72rem","textTransform":"uppercase","letterSpacing":"1px"},"color":{"text":"#64748b"}}} --><p style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:#64748b">Members</p><!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
            <!-- wp:group {"className":"zc-hero-stat","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group zc-hero-stat">
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2rem","fontWeight":"900"},"color":{"text":"#00d4ff"}}} --><h3 style="font-size:2rem;font-weight:900;color:#00d4ff">500+</h3><!-- /wp:heading -->
                <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.72rem","textTransform":"uppercase","letterSpacing":"1px"},"color":{"text":"#64748b"}}} --><p style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:#64748b">Groups</p><!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
            <!-- wp:group {"className":"zc-hero-stat","layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
            <div class="wp-block-group zc-hero-stat">
                <!-- wp:heading {"level":3,"style":{"typography":{"fontSize":"2rem","fontWeight":"900"},"color":{"text":"#34d399"}}} --><h3 style="font-size:2rem;font-weight:900;color:#34d399">50K+</h3><!-- /wp:heading -->
                <!-- wp:paragraph {"style":{"typography":{"fontSize":"0.72rem","textTransform":"uppercase","letterSpacing":"1px"},"color":{"text":"#64748b"}}} --><p style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:#64748b">Posts</p><!-- /wp:paragraph -->
            </div>
            <!-- /wp:group -->
        </div>
        <!-- /wp:group -->

    </div>
    <!-- /wp:group -->

</div>
<!-- /wp:group -->
