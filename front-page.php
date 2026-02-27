<?php
/**
 * Front Page Template
 * @package CBMishra_Portfolio
 */
get_header();
?>
<main id="main-content" role="main">

<!-- ============================================================
     HERO
     ============================================================ -->
<section id="hero" class="grid-bg" aria-labelledby="hero-title">
    <div class="hero-orb hero-orb-1" aria-hidden="true"></div>
    <div class="hero-orb hero-orb-2" aria-hidden="true"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-left">
                <div class="hero-badge">
                    <?php echo esc_html(cbmishra_opt('hero_badge_text','Available for Consulting & Contract Roles')); ?>
                </div>
                <h1 class="hero-title" id="hero-title">
                    <span class="hero-title-line"><?php echo esc_html(cbmishra_opt('hero_title_line1','Strategic')); ?></span>
                    <span class="hero-title-accent"><?php echo esc_html(cbmishra_opt('hero_title_line2','Technical Project Manager')); ?></span>
                </h1>
                <p class="hero-description">
                    <?php echo esc_html(cbmishra_opt('hero_description','I bridge the gap between business strategy and technical execution. With 7+ years directing the full SDLC, I help companies architect robust API integrations, roll out enterprise ERPs, and launch profitable SaaS platforms.')); ?>
                </p>
                <div class="hero-actions">
                    <a href="#contact" class="btn btn-primary">Let's Talk <span aria-hidden="true">→</span></a>
                    <a href="#portfolio" class="btn btn-outline">View Work</a>
                </div>
                <div class="hero-stats">
                    <?php
                    $stats = [
                        [cbmishra_opt('hero_stat1_num','7+'),  cbmishra_opt('hero_stat1_label','Years Experience')],
                        [cbmishra_opt('hero_stat2_num','40+'), cbmishra_opt('hero_stat2_label','Engineers Led')],
                        [cbmishra_opt('hero_stat3_num','35%'), cbmishra_opt('hero_stat3_label','Faster Delivery')],
                        [cbmishra_opt('hero_stat4_num','15+'), cbmishra_opt('hero_stat4_label','Enterprise Clients')],
                    ];
                    foreach ($stats as $s): ?>
                        <div class="hero-stat">
                            <div class="hero-stat-number"><?php echo esc_html($s[0]); ?></div>
                            <div class="hero-stat-label"><?php echo esc_html($s[1]); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Hero Card (hides on mobile) -->
            <div class="hero-card" aria-hidden="true">
                <div class="hero-card-avatar">CB</div>
                <div class="hero-card-name">C B Mishra</div>
                <div class="hero-card-role">Strategic Technical Project Manager</div>
                <div class="hero-card-stats">
                    <div class="hero-card-stat"><div class="hero-card-stat-num">7+</div><div class="hero-card-stat-lbl">Yrs Exp</div></div>
                    <div class="hero-card-stat"><div class="hero-card-stat-num">40+</div><div class="hero-card-stat-lbl">Team</div></div>
                    <div class="hero-card-stat"><div class="hero-card-stat-num">15+</div><div class="hero-card-stat-lbl">Clients</div></div>
                    <div class="hero-card-stat"><div class="hero-card-stat-num">35%</div><div class="hero-card-stat-lbl">Faster</div></div>
                </div>
                <div class="hero-card-skills">
                    <?php foreach (['Odoo ERP','Agile/Scrum','API Arch','Flutter','MERN','AWS'] as $sk): ?>
                        <span class="tag"><?php echo esc_html($sk); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     EXPERTISE / WHAT I DO
     ============================================================ -->
