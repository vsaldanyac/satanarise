<script>
/* ésto comprueba la localStorage si ya tiene la variable guardada */
function compruebaAceptaCookies() {
  if(localStorage.aceptaCookies == 'true'){
    cajacookies.style.display = 'none';
  }
}

/* aquí guardamos la variable de que se ha
aceptado el uso de cookies así no mostraremos
el mensaje de nuevo */
function aceptarCookies() {
  localStorage.aceptaCookies = 'true';
  cajacookies.style.display = 'none';
}

/* ésto se ejecuta cuando la web está cargada */
$(document).ready(function () {
  compruebaAceptaCookies();
});
</script>