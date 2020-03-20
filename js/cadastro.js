const campoNome = document.getElementById('campoNome');
const form = document.querySelector('form');

campoNome.addEventListener('input', () => {
    campoNome.setCustomValidity('');
    campoNome.checkValidity();
});

campoNome.addEventListener('invalid', () => {
    if (campoNome.value == "") {
        campoNome.setCustomValidity('Por favor, digite seu nome completo');
    } else {
        campoNome.setCustomValidity('Nome completo');
    }
});