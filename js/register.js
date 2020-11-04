
$(function () {
    var $resetCadastro = $("#reset").validate();
    $resetCadastro.resetForm();

    var $formCadastro = $(".form-signin");

    $.validator.addMethod("noSpace", function(value, element){
        return value == "" || value.trim().length != 0
    }, "Espaços não são permitidos" );
    
   $.validator.addMethod('lettersonly', function(value, element) {
    return this.optional(element) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
}, "Apenas letras");

    if ($formCadastro.length) {
        $formCadastro.validate({
            rules: {
                nome: {
                    required: true,
                    noSpace: true,
		    lettersonly: true
                },
                email: {
                    required: true,
                    email: true,
                    noSpace: true
                },
                senha: {
                    required: true,
                    noSpace: true,
		    minlength: 8,
		    maxlength: 16
                },
                confirma: {
                    required: true,
                    equalTo: "#campoSenha",
                    noSpace: true
                },
                campus: {
                    required: true
                }
            },
            messages: {
                nome: {
                    required: "Nome completo é necessário",

                },
                email: {
                    required: "E-mail é indispensável.",
                    email: "Por favor, digite um e-mail válido."
		    
                },
                senha: {
                    required: "Senha é importante.",
	            minlength: "Por favor, digite ao menos 8 caracteres.",
		    maxlength: "Por favor, não digite mais do que 16 caracteres."
                },
                confirma : {
                    required: "Confirme sua senha",
                    equalTo: "Por favor, digite a mesma senha de novo"
                }
            }
        })
    }
});
