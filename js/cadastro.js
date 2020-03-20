const campoNome = document.getElementById('campoNome');
const form = document.querySelector('form');

campoNome.addEventListener('input', () => {
    campoNome.setCustomValidity('');
    campoNome.checkValidity();
});

campoNome.addEventListener('invalid', () => {
    if (campoNome.value == "") {
        campoNome.setCustomValidity('Por favor, digite seu nome');
    } else {
        campoNome.setCustomValidity('Somente letras, nada de espaços ou números.');
    }
});

const campoSobrenome = document.getElementById('campoSobrenome');

campoSobrenome.addEventListener('input', () => {
    campoSobrenome.setCustomValidity('');
    campoSobrenome.checkValidity();
});

campoSobrenome.addEventListener('invalid', () => {
    if (campoSobrenome.value == "") {
        campoSobrenome.setCustomValidity('Por favor, digite somente seu sobrenome');
    } else {
        campoSobrenome.setCustomValidity('Somente letras, nada de espaços ou números.')
    }
})