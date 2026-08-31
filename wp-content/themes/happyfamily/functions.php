<?php
require_once dirname( __FILE__ ) . '/extends-lightning/shortcuts.php';
require_once dirname( __FILE__ ) . '/extends-lightning/widget-3pr-area.php';

// This child theme uses the Bootstrap 3 markup provided by Lightning's Origin skin.
function happyfamily_lightning_design_skin( $pre_option ) {
    return 'origin';
}
add_filter( 'pre_option_lightning_design_skin', 'happyfamily_lightning_design_skin' );

function happyfamily_menu_btn_position( $position ) {
    $options = get_option( 'lightning_theme_options' );
    if ( ! empty( $options['menu_btn_position'] ) && in_array( $options['menu_btn_position'], array( 'left', 'right' ), true ) ) {
        return $options['menu_btn_position'];
    }
    return $position;
}
add_filter( 'lightning_menu_btn_position', 'happyfamily_menu_btn_position' );

// The child header already provides its own mobile navigation.
function happyfamily_remove_modern_mobile_nav() {
    remove_action( 'lightning_footer_after', array( 'Vk_Mobile_Nav', 'menu_set_html' ) );
    remove_action( 'wp_enqueue_scripts', array( 'Vk_Mobile_Nav', 'add_inline_css' ), 30 );

    global $vk_mobile_nav;
    if ( is_object( $vk_mobile_nav ) ) {
        remove_filter( 'body_class', array( $vk_mobile_nav, 'add_body_class_mobile_device' ) );
    }
}
add_action( 'after_setup_theme', 'happyfamily_remove_modern_mobile_nav', 100 );

/*-------------------------------------------*/
/*  フッターのウィジェットエリアの数を増やす
/*-------------------------------------------*/
add_filter('lightning_footer_widget_area_count', 'lightning_footer_widget_area_count_custom');
function lightning_footer_widget_area_count_custom($footer_widget_area_count)
{
    $footer_widget_area_count = 2; // ← 1~4の半角数字で設定してください。
    return $footer_widget_area_count;
}

/*-------------------------------------------*/
/* Lightningの子テーマのstyle.cssを更新したら最新を読み込む
/*-------------------------------------------*/
function happyfamily_theme_style() {
    wp_dequeue_style( 'lightning-theme-style' );
    wp_enqueue_style( 'happyfamily-theme-style', get_stylesheet_uri(), array( 'lightning-design-style' ), filemtime( get_stylesheet_directory() . '/style.css' ) );
}
add_action( 'wp_print_styles', 'happyfamily_theme_style' );

function add_wp_head_custom(){ ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
<?php }
add_action( 'wp_head', 'add_wp_head_custom',99);

function add_wp_footer_custom(){ ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/asset/js/common.js"></script>
<?php }
add_action( 'wp_footer', 'add_wp_footer_custom', 99);

/*-------------------------------------------*/
/* アイキャッチ画像をeyecatchショートコードで呼び出す
/*-------------------------------------------*/
function getEyecatchImage() {
    if(has_post_thumbnail()) {
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $img = wp_get_attachment_image_src( $thumb_id, 'full' );
        $img_src = $img[0];//画像のパス
        $img_width = $img[1];//画像の幅
        $img_height = $img[2];//画像の高さ
    }else{
        $img_src = esc_url ( get_template_directory_uri() ).'thumb.png';
    }
    $view_img = '<img class="eyecatch" src="'.$img_src.'" alt="">';
    return $view_img;
}
add_shortcode('eyecatch', 'getEyecatchImage');

/*-------------------------------------------*/
/* Lightningのスライドショーの設定枚数を変更
/*-------------------------------------------*/
add_filter('lightning_top_slide_count_max', 'lightning_top_slide_count_change');
function lightning_top_slide_count_change( $top_slide_count_max )
{
    $top_slide_count_max = 6;
    return $top_slide_count_max;
}

function remove_protected_text() {
    return '%s';
}
add_filter( 'protected_title_format', 'remove_protected_text' );
