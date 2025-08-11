<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

$posts_per_page = get_post_meta($post_id, '_clbgd_posts_per_page', true);
$posts_per_page = $posts_per_page ? $posts_per_page : 5;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
$show_date = $meta_values['show_date'];
$show_author = $meta_values['show_author'];
$show_comments = $meta_values['show_comments'];
$show_excerpt = $meta_values['show_excerpt'];
$excerpt_length = $meta_values['excerpt_length'] ?: 15; 
$show_categories = $meta_values['show_categories'];
$enable_featured_image = $meta_values['enable_featured_image'];
$show_social_share = $meta_values['show_social_share'];
//show tags
$show_tags = isset($meta_values['show_tags']) ? $meta_values['show_tags'] : false;;
//new sort order
$sort_order = get_post_meta($post_id, '_clbgd_sort_order', true);
$sort_order = $sort_order ? strtoupper($sort_order) : 'DESC'; 
// sorting options
$sort_options = array(
    'ASC'        => ['orderby' => 'date', 'order' => 'ASC'],
    'DESC'       => ['orderby' => 'date', 'order' => 'DESC'],
    'A-Z'        => ['orderby' => 'title', 'order' => 'ASC'],
    'Z-A'        => ['orderby' => 'title', 'order' => 'DESC'],
    'MODIFIED'   => ['orderby' => 'modified', 'order' => 'DESC'],
    'RANDOMLY'   => ['orderby' => 'rand'],
    'AUTHOR'     => ['orderby' => 'author', 'order' => 'ASC'],
    'POPULARITY' => ['orderby' => 'meta_value_num', 'order' => 'DESC', 'meta_key' => 'post_views_count'],
    'COMMENT'    => ['orderby' => 'comment_count', 'order' => 'DESC'],
    'CUSTOM'     => ['orderby' => 'meta_value_num', 'order' => 'ASC', 'meta_key' => 'custom_order']
);
// fallback
$selected_sort = $sort_options[$sort_order] ?? $sort_options['DESC'];
$args = array_merge([
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
], $selected_sort);

$tax_query = [];

$include_slugs = array_filter(array_map('trim', explode(',', $meta_values['include_categories_tags'] ?? '')));
$exclude_slugs = array_filter(array_map('trim', explode(',', $meta_values['exclude_categories_tags'] ?? '')));

if (!empty($include_slugs)) {
    $tax_query[] = [
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $include_slugs,
        'operator' => 'IN',
    ];
}

if (!empty($exclude_slugs)) {
    $tax_query[] = [
        'taxonomy' => 'category',
        'field'    => 'slug',
        'terms'    => $exclude_slugs,
        'operator' => 'NOT IN',
    ];
}

if (!empty($tax_query)) {
    $args['tax_query'] = count($tax_query) > 1 ? array_merge(['relation' => 'AND'], $tax_query) : $tax_query;
}

$query = new WP_Query($args);
//end sort order
if ($query->have_posts()) : ?>
<div class="container">
    <div id="clbgdCarousel" class="swiper">
        <div class="swiper-wrapper">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="swiper-slide">
                <div class="clbgd-carousel-item">
                    <?php if ($enable_featured_image !== 'disable' && has_post_thumbnail()) : ?>
                        <?php
                        $image_aspect_class = '';
                        if (!empty($meta_values['image_aspect_ratio'])) {
                            $image_aspect_class = 'aspect-' . esc_attr($meta_values['image_aspect_ratio']); // e.g., 16-9, 1-1
                        }
                        ?>
                    <div class="carousel-image <?php echo esc_attr($image_aspect_class); ?>">
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>"
                            alt="<?php echo esc_attr(get_the_title()); ?>">
                    </div>
                    <?php endif; ?>
                    <div class="carousel-content">
                        <div class="clbgd-carousel-cat-tag">
                            <?php if ($show_categories): ?>
                            <p class="clbgd-blog-post-category clbgd-blog-post-meta-font">
                                <?php echo esc_html__('Category: ', 'classic-blog-grid') . wp_kses_post(get_the_category_list(', ')); ?>
                            </p>
                            <?php endif; ?>
                            <!-- show tags -->
                            <?php if ($show_tags):?>
                            <?php 
                                        $tags = get_the_tags(); 
                                        if ($tags): ?>
                            <p class="clbgd-blog-post-tags clbgd-blog-post-meta-font">
                                <?php foreach ($tags as $tag): ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>">
                                    <?php echo esc_html($tag->name); ?>
                                </a>
                                <?php endforeach; ?>
                            </p>
                            <?php endif; ?>
                            <?php endif; ?>
                            <!-- end -->
                        </div>
                        <h2 class="carousel-title clbgd-blog-post-tittle-font">
                        <a class="clbgd-blog-post-tittle-font" href="<?php echo esc_url(get_permalink()); ?>" title="<?php echo esc_attr(get_the_title()); ?>">
                        <?php the_title(); ?>
                         </a>
                        </h2>
                        <?php if ($show_excerpt) : ?>
                        <p class="carousel-description clbgd-blog-post-excerpt-font">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length, '...')); ?></p>
                        <?php endif; ?>
                        <div class="clbgd-carousel-meta-fields">
                            <?php if ($show_date) : ?>
                            <p class="carousel-date clbgd-blog-post-meta-font">
                                <?php echo esc_html(get_the_date('F j, Y')); ?></p>
                            <?php endif; ?>
                            <?php if ($show_author) : ?>
                            <p class="carousel-author clbgd-blog-post-meta-font">
                                <?php echo esc_html__('By', 'classic-blog-grid') . ' ' . esc_html(get_the_author()); ?>
                            </p>
                            <?php endif; ?>
                            <?php if ($show_comments): ?>
                            <p class="clbgd-blog-post-comments clbgd-blog-post-meta-font">
                                <?php echo esc_html(get_comments_number()) . ' ' . esc_html__('Comments', 'classic-blog-grid'); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <!-- show social share -->
                        <?php if ($show_social_share): ?>
                        <div class="clbgd-social-share-buttons">
                            <span
                                class="clbgd-blog-post-meta-font"><?php esc_html_e('Share:', 'classic-blog-grid'); ?></span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url()); ?>&description=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                        </div>
                        <?php endif; ?>
                        <!-- END Social Share Buttons -->
                        <a href="<?php the_permalink(); ?>" class="carousel-button clbgd-blog-post-content2">Read
                            More</a>
                    </div>
                    <div class="carousel-item-overlay"></div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="carousel-button-paginations">
            <!-- Navigation -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
        <!-- Pagination -->
        <?php if (isset($meta_values['show_pagination']) && $meta_values['show_pagination'] === '1') : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>

    </div>
</div>
<?php else : ?>
<p>No posts found.</p>
<?php endif;
wp_reset_postdata();
?>