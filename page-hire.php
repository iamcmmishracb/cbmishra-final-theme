<?php
/**
 * Hire Me Page
 * Template Name: Hire Me
 * @package CBMishra_Portfolio
 */
get_header();
?>
<main id="main-content" role="main">

    <div class="page-hero grid-bg">
        <div class="container" style="text-align:center;">
            <div class="section-label" style="justify-content:center;">Let's Work Together</div>
            <h1 class="section-title" style="margin:16px auto;">Hire Me</h1>
            <p class="section-subtitle" style="margin:0 auto;">
                Fill out the form below and I'll get back to you within 24 hours with a tailored proposal.
            </p>
        </div>
    </div>

    <section class="section-padding" style="background:var(--bg-primary);">
        <div class="container">
            <div class="hire-page-grid">

                <!-- Left: What you get -->
                <div>
                    <h2 style="font-family:var(--font-display);font-weight:700;font-size:24px;color:var(--text-primary);margin-bottom:16px;">What You Get</h2>
                    <p style="color:var(--text-secondary);font-size:15px;line-height:1.75;margin-bottom:32px;">
                        Partnering with me means you get a seasoned Technical Project Manager who delivers results, not just reports.
                    </p>

                    <?php
                    $offerings = [
                        ['⚙️','ERP & CRM Implementation','Full-scale Odoo 16-19 Enterprise and Zoho ecosystem deployments across industries.'],
                        ['🔄','Digital Transformation','End-to-end product launches from brand ideation to go-live and scaling.'],
                        ['🔗','API Architecture','Robust RESTful integrations with Fintech, logistics, geo, and government APIs.'],
                        ['👥','Engineering Team Leadership','Managing cross-functional squads of 40+ across Web, Mobile, QA, DevOps.'],
                        ['📱','Web & Mobile Development','MERN, Flutter, React Native, Native iOS/Android, PHP, and more.'],
                        ['🚀','0-to-1 Product Strategy','BRD/FRD documentation, MVP sprints, GTM strategy, and product scaling.'],
                    ];
                    foreach ($offerings as $o):
                    ?>
                        <div class="card" style="padding:18px 20px;margin-bottom:12px;display:flex;gap:14px;align-items:flex-start;">
                            <span style="font-size:22px;flex-shrink:0;margin-top:2px;" aria-hidden="true"><?php echo esc_html($o[0]); ?></span>
                            <div>
                                <strong style="color:var(--text-primary);display:block;margin-bottom:3px;font-size:15px;"><?php echo esc_html($o[1]); ?></strong>
                                <span style="font-size:13px;color:var(--text-secondary);line-height:1.6;"><?php echo esc_html($o[2]); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div style="margin-top:32px;padding:24px;background:rgba(0,212,255,0.04);border:1px solid var(--border-color);border-radius:var(--radius-lg);">
                        <p style="font-size:11px;color:var(--text-muted);margin-bottom:6px;font-family:var(--font-mono);letter-spacing:0.12em;text-transform:uppercase;">Response Time</p>
                        <p style="font-family:var(--font-display);font-weight:800;font-size:36px;color:var(--accent-primary);line-height:1;">24 hrs</p>
                        <p style="font-size:13px;color:var(--text-secondary);margin-top:4px;">Guaranteed response on all inquiries</p>
                    </div>

                    <div style="margin-top:20px;display:flex;gap:12px;flex-wrap:wrap;">
                        <a href="mailto:<?php echo esc_attr(cbmishra_opt('contact_email','cmmishracb@gmail.com')); ?>" class="btn btn-outline" style="flex:1;justify-content:center;">
                            📧 Email Directly
                        </a>
                        <a href="<?php echo esc_url(cbmishra_appointment_url()); ?>" class="btn btn-outline" style="flex:1;justify-content:center;">
                            📅 Book a Call Instead
                        </a>
                    </div>
                </div>

                <!-- Right: Hire Me Form -->
                <div class="card" style="padding:40px;">
                    <h2 style="font-family:var(--font-display);font-weight:700;font-size:22px;color:var(--text-primary);margin-bottom:6px;">Tell Me About Your Project</h2>
                    <p style="color:var(--text-muted);font-size:14px;margin-bottom:28px;">All fields marked with * are required.</p>
                    <?php cbmishra_hire_form(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.hire-page-grid {
    display: grid;
    grid-template-columns: 1fr 1.3fr;
    gap: 64px;
    align-items: start;
    max-width: 1100px;
    margin: 0 auto;
}
@media (max-width: 900px) {
    .hire-page-grid { grid-template-columns: 1fr; gap: 40px; }
}
</style>

<?php get_footer(); ?>
