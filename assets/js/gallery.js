$(document).ready(function() {
  $('.gallery-filter-btn').click(function() {
    var position = $('.gallery').position();
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
    $('.t').addClass('active-g');
    $('body').css('overflow', 'hidden');

    $('.a')
      .css('display', 'block')
      .append(
        "<img id='layer-img' src='http://projekt.dev.cymer.pl/timthumb.php?src=" +
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
      $('.t').removeClass('active-g');
    }
  });
});
