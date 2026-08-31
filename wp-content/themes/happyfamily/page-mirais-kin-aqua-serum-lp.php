<?php
/*
 * Template Name: Mirais-Kin Aqua Serum LP
 */
get_header();

global $cfs;

$asset_uri = get_stylesheet_directory_uri() . '/asset/images/mirais-kin';

$mk_value = function ($field, $fallback = '') use ($cfs) {
    if (isset($cfs) && is_object($cfs) && method_exists($cfs, 'get')) {
        $value = $cfs->get($field);
        if ($value !== null && $value !== false && $value !== '' && $value !== array()) {
            return $value;
        }
    }
    return $fallback;
};

$mk_loop = function ($field, $fallback = array()) use ($mk_value) {
    $value = $mk_value($field, array());
    return is_array($value) && !empty($value) ? $value : $fallback;
};

$mk_loop_any = function ($fields, $fallback = array()) use ($mk_value) {
    foreach ((array) $fields as $field) {
        $value = $mk_value($field, array());
        if (is_array($value) && !empty($value)) {
            return $value;
        }
    }
    return $fallback;
};

$mk_lines = function ($field, $fallback = array()) use ($mk_value) {
    $value = $mk_value($field, '');
    if (is_array($value) && !empty($value)) {
        return array_values(array_filter(array_map('trim', $value)));
    }
    if (is_string($value) && trim($value) !== '') {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value))));
    }
    return $fallback;
};

$mk_clean_list_item = function ($text) {
    return preg_replace('/^\s*(?:\d+[\.．、\)]|[（(]?\d+[）)]|[①-⑳]|[（(]?[①-⑳][）)])\s*/u', '', trim((string) $text));
};

$mk_asset = function ($file) use ($asset_uri) {
    return $asset_uri . '/' . ltrim($file, '/');
};

