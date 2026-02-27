<?php
/**
 * Single Post Template
 *
 * @package CBMishra_Portfolio
 */

get_header();
?>

<main id="main-content" role="main">
    <?php while ( have_posts() ) : the_post(); ?>

    <!-- Article Hero -->
    <div class="page-hero grid-bg" style="padding-bottom:0;">
        <div class="container" style="max-width:800px;">
            <div style="margin-bottom:20px;display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                <?php
                $cats = get_the_category();
                if ( $cats ) : ?>
                    <span class="blog-category"><?php echo esc_html( $cats[0]->name ); ?></span>
                <?php endif; ?>
                <span class="blog-date"><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></span>
                <span class="blog-read-time"><?php echo esc_html( cbmishra_read_time() ); ?></span>
            </div>

            <h1 class="section-title" style="font-size:clamp(28px,4vw,52px);margin-bottom:20px;">
                <?php the_title(); ?>
            </h1>

            <div style="display:flex;align-items:center;gap:12px;padding-bottom:40px;">
                <div class="blog-author-avatar">CB</div>
                <div>
                    <p style="font-weight:600;font-size:15px;color:var(--text-primary);"><?php echo esc_html( get_the_author() ); ?></p>
                    <p style="font-size:13px;color:var(--text-muted);">Strategic Technical Project Manager</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Image -->
    <?php if ( has_post_thumbnail() ) : ?>
    <div style="background:var(--bg-secondary);padding:0;">
        <div class="container" style="max-width:900px;padding-top:0;">
            <div style="border-radius:0 0 var(--radius-xl) var(--radius-xl);overflow:hidden;aspect-ratio:16/7;">
                <?php the_post_thumbnail( 'blog-thumbnail', [ 'style' => 'width:100%;height:100%;object-fit:cover;', 'alt' => get_the_title() ] ); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Article Content -->
    <article class="section-padding" style="background:var(--bg-primary);">
        <div class="container" style="max-width:760px;">
            <div class="entry-content" style="
                color:var(--text-secondary);
                font-size:16px;
                line-height:1.85;
            ">
                <?php the_content(); ?>
            </div>

            <!-- Tags -->
            <?php $tags = get_the_tags();
            if ( $tags ) : ?>
            <div style="margin-top:40px;padding-top:32px;border-top:1px solid var(--border-color);">
                <p style="font-size:13px;font-weight:600;color:var(--text-muted);margin-bottom:12px;">Tagged in:</p>
                <div style="display:flex;flex-wrap:wrap;gap:8px;">
                    <?php foreach ( $tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Author Box -->
            <div class="card" style="padding:32px;margin-top:48px;display:flex;gap:24px;align-items:flex-start;">
                <div style="width:72px;height:72px;background:linear-gradient(135deg,#00D4FF,#0095B3);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:24px;color:#050A14;flex-shrink:0;">CB</div>
                <div>
                    <p style="font-family:var(--font-display);font-weight:700;font-size:18px;color:var(--text-primary);">C B Mishra</p>
                    <p style="font-size:13px;color:var(--accent-primary);margin-bottom:10px;">Strategic Technical Project Manager</p>
                    <p style="font-size:14px;color:var(--text-secondary);line-height:1.65;">7+ years directing enterprise-scale digital transformations, ERP implementations, and high-performing engineering teams globally.</p>
                    <div style="display:flex;gap:12px;margin-top:16px;">
                        <a href="<?php echo esc_url( cbmishra_opt( 'linkedin_url', 'https://www.linkedin.com/in/cbmishra/' ) ); ?>" target="_blank" rel="noopener" style="font-size:13px;color:var(--accent-primary);">LinkedIn →</a>
                        <a href="<?php echo esc_url( cbmishra_hire_url() ); ?>" style="font-size:13px;color:var(--accent-hire);">Hire Me →</a>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav style="display:flex;justify-content:space-between;margin-top:48px;gap:16px;flex-wrap:wrap;">
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                if ( $prev ) :
                    echo '<a href="' . esc_url( get_permalink( $prev ) ) . '" class="btn btn-outline" style="flex:1;justify-content:flex-start;">← ' . esc_html( get_the_title( $prev ) ) . '</a>';
                endif;
                if ( $next ) :
                    echo '<a href="' . esc_url( get_permalink( $next ) ) . '" class="btn btn-outline" style="flex:1;justify-content:flex-end;">' . esc_html( get_the_title( $next ) ) . ' →</a>';
                endif;
                ?>
            </nav>
        </div>
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
