<?php get_header(); ?>

<div id="firstview-carousel" data-interval="4000" class="carousel slide" data-ride="carousel" style="margin-top: var(--site-header-offset, 86px);">
	<div class="firstview-inner-carousel">
		<div class="item item-1">
			<a href="/exellent/mirais-kin/" target="_blank">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/mirais-kin_bnr.jpg" alt="Mirais-kin Aqua Serum" class="slide-item-img">
				</picture>
			</a>
		</div>
		<div class="item item-2">
			<a href="/hydrogen-inhaler/soluna/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/soluna_bnr.jpg" alt="SOLUNA" class="slide-item-img">
				</picture>
			</a>
		</div>
		<!-- <div class="item item-2">
			<a href="/hydrogen-inhaler/juwell/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/juwell_bnr.jpg" alt="juwell（ジュウェル）" class="slide-item-img">
				</picture>
			</a>
		</div> -->
		<div class="item item-3">
			<a href="/exellent/p-sac/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/p-sac_bnr.jpg" alt="REVIVAL P-SAC （ピーサック）" class="slide-item-img">
				</picture>
			</a>
		</div>
		<div class="item item-4">
			<a href="/exellent/flora-jelly/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/revival_florabn.jpg" alt="REVIVAL フローラゼリー" class="slide-item-img">
				</picture>
			</a>
		</div>
		<div class="item item-5">
			<a href="/happy-water-ex/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/mizushoriki_bn_2024.jpg" alt="水処理器" class="slide-item-img">
				</picture>
			</a>
		</div><!-- [ /.item ] -->
		<div class="item item-6">
			<a href="/exellent/">
				<picture>
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/top_slide/excellent_bnr.jpg" alt="exellent" class="slide-item-img">
				</picture>
			</a>
		</div><!-- [ /.item ] -->
	</div><!-- [ /.carousel-inner ] -->
</div>

<div class="section siteContent">
	<div class="container">
		<div class="row">

			<?php
			if ( lightning_is_frontpage_onecolumn() ) {
				$main_col = 'col-md-12';
			} else {
				$main_col = 'col-md-8';
			}
			?>

			<div class="<?php echo $main_col; ?> mainSection">

			<?php do_action( 'lightning_home_content_top_widget_area_before' ); ?>

			<?php if ( is_active_sidebar( 'home-content-top-widget-area' ) ) : ?>
				<?php dynamic_sidebar( 'home-content-top-widget-area' ); ?>
			<?php endif; ?>

			<?php do_action( 'lightning_home_content_top_widget_area_after' ); ?>

			<?php if ( apply_filters( 'is_lightning_home_content_display', true ) ) : ?>

			<?php if ( have_posts() ) : ?>

				<?php if ( 'page' == get_option( 'show_on_front' ) ) : ?>

					<?php
					while ( have_posts() ) :
						the_post();
?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="entry-body">
							<?php the_content(); ?>
						</div>
						<?php
						wp_link_pages(
							array(
								'before' => '<div class="page-link">' . 'Pages:',
								'after'  => '</div>',
							)
						);
?>
						 </article><!-- [ /#post-<?php the_ID(); ?> ] -->

					<?php endwhile; ?>

				<?php else : ?>

					<div class="postList">

						<?php
						while ( have_posts() ) :
							the_post();
?>

							<?php get_template_part( 'module_loop_post' ); ?>

						<?php endwhile; ?>

						<?php
						the_posts_pagination(
							array(
								'mid_size'           => 1,
								'prev_text'          => '&laquo;',
								'next_text'          => '&raquo;',
								'type'               => 'list',
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'lightning' ) . ' </span>',
							)
						);
							?>

					</div><!-- [ /.postList ] -->

				<?php endif; // if ( 'page' == get_option('show_on_front') ) : ?>

			<?php else : ?>

				<div class="well"><p><?php _e( 'No posts.', 'lightning' ); ?></p></div>

			<?php endif; // have_post() ?>

			<?php endif; // if ( apply_filters( 'is_lightning_home_top_posts_display', true ) ) : ?>

			</div><!-- [ /.mainSection ] -->

			<?php if ( ! lightning_is_frontpage_onecolumn() ) : ?>

				<div class="col-md-3 col-md-offset-1 subSection sideSection">
					<?php get_sidebar(); ?>
				</div><!-- [ /.subSection ] -->

			<?php endif; ?>

		</div><!-- [ /.row ] -->
	</div><!-- [ /.container ] -->
</div><!-- [ /.siteContent ] -->
<?php get_footer(); ?>
