<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Keeps the legacy 3PR widget ID and saved options independent of VK ExUnit's
 * optional legacy-widget loader.
 */
class WP_Widget_vkExUnit_3PR_areaEx extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'WP_Widget_vkExUnit_3PR_area',
			'HAPPY 3PR area',
			array(
				'description'           => 'Displays the existing three-column PR area.',
				'show_instance_in_rest' => true,
			)
		);
	}

	public static function default_options( $args = array() ) {
		$defaults = array();
		for ( $i = 1; $i <= 3; $i++ ) {
			$defaults[ 'label_' . $i ]              = '';
			$defaults[ 'media_3pr_image_' . $i ]    = '';
			$defaults[ 'media_3pr_alt_' . $i ]      = '';
			$defaults[ 'media_3pr_image_sp_' . $i ] = '';
			$defaults[ 'media_3pr_alt_sp_' . $i ]   = '';
			$defaults[ 'summary_' . $i ]            = '';
			$defaults[ 'linkurl_' . $i ]            = '';
			$defaults[ 'blank_' . $i ]              = false;
		}

		return wp_parse_args( (array) $args, $defaults );
	}

	public function form( $instance ) {
		$instance = self::default_options( $instance );
		for ( $i = 1; $i <= 3; $i++ ) {
			?>
			<h3><?php echo esc_html( sprintf( '3PR area %d', $i ) ); ?></h3>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'label_' . $i ) ); ?>">Title</label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'label_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'label_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'label_' . $i ] ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'media_3pr_image_' . $i ) ); ?>">PC image URL</label>
				<input class="widefat" type="url" id="<?php echo esc_attr( $this->get_field_id( 'media_3pr_image_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_3pr_image_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'media_3pr_image_' . $i ] ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'media_3pr_alt_' . $i ) ); ?>">PC image alt text</label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'media_3pr_alt_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_3pr_alt_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'media_3pr_alt_' . $i ] ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'media_3pr_image_sp_' . $i ) ); ?>">Mobile image URL</label>
				<input class="widefat" type="url" id="<?php echo esc_attr( $this->get_field_id( 'media_3pr_image_sp_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_3pr_image_sp_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'media_3pr_image_sp_' . $i ] ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'media_3pr_alt_sp_' . $i ) ); ?>">Mobile image alt text</label>
				<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'media_3pr_alt_sp_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_3pr_alt_sp_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'media_3pr_alt_sp_' . $i ] ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'summary_' . $i ) ); ?>">Summary</label>
				<textarea class="widefat" rows="4" id="<?php echo esc_attr( $this->get_field_id( 'summary_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'summary_' . $i ) ); ?>"><?php echo esc_textarea( $instance[ 'summary_' . $i ] ); ?></textarea>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'linkurl_' . $i ) ); ?>">Link URL</label>
				<input class="widefat" type="url" id="<?php echo esc_attr( $this->get_field_id( 'linkurl_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkurl_' . $i ) ); ?>" value="<?php echo esc_attr( $instance[ 'linkurl_' . $i ] ); ?>">
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'blank_' . $i ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'blank_' . $i ) ); ?>" value="1" <?php checked( ! empty( $instance[ 'blank_' . $i ] ) ); ?>>
				<label for="<?php echo esc_attr( $this->get_field_id( 'blank_' . $i ) ); ?>">Open in a new tab</label>
			</p>
			<hr>
			<?php
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = self::default_options( $old_instance );
		for ( $i = 1; $i <= 3; $i++ ) {
			$instance[ 'label_' . $i ]              = isset( $new_instance[ 'label_' . $i ] ) ? wp_kses_post( wp_unslash( $new_instance[ 'label_' . $i ] ) ) : '';
			$instance[ 'media_3pr_image_' . $i ]    = isset( $new_instance[ 'media_3pr_image_' . $i ] ) ? esc_url_raw( $new_instance[ 'media_3pr_image_' . $i ] ) : '';
			$instance[ 'media_3pr_alt_' . $i ]      = isset( $new_instance[ 'media_3pr_alt_' . $i ] ) ? sanitize_text_field( $new_instance[ 'media_3pr_alt_' . $i ] ) : '';
			$instance[ 'media_3pr_image_sp_' . $i ] = isset( $new_instance[ 'media_3pr_image_sp_' . $i ] ) ? esc_url_raw( $new_instance[ 'media_3pr_image_sp_' . $i ] ) : '';
			$instance[ 'media_3pr_alt_sp_' . $i ]   = isset( $new_instance[ 'media_3pr_alt_sp_' . $i ] ) ? sanitize_text_field( $new_instance[ 'media_3pr_alt_sp_' . $i ] ) : '';
			$instance[ 'summary_' . $i ]            = isset( $new_instance[ 'summary_' . $i ] ) ? wp_kses_post( wp_unslash( $new_instance[ 'summary_' . $i ] ) ) : '';
			$instance[ 'linkurl_' . $i ]            = isset( $new_instance[ 'linkurl_' . $i ] ) ? esc_url_raw( $new_instance[ 'linkurl_' . $i ] ) : '';
			$instance[ 'blank_' . $i ]              = ! empty( $new_instance[ 'blank_' . $i ] );
		}

		return $instance;
	}

	public function widget( $args, $instance ) {
		$instance = self::default_options( $instance );
		echo $args['before_widget'];
		echo '<div class="veu_3prArea row">';

		for ( $i = 1; $i <= 3; $i++ ) {
			if ( empty( $instance[ 'label_' . $i ] ) ) {
				continue;
			}

			$blank = ! empty( $instance[ 'blank_' . $i ] ) ? ' target="_blank" rel="noopener noreferrer"' : '';
			echo '<div class="prArea col-sm-4">';

			if ( ! empty( $instance[ 'media_3pr_image_' . $i ] ) ) {
				echo '<div class="media_pr veu_3prArea_image">';
				if ( ! empty( $instance[ 'linkurl_' . $i ] ) ) {
					echo '<a href="' . esc_url( $instance[ 'linkurl_' . $i ] ) . '" class="veu_3prArea_image_link"' . $blank . '>';
				}

				$desktop_class = ! empty( $instance[ 'media_3pr_image_sp_' . $i ] ) ? ' class="image_pc"' : '';
				echo '<img' . $desktop_class . ' src="' . esc_url( $instance[ 'media_3pr_image_' . $i ] ) . '" alt="' . esc_attr( $instance[ 'media_3pr_alt_' . $i ] ) . '">';
				if ( ! empty( $instance[ 'media_3pr_image_sp_' . $i ] ) ) {
					echo '<img class="image_sp" src="' . esc_url( $instance[ 'media_3pr_image_sp_' . $i ] ) . '" alt="' . esc_attr( $instance[ 'media_3pr_alt_sp_' . $i ] ) . '">';
				}

				if ( ! empty( $instance[ 'linkurl_' . $i ] ) ) {
					echo '</a>';
				}
				echo '</div>';
			}

			echo '<h1 class="subSection-title">' . wp_kses_post( $instance[ 'label_' . $i ] ) . '</h1>';
			if ( ! empty( $instance[ 'summary_' . $i ] ) ) {
				if ( ! empty( $instance[ 'linkurl_' . $i ] ) ) {
					echo '<a href="' . esc_url( $instance[ 'linkurl_' . $i ] ) . '" class="veu_3prArea_image_link"' . $blank . '>';
				}
				echo '<p class="summary">' . nl2br( wp_kses_post( $instance[ 'summary_' . $i ] ) ) . '</p>';
				if ( ! empty( $instance[ 'linkurl_' . $i ] ) ) {
					echo '</a>';
				}
			}

			echo '</div>';
		}

		echo '</div>';
		echo $args['after_widget'];
	}
}

add_action(
	'widgets_init',
	function () {
		register_widget( 'WP_Widget_vkExUnit_3PR_areaEx' );
	},
	100
);
