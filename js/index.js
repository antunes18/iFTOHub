// Filtro da barra de pesquisa
$(document).ready(function () {
  $("#pesquisarInput").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".card*").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});

// Animação de textos da página index.php
var i = 0;
var i2 = 0;
var bvMsg = "Bem-vinda(o) ao iFTOHub";
var texto = "Repositório Institucional do IFTO.";
var velocidadeEfeito = 75;
function efeitoDigitar() {
  if (i < bvMsg.length) {
    document.getElementById("bvMsg").innerHTML += bvMsg.charAt(i);
    i++;
    setTimeout(efeitoDigitar, velocidadeEfeito);
  }
  if (i == bvMsg.length) {
    velocidadeEfeito = 75;
    document.getElementById("intro").innerHTML += texto.charAt(i2);
    i2++;
    setTimeout(efeitoDigitar, velocidadeEfeito);
  }
}
efeitoDigitar();
