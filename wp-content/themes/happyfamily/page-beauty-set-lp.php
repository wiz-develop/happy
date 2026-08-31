<?php
/*
 * Template Name: Excellent Beauty Set LP
 */
get_header();

global $cfs;

$asset_uri = get_stylesheet_directory_uri() . '/asset/images/beauty-set';
$mirais_asset_uri = get_stylesheet_directory_uri() . '/asset/images/mirais-kin';

$bs_value = function ($field, $fallback = '') use ($cfs) {
    if (isset($cfs) && is_object($cfs) && method_exists($cfs, 'get')) {
        $value = $cfs->get($field);
        if ($value !== null && $value !== false && $value !== '' && $value !== array()) {
            return $value;
        }
    }
    return $fallback;
};

$bs_loop = function ($field, $fallback = array()) use ($bs_value) {
    $value = $bs_value($field, array());
    return is_array($value) && !empty($value) ? $value : $fallback;
};

$bs_loop_any = function ($fields, $fallback = array()) use ($bs_value) {
    foreach ((array) $fields as $field) {
        $value = $bs_value($field, array());
        if (is_array($value) && !empty($value)) {
            return $value;
        }
    }
    return $fallback;
};

$bs_lines = function ($field, $fallback = array()) use ($bs_value) {
    $value = $bs_value($field, '');
    if (is_array($value) && !empty($value)) {
        return array_values(array_filter(array_map('trim', $value)));
    }
    if (is_string($value) && trim($value) !== '') {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }
    return $fallback;
};

$bs_rich_text = function ($text) {
    $text = trim((string) $text);
    if ($text === '') {
        return '';
    }

    if (preg_match('/<\/?(ol|ul|li|p|div|br|table|h[1-6])\b/i', $text)) {
        $text = preg_replace('/<(ol|ul)([^>]*)>\s*(<br\s*\/?>\s*)+/i', '<$1$2>', $text);
        $text = preg_replace('/(<\/li>)\s*(<br\s*\/?>\s*)+/i', '$1', $text);
        $text = preg_replace('/(<br\s*\/?>\s*)+(<\/?(ol|ul|li)\b[^>]*>)/i', '$2', $text);
        return wp_kses_post($text);
    }

    return wp_kses_post(nl2br($text));
};

$bs_fix_text = function ($text) {
    $text = (string) $text;
    return strtr($text, array(
        'セラド1・3・6Ⅱ' => 'セラミドNP・AP・EOP',
        'セラド１・３・６Ⅱ' => 'セラミドNP・AP・EOP',
        'セラミド1・3・6Ⅱ' => 'セラミドNP・AP・EOP',
        'セラミド１・３・６Ⅱ' => 'セラミドNP・AP・EOP',
        'セラド1・3・6II' => 'セラミドNP・AP・EOP',
        'セラド１・３・６II' => 'セラミドNP・AP・EOP',
        'セラミド1・3・6II' => 'セラミドNP・AP・EOP',
        'セラミド１・３・６II' => 'セラミドNP・AP・EOP',
        '（カリプル酸/カプリン酸）グリセリル' => '（カプリル酸/カプリン酸）グリセリル',
        '(カリプル酸/カプリン酸)グリセリル' => '（カプリル酸/カプリン酸）グリセリル',
        '（カリプル酸／カプリン酸）グリセル' => '（カプリル酸／カプリン酸）グリセリル',
        '（カリプル酸／カプリン酸）グリセリル' => '（カプリル酸／カプリン酸）グリセリル',
        '(カリプル酸／カプリン酸)グリセル' => '（カプリル酸／カプリン酸）グリセリル',
        'カリプル酸/カプリン酸' => 'カプリル酸/カプリン酸',
        'カリプル酸／カプリン酸' => 'カプリル酸／カプリン酸',
        '約パール２粒' => '約パール３粒',
        '約パール2粒' => '約パール3粒',
        '150mg' => '150ml',
        '肌ペース' => '肌ベース',
        '肌ぺース' => '肌ベース',
    ));
};

