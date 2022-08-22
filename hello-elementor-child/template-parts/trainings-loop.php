<?php

$post_id = get_the_ID();
$post_terms = get_the_terms( $post_id, 'trainings_category' ); 
$year_terms = get_the_terms( $post_id, 'trainings_year' ); 
//$image = get_field('thumbnail', $post_id);
$image = get_the_post_thumbnail_url($post_id, 'full');

?>

    <div class="avb-training-listing__item avb-training <?php foreach($post_terms as $terms) : echo strtolower($terms->slug). ' '; endforeach; ?> avb-training-listing__item-<?php echo $post_id; ?> avb-trainings-category-item-<?php echo $terms->term_id; ?> avb-trainings-year-">
            <a href="<?php the_permalink( $post_id ); ?>" class="avb-training-listing__item-link course-featured-img">
              <!--   <div class="avb-featured-image-wrap" style="background-image:url(<?php echo esc_url($image); ?>)">
                    <div class="avb-featured-image-overlay"></div>
                </div> -->                    
                <img src="<?php echo esc_url($image); ?>">
                
            </a>
            <div class="avb-training-listing-wrapper__content">
                <div class="visible-box">
                    <a href="<?php the_permalink( $post_id ); ?>" class="avb-training-listing__item-link">
                        <h6 class="avb-training-listing__title">
                            <?php if(get_field( 'course_title', $post_id )) : echo get_field( 'course_title', $post_id ); endif;?>

                        </h6>
                    
                        <div class="avb-training-listing-wrapper__price">
                            <p class="avb-training-listing__price"><?php if(get_field( 'course_price', $post_id )) : echo get_field( 'course_price', $post_id ); endif;?></p>
                        </div>
                    </a>
                </div>
                <div class="hidden-box">
                    <a href="<?php the_permalink($post_id); ?>">
                        <div class="course-short-description">
                            <?php echo get_field( 'short_description', $post_id ); ?>                        
                        </div>
                    </a>

                    <div class="div-buy-now">
                        <a class="btn-buy-now" href="<?php echo get_field('checkout_link', $post_id); ?>" target="_blank">Enrol</a>
                        <a class="btn-learn-more" href="<?php the_permalink($post_id); ?>">Learn More
                        <img src="https://assets-global.website-files.com/5d816b07d269385f68dbcab0/5d816b07d26938636adbcaf8_icon-arrow-small-black.svg" alt="" class="wiz-b-text-link-arrow">
                        </a>
                    </div>
                    <!-- <div class="learn-more">
                        <a href="<?php the_permalink($post_id); ?>">Learn More</a>
                    </div> -->
 
                </div>
            </div>
        
            

    </div>
