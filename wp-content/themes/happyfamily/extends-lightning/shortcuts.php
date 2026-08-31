<?php
add_shortcode( 'vkExUnit_childs', 'vkExUnit_childPageIndex_shortcode1' );
function vkExUnit_childPageIndex_shortcode1() {

	global $is_pagewidget;

	if ( $is_pagewidget ) {

		global $widget_pageid;
		$parentId = $widget_pageid;

	} else {

		global $post;
		if ( ! is_page() || ! get_post_meta( $post->ID, 'vkExUnit_childPageIndex', true ) ) { return false; }
		$parentId = $post->ID;

	}

	$args = array(
		'post_type'			=> 'page',
		'posts_per_page'	=> -1,
		'order'				=> 'ASC',
		'orderby'			=> 'menu_order',
		'post_parent'		=> $parentId,
	);
	$childrens = get_posts( $args );

	if ( empty( $childrens ) ) { wp_reset_query(); return false; }

	$childPageList_html = PHP_EOL.'<div class="veu_childPage_list">'.PHP_EOL;
	foreach( $childrens as $children ):

			$postExcerpt = veu_child_page_excerpt( $children );

			// Page Item build
			$childPageList_html .= '<a href="'.esc_url( get_permalink( $children->ID ) ).'" class="childPage_list_box"><div class="childPage_list_box_inner">';
			$childPageList_html .= '<div class="childPage_list_body">';
			$childPageList_html .= apply_filters('veu_child_index_thumbnail',get_the_post_thumbnail( $children->ID, 'medium' ));
			// $childPageList_html .= '<p class="childPage_list_text">'.$postExcerpt.'</p>';
			// $childPageList_html .= '<span class="childPage_list_more btn btn-primary btn-xs">'.__( 'Read more', 'vkExUnit' ).'</span>';
			$childPageList_html .= '</div>';
			$childPageList_html .= '<h3 class="childPage_list_title">'.esc_html( strip_tags( $children->post_title ) ).'</h3>';

			$childPageList_html .= '</div></a>'.PHP_EOL;
	endforeach;

	$childPageList_html .= PHP_EOL.'</div><!-- [ /.childPage_list ] -->'.PHP_EOL;
	wp_reset_query();

	return $childPageList_html;
}