<section id="expertise" class="section-padding" aria-labelledby="expertise-heading">
    <div class="container">
        <?php cbmishra_section_header([
            'label'    => cbmishra_opt('section_expertise_label','What I Do'),
            'title'    => cbmishra_opt('section_expertise_title','Specialized Capabilities That Drive Results'),
            'subtitle' => cbmishra_opt('section_expertise_subtitle','Specialized capabilities that drive measurable results across enterprise-scale projects and digital transformations.'),
        ]); ?>

        <div class="expertise-grid" id="expertise-heading">
            <?php
            $eq = new WP_Query(['post_type'=>'expertise','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_status'=>'publish']);
            if ($eq->have_posts()):
                while ($eq->have_posts()): $eq->the_post();
                    cbmishra_expertise_card(get_post());
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ============================================================
     EXPERIENCE
     ============================================================ -->
<section id="experience" class="section-padding" aria-labelledby="experience-heading" style="background:var(--bg-primary);">
    <div class="container">
        <?php cbmishra_section_header([
            'label'    => cbmishra_opt('section_exp_label','Experience'),
            'title'    => cbmishra_opt('section_exp_title','A Decade of Delivering Excellence'),
            'subtitle' => cbmishra_opt('section_exp_subtitle','A track record of leading complex technical initiatives, enterprise rollouts, and high-performing engineering teams.'),
        ]); ?>

        <div class="experience-timeline" id="experience-heading">
            <?php
            $exq = new WP_Query(['post_type'=>'experience','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_status'=>'publish']);
            if ($exq->have_posts()):
                while ($exq->have_posts()): $exq->the_post();
                    cbmishra_experience_item(get_post());
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ============================================================
     PORTFOLIO
     ============================================================ -->
<section id="portfolio" class="section-padding" aria-labelledby="portfolio-heading">
    <div class="container">
        <?php cbmishra_section_header([
            'label'    => cbmishra_opt('section_portfolio_label','Portfolio'),
            'title'    => cbmishra_opt('section_portfolio_title','Architected Solutions'),
            'subtitle' => cbmishra_opt('section_portfolio_subtitle','Complex platforms and enterprise systems managed from conception to deployment.'),
        ]); ?>

        <div class="portfolio-grid" id="portfolio-heading">
            <?php
            $pq = new WP_Query(['post_type'=>'project','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_status'=>'publish']);
            if ($pq->have_posts()):
                while ($pq->have_posts()): $pq->the_post();
                    cbmishra_portfolio_card(get_post());
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ============================================================
     EDUCATION
     ============================================================ -->
<section id="education" class="section-padding" aria-labelledby="education-heading" style="background:var(--bg-primary);">
    <div class="container">
        <?php cbmishra_section_header(['label'=>'Education','title'=>'Academic Background','centered'=>true]); ?>
        <div class="education-card reveal" id="education-heading">
            <div class="education-card-emoji" aria-hidden="true">🎓</div>
            <div class="education-degree"><?php echo esc_html(cbmishra_opt('education_degree','Bachelor of Technology (B.Tech)')); ?></div>
            <div class="education-field"><?php echo esc_html(cbmishra_opt('education_field','Electronics and Communication Engineering')); ?></div>
            <div class="education-institution"><?php echo esc_html(cbmishra_opt('education_institution','Cambridge Institute of Technology, Ranchi University')); ?></div>
            <div class="education-year"><?php echo esc_html(cbmishra_opt('education_year','Graduated: July 2019')); ?></div>
        </div>
    </div>
</section>

<!-- ============================================================
     TECH STACK
     ============================================================ -->
