$('#removeUserBtn').click(function( event ) {
    event.preventDefault();
    if(window.confirm("¿Eliminar cuenta?")) {
        document.getElementById('user-destroy-form').submit();
        confirm = false;
        return;
    }
});
