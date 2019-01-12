$('input[name=password], input[name=repeat_password]').on('change', function() {
    var pass = $('input[name=password]').val();
    var repass = $('input[name=repeat_password]').val();
    if(($('input[name=password]').val().length == 0) || ($('input[name=repeat_password]').val().length == 0)){
        $('#passwordHelp').removeClass('d-none');
        $('#passwordHelp').addClass('d-block');
    }
    else if (pass != repass) {
        $('#passwordHelp').removeClass('d-none');
        $('#passwordHelp').addClass('d-block');
    } else {
        $('#passwordHelp').removeClass('d-block');
        $('#passwordHelp').addClass('d-none');
    }
});
