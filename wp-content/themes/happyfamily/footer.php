<?php do_action('lightning_footer_before'); ?>

<?php
$footer_extra_links = array(
    array(
        'label' => '個人情報のお取扱いについて',
        'url'   => home_url('/contact/kojinjoho-otoriatsukai/'),
    ),
    array(
        'label' => '特定商取引法に基づく表記(ハッピーファミリー)',
        'url'   => home_url('/contact/tokusho-happyfaimily/'),
    ),
    array(
        'label' => '特定商取引法に基づく表記(エクセレント事業部)',
        'url'   => home_url('/contact/tokusho-excellent/'),
    ),
    array(
        'label' => 'プライバシーポリシー',
        'url'   => home_url('/contact/privacy-policy/'),
    ),
    array(
        'label' => 'お問い合わせ',
        'url'   => home_url('/contact/'),
    ),
    array(
        'label' => 'よくあるご質問',
        'url'   => home_url('/contact/faq/'),
    ),
);

$footer_normalize_url = function ($url) {
    $path = wp_parse_url($url, PHP_URL_PATH);
    return untrailingslashit($path ? $path : '/');
};

$footer_extra_items = function ($items, $args) use ($footer_extra_links, $footer_normalize_url) {
    if (empty($args->theme_location) || $args->theme_location !== 'Footer') {
        return $items;
    }

    $existing_paths = array();
    foreach ($footer_extra_links as $link) {
        $existing_paths[$footer_normalize_url($link['url'])] = false;
    }

    if (preg_match_all('/href=[\"\']([^\"\']+)[\"\']/', $items, $matches)) {
        foreach ($matches[1] as $url) {
            $path = $footer_normalize_url($url);
            if (array_key_exists($path, $existing_paths)) {
                $existing_paths[$path] = true;
            }
        }
    }

    foreach ($footer_extra_links as $link) {
        if ($existing_paths[$footer_normalize_url($link['url'])]) {
            continue;
        }

        $items .= sprintf(
            '<li class="menu-item footer-menu-extra"><a href="%s">%s</a></li>',
            esc_url($link['url']),
            esc_html($link['label'])
        );
    }

    return $items;
};

add_filter('wp_nav_menu_items', $footer_extra_items, 10, 2);
$footer_menu = wp_nav_menu(array(
    'theme_location' => 'Footer',
    'container'      => 'nav',
    'items_wrap'     => '<ul id="%1$s" class="%2$s nav">%3$s</ul>',
    'fallback_cb'    => '',
    'depth'          => 1,
    'echo'           => false,
));
remove_filter('wp_nav_menu_items', $footer_extra_items, 10);

if (!$footer_menu) {
    $footer_menu_items = '';
    foreach ($footer_extra_links as $link) {
        $footer_menu_items .= sprintf(
            '<li class="menu-item footer-menu-extra"><a href="%s">%s</a></li>',
            esc_url($link['url']),
            esc_html($link['label'])
        );
    }
    $footer_menu = '<nav><ul class="menu nav">' . $footer_menu_items . '</ul></nav>';
}

$footer_logo_id = get_theme_mod('custom_logo');
$footer_logo_url = $footer_logo_id ? wp_get_attachment_image_url($footer_logo_id, 'full') : '';
if (!$footer_logo_url) {
    $footer_logo_url = site_url('/wp-content/uploads/2018/08/logo-560x120.png');
}
?>

<footer class="section siteFooter happy-common-footer">
    <div class="happy-common-footer__logo">
        <a href="<?php echo esc_url(home_url('/')); ?>">
            <img src="<?php echo esc_url($footer_logo_url); ?>" alt="ハッピーファミリー">
        </a>
    </div>

    <div class="footerMenu happy-common-footer__menu">
        <div class="container">
            <?php echo $footer_menu; ?>
        </div>
    </div>

    <address>ハッピーファミリー株式会社　〒532-0003 大阪市淀川区宮原2-14-14　TEL：06-6391-3311（代）</address>
    <small>© HAPPY FAMILY CO., LTD. All Rights Reserved.</small>
</footer>

<?php do_action('lightning_footer_after'); ?>
<?php wp_footer(); ?>
</body>
</html>
