<?php
/*
 Plugin Name:Sticky Related Posts
 Description:Sticky Related Posts for WordPress offers you the ability to link related posts to each other with just 1 click!.
 Version:1.0
 Author:Cool Timeline Team
 Author URI:http://www.cooltimeline.com
 License:GPLv2 or later
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Domain Path: /languages
 Text Domain:srp
*/
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
if (!defined('SRP_VERSION_CURRENT')){
    define('SRP_VERSION_CURRENT', '1.0');
}
if( !defined( 'SRP_JS_URL' ) ) {
    define( 'SRP_JS_URL', plugin_dir_url( __FILE__ ) . 'js' );
}
if( !defined( 'SRP_CSS_URL' ) ) {
    define( 'SRP_CSS_URL', plugin_dir_url( __FILE__ ) . 'css' );	
}

define('SRP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('SRP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if( !class_exists( 'StickyRelatedPosts' ) ) 
{
	class StickyRelatedPosts
	{
		function __construct() 
		{
			add_action( 'wp_footer', array($this,'SRP_related_posts') );
			require_once( 'titan-framework/titan-framework-embedder.php');
			add_action( 'wp_enqueue_scripts',array($this,'SRP_register_frontend_assets')); //registers js and css for frontend
			add_action( 'tf_create_options', array( $this,'srp_createMyOptions'));
			add_action( 'admin_enqueue_scripts',array( $this,'srp_remove_colorpicker'),99);
		}
		
		/**
         * Activating plugin and adding some info
         */
        public static function srp_activate() {
			update_option("srp-v",SRP_VERSION_CURRENT);
			update_option("srp-type","FREE");
			update_option("srp-installDate",date('Y-m-d h:i:s') );
        }
		// END public static function activate

        /**
         * Deactivate the plugin
         */
        public static function srp_deactivate() {
        // Do nothing
        } 
      		
		public function srp_remove_colorpicker() {
			wp_dequeue_script( 'wp-color-picker-alpha' );
		}
		
		function SRP_register_frontend_assets() 
		{
			//  Enqueue common required assets
			wp_register_script( 'srp-footerbar-js', SRP_JS_URL . '/sticky-related-posts.js', array('jquery'), SRP_VERSION_CURRENT );
			wp_enqueue_style( 'srp-footerbar-css', SRP_CSS_URL . '/sticky-related-posts.css', array(), SRP_VERSION_CURRENT);
			wp_register_style( 'srp-fontawesome', SRP_CSS_URL . '/fontawesome/font-awesome.min.css', array(), SRP_VERSION_CURRENT );
			wp_enqueue_style( 'srp-fontawesome');
			wp_enqueue_style( 'srp-slick-css', SRP_CSS_URL . '/slick.css', array(), SRP_VERSION_CURRENT );
			wp_enqueue_style( 'srp-slick-theme-css',SRP_CSS_URL . '/slick-theme.css', array(), SRP_VERSION_CURRENT );
			wp_register_script( 'srp-slick-js', SRP_JS_URL . '/slick.min.js', array('jquery'), '1.0',false );
			wp_enqueue_script( 'srp-footerbar-js');
		}
		
		function srp_createMyOptions(){
			require_once SRP_PLUGIN_DIR .'/setting-panel.php';
		}

		function SRP_related_posts()
		{
			$srp_titan =TitanFramework::getInstance( 'srp_my-theme' );
			$related_to = $srp_titan->getOption( 'srp_related_to' );
			$number_of_posts = $srp_titan->getOption( 'srp_number_posts');
			$order_by = $srp_titan->getOption( 'srp_order_by' );
			$my_order = $srp_titan->getOption( 'srp_order' );
			$target = $srp_titan->getOption( 'srp-target-link' );
			$display_thumbnail = $srp_titan->getOption( 'srp-display-thumbnail' );
			$display_credits = $srp_titan->getOption( 'srp-display-credits' );
		
			
			if ( !is_single()){
				return false;
			}
			
			$post='';
			//$orig_post = $post;
			global $post;
			$args=array();
			$args['orderby']= $order_by;
			$args['post_type'] = 'post';
			$args['post__not_in'] = array($post->ID);
			$args['orderby'] = $order_by;
			$args['order']   =$my_order;
			$args['posts_per_page']= $number_of_posts;
			$exists=array();
			
			if($related_to=='category'){
				$categories = get_the_category($post->ID);
				$exists=$categories;
				if ($categories) 
				{
				$category_ids = array();
				foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
				$args['category__in']=$category_ids;
				}
			}
				
			else if($related_to=='tags'){
				$tags = wp_get_post_tags($post->ID);
				$exists=$tags;
				if ($tags) {
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args['tag__in']=$tag_ids;
				}
			}
			
			if($exists)
			{
				$my_query = new WP_Query( $args );
		
				if( $my_query->have_posts() ) 
				{
					
					$SRP_html='';
					$slide_to_show='';
					$post_count = $my_query->found_posts;
								
					if($post_count<=2 || $number_of_posts<=2){
					$slide_to_show=1;
					$slide_to_show2=1;
					$slide_to_show3=1;
					$SRP_html .= '<div class="srp-fixedbar2">';
					}
				
				
				else if($post_count==3 || $number_of_posts==3){
					$slide_to_show=3;
					$slide_to_show2=2;
					$slide_to_show3=3;
					$SRP_html .= '<div class="srp-fixedbar">';
					}
				

				else{
					$slide_to_show2=2;
					$slide_to_show3=3;
					$slide_to_show=4;
					$SRP_html .= '<div class="srp-fixedbar">';
					}
					
					$SRP_html .= '<div class="relatedpost-btn">
					<span class="srp-hide">'.__('Hide Related Posts','srp').'</span>
					</div>
					
					<div class="srp-boxfloat">
					<ul class="responsive" id="slickautoplay">';
									
					$prevArrow ='<div class="prev"><button type="button" class="srp-slick-prev"><i class="fa fa-caret-left"></i></button></div>';
					$next_arrow  ='<div class="next"><button type="button" class="srp-slick-next"><i class="fa fa-caret-right"></i></button></div>';
							
								
					if( ! wp_script_is( 'jquery', 'done' ) ){
						wp_enqueue_script( 'jquery' );
					}
					
					wp_enqueue_script( 'srp-slick-js');
					wp_add_inline_script( 'srp-slick-js', "jQuery(document).ready(function($){
					$('#slickautoplay').slick({

					slidesToShow:$slide_to_show,
					slidesToScroll:1,
					arrows: true,
					dots: false,
					infinite: false,
					autoplaySpeed: 2000,
					adaptiveHeight: true,
					centerMode: false,
					centerPadding: '60px',
					prevArrow:'".$prevArrow."',
					nextArrow:'".$next_arrow."',
					 responsive: [
						{
						  breakpoint: 1280,
						  settings: {
							slidesToShow: $slide_to_show3,
							slidesToScroll: 1
						  }
						},
						{
						  breakpoint: 840,
						  settings: {
							slidesToShow:$slide_to_show2,
							slidesToScroll: 1
						  }
						},
						{
						  breakpoint: 640,
						  settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						  }
						}
					  ]
							});
	
					});" );
				
					while( $my_query->have_posts() )
					{
							
						$my_query->the_post();
						
						if($target==true){
						$newtarget='_blank';	
						} 
						else{
						$newtarget='_self';
						}
						
											
						$SRP_html .='<li id="'.get_the_ID().'" class="srp-post" >';
						
						$SRP_html .='<a class="srp-title" href="'.get_the_permalink().'" target="'.$newtarget.'">';
						
						if ( has_post_thumbnail() ) {
							if($display_thumbnail==true){
							$SRP_html .='<div class="srp-thumbnail" >'.get_the_post_thumbnail().'</div>';
							}
						}
						else { if($display_thumbnail==true){
							$SRP_html .='<div class="srp-thumbnail" ><img src="'.SRP_PLUGIN_URL .'img/no-thumb.png"/></div>';
							}
						}
						if($display_thumbnail==true) { $SRP_html .='<div class="titletext"><p>'.get_the_title().'</p></div>'; }
						else { $SRP_html .='<div class="titletext nothumb"><p>'.get_the_title().'</p></div>'; }
						$SRP_html .='</a></li>';
					}
					
					if($display_credits==true) { $SRP_html .='</ul><div class="srp-author">Credits: <a rel="nofollow" target="_blank" title="Cool Plugins" href="https://coolplugins.net">Cool Plugins</a></div><div class="boxfiller"></div></div></div>';	 }				
					else { $SRP_html .='</ul><div class="boxfiller"></div></div></div>'; }
					echo $SRP_html;
				
					
				}
				
				//$post = $orig_post;
			
			}
				wp_reset_query();
				
		}
	}
}	
			
	// Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('StickyRelatedPosts', 'srp_activate'));
    register_deactivation_hook(__FILE__, array('StickyRelatedPosts', 'srp_deactivate'));

 $Sticky_relatedposts = new StickyRelatedPosts(); //initialization of plugin
