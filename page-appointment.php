<?php
/**
 * Book Appointment Page
 * Template Name: Book Appointment
 * @package CBMishra_Portfolio
 */
get_header();
?>
<main id="main-content" role="main">

    <div class="page-hero grid-bg">
        <div class="container" style="text-align:center;">
            <div class="section-label" style="justify-content:center;">Schedule a Call</div>
            <h1 class="section-title" style="margin:16px auto;">Book an Appointment</h1>
            <p class="section-subtitle" style="margin:0 auto;">
                Free 30-45 minute strategy consultation. I'll confirm within a few hours.
            </p>
        </div>
    </div>

    <section class="section-padding" style="background:var(--bg-primary);">
        <div class="container">
            <div class="appt-page-grid">

                <!-- Left: Process Steps -->
                <div>
                    <h2 style="font-family:var(--font-display);font-weight:700;font-size:24px;color:var(--text-primary);margin-bottom:16px;">What to Expect</h2>
                    <p style="color:var(--text-secondary);font-size:15px;line-height:1.75;margin-bottom:32px;">
                        A focused, free consultation where we discuss your challenges and map out how to solve them.
                    </p>

                    <?php
                    $steps = [
                        ['1','Fill the Form','Submit your preferred date, time, and what you want to discuss.'],
                        ['2','Confirmation Email','I\'ll confirm the appointment within a few hours.'],
                        ['3','Pre-Call Prep','I\'ll review your context and come prepared with insights.'],
                        ['4','Strategy Call','We discuss, strategize, and define clear next steps.'],
                    ];
                    foreach ($steps as $step):
                    ?>
                        <div style="display:flex;gap:16px;margin-bottom:24px;align-items:flex-start;">
                            <div style="width:38px;height:38px;background:rgba(0,212,255,0.08);border:1px solid var(--border-color);border-radius:10px;display:flex;align-items:center;justify-content:center;font-family:var(--font-mono);font-weight:700;font-size:14px;color:var(--accent-primary);flex-shrink:0;">
                                <?php echo esc_html($step[0]); ?>
                            </div>
                            <div>
                                <strong style="color:var(--text-primary);display:block;margin-bottom:3px;font-size:15px;"><?php echo esc_html($step[1]); ?></strong>
                                <span style="font-size:13px;color:var(--text-secondary);line-height:1.6;"><?php echo esc_html($step[2]); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div style="padding:24px;background:rgba(255,107,53,0.05);border:1px solid rgba(255,107,53,0.2);border-radius:var(--radius-lg);margin-top:8px;">
                        <p style="font-size:13px;font-weight:700;color:#FF8A5C;margin-bottom:4px;">100% Free Consultation</p>
                        <p style="font-size:13px;color:var(--text-secondary);line-height:1.6;">No commitment required. Just a conversation about your project and how I can help.</p>
                    </div>

                    <div style="margin-top:24px;padding:20px;background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);">
                        <p style="font-size:13px;color:var(--text-muted);margin-bottom:8px;">Prefer email instead?</p>
                        <a href="mailto:<?php echo esc_attr(cbmishra_opt('contact_email','cmmishracb@gmail.com')); ?>" class="btn btn-outline" style="width:100%;justify-content:center;">
                            📧 <?php echo esc_html(cbmishra_opt('contact_email','cmmishracb@gmail.com')); ?>
                        </a>
                    </div>

                    <div style="margin-top:16px;padding:20px;background:var(--bg-card);border:1px solid var(--border-color);border-radius:var(--radius-lg);">
                        <p style="font-size:13px;color:var(--text-muted);margin-bottom:8px;">Ready to hire?</p>
                        <a href="<?php echo esc_url(cbmishra_hire_url()); ?>" class="btn btn-hire" style="width:100%;justify-content:center;">
                            💼 Submit a Hire Request
                        </a>
                    </div>
                </div>

                <!-- Right: Appointment Form -->
                <div class="card" style="padding:40px;">
                    <h2 style="font-family:var(--font-display);font-weight:700;font-size:22px;color:var(--text-primary);margin-bottom:6px;">Schedule Your Call</h2>
                    <p style="color:var(--text-muted);font-size:14px;margin-bottom:28px;">All times are in IST (India Standard Time, UTC+5:30).</p>
                    <?php cbmishra_appointment_form(); ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.appt-page-grid {
    display: grid;
    grid-template-columns: 1fr 1.3fr;
    gap: 64px;
    align-items: start;
    max-width: 1100px;
    margin: 0 auto;
}
@media (max-width: 900px) {
    .appt-page-grid { grid-template-columns: 1fr; gap: 40px; }
}
</style>

<?php get_footer(); ?>
