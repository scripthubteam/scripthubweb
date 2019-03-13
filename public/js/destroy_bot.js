$('#removeBotBtn').click(function( event ) {
    event.preventDefault();
    if(window.confirm("¿Eliminar bot?")) {
        document.getElementById('bot-destroy-form').submit();
        confirm = false;
        return;
    }
});
