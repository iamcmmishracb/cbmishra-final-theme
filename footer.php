<footer id="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-inner">

            <!-- Brand -->
            <div class="footer-brand">
                <div class="footer-brand-name">C B Mishra</div>
                <p class="footer-brand-desc">
                    <?php echo esc_html( cbmishra_opt( 'footer_description', 'Strategic Technical Project Manager bridging business requirements and technical execution for global enterprises.' ) ); ?>
                </p>
                <div class="footer-social">
                    <a href="<?php echo esc_url( cbmishra_opt( 'linkedin_url', 'https://www.linkedin.com/in/cbmishra/' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    <a href="<?php echo esc_url( cbmishra_opt( 'youtube_url', 'https://www.youtube.com/@imcbmishra' ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    <a href="mailto:<?php echo esc_attr( cbmishra_opt( 'contact_email', 'cmmishracb@gmail.com' ) ); ?>" aria-label="Email">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </a>
                </div>
            </div>

            <!-- Navigation - links work from any page -->
            <div class="footer-nav-col">
                <h3 class="footer-nav-title">Navigation</h3>
                <nav class="footer-nav" aria-label="Footer navigation">
                    <?php
                    $home = trailingslashit( home_url('/') );
                    $nav_sections = ['#expertise'=>'What I Do','#experience'=>'Experience','#portfolio'=>'Portfolio','#education'=>'Education','#tech-stack'=>'Tech Stack','#blog'=>'Blog'];
                    foreach ( $nav_sections as $hash => $label ) {
                        $href = is_front_page() ? $hash : esc_url( $home . $hash );
                        echo '<a href="' . esc_attr( $href ) . '">' . esc_html( $label ) . '</a>';
                    }
                    ?>
                    <a href="<?php echo esc_url( cbmishra_hire_url() ); ?>">Hire Me</a>
                    <a href="<?php echo esc_url( cbmishra_appointment_url() ); ?>">Book a Call</a>
                </nav>
            </div>

            <!-- Contact -->
            <div class="footer-contact-col">
                <h3 class="footer-nav-title">Contact</h3>
                <div class="footer-nav">
                    <span style="color:var(--text-secondary);font-size:14px;display:flex;gap:6px;align-items:center;">📍 Remote, India</span>
                    <a href="mailto:<?php echo esc_attr( cbmishra_opt('contact_email','cmmishracb@gmail.com') ); ?>" style="font-size:14px;"><?php echo esc_html( cbmishra_opt('contact_email','cmmishracb@gmail.com') ); ?></a>
                    <a href="<?php echo esc_url( cbmishra_opt('linkedin_url','https://www.linkedin.com/in/cbmishra/') ); ?>" target="_blank" rel="noopener noreferrer" style="font-size:14px;">LinkedIn Profile</a>
                    <a href="<?php echo esc_url( cbmishra_opt('youtube_url','https://www.youtube.com/@imcbmishra') ); ?>" target="_blank" rel="noopener noreferrer" style="font-size:14px;">YouTube Channel</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copyright">
                <?php echo esc_html( cbmishra_opt('footer_copyright','© 2026 C B Mishra — Built for Digital Excellence') ); ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('<?php echo esc_url(home_url("/sw.js")); ?>');
    });
}
</script>
</body>
</html>
