<?php
/*
 * Template Name: REVIVAL Flora Jelly LP
 */
get_header();

global $cfs;

$asset_uri = get_stylesheet_directory_uri() . '/asset/images/flora-jelly';
$mirais_asset_uri = get_stylesheet_directory_uri() . '/asset/images/mirais-kin';
$beauty_asset_uri = get_stylesheet_directory_uri() . '/asset/images/beauty-set';

$fj_value = function ($field, $fallback = '') use ($cfs) {
    if (isset($cfs) && is_object($cfs) && method_exists($cfs, 'get')) {
        $value = $cfs->get($field);
        if ($value !== null && $value !== false && $value !== '' && $value !== array()) {
            return $value;
        }
    }
    return $fallback;
};

$fj_loop = function ($field, $fallback = array()) use ($fj_value) {
    $value = $fj_value($field, array());
    return is_array($value) && !empty($value) ? $value : $fallback;
};

$fj_loop_any = function ($fields, $fallback = array()) use ($fj_value) {
    foreach ((array) $fields as $field) {
        $value = $fj_value($field, array());
        if (is_array($value) && !empty($value)) {
            return $value;
        }
    }
    return $fallback;
};

$fj_asset = function ($file) use ($asset_uri) {
    return $asset_uri . '/' . ltrim($file, '/');
};

$fj_rich_text = function ($text) {
    $text = trim((string) $text);
    if ($text === '') {
        return '';
    }
    if (preg_match('/<\/?(ol|ul|li|p|div|br|table|h[1-6])\b/i', $text)) {
        return wp_kses_post($text);
    }
    return wp_kses_post(nl2br($text));
};

$fj_fix_text = function ($text) {
    $text = (string) $text;
    return strtr($text, array(
        'クエン酸N' => 'クエン酸Na',
        'クエン酸Ｎ' => 'クエン酸Na',
        '肌ペース' => '肌ベース',
        '肌ぺース' => '肌ベース',
    ));
};

$fj_movie_embed_html = function ($embed, $title = '') {
    $embed = trim((string) $embed);
    if ($embed === '') {
        return '';
    }
    if (stripos($embed, '<iframe') !== false) {
        return wp_kses($embed, array(
            'iframe' => array(
                'src' => true,
                'title' => true,
                'width' => true,
                'height' => true,
                'frameborder' => true,
                'allow' => true,
                'allowfullscreen' => true,
                'loading' => true,
                'referrerpolicy' => true,
            ),
        ));
    }
    return sprintf(
        '<iframe src="%s" title="%s" loading="lazy" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>',
        esc_url($embed),
        esc_attr($title ?: 'プロモーションムービー')
    );
};

$fj_icon_key = function ($icon, $index = 0) {
    if (is_array($icon)) {
        $icon = $icon['value'] ?? $icon['label'] ?? reset($icon);
    }

    $icon = strtolower(trim((string) $icon));
    $icon = str_replace(array(' ', '_'), '-', $icon);

    if (strpos($icon, 'shield') !== false || strpos($icon, 'care') !== false || strpos($icon, 'odor') !== false || strpos($icon, 'ニオイ') !== false) {
        return 'shield';
    }
    if (strpos($icon, 'jelly') !== false || strpos($icon, 'stick') !== false || strpos($icon, 'package') !== false || strpos($icon, 'ゼリー') !== false || strpos($icon, '個包装') !== false) {
        return 'jelly';
    }
    if (strpos($icon, 'flora') !== false || strpos($icon, 'rhythm') !== false || strpos($icon, 'cycle') !== false || strpos($icon, 'リズム') !== false || strpos($icon, 'フローラ') !== false) {
        return 'flora';
    }
    if (in_array($icon, array('1', '01'), true)) {
        return 'shield';
    }
    if (in_array($icon, array('2', '02'), true)) {
        return 'flora';
    }
    if (in_array($icon, array('3', '03'), true)) {
        return 'jelly';
    }

    $fallbacks = array('shield', 'flora', 'jelly');
    return $fallbacks[$index % count($fallbacks)];
};