$bs_sp_title_break = function ($text) {
    $text = esc_html((string) $text);
    return str_replace('エクセレント オールインワンジェル', 'エクセレント<br class="beauty-sp-break">オールインワンジェル', $text);
};

$bs_asset = function ($file) use ($asset_uri) {
    return $asset_uri . '/' . ltrim($file, '/');
};

$bs_movie_embed_html = function ($embed, $title = '') {
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

$hero_slides = $bs_loop('beauty_hero_slides');
$honest_cards = $bs_loop('beauty_honest_cards');
$step_products = $bs_loop('beauty_step_products');
$usage_steps = $bs_loop('beauty_usage_steps');
$promo_movies = $bs_loop('beauty_promo_movies');
$related_products = $bs_loop_any(array('lp_related_pages', 'beauty_related_pages'));
$related_movies = $bs_loop_any(array('lp_related_videos', 'beauty_related_movies'));
$detail_rows = $bs_loop('beauty_product_detail_rows');
$ingredient_blocks = $bs_loop('beauty_product_ingredient_blocks');
$testimonial_cards = $bs_loop('beauty_testimonial_cards');
$header_logo = $bs_value('beauty_header_logo');
$concept_image = $bs_value('beauty_concept_image');
$product_detail_image = $bs_value('beauty_product_image');
$mirais_url = $bs_value('beauty_mirais_url', '/exellent/mirais-kin/');
$mirais_url_path = wp_parse_url($mirais_url, PHP_URL_PATH);
if (in_array(untrailingslashit((string) $mirais_url_path), array('/mirais-kin', '/hydrogen-inhaler/mirais-kin'), true)) {
    $mirais_url = '/exellent/mirais-kin/';
}
$hero_copy_defaults = array(
    array(
        'label' => 'EXCELLENT BEAUTYSET',
        'name' => 'エクセレント ビューティーセット',
        'product' => 'クレンジング&ウォッシュ ／ オールインワンジェル',
        'lines' => array('100寿の時代に、', '美しさと健康を両立したい', 'あなたに。'),
        'accent' => 1,
        'scene' => 'SCENE 01 — WITH HER',
    ),
    array(
        'label' => 'EXCELLENT BEAUTYSET',
        'name' => 'エクセレント ビューティーセット',
        'product' => 'クレンジング&ウォッシュ ／ オールインワンジェル',
        'lines' => array('わずか1分。', '2ステップで叶える、', 'プロ級のスキンケア。'),
        'accent' => 2,
        'scene' => 'SCENE 02 — ON TABLE',
    ),
);

$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => 'Excellent Beauty Set',
    'alternateName' => 'エクセレント ビューティーセット',
    'brand' => array('@type' => 'Brand', 'name' => 'Excellent'),
    'description' => 'クレンジング＆ウォッシュとオールインワンジェルの2ステップで、100寿の時代に美しさと健康を両立したい方を支えるスキンケアセットです。',
    'offers' => array(
        '@type' => 'Offer',
        'price' => '16500',
        'priceCurrency' => 'JPY',
        'availability' => 'https://schema.org/InStock',
    ),
);
?>

<script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

