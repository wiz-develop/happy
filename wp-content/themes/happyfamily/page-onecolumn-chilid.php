<?php
/*
 * Template Name: Child
 */
get_header(); ?>

<?php 
/* 親のアイキャッチを表示 */
$parent_id = $post->post_parent; 
$parent = get_post($parent_id);
echo get_the_post_thumbnail($parent, 'full'); 
/* /親のアイキャッチを表示 */ 
?>

<?php get_template_part('module_pageTit'); ?>

<?php // get_template_part('module_panList'); ?>

<div class="section siteContent">
<div class="container">
<div class="row">

<div class="col-md-12 mainSection" id="main" role="main">

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php do_action( 'ligthning_entry_body_before' ); ?>
    <div class="entry-body">
    <?php the_content(); ?>
    </div>
	<?php
	$args = array(
		'before'           => '<nav class="page-link"><dl><dt>Pages :</dt><dd>',
		'after'            => '</dd></dl></nav>',
		'link_before'      => '<span class="page-numbers">',
		'link_after'       => '</span>',
		'echo'             => 1
		);
	wp_link_pages( $args ); ?>
    </div><!-- [ /#post-<?php the_ID(); ?> ] -->

	<?php endwhile; ?>

</div><!-- [ /.mainSection ] -->

</div><!-- [ /.row ] -->
</div><!-- [ /.container ] -->
</div><!-- [ /.siteContent ] -->
<?php get_footer(); ?>