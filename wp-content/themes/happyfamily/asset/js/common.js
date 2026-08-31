jQuery(function($){
  if ($('#firstview-carousel').length) {
    $('#firstview-carousel .firstview-inner-carousel').slick({
      infinite: true,
      speed: 1000,
      autoplay: true,
      autoplaySpeed: 4000,
      slidesToScroll: 1,
      adaptiveHeight: true,
      arrows: true,
      dots: true,
      slidesToShow: 1,
      pauseOnFocus: false,
      pauseOnHover: false,
      pauseOnDotsHover: false,
      // cssEase: 'ease-out',
      prevArrow: '<button class="slick-prev slick-arrow left carousel-control" aria-label="Previous" type="button" style="display: block;"><i class="icon-prev fa fa-angle-left"></i></button>',
      nextArrow: '<button class="slick-next slick-arrow right carousel-control" aria-label="Next" type="button" style="display: block;"><i class="icon-next fa fa-angle-right"></i></button>',
    });

    var dotNums = document.querySelectorAll(".slick-dots button");
    function removeText(item) {
      item.innerHTML = ""; // or put the text you need inside quotes
    }
    dotNums.forEach(removeText);
  }

  $('.slick-product_main').slick({
    autoplay: false,
    speed: 800,
    dots: false,
    arrows: true,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    lazyLoad: 'ondemand',
    asNavFor: '.slick-product_sub',
    prevArrow: '<button type="button" class="prev-btn"><img class="link-arrow rotate-90" src="/wordpress/wp-content/themes/happyfamily/asset/images/common/link-arrow_black.png"></button>',
    nextArrow: '<button type="button" class="next-btn"><img class="link-arrow" src="/wordpress/wp-content/themes/happyfamily/asset/images/common/link-arrow_black.png"></button>',
  });

  $('.slick-product_sub').slick({
    autoplay: false,
    speed: 800,
    dots: false,
    arrows: false,
    infinite: true,
    pauseOnHover: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.slick-product_main',
    focusOnSelect: true,
    // centerPadding: '10%',
    // centerMode: false,
    // lazyLoad: 'ondemand',
    // prevArrow: '<button type="button" class="prev-btn"><img class="link-arrow rotate-90" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
    // nextArrow: '<button type="button" class="next-btn"><img class="link-arrow" src="/cms/wp-content/themes/maker/assets/img/common/link-arrow_black.png"></button>',
  });
});