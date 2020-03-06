$(function() {
  var form = $('#contact-form');
  var formMessages = $('#contact-message');

  $(form).submit(function(event) {
    event.preventDefault();

    var formData = $(form).serialize();

    $.ajax({
      type: 'POST',
      url: $(form).attr('action'),
      data: formData
    })
      .done(function(response) {
        $(formMessages).text(response);

        $('#name').val('');
        $('#email').val('');
        $('#message').val('');
      })
      .fail(function(data) {
        $(formMessages).text(
          'Nie udało się wysłać wiadomości, prosimy spróbować ponownie.'
        );
      });
  });
});
