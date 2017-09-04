<?php    
/**
 * Testimonial Section.
 *
 * @package Lawyer_Landing_Page
 */

$section_title   = get_theme_mod( 'testimonial_section_page' );
$testimonial_cat = get_theme_mod( 'testimonials_section_cat' );

if( $section_title || $testimonial_cat ){        
?>

<section class="testimonial">
    <div class="container">
				
        <?php 
        
            lawyer_landing_page_get_section_header( $section_title );
            
            if( $testimonial_cat ){
                
    			$qry = new WP_Query( array(
    				'posts_per_page'      => -1,
    				'post_type'           => 'post',
    				'ignore_sticky_posts' => true,
    				'cat'                 => $testimonial_cat
    			));
    
    			if( $qry->have_posts() ){ ?>
    				<div id="slider" class="flexslider">
      					<ul class="slides">
                        <?php 
                            while( $qry->have_posts() ){
                                $qry->the_post();?>
                                <li>
        					    	<div class="testimonial-holder">
        					    		<?php the_content(); ?>
        					    	</div>
                                </li>
                            <?php 
                            }
                            wp_reset_postdata();  
                        ?>
      					</ul>
    				</div>
                    
    				<div id="carousel" class="flexslider">
    					<ul class="slides">
    					<?php 
                            while( $qry->have_posts() ){
                                $qry->the_post(); ?>
        				    	<li>
        				      		<?php if( has_post_thumbnail() ) the_post_thumbnail( 'lawyer-landing-page-testimonial' ); ?>
        				      		<strong class="name"><?php the_title(); ?></strong>
        				      		<?php if( has_excerpt() ){ ?>
                                        <span class="designation"><?php the_excerpt(); ?></span>
                                    <?php } ?>
        				    	</li>
    				        <?php 
                            }
                            wp_reset_postdata(); 
                        ?>
    				  	</ul>
    				</div>
    			<?php 
                }
			}
        ?>
    </div>
</section>   
            
<?php
}            