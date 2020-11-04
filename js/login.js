
$(function () {
    var $formLogin = $(".form-signin");
    if ($formLogin.length) {
        $formLogin.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                senha: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "E-mail é indispensável."
                },
                senha: {
                    required: "Senha é necessária."
                }
            }
            });
        }
});