$fj_icon_svg = function ($icon) {
    $icons = array(
        'shield' => '<svg viewBox="0 0 48 48" aria-hidden="true" focusable="false"><path d="M24 7l13 5v9c0 9.6-5.4 16.6-13 20-7.6-3.4-13-10.4-13-20v-9l13-5z"/><path d="M18 25c2.4-4.8 9.6-4.8 12 0"/><path d="M20 30h8"/><path d="M33 16l2-3 2 3 3 2-3 2-2 3-2-3-3-2 3-2z"/></svg>',
        'flora' => '<svg viewBox="0 0 48 48" aria-hidden="true" focusable="false"><path d="M24 9a15 15 0 1 1-14 20"/><path d="M12 18a15 15 0 0 1 24-4"/><path d="M34 9h5v5"/><path d="M9 34h5v5"/><path d="M21 24c0-4 6-4 6 0s-6 4-6 0z"/><path d="M24 17v3M24 28v3M17 24h3M28 24h3"/></svg>',
        'jelly' => '<svg viewBox="0 0 48 48" aria-hidden="true" focusable="false"><path d="M16 8h16l3 32H13L16 8z"/><path d="M18 14h12"/><path d="M17 31c4-3 10 3 14 0"/><path d="M20 20h8"/><path d="M34 22l2-3 2 3 3 2-3 2-2 3-2-3-3-2 3-2z"/></svg>',
    );

    return $icons[$icon] ?? $icons['flora'];
};

$header_logo = $fj_value('flora_header_logo');
$hero_image = $fj_value('flora_hero_image', $fj_asset('hero-fv.png'));
$product_image = $fj_value('flora_product_image', $fj_asset('product.png'));
$order_url = $fj_value('flora_order_url', '/contact/');

$reason_cards = $fj_loop('flora_reason_cards', array(
    array('icon' => 'shield', 'title' => '気になるニオイを内側からケア', 'text' => '毎日の食習慣に取り入れやすいゼリーで、体の内側からすっきりとした印象へ導きます。'),
    array('icon' => 'flora', 'title' => '女性のリズムをサポート', 'text' => '乳酸菌発酵由来の成分を中心に、毎日のコンディションづくりをやさしく支えます。'),
    array('icon' => 'jelly', 'title' => '続けやすい個包装ゼリー', 'text' => '持ち運びやすいスティックタイプ。忙しい日々にも無理なく続けられます。'),
));

$promo_movies = $fj_loop('flora_promo_movies', array(
    array(
        'title' => 'フローラゼリー Promotional video',
        'thumb' => $beauty_asset_uri . '/movie-thumb.png',
        'movie_share_url' => 'https://youtu.be/jkpXie1Ki9Q',
        'movie_caption' => 'REVIVAL フローラゼリー Promotional Movie',
    ),
));

$detail_rows = $fj_loop('flora_product_detail_rows', array(
    array('label' => '商品名', 'text' => 'REVIVAL フローラゼリー'),
    array('label' => '内容量', 'text' => '450g（15g × 30包）'),
    array('label' => '希望小売価格', 'text' => '16,500円（税込）'),
    array('label' => 'お召し上がり方', 'text' => '1日1包を目安に、そのままお召し上がりください。冷やしていただくと、よりおいしくお召し上がりいただけます。'),
));

$detail_blocks = $fj_loop('flora_product_detail_blocks', array(
    array(
        'title' => '成分表示',
        'content' => '植物発酵エキス、乳酸菌発酵由来成分、食物繊維、フルーツ由来成分など、毎日の美容と健康をサポートする成分を配合しています。',
    ),
    array(
        'title' => '使用上のご注意',
        'content' => '体質や体調に合わない場合はご使用をお控えください。食品アレルギーのある方は、原材料をご確認のうえお召し上がりください。',
    ),
));

$usage_steps = $fj_loop('flora_usage_steps', array(
    array('step' => 'STEP 01', 'title' => '1日1包を目安に', 'image' => $product_image, 'text' => '毎日のリズムに合わせて、無理なく続けられるタイミングでお召し上がりください。'),
    array('step' => 'CORE STEP', 'title' => '冷やしておいしく', 'image' => $product_image, 'text' => '冷蔵庫で冷やすと、みずみずしいゼリーの口あたりをより楽しめます。'),
    array('step' => 'STEP 03', 'title' => '毎日の習慣へ', 'image' => $product_image, 'text' => '体の内側から整える習慣として、継続してお召し上がりいただくことをおすすめします。'),
));