<section id="tech-stack" class="section-padding" aria-labelledby="tech-stack-heading">
    <div class="container">
        <?php cbmishra_section_header([
            'label'    => 'Technical Arsenal',
            'title'    => 'Comprehensive Tech Stack',
            'subtitle' => 'End-to-end expertise spanning enterprise platforms, mobile, cloud infrastructure, and modern APIs.',
        ]); ?>

        <div class="tech-categories" id="tech-stack-heading">
            <?php
            $tq = new WP_Query(['post_type'=>'tech_stack','posts_per_page'=>-1,'orderby'=>'menu_order','order'=>'ASC','post_status'=>'publish']);
            if ($tq->have_posts()):
                while ($tq->have_posts()): $tq->the_post();
                    $items_raw = get_post_meta(get_the_ID(),'_tech_items',true);
                    $num       = get_post_meta(get_the_ID(),'_tech_order_num',true) ?: '??';
                    $items     = cbmishra_get_tags($items_raw);
                    ?>
                    <div class="tech-category reveal">
                        <div class="tech-category-header">
                            <div class="tech-category-num"><?php echo esc_html($num); ?></div>
                            <h3 class="tech-category-title"><?php the_title(); ?></h3>
                        </div>
                        <div class="tech-items">
                            <?php foreach ($items as $item): ?>
                                <span class="tag"><?php echo esc_html($item); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ============================================================
     VIDEO INTRODUCTION
     ============================================================ -->
<section id="video-intro" class="section-padding" aria-labelledby="video-heading" style="background:var(--bg-primary);">
    <div class="container">
        <div class="video-inner">
            <div class="video-text">
                <div class="section-label reveal">Discover My Approach</div>
                <h2 class="section-title reveal reveal-delay-1" id="video-heading">
                    <?php echo esc_html(cbmishra_opt('video_section_title','Watch My Intro')); ?>
                </h2>
                <p class="section-subtitle reveal reveal-delay-2">
                    <?php echo esc_html(cbmishra_opt('video_section_description','Get to know me, my approach, and how I can transform your enterprise operations.')); ?>
                </p>
                <div class="video-features reveal reveal-delay-3">
                    <div class="video-feature"><span class="video-feature-icon" aria-hidden="true">🎯</span><span>My approach to enterprise project delivery</span></div>
                    <div class="video-feature"><span class="video-feature-icon" aria-hidden="true">🚀</span><span>How I bridge business strategy & technical execution</span></div>
                    <div class="video-feature"><span class="video-feature-icon" aria-hidden="true">💼</span><span>7+ years of global enterprise experience</span></div>
                </div>
                <a href="<?php echo esc_url(cbmishra_opt('youtube_url','https://www.youtube.com/@imcbmishra')); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline reveal reveal-delay-4">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    Visit My YouTube Channel
                </a>
            </div>

            <div>
                <div class="video-embed reveal">
                    <iframe
                        src="<?php echo esc_url(cbmishra_opt('youtube_intro_url','https://www.youtube.com/embed/iLYggCc-TF8')); ?>?rel=0&modestbranding=1"
                        title="Who is C B Mishra? | Strategic Technical Project Manager"
                        allowfullscreen loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>
                <div class="video-trouble">
                    <p>Having trouble playing the video?</p>
                    <a href="https://www.youtube.com/watch?v=iLYggCc-TF8" target="_blank" rel="noopener noreferrer" class="btn-youtube">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        Watch Directly on YouTube
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     BLOG — 6 posts, View All Articles links to /blogs/
     ============================================================ -->
<section id="blog" class="section-padding" aria-labelledby="blog-heading">
    <div class="container">
        <div class="blog-header">
            <div>
                <div class="section-label reveal"><?php echo esc_html(cbmishra_opt('section_blog_label','From the Blog')); ?></div>
                <h2 class="section-title reveal reveal-delay-1" id="blog-heading">
                    <?php echo esc_html(cbmishra_opt('section_blog_title','Latest Insights')); ?>
                </h2>
                <p class="section-subtitle reveal reveal-delay-2">
                    <?php echo esc_html(cbmishra_opt('section_blog_subtitle','Thoughts on technical project management, enterprise ERP, agile delivery, and bridging business with technology.')); ?>
                </p>
            </div>
            <a href="<?php echo esc_url(cbmishra_blogs_url()); ?>" class="btn btn-outline reveal reveal-delay-3">
                View All Articles →
            </a>
        </div>

        <div class="blog-grid">
            <?php
            $bq = new WP_Query(['post_type'=>'post','posts_per_page'=>6,'post_status'=>'publish','orderby'=>'date','order'=>'DESC']);
            if ($bq->have_posts()):
                while ($bq->have_posts()): $bq->the_post();
                    cbmishra_blog_card();
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p style="color:var(--text-secondary);grid-column:1/-1;text-align:center;padding:40px 0;">No blog posts published yet. <a href="' . esc_url(admin_url('post-new.php')) . '" style="color:var(--accent-primary);">Write your first post →</a></p>';
            endif;
            ?>
        </div>

        <div class="blog-view-all">
            <a href="<?php echo esc_url(cbmishra_blogs_url()); ?>" class="btn btn-outline">
                View All Articles
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     CONTACT
     ============================================================ -->
