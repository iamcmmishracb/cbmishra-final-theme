<?php
/**
 * Blog Archive Page — All Articles with Pagination
 * Template Name: Blog Archive
 * @package CBMishra_Portfolio
 */
get_header();

// FIX: On static pages, WordPress uses 'page' query var, not 'paged'
$paged    = max(1, get_query_var('paged'), get_query_var('page'));
$per_page = 9;

$bq = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => $per_page,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
    'paged'          => $paged,
]);
?>
<main id="main-content" role="main">

    <!-- Hero -->
    <div class="page-hero grid-bg">
        <div class="container" style="text-align:center;">
            <div class="section-label" style="justify-content:center;">From the Blog</div>
            <h1 class="section-title" style="margin:16px auto;">All Articles</h1>
            <p class="section-subtitle" style="margin:0 auto;">
                Insights on technical project management, enterprise ERP, agile delivery, and digital transformation.
            </p>
        </div>
    </div>

    <section class="section-padding" style="background:var(--bg-primary);">
        <div class="container">
            <?php if ($bq->have_posts()): ?>
                <div class="blog-grid">
                    <?php while ($bq->have_posts()): $bq->the_post();
                        cbmishra_blog_card();
                    endwhile;
                    wp_reset_postdata(); ?>
                </div>

                <!-- Pagination -->
                <?php if ($bq->max_num_pages > 1): ?>
                <nav class="pagination" aria-label="Blog pagination" style="display:flex;flex-wrap:wrap;gap:8px;justify-content:center;margin-top:56px;">
                    <?php
                    // FIX: Use get_permalink() for the current page as the base
                    $base_url = get_permalink();
                    $links = paginate_links([
                        'base'      => trailingslashit( $base_url ) . '%_%',
                        'format'    => 'page/%#%/',
                        'current'   => $paged,
                        'total'     => $bq->max_num_pages,
                        'prev_text' => '← Prev',
                        'next_text' => 'Next →',
                        'type'      => 'array',
                    ]);
                    if ($links):
                        foreach ($links as $link):
                            $is_current = strpos($link,'current') !== false;
                            $is_dots    = strpos($link,'dots') !== false;
                            $style_base = 'display:inline-flex;align-items:center;justify-content:center;padding:10px 18px;border-radius:10px;font-size:14px;font-weight:500;border:1px solid var(--border-color);text-decoration:none;transition:all 0.2s;';
                            if ($is_current) {
                                echo str_replace('<span','<span style="'.$style_base.'background:var(--accent-primary);color:#050A14;border-color:var(--accent-primary);"',$link);
                            } elseif ($is_dots) {
                                echo str_replace('<span','<span style="'.$style_base.'color:var(--text-muted);"',$link);
                            } else {
                                echo str_replace('<a ','<a style="'.$style_base.'color:var(--text-secondary);background:var(--bg-card);" ',$link);
                            }
                        endforeach;
                    endif;
                    ?>
                </nav>
                <p style="text-align:center;color:var(--text-muted);font-size:13px;margin-top:16px;">
                    Page <?php echo esc_html($paged); ?> of <?php echo esc_html($bq->max_num_pages); ?>
                    &nbsp;·&nbsp; <?php echo esc_html($bq->found_posts); ?> articles total
                </p>
                <?php endif; ?>

            <?php else: ?>
                <div style="text-align:center;padding:80px 20px;">
                    <div style="font-size:64px;margin-bottom:24px;" aria-hidden="true">✍️</div>
                    <h2 style="font-family:var(--font-display);font-size:28px;color:var(--text-primary);margin-bottom:12px;">No Articles Yet</h2>
                    <p style="color:var(--text-secondary);">The first article is being written. Check back soon!</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