$voice_cards = $fj_loop('flora_voice_cards', array(
    array('tag' => 'VOICE 01', 'text' => '気になるタイミングでも、手軽に続けられるのがうれしいです。'),
    array('tag' => 'VOICE 02', 'text' => 'ゼリータイプなので食べやすく、毎日の習慣にしやすいです。'),
    array('tag' => 'VOICE 03', 'text' => '持ち運びやすく、忙しい日でも忘れずにケアできます。'),
));

$related_products = $fj_loop_any(array('lp_related_pages', 'flora_related_pages'), array(
    array('title' => 'ミライズキン アクアセラム', 'subtitle' => '＜美容液＞', 'image' => $mirais_asset_uri . '/product.png', 'url' => '/exellent/mirais-kin/'),
    array('title' => 'Excellentビューティーセット', 'subtitle' => 'クレンジング＆ジェル', 'image' => $beauty_asset_uri . '/product-thumb.png', 'url' => '/exellent/beauty_set/'),
));
$related_movies = $fj_loop_any(array('lp_related_videos', 'flora_related_movies'), array(
    array('title' => 'Mirais-Kin 開発ストーリー', 'subtitle' => 'Development Story', 'image' => $mirais_asset_uri . '/movie-thumb.png', 'url' => '#movie'),
    array('title' => 'Excellentビューティーセット', 'subtitle' => 'Promotional Movie', 'image' => $beauty_asset_uri . '/movie-thumb.png', 'url' => '#movie'),
));

$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => 'REVIVAL Flora Jelly',
    'alternateName' => 'REVIVAL フローラゼリー',
    'brand' => array('@type' => 'Brand', 'name' => 'REVIVAL'),
    'description' => 'エチケット消臭菌で気になるカラダのニオイ・ストレスからの解放を目指す、美容と健康を支えるフローラゼリーです。',
    'offers' => array(
        '@type' => 'Offer',
        'price' => '16500',
        'priceCurrency' => 'JPY',
        'availability' => 'https://schema.org/InStock',
    ),
);
?>

<script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