<main class="beauty-lp" id="beauty-top">
    <header class="beauty-header" aria-label="Excellent Beauty Set LP navigation">
        <nav class="beauty-header__nav" aria-label="ページ内メニュー">
            <a href="#concept">コンセプト</a>
            <a href="#twostep">2ステップ</a>
            <a href="#usage">使い方</a>
            <a href="#movie">ムービー</a>
            <a href="#detail">商品詳細</a>
            <a class="beauty-header__cta" href="<?php echo esc_url($bs_value('beauty_order_url', '#order')); ?>">お問い合わせはこちら</a>
        </nav>
    </header>
    <a class="lp-mobile-fixed-cta lp-mobile-fixed-cta--beauty is-hidden" data-lp-fixed-cta href="<?php echo esc_url($bs_value('beauty_order_url', '#order')); ?>">お問い合わせはこちら</a>

    <?php if (!empty($hero_slides)) : ?>
    <section class="mirais-hero beauty-hero" aria-label="Excellent Beauty Set">
        <svg class="mirais-hero__filter" width="0" height="0" aria-hidden="true" focusable="false">
            <filter id="miraisHeroWaveSoft" x="-8%" y="-8%" width="116%" height="116%">
                <feTurbulence type="fractalNoise" baseFrequency="0.004 0.01" numOctaves="1" seed="6" result="waveNoiseSoft">
                    <animate attributeName="baseFrequency" values="0.009 0.02;0.007 0.015;0.004 0.01;0.004 0.01;0.009 0.02;0.007 0.015;0.004 0.01;0.004 0.01;0.009 0.02;0.009 0.02" keyTimes="0;0.08;0.18;0.42;0.48;0.58;0.66;0.90;0.96;1" dur="16s" repeatCount="indefinite" />
                </feTurbulence>
                <feDisplacementMap in="SourceGraphic" in2="waveNoiseSoft" scale="22" xChannelSelector="R" yChannelSelector="G">
                    <animate attributeName="scale" values="22;14;0;0;22;14;0;0;22;22" keyTimes="0;0.08;0.18;0.42;0.48;0.58;0.66;0.90;0.96;1" dur="16s" repeatCount="indefinite" />
                </feDisplacementMap>
            </filter>
        </svg>
        <div class="mirais-hero__slides">
            <?php foreach ($hero_slides as $index => $slide) : ?>
                <?php
                    $slide_image_pc = $slide['image_pc'] ?? $slide['pc_image'] ?? $slide['hero_image_pc'] ?? $slide['image'] ?? $slide['hero_image'] ?? $slide['slide_image'] ?? '';
                    $slide_image_sp = $slide['image_sp'] ?? $slide['sp_image'] ?? $slide['hero_image_sp'] ?? $slide['image'] ?? $slide['hero_image'] ?? $slide['slide_image'] ?? $slide_image_pc;
                    if (!$slide_image_pc) {
                        continue;
                    }
                    $copy_default = $hero_copy_defaults[$index] ?? array();
                    $copy_label = $copy_default['label'] ?? '';
                    $copy_name = $copy_default['name'] ?? '';
                    $copy_product = $copy_default['product'] ?? '';
                    $copy_lines = $copy_default['lines'] ?? array();
                    $copy_accent = (int) ($copy_default['accent'] ?? -1);
                    $copy_scene = $copy_default['scene'] ?? '';
                ?>
                <div class="mirais-hero__slide mirais-hero__slide--<?php echo esc_attr($index + 1); ?>">
                    <img class="mirais-hero__img mirais-hero__img--pc" src="<?php echo esc_url($slide_image_pc); ?>" alt="">
                    <img class="mirais-hero__img mirais-hero__img--sp" src="<?php echo esc_url($slide_image_sp); ?>" alt="">
                    <?php if ($copy_label || $copy_name || $copy_product || !empty($copy_lines) || $copy_scene) : ?>
                        <div class="beauty-hero-copy">
                            <?php if ($copy_label) : ?><p class="beauty-hero-copy__label"><?php echo esc_html($copy_label); ?></p><?php endif; ?>
                            <?php if ($copy_name || $copy_product) : ?>
                                <p class="beauty-hero-copy__sub">
                                    <?php if ($copy_name) : ?><span><?php echo esc_html($copy_name); ?></span><?php endif; ?>
                                    <?php if ($copy_product) : ?><span><?php echo esc_html($copy_product); ?></span><?php endif; ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($copy_lines)) : ?>
                                <p class="beauty-hero-copy__main">
                                    <?php foreach ($copy_lines as $line_index => $line) : ?>
                                        <span class="<?php echo $line_index === $copy_accent ? 'is-gold' : ''; ?>"><?php echo esc_html($line); ?></span>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($copy_scene) : ?><p class="beauty-hero-copy__scene">— <?php echo esc_html($copy_scene); ?></p><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <section class="beauty-section beauty-concept" id="concept">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>THE CONCEPT</p>
                <h1>100寿の時代に、<br>美しさと健康を両立したい<br class="beauty-sp-break">あなたに！</h1>
                <span>BEAUTY & HEALTH FOR LIFE</span>
            </div>
            <p class="beauty-lead">ビューティーセットで、<br><strong>美しさと健康も満たされる毎日を。</strong></p>
            <div class="beauty-catch">
                <p>きっちり落とす</p>
                <?php if ($concept_image) : ?>
                    <figure>
                        <img src="<?php echo esc_url($concept_image); ?>" alt="エクセレント ビューティーセット 商品イメージ">
                        <figcaption>Excellent BeautySet<span>Cleansing & Wash ／ All-in-One Gel</span></figcaption>
                    </figure>
                <?php endif; ?>
                <p>たっぷり潤す</p>
            </div>
            <h2 class="beauty-two-step">お手入れカンタン！<br class="beauty-sp-break">たった <strong>2 ステップ。</strong></h2>
            <p class="beauty-text">ビューティーセットは、仕事や家事・子育てなど、毎日が目まぐるしく過ぎて行く生活の中、自分の時間がどんどん減っていき、肌も疲れも積み重なり「このままでいいのかな？」って思う方に。<br>忙しい日々の中でも簡単な2ステップで肌にしっかりとした潤いとハリを与え、健康的で若々しい肌を保つ期待が持てる、クレンジング＆ウォッシュ／オールインワンジェルが美肌をサポートします。ナノ化された成分が肌に素早く浸透し、乾燥やシミ、ハリ不足など、さまざまな悩みに短時間にケアを可能にし、総合アプローチする期待が持てます。</p>
        </div>
    </section>

    <?php if (!empty($honest_cards)) : ?>
    <section class="beauty-section beauty-honest">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>HONEST VOICE</p>
                <h2>お客様からの本音。</h2>
                <span>REAL VOICES</span>
            </div>
            <div class="beauty-card-grid beauty-card-grid--3">
                <?php foreach ($honest_cards as $card) : ?>
                    <article class="beauty-mini-card">
                        <p><?php echo wp_kses_post(nl2br($card['text'] ?? '')); ?></p>
                        <strong><?php echo esc_html($card['tag'] ?? ''); ?></strong>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php foreach ($step_products as $product) : ?>
        <?php
            $product_items = $product['items'] ?? array();
            $product_extras = $product['extras'] ?? array();
            $product_reverse = !empty($product['reverse']);
        ?>
        <section class="beauty-section beauty-product <?php echo $product_reverse ? 'beauty-product--reverse' : ''; ?>" id="<?php echo esc_attr($product['id'] ?? ''); ?>">
            <div class="beauty-container">
                <div class="beauty-product__head">
                    <p><span><?php echo esc_html($product['step'] ?? ''); ?></span><?php echo esc_html($product['en'] ?? ''); ?></p>
                    <h2><?php echo $bs_sp_title_break($bs_fix_text($product['title'] ?? '')); ?><span class="beauty-product__role"><?php echo esc_html($bs_fix_text($product['role'] ?? '')); ?></span></h2>
                </div>
                <p class="beauty-product__lead"><?php echo wp_kses_post(nl2br($bs_fix_text($product['lead'] ?? ''))); ?></p>
                <div class="beauty-product__grid">
                    <?php if (!empty($product['image'])) : ?>
                        <figure class="beauty-product__visual">
                            <img src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title'] ?? ''); ?>">
                            <?php if (!empty($product['caption'])) : ?>
                                <figcaption><?php echo esc_html($bs_fix_text($product['caption'])); ?></figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php endif; ?>
                    <div class="beauty-ingredient-list">
                        <?php foreach ($product_items as $item) : ?>
                            <article class="beauty-ingredient-card">
                                <span><?php echo esc_html($item['num'] ?? ''); ?></span>
                                <h3><?php echo wp_kses_post($bs_fix_text($item['title'] ?? '')); ?></h3>
                                <p class="beauty-ingredient-card__keyword"><?php echo esc_html($bs_fix_text($item['keyword'] ?? '')); ?></p>
                                <p><?php echo wp_kses_post($bs_fix_text($item['text'] ?? '')); ?></p>
                            </article>
                        <?php endforeach; ?>
                        <?php if (!empty($product_extras)) : ?>
                            <div class="beauty-gel-extra">
                                <?php foreach ($product_extras as $extra) : ?>
                                    <article>
                                        <h4><?php echo esc_html($bs_fix_text($extra['title'] ?? '')); ?></h4>
                                        <p class="beauty-ingredient-card__keyword"><?php echo esc_html($bs_fix_text($extra['keyword'] ?? '')); ?></p>
                                        <p><?php echo wp_kses_post($bs_fix_text($extra['text'] ?? '')); ?></p>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>

    <section class="beauty-section beauty-twostep" id="twostep">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>TWO-STEP CARE</p>
                <h2>初めての快感<br>2ステップケア。</h2>
                <span>53 NATURAL ESSENCES</span>
            </div>
            <p>エクセレントからまたひとつ美しさへの挑戦です。それは忙しい現代女性にとって着地点ともいえる<span class="beauty-nowrap">究極のベーシックケア</span>。<br>クレンジング・洗顔料とオールインワンジェルに天然由来のナノ化した美容成分を53種も凝縮。<br>特定の悩みに特化して働くのではなく、乾燥、毛穴、…、様々な悩みと弱ったところにねらいを定めて<span class="beauty-nowrap">総合アプローチ</span>をする新生スキンケアとして誕生させました。</p>
            <div class="beauty-count"><strong>53</strong><span>種の天然由来美容成分</span></div>
            <small>日々のお手入れは 1・2 ステップ。</small>
            <div class="beauty-twostep-summary">
                <article class="beauty-twostep-card">
                    <p><span>STEP 01</span><b>Cleansing &amp; Wash</b></p>
                    <h3>エクセレント クレンジング＆ウォッシュ</h3>
                    <small>＜クレンジング・洗顔料＞</small>
                    <div class="beauty-twostep-features">
                        <div>
                            <strong>やさしく<br>洗いあげる</strong>
                            <em>シャルドネ種<br>ブドウ果汁発酵液</em>
                        </div>
                        <div>
                            <strong>潤いを保ち<br>ながら洗浄</strong>
                            <em>特殊<br>ヒアルロン酸</em>
                        </div>
                        <div>
                            <strong>ナノ化された<br>美容成分</strong>
                            <em>23種の天然成分を<br>87％配合</em>
                        </div>
                    </div>
                </article>
                <article class="beauty-twostep-card">
                    <p><span>STEP 02</span><b>All-in-One Gel</b></p>
                    <h3>エクセレント オールインワンジェル</h3>
                    <small>＜ジェルクリーム＞</small>
                    <div class="beauty-twostep-features">
                        <div>
                            <strong>センサー機能付き<br>マイクロカプセル</strong>
                            <em>オリゴノールCS</em>
                        </div>
                        <div>
                            <strong>3大美肌成分を<br>ナノ化</strong>
                            <em>ヒアルロン酸<br>コラーゲン<br>エラスチン</em>
                        </div>
                        <div>
                            <strong>抗酸化力</strong>
                            <em>アスタキサンチン</em>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <?php if (!empty($promo_movies)) : ?>
    <section class="beauty-section beauty-movie" id="movie">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>PROMOTIONAL MOVIE</p>
                <h2>Beauty Set Promotional video</h2>
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
                        $movie_embed_html = $bs_movie_embed_html($movie_embed, $movie_title);
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

    <?php if ($product_detail_image || !empty($detail_rows) || !empty($ingredient_blocks)) : ?>
    <section class="beauty-section beauty-detail" id="detail">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>PRODUCT DETAIL</p>
                <h2>美肌オーラを引きよせる、<br>天然エッセンス53種の力。</h2>
                <span>EXCELLENT BEAUTY SET</span>
            </div>
            <article class="beauty-detail-panel">
                <?php if ($product_detail_image) : ?>
                    <figure>
                        <img src="<?php echo esc_url($product_detail_image); ?>" alt="エクセレント ビューティーセット 商品詳細">
                    </figure>
                <?php endif; ?>
                <div>
                    <span class="beauty-price">希望小売価格 16,500円（税込）</span>
                    <h3>Excellent Beauty Set ／ エクセレント ビューティーセット</h3>
                    <p class="beauty-detail-sub">（クレンジング＆ウォッシュ／オールインワンジェル）</p>
                    <?php if (!empty($detail_rows)) : ?>
                        <dl class="beauty-detail-list">
                            <?php foreach ($detail_rows as $row) : ?>
                                <div>
                                    <dt><?php echo esc_html($bs_fix_text($row['label'] ?? '')); ?><small><?php echo esc_html($bs_fix_text($row['sub'] ?? '')); ?></small></dt>
                                    <dd><?php echo wp_kses_post(nl2br($bs_fix_text($row['text'] ?? ''))); ?></dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </div>
            </article>

            <?php foreach ($ingredient_blocks as $block) : ?>
                <article class="beauty-detail-box">
                    <div class="beauty-detail-box__head">
                        <span><?php echo esc_html($block['step'] ?? ''); ?></span>
                        <h3><?php echo esc_html($block['title'] ?? ''); ?></h3>
                    </div>
                    <div class="beauty-detail-box__row">
                        <h4>成分表示</h4>
                        <div class="beauty-detail-box__content"><?php echo $bs_rich_text($bs_fix_text($block['ingredients'] ?? '')); ?></div>
                    </div>
                    <div class="beauty-detail-box__row">
                        <h4>使用上のご注意</h4>
                        <div class="beauty-detail-box__content"><?php echo $bs_rich_text($bs_fix_text($block['cautions'] ?? '')); ?></div>
                    </div>
                    <div class="beauty-detail-box__row">
                        <h4>＜保管及び取扱上の注意＞</h4>
                        <div class="beauty-detail-box__content"><?php echo $bs_rich_text($bs_fix_text($block['storage'] ?? '')); ?></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($usage_steps)) : ?>
    <section class="beauty-section beauty-usage" id="usage">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>USAGE FLOW</p>
                <h2>使用ステップ</h2>
                <span>DAILY ROUTINE</span>
            </div>
            <p class="beauty-usage__lead">ビューティーセットと共に 美容液 Mirais-Kin を併用してお使い頂くと、より効果が期待できます。<br>STEP01・03 はビューティーセット、STEP02 はミライズキン アクアセラム。</p>
            <div class="beauty-usage-list">
                <?php foreach ($usage_steps as $usage) : ?>
                    <?php
                        $features_source = $usage['features'] ?? '';
                        if (is_array($features_source)) {
                            $features = $features_source;
                        } else {
                            $features_source = preg_replace('/<br\s*\/?>/i', "\n", (string) $features_source);
                            $features = preg_split('/\r\n|\r|\n/', $features_source);
                        }
                    ?>
                    <article class="beauty-usage-card <?php echo !empty($usage['core']) ? 'beauty-usage-card--core' : ''; ?>">
                        <div class="beauty-usage-card__body">
                            <p><?php echo esc_html($usage['label'] ?? ''); ?></p>
                            <h3><?php echo $bs_sp_title_break($bs_fix_text($usage['title'] ?? '')); ?></h3>
                            <strong><?php echo $bs_sp_title_break($bs_fix_text($usage['product'] ?? '')); ?></strong>
                            <ul>
                                <?php foreach (array_filter(array_map('trim', $features)) as $feature) : ?>
                                    <li><?php echo esc_html(strip_tags($bs_fix_text($feature))); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <small>How to use</small>
                            <p><?php echo wp_kses_post($bs_fix_text($usage['text'] ?? '')); ?></p>
                        </div>
                        <div class="beauty-usage-card__marker">
                            <span><?php echo esc_html($usage['num'] ?? ''); ?></span>
                            <b><?php echo esc_html($usage['step'] ?? ('STEP ' . ($usage['num'] ?? ''))); ?></b>
                        </div>
                        <?php if (!empty($usage['image'])) : ?>
                            <figure><img src="<?php echo esc_url($usage['image']); ?>" alt="<?php echo esc_attr($bs_fix_text($usage['title'] ?? '')); ?>"></figure>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if ($mirais_url) : ?>
                <p class="beauty-step-note">ビューティーセットの2ステップ（クレンジング＆ウォッシュ／オールインワンジェル）に<br class="d-none d-md-block"><a href="<?php echo esc_url($mirais_url); ?>">Mirais-kin</a> を加えることで、洗う→届ける→守るの3ステップが完成。<br>STEP02 は美容液 <a href="<?php echo esc_url($mirais_url); ?>">Mirais-kin ミライズキンのページ</a> をご覧ください。</p>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($testimonial_cards)) : ?>
    <section class="beauty-section beauty-testimonials">
        <div class="beauty-container">
            <div class="beauty-heading">
                <p>VOICES</p>
                <h2>お客様の声。</h2>
                <span>TESTIMONIALS</span>
            </div>
            <div class="beauty-card-grid beauty-card-grid--3">
                <?php foreach ($testimonial_cards as $card) : ?>
                    <article class="beauty-voice-card">
                        <?php if (!empty($card['rating'])) : ?><b><?php echo esc_html($card['rating']); ?></b><?php endif; ?>
                        <p><?php echo wp_kses_post(nl2br($card['text'] ?? $card['voice_text'] ?? '')); ?></p>
                        <?php if (!empty($card['name']) || !empty($card['profile'])) : ?>
                            <span><?php echo esc_html($card['name'] ?? $card['profile']); ?></span>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if ($bs_value('beauty_testimonial_note')) : ?>
                <small><?php echo esc_html($bs_value('beauty_testimonial_note')); ?></small>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($related_products) || !empty($related_movies)) : ?>
    <section class="mirais-section mirais-related beauty-related">
        <div class="mirais-container">
            <div class="mirais-heading beauty-heading">
                <p>RELATED</p>
                <h2>ビューティーセットを<br class="beauty-sp-break">見た人は、<br>こちらのページも見ています。</h2>
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

    <section class="beauty-order" id="order">
        <div class="beauty-container">
            <p>ORDER</p>
            <h2>美しさと健康を両立する、<br>2ステップの新習慣を、今日から。</h2>
            <div class="beauty-order__price">
                <span>希望小売価格</span>
                <strong>¥16,500</strong>
                <small>クレンジング＆ウォッシュ 150ml ／ オールインワンジェル 80g</small>
            </div>
            <div class="beauty-order__links">
                <a href="<?php echo esc_url($bs_value('beauty_order_url', '#order')); ?>">お問い合わせはこちら</a>
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

    var revealTargets = document.querySelectorAll('.beauty-section:not(.beauty-detail), .beauty-order, .beauty-related');
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

    var hero = document.querySelector('.beauty-hero');
    var order = document.querySelector('.beauty-order');
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
