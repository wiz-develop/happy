<?php
require_once dirname( __FILE__ ) . '/extends-lightning/shortcuts.php';
require_once dirname( __FILE__ ) . '/extends-lightning/widget-3pr-area.php';

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
    <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/asset/js/common.js?<?php echo date("ymdHis",filemtime( get_stylesheet_directory_uri()."/asset/js/common.js")); ?>"></script>
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
