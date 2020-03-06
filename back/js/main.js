function bannerInit(firstSlide, slidesCnt) {
  $('#' + firstSlide.id + '')
    .animate({ opacity: 1 })
    .css('display', 'block')
    .addClass('active-slide');

  setInterval(nextSlide, 3000, slidesCnt);
}
function nextSlide(slidesCnt) {
  var currentSlide = $('li.banner-slide.active-slide');
  var currentSlideId = parseInt(
    currentSlide
      .attr('id')
      .split('-')
      .pop(),
    10
  );

  if (currentSlideId == slidesCnt) {
    currentSlide.removeClass('active-slide');
    $('#banner-slide-1')
      .animate({ opacity: 1 })
      .css('display', 'block')
      .addClass('active-slide');

    $('#banner-slide-' + currentSlideId + '')
      .animate({ opacity: 0 })
      .css('display', 'none');
  } else {
    currentSlide.removeClass('active-slide');
    var nextSlide = currentSlideId + 1;
    $('#banner-slide-' + nextSlide + '')
      .animate({ opacity: 1 })
      .css('display', 'block')
      .addClass('active-slide');

    $('#banner-slide-' + currentSlideId + '')
      .animate({ opacity: 0 })
      .css('display', 'none');
  }
}
$(document).ready(function() {
  var slides = document.querySelectorAll('.banner-slide');
  var slidesCnt = slides.length;
  var currentSlideId;
  bannerInit(slides[0], slidesCnt);
  if ($('li.banner-slide.active-slide').height() < 650) {
    $('.banner-container').css('height', 'auto');
  } else {
    $('.banner-container').css('height', '650px');
  }
});

/* Container height change */
$(window).resize(function() {
  if ($('li.banner-slide.active-slide').height() < 650) {
    $('.banner-container').css('height', 'auto');
  } else {
    $('.banner-container').css('height', '650px');
  }
  var w = $(window).width();
  var h = $(window.top).height();
  $('.a img').width(w - w * 0.4);
  $('.a').css('left', w * 0.2);
});
/* ---- END --------------- */
/* ------- Add hover to boostrap menu  --------- */
$('.nav-item').hover(
  function() {
    if ($(this).hasClass('dropdown')) {
      $(this).addClass('show');
    }
    $('li.nav-item.show a#navbarDropdownMenuLink').attr('aria-expanded', true);
    $('li.nav-item.show div.dropdown-menu').addClass('show');
  },
  function() {
    $(this).removeClass('show');
    $('li.nav-item a').attr('aria-expanded', false);
    $('li.nav-item div.dropdown-menu').removeClass('show');
  }
);

$('.gallery-filter-btn').click(function() {
  var filter = $(this).attr('data-filter');

  if (filter == 'all') {
    $('.gallery-item').hide();
    $('.gallery-item').each(function(k, v) {
      $(this).fadeIn();
    });
  } else {
    $('.gallery-item').hide();
    $('.gallery-item').each(function(k, v) {
      if ($(this).attr('data-category') == filter) {
        $(this).fadeIn();
      }
    });
  }
});
$('.gallery-img img').click(function() {
  var galleryPhotos = $('.gallery-item img');
  var selectedPhoto = $(this);
  $('.active-photo').removeClass('active-photo');
  selectedPhoto.addClass('active-photo');
  var selectedPhotoId;

  $('.t').css({ display: 'block', position: 'fixed' });
  $('body').css('overflow', 'hidden');

  $('.a')
    .css('display', 'block')
    .append(
      "<img src='http://projekt.dev.cymer.pl/timthumb.php?src=" +
        selectedPhoto.attr('data-original') +
        "&w=1024&h=680'>"
    );
  var w = $(window).width();
  var h = $(window.top).height();
  $('.a img').width(w - w * 0.4);
  $('.a').css('left', w * 0.2);
});
$(document).on('keydown', function(event) {
  if (event.key == 'Escape') {
    $('.a').css('display', 'none');
    $('.t').css('display', 'none');
    $('body').css('overflow', 'visible');
    $('.a img').remove();
  }
});

/* ---------------- END------------------------ */
