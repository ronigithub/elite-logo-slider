<?php
function els_get_option( $option, $section, $default = '' ) {

        $options = get_option( $section );

        if ( isset( $options[$option] ) ) {
            return $options[$option];
        }

        return $default;
}

function els_display(){
?>
<script type="text/javascript">
jQuery(document).ready(function(){

  jQuery('.container').bxSlider({
   	slideWidth: 200,
    minSlides: 1,
    maxSlides: 5,
    infiniteLoop: true,
    slideMargin: 10,
  	moveSlides: 1,
  	speed: 500,
  	controls: true,
  	autoHover: true,
  	pager: false,
  	auto: true
  });
 
});
</script>
<?php
}

add_action( 'wp_footer', 'els_display' );

/*  ---------------------------------
	  SHORTCODE [elite-logo-slider] 
	---------------------------------
*/

function els_shortcode( $atts ) {

$logo_title    = els_get_option( 'title', 'els_titles', 'no');
$title_pos     = els_get_option( 'title_position', 'els_titles', 'bottom');

extract( shortcode_atts(
		array(

			'posts' 	  	 => 25,
			'order'		 	 => 'DESC',
			'orderby'    	 => 'date',
			'title'		 	 => 'no',
			'logo_cat'	 	 => ''	
		), $atts 
) );

$args = array(
		'post_type'	=> 'elite-logo-slider',
		'order'		=> $order,
		'orderby'	=> 'date',
		'elite-logo-category' => $logo_cat,
		'posts_per_page'	  => $posts
);

$query_loop = new WP_Query( $args );

$output = '<div class="container">';
if ( $query_loop->have_posts() ) {
		
	while ( $query_loop->have_posts() ) {
			$query_loop->the_post();
			$meta_data = get_post_meta( get_the_id() );
			
			$els_logo_id = get_post_thumbnail_id();

			$els_logo_url = wp_get_attachment_image_src($els_logo_id, array( 200, 200 ), true);
			$els_logo = $els_logo_url[0];
			$els_logo_alt = get_post_meta( $els_logo_id,'_wp_attachment_image_alt',true );
			
			$output .= '<div class="els_single_img">';

				if ( $meta_data['els_site_url'][0] ) :
			 		$output .= '<a href="'. $meta_data['els_site_url'][0] .'" target="_blank">';
			 	endif;
				
				// Top title
				if ( $logo_title == 'yes' ) {

					if( $title_pos == 'top') {
						$output .= '<h3 class="els_logo_title">'. get_the_title() .'</h3>';
					}
				}
 	
							
				$output .= '<img src="'.$els_logo.'" alt="'.$els_logo_alt.'" >';
				 		

				// bottom
				if (  $title  == 'yes' || $logo_title == 'yes' ) {

					if( $title_pos == 'bottom') :	
						$output .= '<h3 class="els_logo_title">'. get_the_title() .'</h3>';
					endif;

				} 

				if ($meta_data['els_site_url'][0]) :
					$output .= '</a>';
				endif;

			$output .= '</div>';
		}

} else {
	$output .= "No Logo Added!";
}

wp_reset_postdata();
wp_reset_query();

$output .= '</div>';

return $output;

}

add_shortcode( 'elite-logo-slider', 'els_shortcode' );
