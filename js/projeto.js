
$(function () {
    // var $resetCadastro = $("#reset").validate();
    // $resetCadastro.resetForm();

    var $formProjeto = $("#form-projeto");
    
    // $.validator.addMethod("noSpace", function(value, element){
    //     return value == "" || value.trim().length != 0
    // }, "Espaços não são permitidos" );
    
   $.validator.addMethod('apenasletras', function(value, element) {
    return this.optional(element) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
}, "Apenas letras");

    if ($formProjeto.length) {
        $formProjeto.validate({
            rules: {
                orientador: {
                    required: true,
		            apenasletras: true
                },
                coorientador: {
                    apenasletras: true
                },
                tituloprojeto: {
                    required: true
                }
            },
            messages: {
                orientador: {
                    required: "Nome do(a) orientador(a) é fundamental."
                },
                tituloprojeto: {
                    required: "Título do projeto é essencial"
                }
            }
        })
    }
});