<section id="contact" class="section-padding" aria-labelledby="contact-heading" style="background:var(--bg-primary);">
    <div class="container">
        <div class="contact-inner">
            <div>
                <div class="section-label reveal"><?php echo esc_html(cbmishra_opt('section_contact_label',"Let's Connect")); ?></div>
                <h2 class="section-title reveal reveal-delay-1" id="contact-heading">
                    <?php echo esc_html(cbmishra_opt('section_contact_title','Ready to Transform Your IT Operations?')); ?>
                </h2>
                <p class="contact-description reveal reveal-delay-2">
                    <?php echo esc_html(cbmishra_opt('section_contact_description',"Whether you need an expert to oversee a massive ERP rollout, rescue a failing Agile sprint, or build an MVP from scratch — let's talk.")); ?>
                </p>
                <div class="contact-buttons reveal reveal-delay-3">
                    <a href="mailto:<?php echo esc_attr(cbmishra_opt('contact_email','cmmishracb@gmail.com')); ?>" class="contact-btn">
                        <span class="contact-btn-icon" aria-hidden="true">📧</span>
                        <span class="contact-btn-label">Email</span>
                        <span class="contact-btn-value"><?php echo esc_html(cbmishra_opt('contact_email','cmmishracb@gmail.com')); ?></span>
                    </a>
                    <a href="<?php echo esc_url(cbmishra_hire_url()); ?>" class="contact-btn">
                        <span class="contact-btn-icon" aria-hidden="true">💼</span>
                        <span class="contact-btn-label">Hire Me</span>
                        <span class="contact-btn-value">Open hire form</span>
                    </a>
                    <a href="<?php echo esc_url(cbmishra_appointment_url()); ?>" class="contact-btn">
                        <span class="contact-btn-icon" aria-hidden="true">📅</span>
                        <span class="contact-btn-label">Book a Call</span>
                        <span class="contact-btn-value">Schedule appointment</span>
                    </a>
                    <div class="contact-btn" style="cursor:default;">
                        <span class="contact-btn-icon" aria-hidden="true">📍</span>
                        <span class="contact-btn-label">Remote — India</span>
                        <span class="contact-btn-value">Available globally</span>
                    </div>
                </div>
            </div>

            <div class="reveal reveal-delay-2">
                <div class="card" style="padding:40px;">
                    <h3 style="font-family:var(--font-display);font-weight:700;font-size:20px;color:var(--text-primary);margin-bottom:24px;">Send a Quick Message</h3>
                    <?php cbmishra_hire_form(); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Book Appointment CTA -->
<section class="section-padding" style="background:var(--bg-secondary);">
    <div class="container" style="text-align:center;">
        <div class="section-label reveal" style="justify-content:center;">Book an Appointment</div>
        <h2 class="section-title reveal reveal-delay-1" style="margin:16px auto 16px;">Schedule a Free Consultation</h2>
        <p class="section-subtitle reveal reveal-delay-2" style="margin:0 auto 32px;">Ready for the next step? Let's meet and create an action plan together.</p>
        <a href="<?php echo esc_url(cbmishra_appointment_url()); ?>" class="btn btn-primary reveal reveal-delay-3">
            Book an Appointment 📅
        </a>
    </div>
</section>

</main>
<?php get_footer(); ?>