<main class="beauty-lp flora-lp" id="flora-top">
    <header class="beauty-header flora-header" aria-label="REVIVAL Flora Jelly LP navigation">
        <nav class="beauty-header__nav" aria-label="ページ内メニュー">
            <a href="#concept">想い</a>
            <a href="#reason">選ばれる理由</a>
            <a href="#feature">商品特徴</a>
            <a href="#movie">ムービー</a>
            <a href="#detail">商品詳細</a>
            <a class="beauty-header__cta" href="<?php echo esc_url($order_url); ?>">お問い合わせはこちら</a>
        </nav>
    </header>
    <a class="lp-mobile-fixed-cta lp-mobile-fixed-cta--flora is-hidden" data-lp-fixed-cta href="<?php echo esc_url($order_url); ?>">お問い合わせはこちら</a>

    <section class="flora-hero" aria-label="REVIVAL Flora Jelly">
        <div class="flora-hero__inner">
            <div class="flora-hero__copy">
                <p class="flora-hero__eyebrow">REVIVAL <span>Flora Jelly</span></p>
                <h1>エチケット消臭菌<small>※</small>で<br>気になるカラダの<br><span>ニオイ・ストレスからの</span><br><span>解放！</span></h1>
                <p class="flora-hero__lead">自慢したくなる健康長寿を目指す人へ。<br><strong>乳酸菌生産物質配合！</strong><br>疲れにくい体で、毎日HAPPYに！</p>
                <p class="flora-hero__tags">乳酸菌生産物質 / 配合　　天然消臭成分 / オリジナル配合</p>
                <p class="flora-hero__note">※天然消臭成分はハッピーファミリーオリジナル配合</p>
            </div>
            <?php if ($hero_image) : ?>
                <figure class="flora-hero__visual">
                    <img src="<?php echo esc_url($hero_image); ?>" alt="REVIVAL フローラゼリー">
                </figure>
            <?php endif; ?>
        </div>
    </section>

    <section class="beauty-section flora-concept" id="concept">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>CONCEPT</p>
                <h2>REVIVAL フローラゼリー。</h2>
                <span>HEALTHY LONG LIFE</span>
            </div>
            <p class="flora-concept__lead">エチケット消臭菌<small>※</small>で気になるカラダの<br><span>ニオイ・ストレスからの解放！</span></p>
            <p class="flora-concept__text">自慢したくなる健康長寿を<br>目指す人へ。</p>
            <span class="flora-concept__line" aria-hidden="true"></span>
            <p class="flora-concept__point">乳酸菌生産物質配合！</p>
            <p class="flora-concept__happy">疲れにくい体で、毎日 <span>HAPPY</span> に！</p>
            <p class="flora-concept__badge">Daily HAPPY Routine</p>
            <p class="flora-concept__note">※天然消臭成分はハッピーファミリーオリジナル配合</p>
        </div>
    </section>

    <section class="beauty-section flora-reasons" id="reason">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>THREE REASONS</p>
                <h2>フローラゼリーが選ばれる、<br>3つの理由。</h2>
                <span>REASONS TO CHOOSE</span>
            </div>
            <div class="beauty-card-grid beauty-card-grid--3">
                <?php foreach ($reason_cards as $index => $card) : ?>
                    <?php $icon_key = $fj_icon_key($card['icon'] ?? '', $index); ?>
                    <article class="flora-reason-card">
                        <i class="flora-icon flora-icon--<?php echo esc_attr($icon_key); ?>"><?php echo $fj_icon_svg($icon_key); ?></i>
                        <h3><?php echo esc_html($card['title'] ?? ''); ?></h3>
                        <p><?php echo wp_kses_post(nl2br($card['text'] ?? '')); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="beauty-section flora-feature" id="feature">
        <div class="beauty-container flora-feature__grid">
            <?php if ($product_image) : ?>
                <figure class="flora-feature__image">
                    <img src="<?php echo esc_url($product_image); ?>" alt="REVIVAL フローラゼリー 商品画像">
                </figure>
            <?php endif; ?>
            <div class="flora-feature__body">
                <p>OUR PROMISE</p>
                <h2>体の内側から、<br>毎日のリズムを整える。</h2>
                <div class="flora-feature__copy">
                    <div><?php echo $fj_rich_text($fj_value('flora_feature_text', 'カラダのニオイやストレス、疲れやすさは、年齢を重ねるにつれて気になりやすくなる悩み。スキンケアと同じように、内側のケアにも、しっかりとした答えを。')); ?></div>
                    <p class="flora-feature__highlight"><?php echo esc_html($fj_value('flora_feature_highlight', '乳酸菌生産物質と、天然消臭成分。')); ?></p>
                    <div><?php echo $fj_rich_text($fj_value('flora_feature_detail', 'ハッピーファミリーがオリジナルで配合した天然消臭成分と、私たちが大切にし続けてきた乳酸菌生産物質を、毎日続けやすいゼリータイプにしました。続けることで、自慢したくなる毎日を。')); ?></div>
                    <div><?php echo $fj_rich_text($fj_value('flora_feature_closing', '美しさと健康は、ひとつながり。<br>ミライズキン・ビューティーセットと組み合わせて、内外からのトータルケアを。')); ?></div>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($promo_movies)) : ?>
    <section class="beauty-section beauty-movie flora-movie" id="movie">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>PROMOTIONAL MOVIE</p>
                <h2>フローラゼリー Promotional video</h2>
                <span>PRODUCT MOVIE</span>
            </div>
            <div class="beauty-movie-grid">
                <?php foreach ($promo_movies as $movie) : ?>
                    <?php
                        $movie_title = $movie['title'] ?? $movie['movie_title'] ?? '';
                        $movie_thumb = $movie['thumb'] ?? $movie['movie_thumb'] ?? $movie['image'] ?? '';
                        $movie_embed = $movie['movie_embed'] ?? $movie['embed'] ?? $movie['embed_url'] ?? $movie['movie_embed_url'] ?? '';
                        $movie_url = $movie['movie_share_url'] ?? $movie['share_url'] ?? $movie['url'] ?? $movie['movie_url'] ?? '#movie';
                        $movie_caption = $movie['movie_caption'] ?? $movie['caption'] ?? '';
                        $movie_embed_html = $fj_movie_embed_html($movie_embed, $movie_title);
                    ?>
                    <article class="mirais-movie-card beauty-movie-card">
                        <div class="mirais-movie-card__media">
                            <?php if ($movie_embed_html) : ?>
                                <?php echo $movie_embed_html; ?>
                            <?php elseif ($movie_thumb) : ?>
                                <a href="<?php echo esc_url($movie_url); ?>" target="<?php echo $movie_url !== '#movie' ? '_blank' : '_self'; ?>" rel="noopener">
                                    <img src="<?php echo esc_url($movie_thumb); ?>" alt="<?php echo esc_attr($movie_title); ?>">
                                    <span class="mirais-play" aria-hidden="true"></span>
                                </a>
                            <?php endif; ?>
                        </div>
                        <p><?php echo esc_html($movie_caption); ?></p>
                        <?php if ($movie_url && $movie_url !== '#movie') : ?>
                            <a class="mirais-text-link" href="<?php echo esc_url($movie_url); ?>" target="_blank" rel="noopener">Youtubeを開く↗</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="beauty-section beauty-detail flora-detail" id="detail">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>PRODUCT DETAIL</p>
                <h2>毎日HAPPYに、<br>健康長寿の習慣を。</h2>
                <span>REVIVAL FLORA JELLY</span>
            </div>
            <article class="beauty-detail-panel">
                <?php if ($product_image) : ?>
                    <figure>
                        <img src="<?php echo esc_url($product_image); ?>" alt="REVIVAL フローラゼリー 商品詳細">
                    </figure>
                <?php endif; ?>
                <div>
                    <span class="beauty-price">希望小売価格 16,500円（税込）</span>
                    <h3>REVIVAL Flora Jelly ／ フローラゼリー</h3>
                    <p class="beauty-detail-sub">（美容・健康サポートゼリー）</p>
                    <?php if (!empty($detail_rows)) : ?>
                        <dl class="beauty-detail-list">
                            <?php foreach ($detail_rows as $row) : ?>
                                <div>
                                    <dt><?php echo esc_html($fj_fix_text($row['label'] ?? '')); ?><small><?php echo esc_html($fj_fix_text($row['sub'] ?? '')); ?></small></dt>
                                    <dd><?php echo wp_kses_post(nl2br($fj_fix_text($row['text'] ?? ''))); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </div>
            </article>

            <?php if (!empty($detail_blocks)) : ?>
                <article class="beauty-detail-box flora-detail-box">
                    <div class="beauty-detail-box__head">
                        <span>DETAIL</span>
                        <h3>REVIVAL フローラゼリー</h3>
                    </div>
                    <?php foreach ($detail_blocks as $block) : ?>
                        <div class="beauty-detail-box__row">
                            <h4><?php echo esc_html($fj_fix_text($block['title'] ?? '')); ?></h4>
                            <div class="beauty-detail-box__content"><?php echo $fj_rich_text($fj_fix_text($block['content'] ?? '')); ?></div>
                        </div>
                    <?php endforeach; ?>
                </article>
            <?php endif; ?>
        </div>
    </section>

    <?php if (!empty($voice_cards)) : ?>
    <section class="beauty-section beauty-testimonials flora-voices">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>VOICE</p>
                <h2>お客様の声。</h2>
                <span>TESTIMONIALS</span>
            </div>
            <div class="beauty-card-grid beauty-card-grid--3">
                <?php foreach ($voice_cards as $card) : ?>
                    <article class="beauty-voice-card">
                        <b><?php echo esc_html($card['tag'] ?? ''); ?></b>
                        <p><?php echo wp_kses_post(nl2br($card['text'] ?? '')); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($related_products) || !empty($related_movies)) : ?>
    <section class="mirais-section mirais-related beauty-related flora-related">
        <div class="mirais-container">
            <div class="mirais-heading beauty-heading">
                <p>RELATED</p>
                <h2>フローラゼリーを見た人は、<br>こちらのページも見ています。</h2>
                <span>YOU MAY ALSO LIKE</span>
            </div>
            <div class="mirais-related-grid">
                <?php if (!empty($related_products)) : ?>
                <article class="mirais-related-box">
                    <h3>HOME PAGE</h3>
                    <div class="mirais-related-items">
                        <?php foreach ($related_products as $item) : ?>
                            <?php
                                $item_title = $item['title'] ?? $item['related_title'] ?? '';
                                $item_subtitle = $item['subtitle'] ?? $item['related_subtitle'] ?? '';
                                $item_image = $item['image'] ?? $item['related_image'] ?? '';
                                $item_url = $item['url'] ?? $item['related_url'] ?? '#';
                            ?>
                            <a href="<?php echo esc_url($item_url); ?>">
                                <?php if ($item_image) : ?>
                                    <div class="mirais-related-thumb mirais-related-thumb--page">
                                        <img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_title); ?>">
                                    </div>
                                <?php endif; ?>
                                <strong><?php echo esc_html($item_title); ?></strong>
                                <span><?php echo esc_html($item_subtitle); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
                <?php endif; ?>
                <?php if (!empty($related_movies)) : ?>
                <article class="mirais-related-box">
                    <h3>PROMOTIONAL VIDEO</h3>
                    <div class="mirais-related-items">
                        <?php foreach ($related_movies as $item) : ?>
                            <?php
                                $item_title = $item['title'] ?? $item['related_title'] ?? '';
                                $item_subtitle = $item['subtitle'] ?? $item['related_subtitle'] ?? '';
                                $item_image = $item['image'] ?? $item['related_image'] ?? '';
                                $item_url = $item['url'] ?? $item['related_url'] ?? '#';
                            ?>
                            <a href="<?php echo esc_url($item_url); ?>">
                                <?php if ($item_image) : ?>
                                    <div class="mirais-related-thumb">
                                        <img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_title); ?>">
                                        <i class="mirais-related-play" aria-hidden="true"></i>
                                    </div>
                                <?php endif; ?>
                                <strong><?php echo esc_html($item_title); ?></strong>
                                <span><?php echo esc_html($item_subtitle); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="beauty-order flora-order" id="order">
        <div class="beauty-container">
            <p>ORDER</p>
            <h2>毎日HAPPYは、<br>健康長寿の習慣を。</h2>
            <div class="beauty-order__links">
                <a href="<?php echo esc_url($order_url); ?>">お問い合わせはこちら</a>
                <a href="#detail">詳しくはこちら</a>
            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!document.documentElement.dataset.lpMenuScrollFix) {
        document.documentElement.dataset.lpMenuScrollFix = '1';
        document.addEventListener('click', function (event) {
            var menuButton = event.target.closest && event.target.closest('#menuBtn');
            if (!menuButton) {
                return;
            }
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop || 0;
            event.preventDefault();
            window.requestAnimationFrame(function () {
                window.scrollTo(0, scrollTop);
                window.setTimeout(function () {
                    window.scrollTo(0, scrollTop);
                }, 80);
            });
        }, true);
    }

    var revealTargets = document.querySelectorAll('.flora-lp .beauty-section, .flora-lp .beauty-order');
    if (!('IntersectionObserver' in window)) {
        revealTargets.forEach(function (target) {
            target.classList.add('beauty-reveal-visible');
        });
        return;
    }

    document.documentElement.classList.add('beauty-reveal-ready');

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }
            entry.target.classList.add('beauty-reveal-visible');
            observer.unobserve(entry.target);
        });
    }, {
        rootMargin: '0px 0px -12% 0px',
        threshold: 0.12
    });

    revealTargets.forEach(function (target) {
        target.classList.add('beauty-reveal-item');
        observer.observe(target);
    });

    var fixedCta = document.querySelector('[data-lp-fixed-cta]');
    if (!fixedCta) {
        return;
    }
    if (!('IntersectionObserver' in window)) {
        fixedCta.classList.remove('is-hidden');
        return;
    }

    var hero = document.querySelector('.flora-hero');
    var order = document.querySelector('.flora-order');
    var footer = document.querySelector('#site-footer, .siteFooter');
    var rafId = 0;
    var updateFixedCta = function () {
        rafId = 0;
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        var viewportBottom = scrollTop + window.innerHeight;
        var heroBottom = hero ? hero.offsetTop + hero.offsetHeight : 0;
        var orderTop = order ? order.offsetTop : Number.POSITIVE_INFINITY;
        var footerTop = footer ? footer.offsetTop : Number.POSITIVE_INFINITY;
        var shouldHide = scrollTop < (heroBottom - 90) || viewportBottom > (orderTop + 60) || viewportBottom > (footerTop - 80);
        fixedCta.classList.toggle('is-hidden', shouldHide);
    };
    var requestFixedCtaUpdate = function () {
        if (rafId) {
            return;
        }
        rafId = window.requestAnimationFrame(updateFixedCta);
    };
    window.addEventListener('scroll', requestFixedCtaUpdate, { passive: true });
    window.addEventListener('resize', requestFixedCtaUpdate);
    requestFixedCtaUpdate();
});
</script>

<?php get_footer(); ?>
