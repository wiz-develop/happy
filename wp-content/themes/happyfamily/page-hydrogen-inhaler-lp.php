<?php
/*
 * Template Name: 水素ガス吸入機LP
 */
get_header(); ?>

<?php 
/* 親のアイキャッチを表示 */
$parent_id = $post->post_parent; 
$parent = get_post($parent_id);
// echo get_the_post_thumbnail($parent, 'full'); 
/* /親のアイキャッチを表示 */ 
?>

<div class="section siteContent <?php echo $cfs->get('page_class'); ?>" role="main">
    <div class="hydrogen-lp-first">
        <div class="container first-content">
            <h1>
                <div class="first-logo">
                    <img class="first-logo__img" src="<?php echo $cfs->get('logo_img'); ?>" alt="<?php echo $cfs->get('pro_name_en'); ?>">
                </div>
            </h1>
            <div class="catchcopy">
                <?php echo $cfs->get('page_catch'); ?>
            </div>
            <a class="first-contact" href="/contact/" <?php if (is_page('repos')) echo 'style="margin-left: 7%;"'; ?>>お問い合わせ</a>
        </div>
        <div class="first-bg">
            <img class="first-bg__pc" src="<?php echo $cfs->get('top_img_pc'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>イメージ">
            <img class="first-bg__sp" src="<?php echo $cfs->get('top_img_sp'); ?>" alt="<?php echo strip_tags(get_the_title()); ?>イメージ">
        </div>
    </div>
    <div class="container">
        <div class="mainSection" id="main">
            <section>
                <h2 class="product-title">
                    <?php echo $cfs->get('pro_name_en'); ?>
                    <?php if($cfs->get('pro_name_kana')):?>
                    <span class="fw-normal"><?php echo '（'.$cfs->get('pro_name_kana').'）'; ?></span>
                    <?php endif; ?>
                </h2>
                <div class="product-message"><?php echo $cfs->get('product_about'); ?></div>
                <div class="product-contact"><a href="/contact/">お問い合わせ</a></div>
            </section>
            <section class="content_about">
                <div class="content_about__first">
                    <div class="use-image-1">
                        <img src="<?php echo $cfs->get('about_img1'); ?>" alt="使用イメージ">
                    </div>
                    <!-- <div class="use-image-2">
                        使用イメージ写真２
                    </div> -->
                    <div class="content_about__first__stable">
                        <h2 class="content-title">ABOUT</h2>
                        <section>
                            <h3 class="content-subtitle"><?php echo $cfs->get('about_catch1'); ?></h3>
                            <?php
                                $about_forte_list = $cfs->get('about_forte_list');
                                if ($about_forte_list) :
                            ?>
                            <ul class="stable_list">
                                <?php foreach ($about_forte_list as $about_forte) : ?>
                                <li class="stable_list__li">
                                    <div class="d-flex stable_list__content">
                                        <figure>
                                            <img src="<?php echo $about_forte['forte_icon']; ?>" alt="<?php echo strip_tags($about_forte['forte_catch']); ?>">
                                        </figure>
                                        <div class="stable_list__content__message">
                                            <p class="stable_list__title"><?php echo $about_forte['forte_catch']; ?></p>
                                            <p class="stable_list__text"><?php echo $about_forte['forte_about']; ?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php if ( is_page('soluna') ) :?>
    <section class="soluna-breathe">
        <div class="container">
            <h3 class="content-subtitle" style="margin-bottom: 0;">呼吸を、ととのえる</h3>
            <p class="soluna-breathe__subtitle">〜暮らしに溶け込む、ととのえ習慣〜</p>
            <p class="soluna-breathe__lead">朝起きて、まず何をしますか？</p>
            <div class="soluna-breathe__text">
                <p>スマートフォンの通知確認、ニュースチェック、SNS。<br>子育て、仕事、家事、趣味。<br>年齢や生活スタイルは違っても、現代の私たちに共通しているのは、ゆっくり呼吸をする時間が少ないこと。<br>「ながら」の連続で、いつの間にか呼吸が浅くなっています。</p>
                <p>でも、呼吸は体の“めぐり”を司る入口なのです。</p>
                <p>東洋医学でいう「気・血・水」、私たちの言葉で言えば<span class="soluna-breathe__em">「5つのめぐり」－呼吸、腸、脳、肌、笑顔</span>。<br>この中でも呼吸はすべての始まり。</p>
                <p>呼吸が整うと、全身が動き出します。</p>
                <p>ヨガも瞑想も時間がない。<br>でも<span class="soluna-breathe__em2">身体の“めぐり”は整えたい。</span><br>そんな方に<span class="soluna-breathe__brand">SOLUNA</span>を。<br>純度99.9%以上の水素を毎分150ml生成。</p>
                <p>この水素で「呼吸のめぐり」を整え、毎日に再起動のリズムを。</p>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <div class="container">
        <div class="mainSection">
            <section class="content_about">
                <div class="d-flex content_about__second">
                    <div class="content_about__second__text">
                        <h3 class="content-subtitle"><?php echo $cfs->get('about_catch2'); ?></h3>
                        <p class="mb-0"><?php echo $cfs->get('about_detail2'); ?></p>
                    </div>
                    <div class="content_about__second__image">
                        <img src="<?php echo $cfs->get('about_img2'); ?>" alt="<?php echo strip_tags($cfs->get('about_catch2')); ?>">
                    </div>
                </div>
            </section>
            <section class="content_point">
                <h2 class="content-title">POINT</h2>
                <?php
                    $product_point_list = $cfs->get('product_point_list');
                    if ($product_point_list) :
                ?>
                <ul class="d-flex point_list">
                    <?php foreach ($product_point_list as $product_point) : ?>
                    <li class="point_list__list">
                        <h3 class="point_list__title"><?php echo $product_point['point_catch']; ?></h3>
                        <div class="point_list__content">
                            <p><?php echo $product_point['point_about']; ?></p>
                            <picture><img src="<?php echo $product_point['point_img']; ?>" alt="<?php echo strip_tags($product_point['point_catch']); ?>"></picture>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </section>
        </div>
    </div>
    <?php if ( is_page('soluna') ) :?>
    <section class="soluna-movie">
        <div class="container">
            <p class="soluna-movie__eyebrow">PROMOTIONAL MOVIE</p>
            <h3 class="soluna-movie__title">SOLUNA（ソルナ） Promotional video</h3>
            <p class="soluna-movie__lead">「自分を大切にすることって。」SOLUNA（ソルナ）が描く、毎日のHAPPYを映像で。</p>
            <div class="soluna-movie__frame">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/LYeliPQDK1s?si=ah20Uw-emomFqkuy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>
    <section class="soluna-steps">
        <div class="container">
            <div class="soluna-steps__head">
                <div class="soluna-steps__headText">
                    <h3 class="content-subtitle" style="margin-bottom: 0;">かんたん５ステップで！</h3>
                    <p class="soluna-steps__lead">難しい準備は一切いりません。5つのステップで、すぐに始められます。</p>
                </div>
            </div>

            <div class="soluna-steps__body">
                <div class="soluna-steps__line" aria-hidden="true"></div>
                <div class="soluna-steps__content">
                    <ol class="soluna-steps__list">
                        <li class="soluna-steps__item">
                            <div class="soluna-steps__item__img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step1.png">
                            </div>
                            <div class="soluna-steps__item__about">
                                <div class="soluna-steps__badge">
                                    <span class="soluna-steps__badgeNo">ステップ 1</span>
                                    <span class="soluna-steps__badgeText">電源を入れる</span>
                                </div>
                                <p>本体とアダプターを接続し、電源をコンセントに差し込みます。</p>
                            </div>
                        </li>

                        <li class="soluna-steps__item">
                            <div class="soluna-steps__item__img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step2.png">
                            </div>
                            <div class="soluna-steps__item__about">
                                <div class="soluna-steps__badge">
                                    <span class="soluna-steps__badgeNo">ステップ 2</span>
                                    <span class="soluna-steps__badgeText">精製水を入れる</span>
                                </div>
                                <p>上部キャップを開けて、精製水を小窓を見ながら注ぐだけ。満水で音がなります。</p>
                            </div>
                        </li>

                        <li class="soluna-steps__item">
                            <div class="soluna-steps__item__img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step3.png?20251215">
                            </div>
                            <div class="soluna-steps__item__about">
                                <div class="soluna-steps__badge">
                                    <span class="soluna-steps__badgeNo">ステップ 3</span>
                                    <span class="soluna-steps__badgeText">カニューラをつなぐ</span>
                                </div>
                                <p>付属のカニューラをつなぐ。直結チューブを本体上部に差し込み、もう片方を集水瓶ボトルの長い菅へ。<br>そして短い菅にカニューラを差し込む。</p>
                            </div>
                        </li>

                        <li class="soluna-steps__item">
                            <div class="soluna-steps__item__img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step4.png">
                            </div>
                            <div class="soluna-steps__item__about">
                                <div class="soluna-steps__badge">
                                    <span class="soluna-steps__badgeNo">ステップ 4</span>
                                    <span class="soluna-steps__badgeText">時間を選ぶ</span>
                                </div>
                                <p>電源を押すと、静かに動き始めます。タイマーは1．2，3，4時間から選択できます。</p>
                            </div>
                        </li>

                        <li class="soluna-steps__item">
                            <div class="soluna-steps__item__img">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step5.png">
                            </div>
                            <div class="soluna-steps__item__about">
                                <div class="soluna-steps__badge">
                                    <span class="soluna-steps__badgeNo">ステップ 5</span>
                                    <span class="soluna-steps__badgeText">リラックスして呼吸</span>
                                </div>
                                <p>カニューラを鼻に装着したら、あとは普段通りの呼吸で。</p>
                            </div>
                        </li>
                    </ol>
                    <div class="soluna-steps__headImg">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/soluna-step_img.png">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php if ($cfs->get('about_hydrogen')) : ?>
    <section class="content_hydrogen" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/asset/images/hydrogen/page_middle.jpg');<?php if ($cfs->get('about_hydrogen')) : ?> margin-top: 0;<?php endif; ?>">
        <div class="container">
            <div class="content_hydrogen__content">
                <h2 class="content-title">ABOUT HYDROGEN</h2>
                <h3 class="content-subtitle">水素が体に与える効果</h3>
                <div class="content_hydrogen__text"><?php echo $cfs->get('about_hydrogen'); ?></div>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php
        $hydrogen_point_list = $cfs->get('hydrogen_point_list');
        if ($hydrogen_point_list) :
    ?>
    <section class="content_hydrogen_point">
        <div class="container">
            <h2 class="content-title">HYDROGEN INHALATION POINT</h2>
            <section>
                <h3 class="content-subtitle">水素吸入の3つのポイント</h3>
                <ul class="hydrogen_list">
                    <?php foreach($hydrogen_point_list as $index => $hydrogen_point) : ?>
                    <li class="hydrogen_list__content">
                        <div class="d-flex hydrogen_list__title">
                            <div class="hydrogen_list__title__icon">
                                <img src="<?php echo $hydrogen_point['hydrogen_point_icon']; ?>" alt="<?php echo strip_tags($hydrogen_point['hydrogen_point_item']); ?>">
                            </div>
                            <p class="hydrogen_list__title__point">
                                <span>POINT<?php echo $index+1; ?></span>
                                <span><?php echo $hydrogen_point['hydrogen_point_item']; ?></span>
                            </p>
                        </div>
                        <p><?php echo $hydrogen_point['hydrogen_point_about']; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </section>
    <?php endif; ?>
    <div class="container">
        <section class="content_product">
            <h2 class="content-title">PRODUCTS</h2>
            <section>
                <p class="mb-0">水素ガス吸入器</p>
                <p class="content-subtitle font-gabarito">
                    <span>
                        <?php echo $cfs->get('pro_name_en'); ?>
                        <?php if($cfs->get('pro_name_kana')):?>
                        <span class="fw-normal"><?php echo '（'.$cfs->get('pro_name_kana').'）'; ?></span>
                        <?php endif; ?>
                    </span>
                </p>
                <?php
                    $product_slide = $cfs->get('product_slide');
                    if ($product_slide) :
                ?>
                <div class="product-slide">
                    <div class="product-slide__item">
                        <div class="slick-product_main">
                            <?php foreach ($product_slide as $index_main => $slide_main) : ?>
                                <div class="slick-product_main__item">
                                    <div class="item-img">
                                        <img src="<?php echo $slide_main['product_img']; ?>" alt="<?php echo $cfs->get('pro_name_en'); ?> <?php echo $index_main+1; ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="slick-product_sub">
                            <?php foreach ($product_slide as $index_sub => $slide_sub) : ?>
                                <div class="slick-product_sub__item">
                                    <div class="item-th">
                                        <div class="item_th__img">
                                            <img src="<?php echo $slide_sub['product_img']; ?>" alt="<?php echo $cfs->get('pro_name_en'); ?> <?php echo $index_sub+1; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="product-slide__item product-about">
                        <div class="product-about__sub">
                            <div class="product-about__sub__item">
                                <div class="product-item_detail">
                                    <?php
                                        $specification_list = $cfs->get('specification_list');
                                        if ($specification_list) :
                                    ?>
                                    <div class="specification_list">
                                        <?php foreach($specification_list as $s_list) : ?>
                                            <div class="specification_list__item d-flex">
                                                <div class="specification_list__item__tit">
                                                    <p class="mb-0"><?php echo $s_list['specification_name']; ?></p>
                                                </div>
                                                <div class="specification_list__item__about">
                                                    <p class="mb-0"><?php echo $s_list['specification_about']; ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    <?php
                                        $specification_note = $cfs->get('specification_note');
                                        if ($specification_note) :
                                    ?>
                                    <div class="attention_list">
                                        <?php echo $specification_note; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </section>
    </div>
    <section class="content_contact">
        <div class="container">
            <div class="content_contact__wrap">
                <div class="content_contact__content">
                    <h2 class="content-title">CONTACT</h2>
                    <h3 class="content-subtitle">お問い合わせ</h3>
                    <p class="content_contact__content__text">商品についてのお問い合わせは、右記のお問い合わせフォームまたはお電話からお気軽にご連絡ください。</p>
                </div>
                <div class="content_contact__content">
                    <a href="/contact/" class="contact-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21.735" height="16.403" viewBox="0 0 21.735 16.403">
                        <defs>
                            <style>
                            .cls-1 {
                                fill: #fff;
                            }
                            </style>
                        </defs>
                        <g id="mail" transform="translate(0 -62.799)">
                            <path id="パス_49335" data-name="パス 49335" class="cls-1" d="M20.678,63.856A3.6,3.6,0,0,0,18.125,62.8H3.61A3.61,3.61,0,0,0,0,66.409v9.183A3.61,3.61,0,0,0,3.61,79.2H18.125a3.61,3.61,0,0,0,3.61-3.61V66.409A3.6,3.6,0,0,0,20.678,63.856Zm-.583,11.736a1.97,1.97,0,0,1-1.97,1.97H3.61a1.97,1.97,0,0,1-1.97-1.97V66.409a1.97,1.97,0,0,1,1.97-1.97H18.125a1.97,1.97,0,0,1,1.97,1.97v9.183Z"/>
                            <path id="パス_49336" data-name="パス 49336" class="cls-1" d="M86.017,123.37l-6.435,6.473a1.016,1.016,0,0,1-1.439,0l0,0-6.439-6.476-.7.694,6.434,6.471v0a2,2,0,0,0,2.834,0l.006-.006,6.43-6.468Z" transform="translate(-67.995 -58)"/>
                            <path id="パス_49337" data-name="パス 49337" class="cls-1" d="M336.511,290.816l4.195,3.578.639-.749-4.195-3.578Z" transform="translate(-322.226 -217.62)"/>
                            <rect id="長方形_8687" data-name="長方形 8687" class="cls-1" width="0.984" height="5.514" transform="translate(3.256 76.774) rotate(-130.458)"/>
                        </g>
                        </svg>
                        <span>お問い合わせフォーム</span>
                    </a>
                    <a href="tel:0120-198-141" class="contact-tel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15.719" height="20.5" viewBox="0 0 15.719 20.5">
                        <defs>
                            <style>
                            .cls-2 {
                                fill: #707070;
                            }
                            </style>
                        </defs>
                        <g id="tel" transform="translate(-59.712 0)">
                            <path id="パス_49338" data-name="パス 49338" class="cls-2" d="M61.117.868c-1.409.914-1.685,3.769-1.153,6.1a21.022,21.022,0,0,0,2.78,6.533,21.832,21.832,0,0,0,4.832,5.2c1.908,1.435,4.628,2.347,6.037,1.433a7.134,7.134,0,0,0,1.819-1.95l-.757-1.167-2.081-3.209c-.155-.238-1.124-.021-1.617.259A4.691,4.691,0,0,0,69.7,15.452c-.456.263-.837,0-1.635-.366a9.71,9.71,0,0,1-2.959-3.121,9.71,9.71,0,0,1-1.643-3.974c-.01-.878-.094-1.333.332-1.642a4.691,4.691,0,0,0,1.787-.6c.456-.336,1.05-1.133.9-1.371L64.4,1.17,63.64,0A7.134,7.134,0,0,0,61.117.868Z" transform="translate(0 0)"/>
                        </g>
                        </svg>
                        <span>0120-198-141</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div><!-- [ /.siteContent ] -->
<?php get_footer(); ?>
