<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'hello-elementor','hello-elementor','hello-elementor-theme-style' ) );
		wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/assets/js/main.js', array( 'jquery' ), true );
		
		$vars['ajaxurl'] = admin_url( 'admin-ajax.php' );
		wp_localize_script( 'main', '_avb', $vars );
    }
endif;

add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

/**
 * Load Ajax Init
 */
require_once( get_stylesheet_directory() . '/includes/ajax/init.php' );

/**
 * Custom Widget Elementor
 */
require_once( get_stylesheet_directory() . '/includes/elementor/init.php' );


// END ENQUEUE PARENT ACTION

// Remove header delay
add_action( 'wp_footer', function () { ?>
<script>
 
jQuery(document).ready(function($) {
 
   // Get the menu instance
   // Ultimately smartmenus is expecting a <ul> input, so you need to target the <ul> of the drop-down you're trying to affect.
  var $menu = $('.elementor-nav-menu:first');
 
  // Get rid of the existing menu
  $menu.smartmenus('destroy');
 
  // Re-instantiate the new menu, with no delay settings
  $menu.smartmenus( {
      subIndicatorsText: '',
      subIndicatorsPos: 'append',
      subMenusMaxWidth: '1000px',
      hideDuration: 200, // the length of the fade-out animation
      hideTimeout: 150, // timeout before hiding the sub menus
      showTimeout: 0,   // timeout before showing the sub menus
  });
 
});
 
</script>

<?php } );











////// shortcode for related post by tag
//
//
add_shortcode('related-training', 'related_post_by_tags');
function related_post_by_tags(){
	ob_start();
	
	$orig_post = $post;
	global $post;
	
	//get the taxonomy terms of custom post type

	/*
$customTaxonomyTerms = wp_get_object_terms( $post->ID, 'course_type', array('fields' => 'ids') );
$customTaxonomyTermsLearner = wp_get_object_terms( $post->ID, 'course_learner', array('fields' => 'ids') );
if($customTaxonomyTerms != null && $customTaxonomyTermsLearner != null )
	{
		$args = array(
    'post_type' => 'trainings',
    'post_status' => 'publish',
    'posts_per_page' => 3,
	'orderby'  => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'course_type',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        ),
		array(
            'taxonomy' => 'course_learner',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        )
    ),
    'post__not_in' => array ($post->ID),
	)	;
	}
	if($customTaxonomyTerms == null && $customTaxonomyTermsLearner != null )
	{
		$args = array(
    'post_type' => 'trainings',
    'post_status' => 'publish',
    'posts_per_page' => 3,
	'orderby'  => 'rand',
    'tax_query' => array(
		array(
            'taxonomy' => 'course_learner',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        )
    ),
    'post__not_in' => array ($post->ID),
	)	;
	}
	if($customTaxonomyTerms != null && $customTaxonomyTermsLearner == null )
	{
		$args = array(
    'post_type' => 'trainings',
    'post_status' => 'publish',
    'posts_per_page' => 3,
	'orderby'  => 'rand',
    'tax_query' => array(
		array(
            'taxonomy' => 'course_learner',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        )
    ),
    'post__not_in' => array ($post->ID),
	)	;
	}

//query arguments
$args = array(
    'post_type' => 'trainings',
    'post_status' => 'publish',
    'posts_per_page' => 3,
	'orderby'  => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'course_type',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        )
    ),
    'post__not_in' => array ($post->ID),
);
*/
	
$args = array(
    'post_type' => 'trainings',
    'post_status' => 'publish',
    'posts_per_page' => 3,
	'orderby'  => 'rand',
    'post__not_in' => array ($post->ID),
);
	
//the query
$relatedPosts = new WP_Query( $args );

//loop through query
if($relatedPosts->have_posts()){
    echo '<div class="related-training" >';
    while($relatedPosts->have_posts()){ 
        $relatedPosts->the_post();
?>
<div class='training-card'>
	<div class="image-wrap">
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
	</div>
	<div class='training-description'>
	<div class='the-training-title'>
		<a href="<?php the_permalink(); ?>"><?php  echo get_field('course_title'); ?> </a>
	</div>
	<div class='the-training-price'>
		<?php  echo get_field('course_price'); ?> 
	</div>
	<div class='the-training-des related-card-hidden'>
		<?php  echo get_field('short_description'); ?> 
	</div>
	<div class='learn-more-button related-card-hidden'>
		<a href="<?php the_permalink(); ?>">Learn More </a>
	</div>
	</div>
</div>
        
<?php
    }
    echo '</div>';
}else{
    //no posts found
}

//restore original post data
wp_reset_postdata();

	
	return ob_get_clean();
	
}
//
//..shortcode for related post by tag
//
//
//
////// shortcode for featured training
//
//
add_shortcode('featured-training', 'function_featured_training');
function function_featured_training(){
	ob_start();
	
	$orig_post = $post;
	global $post;

$field = get_field_object('featured_training');
$featured_training = $field['value'][0];

	
	$args = array(
		'post_type' => 'trainings',
		'post_status' => 'publish',
		'posts_per_page' => 3,
		'tax_query' => array(
			array(
				'taxonomy' => 'training_type',
				'field' => 'slug',
				'terms' => 'featured'
			)
		),
	);
	
	
	$posts = new \WP_Query( $args );

	if( $posts->have_posts() ) { ?>
		<div class="avb-trainings-listing-wrapper__item">
			<?php
				while( $posts->have_posts() ) {
					$posts->the_post();
						get_template_part( 'template-parts/trainings', 'loop' );
					}
					wp_reset_postdata();
			?>
		</div>
	<?php } else {
		echo __( 'No training(s) found.', 'frontieradvisorygroup' ); 
	}

	return ob_get_clean();
}