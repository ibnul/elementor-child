<?php
/**
 * Ajax Filter Training List
 */
add_action('wp_ajax_availhub_trainings_filter', 'availhub_trainings_filter_list_ajax');
add_action('wp_ajax_nopriv_availhub_trainings_filter', 'availhub_trainings_filter_list_ajax');
function availhub_trainings_filter_list_ajax() {
    $settings       = $_POST['settings'];
    $query          = $_POST['query'];
    //$catFilter = $_POST['catFilter'];
    $yearFilter = $_POST['yearFilter'];
    $learnerFilter = $_POST['learnerFilter'];

/*var_dump('<pre>');
var_dump('cat_id '. $catFilter);
var_dump('type '. $yearFilter);
var_dump('learner '. $learnerFilter);
var_dump('</pre>');*/

    // $posts_per_page = $_POST['posts_per_page'];
    // $numberposts    = $_POST['numberposts'];

//1 if all filter empty    
    if ($yearFilter == "" && $learnerFilter == ""){         
        $args = array( 
            'post_type'      => 'trainings',
            'post_status'    => 'publish',
            'orderby' => 'rand'
            
        );
    }
//2 if type filter is there
    elseif( $yearFilter != "" && $learnerFilter == ""){      
        $args = array( 
            'post_type'      => 'trainings',
            'post_status'    => 'publish',
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'course_type',
                    'field' => 'term_id',
                    'terms' => $yearFilter
                 )
            )
        );
    }
//3 if learner filter is there
    elseif($yearFilter == "" && $learnerFilter != ""){      
        $args = array( 
            'post_type'      => 'trainings',
            'post_status'    => 'publish',
            'orderby' => 'rand',
            'tax_query' => array(

                array(
                    'taxonomy' => 'course_learner',
                    'field' => 'term_id',
                    'terms' => $learnerFilter
                 )
            )
        );
    }
//4 if type and learner filter is there
    elseif( $yearFilter != "" && $learnerFilter != ""){      
        $args = array( 
            'post_type'      => 'trainings',
            'post_status'    => 'publish',
            'orderby' => 'rand',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'course_type',
                    'field' => 'term_id',
                    'terms' => $yearFilter
                 ),

                array(
                    'taxonomy' => 'course_learner',
                    'field' => 'term_id',
                    'terms' => $learnerFilter
                 )
            )
        );
    }

    

    $posts = new \WP_Query( $args );

    if( $posts->have_posts() ) {
        while( $posts->have_posts() ){ $posts->the_post(); 
            get_template_part( 'template-parts/trainings', 'loop' );
        } wp_reset_postdata();
    }else {
        echo __( 'No training(s) found.', 'frontieradvisorygroup' ); 
    }
    die();
}