$mk_movie_embed_html = function ($embed, $title = '') {
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

$hero_slides = $mk_loop('mirais_hero_slides', array(
    array('image_pc' => $mk_asset('hero-slide-1.png'), 'image_sp' => $mk_asset('hero-slide-1.png'), 'alt' => 'Mirais-Kin Aqua Serum メインビジュアル'),
    array('image_pc' => $mk_asset('hero-slide-2.png'), 'image_sp' => $mk_asset('hero-slide-2.png'), 'alt' => 'Mirais-Kin Aqua Serum 水のイメージ'),
));
$hero_copy_default = array(
    'label' => 'MIRAIS-KIN AQUA SERUM',
    'name' => 'ミライズキン　アクアセラム',
    'lines' => array('その一滴が、肌の奥で。', '明日のあなたを、整える。'),
);

$promo_movies = $mk_loop('mirais_promo_movies', array(
    array(
        'title' => 'Mirais-Kin Aqua Serum＜美容液＞プロモーションムービー',
        'embed' => '',
        'share_url' => '#movie',
        'thumb' => $mk_asset('movie-thumb.png'),
        'url' => '#movie',
    ),
    array(
        'title' => 'Mirais-Kin Aqua Serum＜美容液＞プロモーションムービー',
        'embed' => '',
        'share_url' => '#movie',
        'thumb' => $mk_asset('movie-thumb.png'),
        'url' => '#movie',
    ),
));

$related_products = $mk_loop_any(array('lp_related_pages', 'mirais_related_products'), array(
    array('title' => 'Excellentピュアーキィーセット', 'subtitle' => 'オールインワンジェルクリーム', 'image' => get_stylesheet_directory_uri() . '/asset/images/top_slide/excellent_bnr.jpg', 'url' => '/'),
    array('title' => 'REVIVALフローラゼリー', 'subtitle' => 'Flora Jelly', 'image' => get_stylesheet_directory_uri() . '/asset/images/top_slide/revival_florabn.jpg', 'url' => '/'),
));

$related_movies = $mk_loop_any(array('lp_related_videos', 'mirais_related_movies'), array(
    array('title' => 'Excellentピュアーキィーセット', 'subtitle' => 'Promotional Movie', 'image' => get_stylesheet_directory_uri() . '/asset/images/top_slide/excellent_bnr.jpg', 'url' => '/'),
    array('title' => 'REVIVALフローラゼリー', 'subtitle' => 'Promotional Movie', 'image' => get_stylesheet_directory_uri() . '/asset/images/top_slide/revival_florabn.jpg', 'url' => '/'),
));

$ingredients = $mk_loop('mirais_ingredients', array(
    array('label' => 'PS-B1', 'number' => '01', 'name' => '乳酸菌生産物質 PS-B1', 'lead' => '肌環境を整える、整肌アプローチ', 'text' => '産学官共同研究から生まれたこの成分は、21種21株の善玉菌から作られた409種類の成分で、肌環境を整え、肌本来の力をサポートします。'),
    array('label' => 'NMN', 'number' => '02', 'name' => 'NMN<br>（ニコチンアミドモノヌクレオチド）', 'lead' => '今大注目のエイジングケア成分※', 'text' => '若返り遺伝子とも呼ばれるサーチュイン遺伝子にアプローチする、次世代の美容成分です。年齢を重ねた肌に、ハリとツヤを与え、いきいきとした印象へ導きます。乾燥によるくすみのない、明るい印象の肌への期待が持てます。<small>※年齢に応じたお手入れのこと<br>※NMNの作用は成分の一般的な特性であり、本製品の効能効果を保証するものではありません。<br>※効果への期待には個人差があります。</small>'),
    array('label' => 'Galactomyces', 'number' => '03', 'name' => 'ガラクトミセス培養液', 'lead' => '発酵由来の美容成分', 'text' => '天然保湿因子そのものを含み、高い保湿力で肌を整えるだけでなく、酸化と糖化、2つの老化原因にも働きかける効果が期待できます。肌トラブル時の炎症を抑え、シワの原因となる酵素の働きを阻害する期待が持たれ、これが未来図菌の隠れたスター成分です。'),
    array('label' => 'Retinol', 'number' => '04', 'name' => 'パルチミン酸レチノール', 'lead' => 'ビタミンA誘導体', 'text' => '不安定なレチノールを安定化させた、ビタミンA誘導体です。ターンオーバーを整え、コラーゲンの産生をサポートし、シワやハリ不足にアプローチする期待が持て、さらに、紫外線から肌を守る働きも期待できます。これが、光老化へのアプローチです。'),
    array('label' => 'Ceramide', 'number' => '05', 'name' => 'セラミド3種<br>（NP / AP / EOP）', 'lead' => '水分を保持し、肌のバリアを強化', 'text' => 'NP、AP、EOPという、角層のバリア機能に最も重要な3種類を厳選配合。レンガとセメントのように組み合わさり、肌のラメラ構造を整え、水分保持力を高める期待が持てます。'),
));

$product_name = $mk_value('mirais_product_name');
$product_volume = $mk_value('mirais_product_volume');
$product_price = $mk_value('mirais_product_price');
$product_usage = $mk_value('mirais_product_usage');
$product_ingredients = $mk_value('mirais_product_ingredients');
$product_cautions = $mk_value('mirais_product_cautions');
$product_storage_notes = $mk_lines('mirais_product_storage_notes');
$usage_step_images = array(
    'step01' => $mk_value('mirais_usage_step_01_image'),
    'step02' => $mk_value('mirais_usage_step_02_image'),
    'step03' => $mk_value('mirais_usage_step_03_image'),
);

$schema = array(
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => 'Mirais-Kin Aqua Serum',
    'alternateName' => 'ミライズキン アクアセラム',
    'brand' => array('@type' => 'Brand', 'name' => 'Mirais-Kin'),
    'description' => 'Mirais-Kin Aqua Serumは、テラナノバブル水素水、酵素水、乳酸菌生産物質PS-B1、NMNなどを配合した美容液です。',
    'offers' => array(
        '@type' => 'Offer',
        'price' => '16500',
        'priceCurrency' => 'JPY',
        'availability' => 'https://schema.org/InStock',
    ),
);
?>

<script type="application/ld+json"><?php echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?></script>

<main class="mirais-lp" id="mirais-top">
    <header class="mirais-header" aria-label="Mirais-Kin LP navigation">
        <nav class="mirais-header__nav" aria-label="ページ内メニュー">
            <a href="#story">想い</a>
            <a href="#water">水へのこだわり</a>
            <a href="#formula">成分</a>
            <a href="#skinnimalism">シンプルケア</a>
            <a href="#usage">使い方</a>
            <a href="#movie">ムービー</a>
            <a href="#detail">商品詳細</a>
            <a class="mirais-header__cta" href="<?php echo esc_url($mk_value('mirais_order_url', '#order')); ?>">お問い合わせはこちら</a>
        </nav>
    </header>
    <a class="lp-mobile-fixed-cta lp-mobile-fixed-cta--mirais is-hidden" data-lp-fixed-cta href="<?php echo esc_url($mk_value('mirais_order_url', '#order')); ?>">お問い合わせはこちら</a>

    <section class="mirais-hero" aria-label="Mirais-Kin Aqua Serum">
        <svg class="mirais-hero__filter" width="0" height="0" aria-hidden="true" focusable="false">
            <filter id="miraisHeroWave" x="-8%" y="-8%" width="116%" height="116%">
                <feTurbulence type="fractalNoise" baseFrequency="0.004 0.01" numOctaves="2" seed="6" result="waveNoise">
                    <animate attributeName="baseFrequency" values="0.004 0.01;0.006 0.014;0.011 0.022;0.018 0.034;0.026 0.044;0.004 0.01" dur="8s" repeatCount="indefinite" />
                </feTurbulence>
                <feDisplacementMap in="SourceGraphic" in2="waveNoise" scale="22" xChannelSelector="R" yChannelSelector="G">
                    <animate attributeName="scale" values="24;18;12;7;3;24" dur="8s" repeatCount="indefinite" />
                </feDisplacementMap>
            </filter>
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
                    $slide_image_pc = $slide['image_pc'] ?? $slide['pc_image'] ?? $slide['hero_image_pc'] ?? $slide['image'] ?? $slide['hero_image'] ?? $slide['slide_image'] ?? $mk_asset('hero-slide-1.png');
                    $slide_image_sp = $slide['image_sp'] ?? $slide['sp_image'] ?? $slide['hero_image_sp'] ?? $slide['image'] ?? $slide['hero_image'] ?? $slide['slide_image'] ?? $slide_image_pc;
                    $copy_label = $hero_copy_default['label'];
                    $copy_name = $hero_copy_default['name'];
                    $copy_lines = $hero_copy_default['lines'];
                ?>
                <div class="mirais-hero__slide mirais-hero__slide--<?php echo esc_attr($index + 1); ?>">
                    <img class="mirais-hero__img mirais-hero__img--pc" src="<?php echo esc_url($slide_image_pc); ?>" alt="">
                    <img class="mirais-hero__img mirais-hero__img--sp" src="<?php echo esc_url($slide_image_sp); ?>" alt="">
                    <div class="mirais-hero-copy">
                        <p class="mirais-hero-copy__label"><?php echo esc_html($copy_label); ?></p>
                        <p class="mirais-hero-copy__name"><?php echo esc_html($copy_name); ?></p>
                        <p class="mirais-hero-copy__main">
                            <span>その一滴が、<br class="mirais-hero-copy__sp-break">肌の奥で。</span>
                            <span>明日のあなたを、<br class="mirais-hero-copy__sp-break">整える。</span>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="mirais-section mirais-story" id="story">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>NAMING</p>
                <h2>Mirais-Kin という名前に込められた想い</h2>
                <span>THE MEANING OF THE NAME</span>
            </div>
            <div class="mirais-name-cards">
                <div>
                    <strong>Mirais</strong>
                    <span>未来図</span>
                    <p>年齢肌の<br>未来図を描き直す</p>
                </div>
                <b>+</b>
                <div>
                    <strong>Kin</strong>
                    <span>菌</span>
                    <p>肌環境を<br>整える</p>
                </div>
            </div>
            <article class="mirais-prose">
                <p class="mirais-eyebrow">SKINNIMALISM</p>
                <h3>ミライズキン／未来図菌</h3>
                <p class="mirais-sublead">引き算の美学で、肌の未来を整える</p>
                <p>Mirais_kin＝ミライズキンは、「もっと売れる美容液をつくろう」として生まれた商品ではありません。<br>「もう一歩上の美肌を目指したい」「でも、複雑なケアは続かない…」</p>
                <p>年齢を重ねるにつれて、肌の変化だけでなく、身体や気持ちの揺らぎを感じる方が増えていく。<br>だからこそ、一時的な変化を追いかけるのではなく、毎日、安心して使い続けられることを大切にしています。</p>
                <p>無理に変えようとしないこと。<br>肌が本来もっている力を、そっと支える存在であること。<br>Mirais-Kinが目指しているのは、鏡の前でふと、「今日の自分、悪くないな」と思える瞬間を感じて欲しいからです。</p>
                <p class="mirais-blue">お客様の本音から生まれた一滴。<br>50代・60代は、終わりではなく新しい始まり。<br>Mirais-Kin と共に、心も体も満たされる毎日を。</p>
            </article>
        </div>
    </section>

    <section class="mirais-section mirais-voice">
        <div class="mirais-orbit" aria-hidden="true"></div>
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>YOUR HONEST VOICE</p>
                <h2>お客様からの本音。</h2>
                <span>REAL VOICES</span>
            </div>
            <div class="mirais-card-grid mirais-card-grid--3">
                <article class="mirais-mini-card">
                    <p>化粧水をつけても、<br>すぐに肌が乾いてしまう…。<br>何をつけても同じ気がする。</p>
                    <strong>EFFECTIVENESS</strong>
                </article>
                <article class="mirais-mini-card">
                    <p>朝は忙しい。<br>複雑なケアは続かない。<br>けれど、効果は諦めたくない。</p>
                    <strong>SIMPLICITY</strong>
                </article>
                <article class="mirais-mini-card">
                    <p>高価なものを次々試すのは、<br>もう終わりにしたい。</p>
                    <strong>SUSTAINABILITY</strong>
                </article>
            </div>
        </div>
    </section>

    <section class="mirais-section mirais-water" id="water">
        <div class="mirais-water-bg" aria-hidden="true"></div>
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>WATER REVOLUTION</p>
                <h2>こだわりを極めた、<br>水の革命。</h2>
                <span>TERA NANO BUBBLE</span>
            </div>
            <p class="mirais-center-text">肌悩みに本気で考え、辿り着いたのは「水」そのものの革新でした。<br>この水そのものを変えることが、肌を変える、最も誠実なルートだったのです。</p>
            <figure class="mirais-feature-image">
                <img src="<?php echo esc_url($mk_value('mirais_water_image', $mk_asset('water-revolution.png'))); ?>" alt="テラナノバブル水素水">
            </figure>
            <div class="mirais-stats" aria-label="水の比率">
                <div><strong>60<span>%</span></strong><p>人体は水</p></div>
                <div><strong>70<span>%+</span></strong><p>表皮細胞も水</p></div>
                <div><strong>50<span>%+</span></strong><p>化粧品も水</p></div>
            </div>
            <article class="mirais-water-panel">
                <div class="mirais-water-panel__head">
                    <div>
                        <p>TERA NANO BUBBLE</p>
                        <h3>テラナノバブル水素水</h3>
                    </div>
                    <span>特許技術 TERAQOL®</span>
                </div>
                <div class="mirais-card-grid mirais-card-grid--3">
                    <div class="mirais-icon-card">
                        <span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 5l15 6v11c0 10-6.4 17.2-15 21-8.6-3.8-15-11-15-21V11l15-6z"/><path d="M16 24l5 5 11-12"/></svg></span>
                        <strong>特許技術<br>TERAQOL®</strong>
                        <p>水素水を安定させるための独自加工技術です。</p>
                    </div>
                    <div class="mirais-icon-card">
                        <span aria-hidden="true"><svg viewBox="0 0 48 48"><circle cx="16" cy="18" r="7"/><circle cx="31" cy="28" r="10"/><circle cx="33" cy="12" r="4"/><path d="M13 34h6M29 34h7"/><text x="12" y="28">H2</text></svg></span>
                        <strong>高濃度水素水<br>×<br>長期保存</strong>
                        <p>小さな泡のように、水素を肌へ届ける水のベースです。</p>
                    </div>
                    <div class="mirais-icon-card">
                        <span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 5l3.8 12.2L40 21l-12.2 3.8L24 37l-3.8-12.2L8 21l12.2-3.8L24 5z"/><path d="M38 32l1.8 5.2L45 39l-5.2 1.8L38 46l-1.8-5.2L31 39l5.2-1.8L38 32z"/></svg></span>
                        <strong>うるおい・ツヤ<br>明るさ</strong>
                        <p>乾燥によるくすみを防ぎ、みずみずしい印象へ導きます。</p>
                    </div>
                </div>
                <p>特許技術テラクオール加工により、高濃度水素と長期保存を両立。水素の力で、細胞を傷つける老化にアプローチし、肌にうるおいを与え、乾燥によるくすみを防ぐ効果が期待できます。ツヤのある明るい印象へと導きます。</p>
                <div class="mirais-note-box">
                    <h4>テラクオール加工とは</h4>
                    <p>TERAQOL® は電子活性化の技術です。あらゆる媒体、液体に原子レベルで影響を与え電子活動を活性化し、長期にわたりその効果を持続させられることが最大の特徴です。</p>
                </div>
                <a class="mirais-dark-link" href="<?php echo esc_url($mk_value('mirais_teraqol_url', '#movie')); ?>">テラクオール説明動画を見る</a>
            </article>
        </div>
    </section>

    <section class="mirais-section mirais-penetration">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>PENETRATION</p>
                <h2>酵素水と圧倒的な浸透力。</h2>
                <span>DEEP PERMEATION</span>
            </div>
            <figure class="mirais-feature-image mirais-feature-image--narrow">
                <img src="<?php echo esc_url($mk_value('mirais_penetration_image', $mk_asset('penetration.png'))); ?>" alt="酵素水と浸透力のイメージ">
            </figure>
            <div class="mirais-card-grid mirais-card-grid--2">
                <article class="mirais-info-card">
                    <p>BASE</p>
                    <h3>酵素水<br>=水（基剤）</h3>
                    <p>※成分表示には「水」と記載しています。基剤として、独自に処方された酵素水を採用。Mirais-Kinの力をこの一滴に閉じ込める、土台となる水です。</p>
                </article>
                <article class="mirais-info-card">
                    <p>PENETRATION</p>
                    <h3>圧倒的な浸透力</h3>
                    <p>マイクロカプセル技術でナノ化された美容成分が、角層のすみずみまでスッと届く。「届ける力」と「保つ力」を兼ね備えた一滴です。</p>
                </article>
            </div>
        </div>
    </section>

    <section class="mirais-section mirais-formula" id="formula">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>FORMULA</p>
                <h2>こだわりを極めた、特徴成分。</h2>
                <span>CAREFULLY SELECTED INGREDIENTS</span>
            </div>
            <p class="mirais-twenty"><strong>20</strong><span>成分配合</span></p>
            <p class="mirais-center-text">厳選された20成分の中から、Mirais-Kin の主役となる5本柱をご紹介します。</p>
            <p class="mirais-formula-note">※整肌・保湿・ハリ感など、肌を健やかに保つための成分を厳選しています。</p>
            <div class="mirais-ingredient-grid">
                <?php foreach ($ingredients as $item) : ?>
                    <?php
                        $ingredient_label = $item['label'] ?? '';
                        $ingredient_number = $item['number'] ?? '';
                        $ingredient_name = $item['name'] ?? '';
                        $ingredient_lead = $item['lead'] ?? '';
                        $ingredient_text = $item['text'] ?? '';
                    ?>
                    <article class="mirais-ingredient">
                        <div class="mirais-ingredient__meta">
                            <span><?php echo wp_kses_post($ingredient_label); ?></span>
                            <b><?php echo esc_html($ingredient_number); ?></b>
                        </div>
                        <h3><?php echo wp_kses_post($ingredient_name); ?></h3>
                        <p class="mirais-ingredient__lead"><?php echo wp_kses_post($ingredient_lead); ?></p>
                        <p><?php echo wp_kses_post($ingredient_text); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="mirais-section mirais-confidence">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>CONFIDENCE</p>
                <h2>整った肌が、<br>自信と笑顔をもたらします。</h2>
                <span>CONFIDENCE IN SKIN</span>
            </div>
            <div class="mirais-card-grid mirais-card-grid--3">
                <div class="mirais-benefit">
                    <span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M32 9a16 16 0 1 0 7 27 13 13 0 0 1-7-27z"/><path d="M17 30c3.6 3.1 9.4 3.1 13 0"/></svg></span>
                    <strong>夕方に<br>くすまない</strong>
                    <p>日中の乾燥ぐすみを防ぎ、夜まで明るい印象へ。</p>
                    <em>Tera Nano Bubble 水素水</em>
                </div>
                <div class="mirais-benefit">
                    <span aria-hidden="true"><svg viewBox="0 0 48 48"><rect x="14" y="16" width="20" height="26" rx="4"/><path d="M18 16V9h12v7"/><path d="M18 30h12"/><path d="M37 18l4 4-4 4"/></svg></span>
                    <strong>ファンデが<br>ヨレにくい</strong>
                    <p>肌表面をなめらかに整え、メイクがなじみやすい肌へ。</p>
                    <em>乳酸菌生産物質 PS-B1</em>
                </div>
                <div class="mirais-benefit">
                    <span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 8c-7.2 0-13 6.5-13 14.5 0 8.6 5.6 16.1 13 17.5 7.4-1.4 13-8.9 13-17.5C37 14.5 31.2 8 24 8z"/><path d="M18 29c3.4 2.7 8.6 2.7 12 0"/></svg></span>
                    <strong>頬が<br>下がりにくい</strong>
                    <p>ハリ感を支え、すっきり上向きな印象を目指します。</p>
                    <em>NMN</em>
                </div>
            </div>
        </div>
    </section>

    <section class="mirais-section mirais-philosophy" id="skinnimalism">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>MIRAIS-KIN PHILOSOPHY</p>
                <h2>引き算の美学。</h2>
                <span>SKINNIMALISM</span>
            </div>
            <div class="mirais-equation">
                <div><strong>SKIN</strong><span>スキン</span></div>
                <b>+</b>
                <div><strong>Minimalism</strong><span>ミニマリズム</span></div>
                <b>=</b>
                <div class="mirais-equation__answer"><strong>Skinnimalism</strong><span>スキンミニマリズム</span></div>
            </div>
            <h3>引き算の美学。</h3>
            <p>必要なものを必要な分だけ与え、健康的な肌を保つ。</p>
        </div>
    </section>

    <section class="mirais-section mirais-essentials">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>SKINNIMALISM - 3 ESSENTIALS</p>
                <h2>こだわりの3原則。</h2>
                <small>シンプルだから、続けられる。</small>
            </div>
            <div class="mirais-card-grid mirais-card-grid--3">
                <article class="mirais-principle"><span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 8v9M24 31v9M10 16l8 5M30 27l8 5M38 16l-8 5M18 27l-8 5"/><path d="M18 21l6-4 6 4v6l-6 4-6-4z"/></svg></span><h3>整 肌</h3><p>SKIN FLORA BALANCE</p><p>肌本来のバランスを整え、乳酸菌生産物質が、土台から肌を育てます。</p></article>
                <article class="mirais-principle"><span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M24 7s12 13.2 12 23a12 12 0 0 1-24 0C12 20.2 24 7 24 7z"/><path d="M19 32c2.8 2.6 7.2 2.6 10 0"/></svg></span><h3>浸 透</h3><p>DEEP PERMEATION</p><p>ご角層まで、マイクロカプセル技術で、美容成分を必要な場所へ届けます。</p></article>
                <article class="mirais-principle"><span aria-hidden="true"><svg viewBox="0 0 48 48"><path d="M18 8l3.8 10.2L32 22l-10.2 3.8L18 36l-3.8-10.2L4 22l10.2-3.8L18 8z"/><path d="M35 24l2.4 6.6L44 33l-6.6 2.4L35 42l-2.4-6.6L26 33l6.6-2.4L35 24z"/></svg></span><h3>輝 き</h3><p>REGENERATION SUPPORT</p><p>使うたびに肌が応えてくれる。ハリと明るさのある印象へ。</p></article>
            </div>
            <p class="mirais-border-text">複雑なケアに疲れた50代・60代女性にこそ必要なのは、本当に必要な成分だけを、厳選すること。<br>整肌、浸透、輝き。この3つのアプローチで、シンプルで確実な答えを。</p>
        </div>
    </section>

    <section class="mirais-section mirais-usage" id="usage">
        <div class="mirais-container">
            <p class="mirais-side-label">USAGE STEPS</p>
            <div class="mirais-heading">
                <h2>使うたび、肌が応えてくれる。<br>使用ステップ</h2>
                <span>DAILY ROUTINE</span>
            </div>
            <div class="mirais-card-grid mirais-card-grid--3 mirais-step-grid">
                <article class="mirais-step">
                    <p>STEP 01</p>
                    <h3>土台を整える</h3>
                    <?php if (!empty($usage_step_images['step01'])) : ?>
                        <figure class="mirais-step-image"><img src="<?php echo esc_url($usage_step_images['step01']); ?>" alt="STEP 01 使用商品イメージ"></figure>
                    <?php endif; ?>
                    <ul>
                        <li>通常までの汚れを優しくオフ</li>
                        <li>洗顔後の水を清し軽く</li>
                        <li>次の美容液が浸透しやすい肌環境に整える</li>
                    </ul>
                    <p>2〜4プッシュ手にとり、泡で優しく顔全体になじませます。古い角質や汚れをやさしく落とします。</p>
                </article>
                <article class="mirais-step mirais-step--gold">
                    <span>GOLD STEP</span>
                    <p>STEP 02</p>
                    <h3>未来の肌ベースを高める</h3>
                    <?php if (!empty($usage_step_images['step02'])) : ?>
                        <figure class="mirais-step-image"><img src="<?php echo esc_url($usage_step_images['step02']); ?>" alt="STEP 02 Mirais-Kin Aqua Serum 商品イメージ"></figure>
                    <?php endif; ?>
                    <ul>
                        <li>体感を実感した美容液</li>
                        <li>テラナノバブル水素水×NMN配合</li>
                        <li>エイジングケアの機能を支える美容セラム</li>
                    </ul>
                    <p>手のひらに3〜5滴を取り、顔の内側から外側へ、やさしく滑り伸ばします。気になる部分は重ね塗りで集中ケアも。一度にたっぷりの使用がおすすめです。</p>
                </article>
                <article class="mirais-step">
                    <p>STEP 03</p>
                    <h3>守り抜く（閉じ込める）</h3>
                    <?php if (!empty($usage_step_images['step03'])) : ?>
                        <figure class="mirais-step-image"><img src="<?php echo esc_url($usage_step_images['step03']); ?>" alt="STEP 03 使用商品イメージ"></figure>
                    <?php endif; ?>
                    <ul>
                        <li>化粧水・美容液・乳液の働きを1本で</li>
                        <li>肌のバリア機能をサポート</li>
                        <li>長時間うるおいを逃がさない健やかな肌へ</li>
                    </ul>
                    <p>パール３粒前後を手にとり、指先で下から上に向かって、パッティングしながら優しくなじませます。<br>美容成分を肌の中に閉じ込め、外的刺激からバリアを張り、集中ケアを叶えます。</p>
                </article>
            </div>
            <p class="mirais-step-note">STEP1・3は、<a href="<?php echo esc_url($mk_value('mirais_pure_url', '/')); ?>">ビューティーセット</a>のページをご覧ください。</p>
        </div>
    </section>

    <section class="mirais-section mirais-movie" id="movie">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>PROMOTIONAL MOVIE</p>
                <h2>Mirais-Kin Aqua Serum<br>プロモーションムービー</h2>
                <span>PRODUCT MOVIE</span>
            </div>
            <p class="mirais-center-text">未来の美肌が目覚める。肌が応えてくれる、その物語をムービーで。</p>
            <div class="mirais-movie-grid">
                <?php foreach ($promo_movies as $movie) : ?>
                    <?php
                        $movie_title = $movie['title'] ?? $movie['movie_title'] ?? 'Mirais-Kin Aqua Serum＜美容液＞プロモーションムービー';
                        $movie_thumb = $movie['thumb'] ?? $movie['movie_thumb'] ?? $movie['image'] ?? $mk_asset('movie-thumb.png');
                        $movie_embed = $movie['movie_embed'] ?? $movie['embed'] ?? $movie['embed_url'] ?? $movie['movie_embed_url'] ?? '';
                        $movie_url = $movie['movie_share_url'] ?? $movie['share_url'] ?? $movie['url'] ?? $movie['movie_url'] ?? '#movie';
                        $movie_caption = $movie['movie_caption'] ?? $movie['caption'] ?? $movie_title;
                        $movie_embed_html = $mk_movie_embed_html($movie_embed, $movie_title);
                    ?>
                    <article class="mirais-movie-card">
                        <div class="mirais-movie-card__media">
                            <?php if ($movie_embed_html) : ?>
                                <?php echo $movie_embed_html; ?>
                            <?php else : ?>
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

    <section class="mirais-section mirais-detail" id="detail">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>PRODUCT DETAIL</p>
                <h2>未来の美肌が目覚める。<br>肌が、応えてくれる。</h2>
                <span>MIRAIS-KIN AQUA SERUM</span>
            </div>
            <article class="mirais-product-panel">
                <figure>
                    <img src="<?php echo esc_url($mk_value('mirais_product_image', $mk_asset('product.png'))); ?>" alt="Mirais-Kin Aqua Serum 商品画像">
                </figure>
                <div class="mirais-product-panel__body">
                    <dl class="mirais-spec">
                        <div><dt>商品名</dt><dd><?php echo wp_kses_post($product_name); ?></dd></div>
                        <div><dt>内容量</dt><dd><?php echo wp_kses_post($product_volume); ?></dd></div>
                        <div><dt>希望小売価格</dt><dd><strong><?php echo wp_kses_post($product_price); ?></strong></dd></div>
                        <div><dt>ご使用方法（夜）</dt><dd><?php echo wp_kses_post(nl2br($product_usage)); ?></dd></div>
                    </dl>
                </div>
                <?php if ($product_ingredients !== '') : ?>
                    <div class="mirais-detail-box">
                        <h3>成分表示</h3>
                        <p><?php echo wp_kses_post(nl2br($product_ingredients)); ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product_cautions)) : ?>
                    <div class="mirais-detail-box">
                        <h3>使用上のご注意</h3>
                        <div class="mirais-detail-box__html"><?php echo wp_kses_post($product_cautions); ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($product_storage_notes)) : ?>
                    <div class="mirais-detail-box">
                        <h3>＜保管及び取扱上の注意＞</h3>
                        <ul>
                            <?php foreach ($product_storage_notes as $storage_note) : ?>
                                <li><?php echo wp_kses_post($storage_note); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </article>
        </div>
    </section>

    <section class="mirais-section mirais-related">
        <div class="mirais-container">
            <div class="mirais-heading">
                <p>RELATED</p>
                <h2>ミライズキンを見た人は、<br>こちらのページも見ています。</h2>
                <span>YOU MAY ALSO LIKE</span>
            </div>
            <div class="mirais-related-grid">
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
                                <div class="mirais-related-thumb mirais-related-thumb--page">
                                    <img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_title); ?>">
                                </div>
                                <strong><?php echo esc_html($item_title); ?></strong>
                                <span><?php echo esc_html($item_subtitle); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
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
                                <div class="mirais-related-thumb">
                                    <img src="<?php echo esc_url($item_image); ?>" alt="<?php echo esc_attr($item_title); ?>">
                                    <i class="mirais-related-play" aria-hidden="true"></i>
                                </div>
                                <strong><?php echo esc_html($item_title); ?></strong>
                                <span><?php echo esc_html($item_subtitle); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="mirais-order" id="order">
        <div class="mirais-container">
            <p>ORDER</p>
            <h2>希望という一滴を、今日から。</h2>
            <strong>¥16,500</strong>
            <span>税込 / 希望小売価格</span>
            <small>内容量 48mL</small>
            <div class="mirais-order__links">
                <a href="<?php echo esc_url($mk_value('mirais_order_url', '#order')); ?>">お問い合わせはこちら</a>
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

    var revealTargets = document.querySelectorAll('.mirais-section, .mirais-order');
    if (!('IntersectionObserver' in window)) {
        revealTargets.forEach(function (target) {
            target.classList.add('mirais-reveal-visible');
        });
        return;
    }

    document.documentElement.classList.add('mirais-reveal-ready');

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }
            entry.target.classList.add('mirais-reveal-visible');
            observer.unobserve(entry.target);
        });
    }, {
        rootMargin: '0px 0px -12% 0px',
        threshold: 0.12
    });

    revealTargets.forEach(function (target) {
        target.classList.add('mirais-reveal-item');
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

    var hero = document.querySelector('.mirais-hero');
    var order = document.querySelector('.mirais-order');
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
