<?php
/**
 * Template tags — CB Mishra Portfolio
 *
 * @package CBMishra_Portfolio
 */
defined('ABSPATH') || exit;

// ============================================================
// SECTION HEADER
// ============================================================
function cbmishra_section_header($args=[]) {
    $args = wp_parse_args($args, ['label'=>'','title'=>'','subtitle'=>'','centered'=>false]);
    $cls  = $args['centered'] ? ' style="text-align:center;"' : '';
    echo '<div class="section-header"' . $cls . '>';
    if ($args['label']) echo '<div class="section-label reveal">' . esc_html($args['label']) . '</div>';
    if ($args['title']) echo '<h2 class="section-title reveal reveal-delay-1">' . esc_html($args['title']) . '</h2>';
    if ($args['subtitle']) echo '<p class="section-subtitle reveal reveal-delay-2">' . esc_html($args['subtitle']) . '</p>';
    echo '</div>';
}

// ============================================================
// BLOG CARD
// ============================================================
function cbmishra_blog_card($post_id=null) {
    if ($post_id) { $post = get_post($post_id); setup_postdata($post); }
    ?>
    <article class="blog-card reveal">
        <a href="<?php the_permalink(); ?>" class="blog-card-image-link" tabindex="-1" aria-label="<?php the_title_attribute(); ?>">
            <div class="blog-card-image">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('blog-card', ['loading'=>'lazy','alt'=>esc_attr(get_the_title())]); ?>
                <?php else: ?>
                    <div class="blog-card-image-placeholder" aria-hidden="true">✍️</div>
                <?php endif; ?>
            </div>
        </a>
        <div class="blog-card-body">
            <div class="blog-card-meta">
                <?php
                $cats = get_the_category();
                $cat_name = $cats ? $cats[0]->name : 'Article';
                echo '<span class="blog-category">' . esc_html($cat_name) . '</span>';
                ?>
                <span class="blog-date"><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                <span class="blog-read-time"><?php echo esc_html(cbmishra_read_time()); ?></span>
            </div>
            <h3 class="blog-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="blog-card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
            <div class="blog-card-footer">
                <div class="blog-author">
                    <div class="blog-author-avatar" aria-hidden="true">CB</div>
                    <span class="blog-author-name"><?php echo esc_html(get_the_author()); ?></span>
                </div>
                <a href="<?php the_permalink(); ?>" class="blog-read-link">Read <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </article>
    <?php
    if ($post_id) wp_reset_postdata();
}

// ============================================================
// EXPERTISE CARD
// ============================================================
function cbmishra_expertise_card($post) {
    $icon    = get_post_meta($post->ID,'_expertise_icon',true) ?: '💡';
    $content = apply_filters('the_content', get_post_field('post_content', $post->ID));
    if (empty(trim(strip_tags($content)))) $content = '<p>' . esc_html(get_the_excerpt($post)) . '</p>';
    ?>
    <div class="expertise-card card reveal">
        <div class="expertise-icon" aria-hidden="true"><?php echo esc_html($icon); ?></div>
        <h3 class="expertise-title"><?php echo esc_html(get_the_title($post)); ?></h3>
        <div class="expertise-desc"><?php echo wp_kses_post($content); ?></div>
    </div>
    <?php
}

