<?php

		$srp_titan =  TitanFramework::getInstance( 'srp_my-theme' );
		$srp_panel = $srp_titan->createAdminPanel( array(
		'name' => __('Sticky Related Posts','srp'),
		) );

		$srp_panel->createOption( array(
		'name' => __('Related to','srp'),
		'id' => 'srp_related_to',
		'type' => 'select',
		'options' => array(
		'category' => __('Category','srp'),
		'tags' => __('Tags','srp'),
		),
		'desc' => __('Related Post based','srp'),
		'default' => 'category',
		) );
		
		$srp_panel->createOption( array(
		'name' => __('Number of Similar Posts','srp'),
		'id' => 'srp_number_posts',
		'type' => 'number',
		'desc' => __('Number of similar Posts To display','srp'),
		'default' => '10',
		'min'=>'1',
		'max' => '100',
		) );
	

		$srp_panel->createOption( array(
		'name' => __('Order By','srp'),
		'id' => 'srp_order_by',
		'type' => 'select',
		'options' => array(
		'date' => __('Date','srp'),
		'author' => __('Author','srp'),
		'name' => __('Name','srp'),
		'ID' => __('ID','srp'),
		'title' => __('Title','srp'),
		'modified' => __('Modified','srp'),
		'rand' => __('Random','srp'),
		'comment_count' => __('Comment Count','srp'),
		),
		'desc' => __('Related Post order by','srp'),
		'default' => 'date',
		) );
		
		$srp_panel->createOption( array(
		'name' => __('Order','srp'),
		'id' => 'srp_order',
		'type' => 'select',
		'options' => array(
		'DESC' => __('Descending','srp'),
		'ASC' => __('Ascending','srp'),
		),
		'desc' => __('Related Post order','srp'),
		'default' => 'ASC',
		) );

		$srp_panel->createOption( array(
		'name' => __('Target Link','srp'),
		'id' => 'srp-target-link',
		'type' => 'enable',
		'default' => false,
		'desc' => __('Enable this field to open related post in new tab','srp'),
		) );

		/* ------Display Image YES/NO------- */
		$srp_panel->createOption( array(
		'name' => __('Display Thumbnail','srp'),
		'id' => 'srp-display-thumbnail',
		'type' => 'enable',
		'default' => true,
		'desc' => __('Enable To Display Thumbnail in related post','srp'),
		) );
		
		/* ------Background Color------- */
		$srp_panel->createOption( array(
		'name' => __('Choose Background Color','srp'),
		'id' => 'srp_background_color',
		'type' => 'color',
		'desc' => __('Pick a color','srp'),
		'default' => '#e0e0e0',
		'css'=>'.srp-fixedbar, .srp-fixedbar2 {
					background-color:value!important; 
				}
				@if (lightness($srp_background_color) > 65%) {
				.srp-thumbnail {
					border-color: darken( $srp_background_color , 15% );
				}
				.srp-fixedbar .slick-arrow i.fa, .srp-fixedbar2 .slick-arrow i.fa {
				   color: darken( $srp_background_color , 15% );
			    }
				.srp-fixedbar .slick-arrow i.fa:hover, .srp-fixedbar2 .slick-arrow i.fa:hover {
				   color: darken( $srp_background_color , 25% );
			    }
				.srp-post.slick-active a {
					border-right: 1px solid darken( $srp_background_color , 15% );
				}
				}
				@else {
				.srp-thumbnail {
					border-color: lighten( $srp_background_color , 15% );
				}
				.srp-fixedbar .slick-arrow i.fa, .srp-fixedbar2 .slick-arrow i.fa {
				   color: lighten( $srp_background_color , 15% );
			    }
				.srp-fixedbar .slick-arrow i.fa:hover, .srp-fixedbar2 .slick-arrow i.fa:hover {
				   color: lighten( $srp_background_color , 25% );
			    }
				.srp-post.slick-active a {
					border-right: 1px solid lighten( $srp_background_color , 15% );
				}
				}'
		) );

		/* ------Border Color------- */
		$srp_panel->createOption( array(
		'name' => __('Choose Border Color','srp'),
		'id' => 'srp_border_color',
		'type' => 'color',
		'desc' => __('Pick a color','srp'),
		'default' => '#7f7f7f',
		'css'=>'.srp-fixedbar, .srp-fixedbar2 {
					border-top: 5px solid value !important;
			   }
			   .srp-boxfloat .boxfiller { background-color: darken( $srp_border_color , 20% ); }
			   .relatedpost-btn {
					background-color: value !important;
		
					@if (lightness($srp_border_color) > 45%) {
					  color: darken( $srp_border_color , 35% );
					}
					@else {
					  color: lighten( $srp_border_color , 55% );
					}
		
			   }'
		) );

		/* ------Font Color------- */		
		$srp_panel->createOption( array(
		'name' => __('Choose Font Color','srp'),
		'id' => 'srp_font_color',
		'type' => 'color',
		'desc' => __('Pick a color','srp'),
		'default' => '#775f4a',
		'css'=>'a.srp-title, .titletext {color:value!important;
			   }
			   a.srp-title:hover, a.srp-title:hover .titletext { 
					@if (lightness($srp_font_color) > 60%) {
					  color: darken( $srp_font_color , 20% ) !important;
					}
					@else {
					  color: lighten( $srp_font_color , 20% ) !important;
					}
			   }'
			   
		) );
		
		
		/* ------Plugin Author Credits------- */
		$srp_panel->createOption( array(
		'name' => __('Display Plugin Author Link','srp'),
		'id' => 'srp-display-credits',
		'type' => 'enable',
		'default' => false,
		'desc' => __('Enable This Option To Thanks The Plugin Author','srp'),
		) );
		
	
		/* ------SAVE IT------- */
		$srp_panel->createOption( array(
		'type' => 'save'
		) );
		
?>