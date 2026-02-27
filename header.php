<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(CBMISHRA_URI); ?>/assets/images/favicon.svg">
    <link rel="apple-touch-icon" href="<?php echo esc_url(CBMISHRA_URI); ?>/assets/images/favicon.svg">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">Skip to content</a>

<header id="site-header" role="banner">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                <div class="logo-mark" aria-hidden="true">CB</div>
                <span class="logo-text">C B Mishra</span>
            </a>

            <!-- Primary Nav (Desktop) - links target home page sections -->
            <nav id="primary-nav" role="navigation" aria-label="Primary navigation">
                <?php
                $home = trailingslashit(home_url('/'));
                $nav_items = [
                    '#expertise'  => 'What I Do',
                    '#experience' => 'Experience',
                    '#portfolio'  => 'Portfolio',
                    '#education'  => 'Education',
                    '#tech-stack' => 'Tech Stack',
                    '#blog'       => 'Blog',
                    '#contact'    => 'Contact',
                ];
                foreach ($nav_items as $hash => $label) {
                    $href = is_front_page() ? $hash : esc_url($home . $hash);
                    echo '<a href="' . esc_attr($href) . '" class="nav-link">' . esc_html($label) . '</a>';
                }
                ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Social Icons -->
                <div class="header-social">
                    <a href="<?php echo esc_url(cbmishra_opt('linkedin_url','https://www.linkedin.com/in/cbmishra/')); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Profile">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="<?php echo esc_url(cbmishra_opt('youtube_url','https://www.youtube.com/@imcbmishra')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube Channel">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>

                <!-- Dark/Light Toggle -->
                <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark/light mode">
                    <span id="theme-icon">🌙</span>
                </button>

                <!-- Hire Me Button - always linked to hire page -->
                <a href="<?php echo esc_url(cbmishra_hire_url()); ?>" class="btn btn-hire" id="hire-me-btn">
                    Hire Me
                </a>

                <!-- Mobile Hamburger -->
                <button class="mobile-menu-toggle" id="mobile-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-nav">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Navigation -->
<div id="mobile-nav" aria-label="Mobile navigation" role="navigation">
    <div class="container">
        <?php
        foreach ($nav_items as $hash => $label) {
            $href = is_front_page() ? $hash : esc_url($home . $hash);
            echo '<a href="' . esc_attr($href) . '" class="nav-link">' . esc_html($label) . '</a>';
        }
        ?>
        <div style="border-top:1px solid var(--border-color);margin-top:12px;padding-top:12px;display:flex;flex-direction:column;gap:10px;">
            <a href="<?php echo esc_url(cbmishra_hire_url()); ?>" class="btn btn-hire" style="text-align:center;justify-content:center;">Hire Me</a>
            <a href="<?php echo esc_url(cbmishra_appointment_url()); ?>" class="btn btn-outline" style="text-align:center;justify-content:center;">Book a Call</a>
        </div>
    </div>
</div>
