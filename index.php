<?php
/**
 * Main template file
 *
 * @package CBMishra_Portfolio
 */

get_header();
?>
<main id="main-content" role="main">
    <div class="page-hero">
        <div class="container"><h1 class="section-title"><?php the_archive_title(); ?></h1></div>
    </div>
    <section class="section-padding">
        <div class="container">
            <div class="blog-grid">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    cbmishra_blog_card();
                endwhile;
                else : echo '<p style="color:var(--text-secondary);">Nothing found.</p>';
                endif; ?>
            </div>
            <?php cbmishra_pagination(); ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>
