$(".test").click(function() {
    $.ajax({
        url: 'http://beagui.com/test.php',
        data: {
            id: 'id'
        },
        dataType: 'json'
    }).done(function(resp) {
        console.log(resp.msg)
    });
});