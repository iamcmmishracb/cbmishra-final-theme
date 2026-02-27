<?php
/**
 * CB Mishra Portfolio Theme – functions.php v2
 * Fixed: all sections editable, hire/appointment URLs, blog links, seeded defaults
 *
 * @package CBMishra_Portfolio
 */

defined( 'ABSPATH' ) || exit;

define( 'CBMISHRA_VERSION', '1.0.1' );
define( 'CBMISHRA_DIR', get_template_directory() );
define( 'CBMISHRA_URI', get_template_directory_uri() );

// ============================================================
// THEME SETUP
// ============================================================
function cbmishra_setup() {
    load_theme_textdomain( 'cbmishra-portfolio', CBMISHRA_DIR . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', ['search-form','comment-form','comment-list','gallery','caption','style','script'] );
    add_theme_support( 'responsive-embeds' );
    add_image_size( 'blog-thumbnail', 800, 450, true );
    add_image_size( 'blog-card', 600, 340, true );
    add_image_size( 'og-image', 1200, 630, true );
    register_nav_menus( ['primary' => 'Primary Menu', 'footer' => 'Footer Menu'] );
}
add_action( 'after_setup_theme', 'cbmishra_setup' );

// ============================================================
// ENQUEUE ASSETS
// ============================================================
function cbmishra_enqueue() {
    wp_enqueue_style( 'cbmishra-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Manrope:wght@600;700;800&family=JetBrains+Mono:wght@400;500&display=swap',
        [], null );
    wp_enqueue_style( 'cbmishra-main', CBMISHRA_URI . '/assets/css/main.css', ['cbmishra-fonts'], CBMISHRA_VERSION );
    wp_enqueue_script( 'cbmishra-main', CBMISHRA_URI . '/assets/js/main.js', [], CBMISHRA_VERSION, true );
    wp_localize_script( 'cbmishra-main', 'cbmishraData', [
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'cbmishra_nonce' ),
        'homeUrl' => home_url( '/' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'cbmishra_enqueue' );

// ============================================================
// CUSTOM POST TYPES
// ============================================================
function cbmishra_register_cpts() {
    register_post_type( 'expertise', [
        'labels'      => ['name'=>'Expertise','singular_name'=>'Expertise Item','add_new_item'=>'Add New Expertise','all_items'=>'All Expertise Items'],
        'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>true,
        'menu_icon'=>'dashicons-star-filled','menu_position'=>5,
        'supports'=>['title','editor','page-attributes'],'rewrite'=>false,
    ]);

    register_post_type( 'experience', [
        'labels'      => ['name'=>'Experience','singular_name'=>'Experience Entry','add_new_item'=>'Add New Experience','all_items'=>'All Experience Entries'],
        'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>true,
        'menu_icon'=>'dashicons-businessman','menu_position'=>6,
        'supports'=>['title','editor','page-attributes'],'rewrite'=>false,
    ]);

    register_post_type( 'project', [
        'labels'      => ['name'=>'Portfolio','singular_name'=>'Project','add_new_item'=>'Add New Project','all_items'=>'All Projects'],
        'public'=>true,'has_archive'=>false,'show_in_menu'=>true,'show_in_rest'=>true,
        'menu_icon'=>'dashicons-portfolio','menu_position'=>7,
        'supports'=>['title','editor','excerpt','page-attributes'],'rewrite'=>false,
    ]);

    register_post_type( 'tech_stack', [
        'labels'      => ['name'=>'Tech Stack','singular_name'=>'Tech Category','add_new_item'=>'Add Tech Category','all_items'=>'All Tech Categories'],
        'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>true,
        'menu_icon'=>'dashicons-code-standards','menu_position'=>8,
        'supports'=>['title','page-attributes'],'rewrite'=>false,
    ]);

    register_post_type( 'appointment', [
        'labels'      => ['name'=>'Appointments','singular_name'=>'Appointment'],
        'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>false,
        'menu_icon'=>'dashicons-calendar-alt','menu_position'=>9,
        'supports'=>['title'],'rewrite'=>false,
        'capabilities'=>['create_posts'=>'do_not_allow'],'map_meta_cap'=>true,
    ]);

    register_post_type( 'hire_submission', [
        'labels'      => ['name'=>'Hire Me Submissions','singular_name'=>'Hire Submission'],
        'public'=>false,'show_ui'=>true,'show_in_menu'=>true,'show_in_rest'=>false,
        'menu_icon'=>'dashicons-email-alt','menu_position'=>10,
        'supports'=>['title'],'rewrite'=>false,
        'capabilities'=>['create_posts'=>'do_not_allow'],'map_meta_cap'=>true,
    ]);
}
add_action( 'init', 'cbmishra_register_cpts' );

// ============================================================
// META BOXES
// ============================================================
function cbmishra_register_meta_boxes() {
    add_meta_box( 'cbm_expertise',  'Expertise Details',  'cbm_expertise_meta_cb',  'expertise',  'normal', 'high' );
    add_meta_box( 'cbm_experience', 'Experience Details', 'cbm_experience_meta_cb', 'experience', 'normal', 'high' );
    add_meta_box( 'cbm_project',    'Project Details',    'cbm_project_meta_cb',    'project',    'normal', 'high' );
    add_meta_box( 'cbm_tech',       'Tech Items',         'cbm_tech_meta_cb',       'tech_stack', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'cbmishra_register_meta_boxes' );

function cbm_expertise_meta_cb( $post ) {
    wp_nonce_field( 'cbm_save_meta', 'cbm_meta_nonce' );
    $icon = get_post_meta( $post->ID, '_expertise_icon', true ) ?: '💡';
    echo '<table class="form-table"><tr><th style="width:160px">Icon (Emoji)</th><td>';
    echo '<input type="text" name="expertise_icon" value="' . esc_attr($icon) . '" style="width:80px;font-size:22px;">';
    echo '<p class="description">Paste any emoji: 🔄 ⚙️ 🔗 👥 📱 🚀 🌐 🔑</p></td></tr>';
    echo '<tr><th colspan="2"><p class="description" style="color:#777;">Set the <strong>Title</strong> above and write the full description in the <strong>editor below</strong>.</p></th></tr></table>';
}

function cbm_experience_meta_cb( $post ) {
    wp_nonce_field( 'cbm_save_meta', 'cbm_meta_nonce' );
    $dr = get_post_meta( $post->ID, '_exp_date_range', true );
    $co = get_post_meta( $post->ID, '_exp_company',    true );
    $ro = get_post_meta( $post->ID, '_exp_role',       true );
    $hl = get_post_meta( $post->ID, '_exp_highlights', true );
    echo '<table class="form-table">';
    echo '<tr><th style="width:160px">Date Range</th><td><input type="text" name="exp_date_range" value="' . esc_attr($dr) . '" class="large-text" placeholder="e.g. Jan 2024 — Present"></td></tr>';
    echo '<tr><th>Role / Profile</th><td><input type="text" name="exp_role" value="' . esc_attr($ro) . '" class="large-text" placeholder="e.g. Strategic Technical Project Manager"></td></tr>';
    echo '<tr><th>Company Name</th><td><input type="text" name="exp_company" value="' . esc_attr($co) . '" class="large-text" placeholder="e.g. Global Enterprise Solutions"></td></tr>';
    echo '<tr><th>Key Highlights</th><td><textarea name="exp_highlights" rows="10" class="large-text" placeholder="One per line. Format: Title: Description\n\nExample:\nEnd-to-End Rollouts: Directed Odoo ERP implementations for 15+ clients...">' . esc_textarea($hl) . '</textarea>';
    echo '<p class="description">One highlight per line. Format: <code>Title: Description</code></p></td></tr>';
    echo '</table>';
}

function cbm_project_meta_cb( $post ) {
    wp_nonce_field( 'cbm_save_meta', 'cbm_meta_nonce' );
    $ic = get_post_meta( $post->ID, '_project_icon',           true ) ?: '🚀';
    $ca = get_post_meta( $post->ID, '_project_category_label', true );
    $tg = get_post_meta( $post->ID, '_project_tags',           true );
    echo '<table class="form-table">';
    echo '<tr><th style="width:160px">Icon (Emoji)</th><td><input type="text" name="project_icon" value="' . esc_attr($ic) . '" style="width:80px;font-size:22px;"></td></tr>';
    echo '<tr><th>Category Label</th><td><input type="text" name="project_category_label" value="' . esc_attr($ca) . '" class="large-text" placeholder="e.g. ERP / Enterprise"></td></tr>';
    echo '<tr><th>Tech Tags</th><td><input type="text" name="project_tags" value="' . esc_attr($tg) . '" class="large-text" placeholder="Comma separated: Odoo ERP, Flutter, AWS"></td></tr>';
    echo '<tr><th></th><td><p class="description">Write the short project description in the <strong>Excerpt</strong> field below the editor.</p></td></tr>';
    echo '</table>';
}

function cbm_tech_meta_cb( $post ) {
    wp_nonce_field( 'cbm_save_meta', 'cbm_meta_nonce' );
    $it = get_post_meta( $post->ID, '_tech_items',     true );
    $nu = get_post_meta( $post->ID, '_tech_order_num', true );
    echo '<table class="form-table">';
    echo '<tr><th style="width:160px">Display Number</th><td><input type="text" name="tech_order_num" value="' . esc_attr($nu) . '" style="width:60px" placeholder="01"></td></tr>';
    echo '<tr><th>Tech Items</th><td><textarea name="tech_items" rows="4" class="large-text" placeholder="Comma separated: Flutter (Dart), Native iOS (Swift), React Native">' . esc_textarea($it) . '</textarea>';
    echo '<p class="description">Comma-separated. Set <strong>Menu Order</strong> in the Publish box to control sort order.</p></td></tr>';
    echo '</table>';
}

function cbm_save_meta( $post_id ) {
    if ( ! isset($_POST['cbm_meta_nonce']) || ! wp_verify_nonce($_POST['cbm_meta_nonce'], 'cbm_save_meta') ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $map = [
        'expertise_icon'         => '_expertise_icon',
        'exp_date_range'         => '_exp_date_range',
        'exp_role'               => '_exp_role',
        'exp_company'            => '_exp_company',
        'exp_highlights'         => '_exp_highlights',
        'project_icon'           => '_project_icon',
        'project_category_label' => '_project_category_label',
        'project_tags'           => '_project_tags',
        'tech_items'             => '_tech_items',
        'tech_order_num'         => '_tech_order_num',
    ];
    foreach ( $map as $k => $mk ) {
        if ( isset($_POST[$k]) ) update_post_meta( $post_id, $mk, sanitize_textarea_field( wp_unslash($_POST[$k]) ) );
    }
}
add_action( 'save_post', 'cbm_save_meta' );

// ============================================================
// SETTINGS / OPTIONS PAGE
// ============================================================
add_action( 'admin_menu', function() {
    add_menu_page( 'CB Mishra Settings', 'CB Mishra Settings', 'manage_options',
        'cbmishra-settings', 'cbmishra_settings_page', 'dashicons-admin-appearance', 2 );
});

function cbmishra_settings_page() {
    if ( isset($_POST['cbm_save']) ) {
        check_admin_referer( 'cbmishra_settings_nonce' );
        $fields = [
            'hero_badge_text','hero_title_line1','hero_title_line2','hero_description',
            'hero_stat1_num','hero_stat1_label','hero_stat2_num','hero_stat2_label',
            'hero_stat3_num','hero_stat3_label','hero_stat4_num','hero_stat4_label',
            'contact_email','linkedin_url','youtube_url','youtube_intro_url',
            'hire_page_id','appointment_page_id',
            'footer_description','footer_copyright',
            'section_expertise_label','section_expertise_title','section_expertise_subtitle',
            'section_exp_label','section_exp_title','section_exp_subtitle',
            'section_portfolio_label','section_portfolio_title','section_portfolio_subtitle',
            'section_blog_label','section_blog_title','section_blog_subtitle',
            'section_contact_label','section_contact_title','section_contact_description',
            'video_section_title','video_section_description',
            'education_degree','education_field','education_institution','education_year',
        ];
        foreach ($fields as $f) {
            if ( isset($_POST[$f]) ) update_option( 'cbmishra_'.$f, sanitize_textarea_field( wp_unslash($_POST[$f]) ) );
        }
        echo '<div class="notice notice-success is-dismissible"><p><strong>✅ Settings saved successfully!</strong></p></div>';
    }

    $g  = fn($k,$d='') => esc_attr( get_option('cbmishra_'.$k, $d) );
    $gt = fn($k,$d='') => esc_textarea( get_option('cbmishra_'.$k, $d) );

    $pages   = get_pages();
    $hire_id = (int) get_option('cbmishra_hire_page_id', 0);
    $appt_id = (int) get_option('cbmishra_appointment_page_id', 0);
    ?>
    <style>
    .cbm-tab { display:none; }
    .cbm-tab.active { display:block; }
    .cbm-info { background:#e8f5e9;border-left:4px solid #4caf50;padding:12px 16px;border-radius:4px;margin-bottom:20px; }
    </style>
    <div class="wrap">
        <h1>⚙️ CB Mishra Portfolio — Settings</h1>
        <p style="color:#666;">All text on the website can be changed here. For repeating items (Expertise cards, Experience entries, Portfolio projects, Tech Stack categories), use their dedicated menu items in the left sidebar.</p>
        <form method="post">
            <?php wp_nonce_field('cbmishra_settings_nonce'); ?>
            <nav class="nav-tab-wrapper" id="cbm-tabs">
                <a href="#tab-hero"      class="nav-tab nav-tab-active" data-tab="tab-hero">🏠 Hero</a>
                <a href="#tab-sections"  class="nav-tab" data-tab="tab-sections">📑 Section Labels</a>
                <a href="#tab-education" class="nav-tab" data-tab="tab-education">🎓 Education</a>
                <a href="#tab-links"     class="nav-tab" data-tab="tab-links">🔗 Links & Pages</a>
                <a href="#tab-footer"    class="nav-tab" data-tab="tab-footer">📌 Footer</a>
                <a href="#tab-video"     class="nav-tab" data-tab="tab-video">▶️ Video</a>
            </nav>

            <div id="tab-hero" class="cbm-tab active">
                <h2>Hero Section</h2>
                <table class="form-table">
                    <tr><th style="width:200px">Badge Text</th><td><input type="text" name="hero_badge_text" value="<?php echo $g('hero_badge_text','Available for Consulting &amp; Contract Roles'); ?>" class="large-text"></td></tr>
                    <tr><th>Title Line 1 (normal)</th><td><input type="text" name="hero_title_line1" value="<?php echo $g('hero_title_line1','Strategic'); ?>" class="large-text"></td></tr>
                    <tr><th>Title Line 2 (accent)</th><td><input type="text" name="hero_title_line2" value="<?php echo $g('hero_title_line2','Technical Project Manager'); ?>" class="large-text"></td></tr>
                    <tr><th>Description</th><td><textarea name="hero_description" class="large-text" rows="3"><?php echo $gt('hero_description','I bridge the gap between business strategy and technical execution. With 7+ years directing the full SDLC, I help companies architect robust API integrations, roll out enterprise ERPs, and launch profitable SaaS platforms.'); ?></textarea></td></tr>
                </table>
                <h3>Stats</h3>
                <table class="form-table">
                    <tr><th>Stat 1</th><td><input name="hero_stat1_num" value="<?php echo $g('hero_stat1_num','7+'); ?>" style="width:70px"> Label: <input name="hero_stat1_label" value="<?php echo $g('hero_stat1_label','Years Experience'); ?>" style="width:240px"></td></tr>
                    <tr><th>Stat 2</th><td><input name="hero_stat2_num" value="<?php echo $g('hero_stat2_num','40+'); ?>" style="width:70px"> Label: <input name="hero_stat2_label" value="<?php echo $g('hero_stat2_label','Engineers Led'); ?>" style="width:240px"></td></tr>
                    <tr><th>Stat 3</th><td><input name="hero_stat3_num" value="<?php echo $g('hero_stat3_num','35%'); ?>" style="width:70px"> Label: <input name="hero_stat3_label" value="<?php echo $g('hero_stat3_label','Faster Delivery'); ?>" style="width:240px"></td></tr>
                    <tr><th>Stat 4</th><td><input name="hero_stat4_num" value="<?php echo $g('hero_stat4_num','15+'); ?>" style="width:70px"> Label: <input name="hero_stat4_label" value="<?php echo $g('hero_stat4_label','Enterprise Clients'); ?>" style="width:240px"></td></tr>
                </table>
            </div>

            <div id="tab-sections" class="cbm-tab">
                <div class="cbm-info"><strong>Tip:</strong> These control the labels/headings of each section. To add/edit/delete cards and entries, use the sidebar menu items (Expertise, Experience, Portfolio, Tech Stack).</div>
                <?php
                $sections = [
                    'expertise'  => ['What I Do', 'Expertise', 'Specialized Capabilities That Drive Results', 'Specialized capabilities that drive measurable results across enterprise-scale projects.'],
                    'exp'        => ['Experience', 'Experience', 'A Decade of Delivering Excellence', 'A track record of leading complex technical initiatives and high-performing engineering teams.'],
                    'portfolio'  => ['Portfolio', 'Portfolio', 'Architected Solutions', 'Complex platforms and enterprise systems managed from conception to deployment.'],
                    'blog'       => ['Blog', 'From the Blog', 'Latest Insights', 'Thoughts on TPM, enterprise ERP, agile delivery, and bridging business with technology.'],
                    'contact'    => ['Contact', "Let's Connect", 'Ready to Transform Your IT Operations?', "Whether you need an expert to oversee a massive ERP rollout, rescue a failing Agile sprint, or build an MVP — let's talk."],
                ];
                foreach ( $sections as $key => $def ) :
                    $label_key = $key === 'contact' ? 'section_contact_label' : "section_{$key}_label";
                    $title_key = $key === 'contact' ? 'section_contact_title' : "section_{$key}_title";
                    $sub_key   = $key === 'contact' ? 'section_contact_description' : "section_{$key}_subtitle";
                    $sub_field = $key === 'contact' ? 'section_contact_description' : "section_{$key}_subtitle";
                    ?>
                    <h2><?php echo esc_html($def[0]); ?> Section</h2>
                    <table class="form-table">
                        <tr><th style="width:180px">Eyebrow Label</th><td><input name="<?php echo $label_key; ?>" value="<?php echo $g($label_key, $def[1]); ?>" class="large-text"></td></tr>
                        <tr><th>Heading</th><td><input name="<?php echo $title_key; ?>" value="<?php echo $g($title_key, $def[2]); ?>" class="large-text"></td></tr>
                        <tr><th>Subtitle / Description</th><td><textarea name="<?php echo $sub_field; ?>" class="large-text" rows="2"><?php echo $gt($sub_field, $def[3]); ?></textarea></td></tr>
                    </table>
                <?php endforeach; ?>
            </div>

            <div id="tab-education" class="cbm-tab">
                <h2>Education Section</h2>
                <table class="form-table">
                    <tr><th style="width:200px">Degree</th><td><input name="education_degree" value="<?php echo $g('education_degree','Bachelor of Technology (B.Tech)'); ?>" class="large-text"></td></tr>
                    <tr><th>Field of Study</th><td><input name="education_field" value="<?php echo $g('education_field','Electronics and Communication Engineering'); ?>" class="large-text"></td></tr>
                    <tr><th>Institution</th><td><input name="education_institution" value="<?php echo $g('education_institution','Cambridge Institute of Technology, Ranchi University'); ?>" class="large-text"></td></tr>
                    <tr><th>Graduation Year</th><td><input name="education_year" value="<?php echo $g('education_year','Graduated: July 2019'); ?>" class="large-text"></td></tr>
                </table>
            </div>

            <div id="tab-links" class="cbm-tab">
                <h2>Contact & Social</h2>
                <table class="form-table">
                    <tr><th style="width:220px">Contact Email</th><td><input type="email" name="contact_email" value="<?php echo $g('contact_email','cmmishracb@gmail.com'); ?>" class="large-text"></td></tr>
                    <tr><th>LinkedIn URL</th><td><input type="url" name="linkedin_url" value="<?php echo $g('linkedin_url','https://www.linkedin.com/in/cbmishra/'); ?>" class="large-text"></td></tr>
                    <tr><th>YouTube Channel URL</th><td><input type="url" name="youtube_url" value="<?php echo $g('youtube_url','https://www.youtube.com/@imcbmishra'); ?>" class="large-text"></td></tr>
                    <tr><th>YouTube Intro Video URL</th><td><input type="url" name="youtube_intro_url" value="<?php echo $g('youtube_intro_url','https://www.youtube.com/embed/iLYggCc-TF8'); ?>" class="large-text"><p class="description">Use embed format: <code>https://www.youtube.com/embed/VIDEO_ID</code></p></td></tr>
                </table>
                <h2>Page Assignments</h2>
                <div style="background:#fff3cd;border:1px solid #ffc107;padding:14px 18px;border-radius:4px;margin-bottom:20px;">
                    <strong>Setup steps:</strong><br>
                    1. Go to <strong>Pages → Add New</strong>, choose template <strong>"Hire Me"</strong>, publish it.<br>
                    2. Do the same for template <strong>"Book Appointment"</strong>.<br>
                    3. Come back here and select those pages below. The <strong>Hire Me button</strong> in the header will link automatically.
                </div>
                <table class="form-table">
                    <tr><th style="width:220px">Hire Me Page</th><td>
                        <select name="hire_page_id">
                            <option value="0">— Select a page —</option>
                            <?php foreach ($pages as $p) echo '<option value="'.(int)$p->ID.'"'.selected($hire_id,$p->ID,false).'>'.esc_html($p->post_title).'</option>'; ?>
                        </select>
                        <?php if ($hire_id) echo ' &nbsp;<a href="'.esc_url(get_permalink($hire_id)).'" target="_blank">View →</a>'; ?>
                    </td></tr>
                    <tr><th>Book Appointment Page</th><td>
                        <select name="appointment_page_id">
                            <option value="0">— Select a page —</option>
                            <?php foreach ($pages as $p) echo '<option value="'.(int)$p->ID.'"'.selected($appt_id,$p->ID,false).'>'.esc_html($p->post_title).'</option>'; ?>
                        </select>
                        <?php if ($appt_id) echo ' &nbsp;<a href="'.esc_url(get_permalink($appt_id)).'" target="_blank">View →</a>'; ?>
                    </td></tr>
                </table>
            </div>

            <div id="tab-footer" class="cbm-tab">
                <h2>Footer</h2>
                <table class="form-table">
                    <tr><th style="width:200px">Brand Description</th><td><textarea name="footer_description" class="large-text" rows="2"><?php echo $gt('footer_description','Strategic Technical Project Manager bridging business requirements and technical execution for global enterprises.'); ?></textarea></td></tr>
                    <tr><th>Copyright Line</th><td><input name="footer_copyright" value="<?php echo $g('footer_copyright','© 2026 C B Mishra — Built for Digital Excellence'); ?>" class="large-text"></td></tr>
                </table>
            </div>

            <div id="tab-video" class="cbm-tab">
                <h2>Video Introduction Section</h2>
                <table class="form-table">
                    <tr><th style="width:200px">Section Heading</th><td><input name="video_section_title" value="<?php echo $g('video_section_title','Watch My Intro'); ?>" class="large-text"></td></tr>
                    <tr><th>Description</th><td><textarea name="video_section_description" class="large-text" rows="2"><?php echo $gt('video_section_description','Get to know me, my approach, and how I can transform your enterprise operations.'); ?></textarea></td></tr>
                </table>
            </div>

            <p class="submit"><input type="submit" name="cbm_save" class="button button-primary button-large" value="💾  Save All Settings"></p>
        </form>
    </div>
    <script>
    document.querySelectorAll('#cbm-tabs .nav-tab').forEach(function(tab) {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.cbm-tab').forEach(function(t){ t.classList.remove('active'); });
            document.querySelectorAll('#cbm-tabs .nav-tab').forEach(function(t){ t.classList.remove('nav-tab-active'); });
            document.getElementById(this.dataset.tab).classList.add('active');
            this.classList.add('nav-tab-active');
        });
    });
    </script>
    <?php
}

// ============================================================
// AUTO-SEED DEFAULT CONTENT
// ============================================================
function cbmishra_seed_defaults() {
    if ( get_option('cbmishra_seeded_v3') ) return;

    $expertise_items = [
        ['title'=>'Digital Transformation',    'icon'=>'🔄','order'=>1,'content'=>'Guiding businesses from scratch to market dominance. End-to-end orchestration — from brand naming and concept ideation to full-scale product launch and scaling operations.'],
        ['title'=>'Enterprise ERP & CRM',       'icon'=>'⚙️','order'=>2,'content'=>'Specialized in full-scale Odoo 16–19 Enterprise and Zoho Ecosystem implementations. Streamline operations, automate lot/batch tracking, and reduce logistical overheads.'],
        ['title'=>'Complex API Integrations',   'icon'=>'🔗','order'=>3,'content'=>'Architecting robust RESTful API structures. Deep expertise integrating Decentro Fintech APIs, Stripe, Razorpay, Google Maps/Earth APIs, and IoT hardware.'],
        ['title'=>'Engineering Team Leadership','icon'=>'👥','order'=>4,'content'=>'Leading cross-functional squads of 40+ members across full-stack Web (MERN, React, PHP) and Mobile (Flutter) paradigms, with multi-million-rupee budget ownership.'],
        ['title'=>'Web & Mobile Development',   'icon'=>'📱','order'=>5,'content'=>'Directing end-to-end SaaS platform development (MERN, PHP, React) and robust cross-platform mobile apps (Flutter, Native iOS/Android) for B2B and B2C markets.'],
        ['title'=>'0-to-1 Product Strategy',    'icon'=>'🚀','order'=>6,'content'=>'Bridging business strategy with technical execution through rigorous BRD/FRD documentation, rapid MVP launches, and precise Go-To-Market strategies.'],
    ];
    foreach ($expertise_items as $item) {
        $ex = get_posts(['post_type'=>'expertise','title'=>$item['title'],'post_status'=>'any','numberposts'=>1]);
        if ($ex) continue;
        $pid = wp_insert_post(['post_type'=>'expertise','post_title'=>$item['title'],'post_content'=>$item['content'],'post_status'=>'publish','menu_order'=>$item['order']]);
        if ($pid) update_post_meta($pid,'_expertise_icon',$item['icon']);
    }

    $experiences = [
        ['title'=>'Strategic Technical Project Manager','order'=>1,'date'=>'Jan 2024 — Present','company'=>'Global Enterprise Solutions','role'=>'Strategic Technical Project Manager',
         'highlights'=>"End-to-End Enterprise Rollouts: Directed complex IT implementations for Odoo ERP (v17-v19) and Zoho CRM ecosystems across 15+ global enterprise clients on US-based AWS infrastructure.\nProduct Lifecycle & Requirement Engineering: Managed the complete SDLC from ideation to deployment. Authored rigorous BRDs, FRDs, and user stories, directly bridging business strategy with technical execution.\nCross-Functional Leadership: Led diverse engineering and UI/UX squads of 40+ members (Frontend, Backend, Mobile, QA, DevOps) to architect and launch highly customized SaaS and mobile platforms.\nAgile & Scrum Execution: Executed strict Agile methodologies, orchestrating sprint planning, backlog grooming, and complete Jira/Epics management to maintain aggressive team velocity.\nComplex API Integrations: Engineered seamless connections bridging core ERP backends with third-party Fintech solutions (Decentro), payment gateways, global e-commerce platforms, and IoT hardware dashboards.\nProcess Optimization: Architected advanced lot/batch workflows driving a 35% reduction in cycle times, and fully optimized logistical algorithms to achieve a 28% reduction in transportation costs.\nDelivery & Infrastructure Ownership: Oversaw comprehensive server setups, rigorous QA deployment planning, release management, and 360° stakeholder communication — consistently delivering project milestones 15% ahead of schedule."],
        ['title'=>'Independent TPM & Consultant','order'=>2,'date'=>'Apr 2022 — Dec 2023','company'=>'Remote Contract Engagements','role'=>'Independent TPM & Consultant',
         'highlights'=>"Strategic Consulting & MVPs: Directed strategic consulting engagements encompassing rapid MVP launches and complex enterprise systems for diverse IT clients.\n0-to-1 Product Lifecycle: Spearheaded the entire product lifecycle for multiple high-impact SaaS platforms and mobile applications, including CRM platforms and health-tech apps integrating Google Fit/Health Connect.\nTechnical Architecture & Documentation: Bridged business strategy and backend engineering by authoring rigorous PRDs, BRDs, and defining robust API architectures.\nCustom Enterprise Solutions: Implemented highly customized Zoho solutions (CRM, Mail, Meeting) and tailored WordPress architectures to streamline operational workflows for B2B startups.\nGovernance & Delivery: Managed complex stakeholder communications, establishing strict project governance, resource allocation, and budget tracking to ensure 100% adherence to project delivery timelines."],
        ['title'=>'Product Owner / Application Engineer','order'=>3,'date'=>'Nov 2019 — Feb 2022','company'=>'Digital Transformation Agency','role'=>'Product Owner / Application Engineer',
         'highlights'=>"Team Management & Delivery: Managed cross-functional development teams to deliver diverse web applications and custom WordPress solutions, successfully transitioning from technical execution to strategic product leadership.\nMarket Research & GTM Strategy: Executed comprehensive market research and Go-To-Market (GTM) strategies, translating direct user feedback into actionable technical requirements and Agile backlogs.\nDigital Presence & Acquisition: Orchestrated end-to-end digital presence strategies, integrating SEO, SEM, and CRM tools to drive measurable user acquisition and brand awareness for client deliverables."],
    ];
    foreach ($experiences as $e) {
        $ex = get_posts(['post_type'=>'experience','title'=>$e['title'],'post_status'=>'any','numberposts'=>1]);
        if ($ex) continue;
        $pid = wp_insert_post(['post_type'=>'experience','post_title'=>$e['title'],'post_status'=>'publish','menu_order'=>$e['order']]);
        if ($pid) {
            update_post_meta($pid,'_exp_date_range',$e['date']);
            update_post_meta($pid,'_exp_company',$e['company']);
            update_post_meta($pid,'_exp_role',$e['role']);
            update_post_meta($pid,'_exp_highlights',$e['highlights']);
        }
    }

    $projects = [
        ['title'=>'Multi-Industry ERP Implementations','icon'=>'🏭','cat'=>'ERP / Enterprise','tags'=>'Odoo ERP, Cross-Industry, Cloud Infrastructure','order'=>1,'excerpt'=>'Directed 15+ full-scale ERP deployments across Manufacturing, Solar, Retail, FMCG, and SaaS. Customized complex supply chain, accounting, and HR workflows.'],
        ['title'=>'Neo-Banking Mobile Platform','icon'=>'🏦','cat'=>'Fintech / Mobile','tags'=>'Flutter, Decentro APIs, Payment Gateways','order'=>2,'excerpt'=>'Led a secure digital banking app integrating Decentro APIs. Automated KYC onboarding and built dual-recourse mechanisms for instant capital release workflows.'],
        ['title'=>'B2B Smart Estimation & IoT Tool','icon'=>'⚡','cat'=>'IoT / SaaS','tags'=>'MERN Stack, IoT Integration, Odoo Backend','order'=>3,'excerpt'=>'Launched a customized MERN-stack estimation platform alongside an IoT dashboard connecting smart hardware inverters to enterprise cloud analytics.'],
        ['title'=>'Comprehensive Fitness SaaS','icon'=>'🏃','cat'=>'Health-Tech','tags'=>'Google Fit APIs, Mobile, Zoho CRM','order'=>4,'excerpt'=>'Spearheaded 0-to-1 delivery integrating Google Fit/Health Connect wearable APIs with a comprehensive B2B studio management suite.'],
        ['title'=>'E-Commerce Solutions','icon'=>'🛒','cat'=>'Retail & E-Commerce','tags'=>'Odoo eCommerce, WooCommerce, Custom','order'=>5,'excerpt'=>'End-to-end development of robust e-commerce platforms tailored for high-volume sales across multiple digital ecosystems.'],
        ['title'=>'E-Learning Platforms','icon'=>'🎓','cat'=>'EdTech','tags'=>'Odoo Education, Custom LMS','order'=>6,'excerpt'=>'Architected comprehensive e-learning solutions from Odoo-based education modules to fully customized standalone Learning Management Systems.'],
        ['title'=>'Mobile Application Development','icon'=>'📱','cat'=>'Mobile Solutions','tags'=>'Flutter, Native iOS, Native Android','order'=>7,'excerpt'=>'Directed complete mobile application lifecycles across multiple ecosystems to reach vast B2B and B2C user bases globally.'],
        ['title'=>'Enterprise Web Development','icon'=>'🌐','cat'=>'Web Solutions','tags'=>'MERN, PHP, Responsive UI/UX','order'=>8,'excerpt'=>'Developed and launched multiple high-performing, responsive websites and complex web applications for modern business requirements.'],
        ['title'=>'API Dev & Integrations','icon'=>'🔗','cat'=>'API Development','tags'=>'RESTful APIs, Third-Party, Data Sync','order'=>9,'excerpt'=>'Engineered custom APIs and executed complex third-party integrations connecting core business tools with external SaaS ecosystems.'],
    ];
    foreach ($projects as $p) {
        $ex = get_posts(['post_type'=>'project','title'=>$p['title'],'post_status'=>'any','numberposts'=>1]);
        if ($ex) continue;
        $pid = wp_insert_post(['post_type'=>'project','post_title'=>$p['title'],'post_excerpt'=>$p['excerpt'],'post_status'=>'publish','menu_order'=>$p['order']]);
        if ($pid) {
            update_post_meta($pid,'_project_icon',$p['icon']);
            update_post_meta($pid,'_project_category_label',$p['cat']);
            update_post_meta($pid,'_project_tags',$p['tags']);
        }
    }

    $tech_cats = [
        ['title'=>'ERP & Odoo Core',        'num'=>'01','order'=>1,'items'=>'Odoo 16-19 (Comm/Ent), Odoo.sh & On-Premise, QWeb & XML Architecture, Ninja Dashboard, Custom Module Dev, Zoho ERP & Zoho One, Amazon & Shopee Connectors'],
        ['title'=>'Mobile App Development',  'num'=>'02','order'=>2,'items'=>'Flutter (Dart), Native iOS (Swift/UIKit), Native Android (Kotlin), React Native, Xamarin (C#)'],
        ['title'=>'Web Dev & Backend',       'num'=>'03','order'=>3,'items'=>'Python & Django, PHP & Laravel, MERN Stack, Node.js & Express, React.js & Next.js, C# & .NET, BaaS Architecture'],
        ['title'=>'Databases & Cloud',       'num'=>'04','order'=>4,'items'=>'PostgreSQL, MySQL & MongoDB, AWS (EC2/S3/Lightsail), Google Cloud, GitHub Actions (CI/CD), GitLab & Bitbucket, Nginx & Apache'],
        ['title'=>'Payment & Fintech APIs',  'num'=>'05','order'=>5,'items'=>'Decentro Fintech API, Stripe & Razorpay, PayPal & PayU, Instamojo & Fatora, Modularity API, zahls.ch & Postfinance'],
        ['title'=>'Logistics APIs',          'num'=>'06','order'=>6,'items'=>'DHL Express, FedEx / UPS / USPS, Shiprocket & Falcon Flex, bpost & Easypost, Sendcloud & Envia'],
        ['title'=>'Geo, Gov & B2B APIs',     'num'=>'07','order'=>7,'items'=>'Postman, API Setu (Gov KYC), Google Earth Engine, Google Maps & Business, LinkedIn & Indeed APIs, WhatsApp & Socket.IO'],
        ['title'=>'Design & DevTools',       'num'=>'08','order'=>8,'items'=>'Figma (UI/UX), OBS Studio & Loom, Canva, Power BI & Analytics, Meta Business Suite, AutoCAD & SketchUp'],
        ['title'=>'Agile & PM Tools',        'num'=>'09','order'=>9,'items'=>'Jira & Confluence, Trello & Asana, Notion, Slack & Teams, Zoom & Google Meet, MS Project'],
    ];
    foreach ($tech_cats as $tc) {
        $ex = get_posts(['post_type'=>'tech_stack','title'=>$tc['title'],'post_status'=>'any','numberposts'=>1]);
        if ($ex) continue;
        $pid = wp_insert_post(['post_type'=>'tech_stack','post_title'=>$tc['title'],'post_status'=>'publish','menu_order'=>$tc['order']]);
        if ($pid) {
            update_post_meta($pid,'_tech_items',$tc['items']);
            update_post_meta($pid,'_tech_order_num',$tc['num']);
        }
    }

    update_option('cbmishra_seeded_v3', true);
}
add_action('after_switch_theme', 'cbmishra_seed_defaults');
add_action('wp_loaded', 'cbmishra_seed_defaults');

// ============================================================
// AJAX HANDLERS
// ============================================================
function cbmishra_handle_hire_form() {
    if (!check_ajax_referer('cbmishra_nonce','nonce',false)) wp_send_json_error(['message'=>'Security check failed.']);

    $name    = sanitize_text_field($_POST['full_name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $company = sanitize_text_field($_POST['company'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $service = sanitize_text_field($_POST['service_type'] ?? '');
    $budget  = sanitize_text_field($_POST['budget_range'] ?? '');
    $tl      = sanitize_text_field($_POST['timeline'] ?? '');
    $desc    = sanitize_textarea_field($_POST['project_desc'] ?? '');

    if (empty($name)) wp_send_json_error(['message'=>'Please enter your full name.']);
    if (!is_email($email)) wp_send_json_error(['message'=>'Please enter a valid email address.']);
    if (empty($desc)) wp_send_json_error(['message'=>'Please describe your project.']);

    $pid = wp_insert_post(['post_type'=>'hire_submission','post_title'=>$name.' — '.gmdate('Y-m-d H:i'),'post_status'=>'publish']);
    if ($pid && !is_wp_error($pid)) {
        foreach (['name'=>$name,'email'=>$email,'company'=>$company,'phone'=>$phone,'service'=>$service,'budget'=>$budget,'timeline'=>$tl,'desc'=>$desc] as $k=>$v)
            update_post_meta($pid,"_hire_{$k}",$v);
        $to = get_option('cbmishra_contact_email', get_option('admin_email'));
        wp_mail($to,"New Hire Request from {$name}","Name: {$name}\nEmail: {$email}\nCompany: {$company}\nService: {$service}\nBudget: {$budget}\n\n{$desc}");
        wp_send_json_success(['message'=>"Thank you {$name}! I've received your inquiry and will respond within 24 hours."]);
    }
    wp_send_json_error(['message'=>'Something went wrong. Please try again.']);
}
add_action('wp_ajax_cbmishra_hire_form','cbmishra_handle_hire_form');
add_action('wp_ajax_nopriv_cbmishra_hire_form','cbmishra_handle_hire_form');

function cbmishra_handle_appointment() {
    if (!check_ajax_referer('cbmishra_nonce','nonce',false)) wp_send_json_error(['message'=>'Security check failed.']);

    $name    = sanitize_text_field($_POST['full_name'] ?? '');
    $company = sanitize_text_field($_POST['company_name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $date    = sanitize_text_field($_POST['preferred_date'] ?? '');
    $time    = sanitize_text_field($_POST['preferred_time'] ?? '');
    $topic   = sanitize_text_field($_POST['topic'] ?? '');
    $desc    = sanitize_textarea_field($_POST['description'] ?? '');

    if (empty($name)) wp_send_json_error(['message'=>'Please enter your full name.']);
    if (!is_email($email)) wp_send_json_error(['message'=>'Please enter a valid email address.']);
    if (empty($date)) wp_send_json_error(['message'=>'Please select a preferred date.']);
    if (empty($time)) wp_send_json_error(['message'=>'Please select a preferred time.']);

    $pid = wp_insert_post(['post_type'=>'appointment','post_title'=>$name.' — '.$date.' '.$time,'post_status'=>'publish']);
    if ($pid && !is_wp_error($pid)) {
        foreach (['name'=>$name,'company'=>$company,'email'=>$email,'date'=>$date,'time'=>$time,'topic'=>$topic,'desc'=>$desc] as $k=>$v)
            update_post_meta($pid,"_appt_{$k}",$v);
        $to = get_option('cbmishra_contact_email', get_option('admin_email'));
        wp_mail($to,"Appointment Request from {$name}","Name: {$name}\nEmail: {$email}\nDate: {$date}\nTime: {$time}\nTopic: {$topic}\n\n{$desc}");
        wp_send_json_success(['message'=>"Your appointment request is submitted! I'll confirm the time shortly, {$name}."]);
    }
    wp_send_json_error(['message'=>'Something went wrong. Please try again.']);
}
add_action('wp_ajax_cbmishra_appointment','cbmishra_handle_appointment');
add_action('wp_ajax_nopriv_cbmishra_appointment','cbmishra_handle_appointment');

// ============================================================
// PWA
// ============================================================
add_action('wp_head', function() {
    echo '<link rel="manifest" href="'.esc_url(home_url('/manifest.json')).'">' . "\n";
    echo '<meta name="theme-color" content="#050A14">' . "\n";
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
    echo '<meta name="apple-mobile-web-app-title" content="CB Mishra">' . "\n";
});

add_action('init', function() {
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    if ($path === '/manifest.json') {
        header('Content-Type: application/manifest+json');
        echo wp_json_encode(['name'=>'C B Mishra — Portfolio','short_name'=>'CB Mishra','start_url'=>home_url('/'),'display'=>'standalone','background_color'=>'#050A14','theme_color'=>'#00D4FF']);
        exit;
    }
    if ($path === '/sw.js') { header('Content-Type: application/javascript'); include CBMISHRA_DIR.'/sw.js'; exit; }
}, 1);

// ============================================================
// SEO
// ============================================================
add_action('wp_head', function() {
    $d = is_singular() ? wp_trim_words(get_the_excerpt(),20,'...') : 'Strategic Technical Project Manager bridging business strategy and technical execution.';
    echo '<meta name="description" content="'.esc_attr($d).'">' . "\n";
});

// ============================================================
// HELPERS
// ============================================================
function cbmishra_opt($key, $default='') { return get_option('cbmishra_'.$key, $default); }

function cbmishra_hire_url() {
    $pid = (int)cbmishra_opt('hire_page_id',0);
    if ($pid && get_post_status($pid)==='publish') return get_permalink($pid);
    $p = get_posts(['post_type'=>'page','meta_key'=>'_wp_page_template','meta_value'=>'page-hire.php','numberposts'=>1]);
    return $p ? get_permalink($p[0]->ID) : home_url('/#contact');
}
function cbmishra_appointment_url() {
    $pid = (int)cbmishra_opt('appointment_page_id',0);
    if ($pid && get_post_status($pid)==='publish') return get_permalink($pid);
    $p = get_posts(['post_type'=>'page','meta_key'=>'_wp_page_template','meta_value'=>'page-appointment.php','numberposts'=>1]);
    return $p ? get_permalink($p[0]->ID) : home_url('/#contact');
}
function cbmishra_blogs_url() {
    $p = get_page_by_path('blogs');
    return $p ? get_permalink($p->ID) : home_url('/blogs/');
}
function cbmishra_read_time($content=null) {
    $content = $content ?: get_the_content();
    return max(1,(int)ceil(str_word_count(strip_tags($content))/200)).' min read';
}
function cbmishra_get_tags($str) {
    return array_values(array_filter(array_map('trim',explode(',',$str))));
}

// ============================================================
// SECURITY
// ============================================================
remove_action('wp_head','wp_generator');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wp_shortlink_wp_head');
add_filter('xmlrpc_enabled','__return_false');
add_filter('excerpt_length', fn() => 25);
add_filter('excerpt_more',   fn() => '...');

require_once CBMISHRA_DIR . '/inc/template-tags.php';