// ============================================================
// EXPERIENCE ITEM
// ============================================================
function cbmishra_experience_item($post) {
    $date       = get_post_meta($post->ID,'_exp_date_range',true);
    $role       = get_post_meta($post->ID,'_exp_role',true) ?: get_the_title($post);
    $company    = get_post_meta($post->ID,'_exp_company',true);
    $highlights = get_post_meta($post->ID,'_exp_highlights',true);
    $lines      = $highlights ? array_filter(array_map('trim', explode("\n", $highlights))) : [];
    ?>
    <div class="experience-item reveal">
        <?php if ($date): ?>
            <p class="experience-date"><?php echo esc_html($date); ?></p>
        <?php endif; ?>
        <h3 class="experience-role"><?php echo esc_html($role); ?></h3>
        <?php if ($company): ?>
            <p class="experience-company"><?php echo esc_html($company); ?></p>
        <?php endif; ?>
        <?php if ($lines): ?>
            <div class="experience-details">
                <?php foreach ($lines as $line):
                    $parts = explode(':', $line, 2);
                    if (count($parts) === 2): ?>
                        <div class="experience-detail-item">
                            <p class="experience-detail-title"><?php echo esc_html(trim($parts[0])); ?>:</p>
                            <p class="experience-detail-desc"><?php echo esc_html(trim($parts[1])); ?></p>
                        </div>
                    <?php else: ?>
                        <p class="experience-detail-desc"><?php echo esc_html($line); ?></p>
                    <?php endif;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

// ============================================================
// PORTFOLIO CARD
// ============================================================
function cbmishra_portfolio_card($post) {
    $icon    = get_post_meta($post->ID,'_project_icon',true) ?: '🚀';
    $cat     = get_post_meta($post->ID,'_project_category_label',true);
    $tags_r  = get_post_meta($post->ID,'_project_tags',true);
    $tags    = cbmishra_get_tags($tags_r);
    $desc    = get_post_field('post_excerpt',$post->ID);
    if (!$desc) $desc = wp_trim_words(get_post_field('post_content',$post->ID), 25);
    ?>
    <div class="portfolio-card reveal">
        <div class="portfolio-card-header">
            <div class="portfolio-icon" aria-hidden="true"><?php echo esc_html($icon); ?></div>
            <div>
                <?php if ($cat): ?>
                    <p class="portfolio-category"><?php echo esc_html($cat); ?></p>
                <?php endif; ?>
                <h3 class="portfolio-title"><?php echo esc_html(get_the_title($post)); ?></h3>
            </div>
        </div>
        <p class="portfolio-desc"><?php echo esc_html($desc); ?></p>
        <?php if ($tags): ?>
            <div class="portfolio-tags">
                <?php foreach ($tags as $tag): ?>
                    <span class="tag"><?php echo esc_html($tag); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

// ============================================================
// HIRE ME FORM
// ============================================================
function cbmishra_hire_form() {
    ?>
    <div id="hire-success" class="form-success" role="alert" style="display:none;"></div>
    <form id="hire-me-form" class="hire-form" novalidate>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label required" for="hire_name">Full Name</label>
                <input type="text" id="hire_name" name="full_name" class="form-input" placeholder="Your full name" required autocomplete="name">
            </div>
            <div class="form-group">
                <label class="form-label required" for="hire_email">Email Address</label>
                <input type="email" id="hire_email" name="email" class="form-input" placeholder="your@email.com" required autocomplete="email">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="hire_company">Company Name</label>
                <input type="text" id="hire_company" name="company" class="form-input" placeholder="Your company (optional)" autocomplete="organization">
            </div>
            <div class="form-group">
                <label class="form-label" for="hire_phone">Phone Number</label>
                <input type="tel" id="hire_phone" name="phone" class="form-input" placeholder="+91 98765 43210" autocomplete="tel">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="hire_service">Service Type</label>
                <select id="hire_service" name="service_type" class="form-input">
                    <option value="">— Select a service —</option>
                    <option value="Digital Transformation">Digital Transformation</option>
                    <option value="Enterprise ERP / CRM">Enterprise ERP / CRM (Odoo, Zoho)</option>
                    <option value="API Integration">API Architecture & Integration</option>
                    <option value="Web & Mobile Dev">Web & Mobile Development</option>
                    <option value="Team Leadership">Engineering Team Leadership</option>
                    <option value="0-to-1 Product Strategy">0-to-1 Product Strategy</option>
                    <option value="Technical Consulting">Technical Consulting</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="hire_budget">Budget Range</label>
                <select id="hire_budget" name="budget_range" class="form-input">
                    <option value="">— Select budget —</option>
                    <option value="Under ₹1L">Under ₹1 Lakh</option>
                    <option value="₹1L–₹5L">₹1L – ₹5L</option>
                    <option value="₹5L–₹20L">₹5L – ₹20L</option>
                    <option value="₹20L+">₹20L+</option>
                    <option value="Discuss">Let's Discuss</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="hire_timeline">Project Timeline</label>
            <select id="hire_timeline" name="timeline" class="form-input">
                <option value="">— Select timeline —</option>
                <option value="ASAP">ASAP</option>
                <option value="Within 1 Month">Within 1 Month</option>
                <option value="Within 3 Months">Within 3 Months</option>
                <option value="Ongoing">Ongoing / Long-term</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label required" for="hire_desc">Project Description</label>
            <textarea id="hire_desc" name="project_desc" class="form-textarea" placeholder="Describe your project, goals, and what you need help with..." required></textarea>
        </div>
        <button type="submit" class="btn btn-hire w-full">
            <span class="btn-text">Send Inquiry →</span>
            <span class="btn-loading" style="display:none;">Sending...</span>
        </button>
    </form>
    <?php
}

// ============================================================
// APPOINTMENT FORM
// ============================================================
function cbmishra_appointment_form() {
    ?>
    <div id="appt-success" class="form-success" role="alert" style="display:none;"></div>
    <form id="appointment-form" class="booking-form" novalidate>
        <div class="form-group">
            <label class="form-label required" for="appt_name">Full Name</label>
            <input type="text" id="appt_name" name="full_name" class="form-input" placeholder="Your full name" required autocomplete="name">
        </div>
        <div class="form-group">
            <label class="form-label" for="appt_company">Company Name</label>
            <input type="text" id="appt_company" name="company_name" class="form-input" placeholder="Your company (optional)" autocomplete="organization">
        </div>
        <div class="form-group">
            <label class="form-label required" for="appt_email">Email Address</label>
            <input type="email" id="appt_email" name="email" class="form-input" placeholder="your@email.com" required autocomplete="email">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label required" for="appt_date">Preferred Date</label>
                <input type="date" id="appt_date" name="preferred_date" class="form-input" required
                       min="<?php echo esc_attr(gmdate('Y-m-d', strtotime('+1 day'))); ?>">
            </div>
            <div class="form-group">
                <label class="form-label required" for="appt_time">Preferred Time (IST)</label>
                <select id="appt_time" name="preferred_time" class="form-input" required>
                    <option value="">— Select time slot —</option>
                    <option value="09:00 AM">09:00 AM IST</option>
                    <option value="10:00 AM">10:00 AM IST</option>
                    <option value="11:00 AM">11:00 AM IST</option>
                    <option value="12:00 PM">12:00 PM IST</option>
                    <option value="02:00 PM">02:00 PM IST</option>
                    <option value="03:00 PM">03:00 PM IST</option>
                    <option value="04:00 PM">04:00 PM IST</option>
                    <option value="05:00 PM">05:00 PM IST</option>
                    <option value="06:00 PM">06:00 PM IST</option>
                    <option value="07:00 PM">07:00 PM IST</option>
                    <option value="08:00 PM">08:00 PM IST</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="appt_topic">Consultation Topic</label>
            <select id="appt_topic" name="topic" class="form-input">
                <option value="">— Select a topic —</option>
                <option value="ERP Implementation">ERP Implementation (Odoo / Zoho)</option>
                <option value="Digital Transformation">Digital Transformation Strategy</option>
                <option value="API Integration">API Integration & Architecture</option>
                <option value="Product Development">Product Development (0-to-1)</option>
                <option value="Agile / Team Leadership">Agile & Team Leadership</option>
                <option value="General Consultation">General Consultation</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label" for="appt_desc">Brief Description</label>
            <textarea id="appt_desc" name="description" class="form-textarea" placeholder="What would you like to discuss? Share any relevant context..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-full">
            <span class="btn-text">Book Appointment 📅</span>
            <span class="btn-loading" style="display:none;">Submitting...</span>
        </button>
    </form>
    <?php
}

// ============================================================
// PAGINATION
// ============================================================
function cbmishra_pagination($query=null) {
    global $wp_query;
    $q       = $query ?: $wp_query;
    $total   = $q->max_num_pages;
    $current = max(1, get_query_var('paged'));
    if ($total <= 1) return;
    ?>
    <nav class="pagination" aria-label="Posts pagination">
        <?php
        $links = paginate_links([
            'base'      => str_replace(PHP_INT_MAX,'%#%',esc_url(get_pagenum_link(PHP_INT_MAX))),
            'format'    => '?paged=%#%',
            'current'   => $current,
            'total'     => $total,
            'prev_text' => '← Previous',
            'next_text' => 'Next →',
            'type'      => 'array',
        ]);
        if ($links) foreach ($links as $link) echo '<div class="page-item">'.$link.'</div>';
        ?>
    </nav>
    <?php
}
