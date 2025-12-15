<?php

defined( 'ABSPATH' ) || exit;




get_header();
?>

<div class="container my-5">
  <h1 class="mb-4 text-center">Wydarzenia</h1>

  <?php if (have_posts()) : ?>
    <div class="row g-4">
      <?php while (have_posts()) : the_post(); ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0">
            <?php if (has_post_thumbnail()) : ?>
              <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large', ['class' => 'card-img-top', 'alt' => get_the_title()]); ?>
              </a>
            <?php endif; ?>

            <div class="card-body">
              <h5 class="card-title">
                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                  <?php the_title(); ?>
                </a>
              </h5>

              <?php
        
              $cities = get_the_terms(get_the_ID(), 'city');
              if ($cities && !is_wp_error($cities)) :
                  echo '<p class="text-muted mb-2">';
                  echo '<i class="bi bi-geo-alt"></i> ';
                  echo esc_html(join(', ', wp_list_pluck($cities, 'name')));
                  echo '</p>';
              endif;
              ?>
            </div>

            <div class="card-footer bg-transparent border-0">
              <a href="<?php the_permalink(); ?>" class="btn btn-primary w-100">
                Zobacz szczegóły
              </a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="mt-5">
      <?php the_posts_pagination([
        'mid_size' => 2,
        'prev_text' => __('&laquo; Poprzednie', 'textdomain'),
        'next_text' => __('Następne &raquo;', 'textdomain'),
      ]); ?>
    </div>

  <?php else : ?>
    <div class="alert alert-info text-center">
      Brak wydarzeń do wyświetlenia.
    </div>
  <?php endif; ?>
</div>

<?php
get_footer();