$(document).ready(function() {

    (function($) {
        "use strict";


        jQuery.validator.addMethod('answercheck', function(value, element) {
            return this.optional(element) || /^\bcat\b$/.test(value)
        }, "Digite a resposta certa.");

        // validate contactForm form
        $(function() {
            $('#contactForm').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    subject: {
                        required: true,
                        minlength: 4
                    },
                    phone: {
                        required: true,
                        minlength: 14
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    message: {
                        required: true,
                        minlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Vamo lá, você tem um nome, não tem?",
                        minlength: "Seu nome deve possuir no mínimo 2 caracteres."
                    },
                    subject: {
                        required: "Vamo lá, você tem um assunto, não tem?",
                        minlength: "O assunto deve possuir no mínimo 4 caracteres."
                    },
                    phone: {
                        required: "Vamo lá, você tem um número, não tem?",
                        minlength: "O seu número deve possuir no mínimo 14 caracteres."
                    },
                    email: {
                        required: "Sem e-mail, sem mensagem."
                    },
                    message: {
                        required: "Você precisa escrever algo para enviar esse formulário.",
                        minlength: "Sua mensagem deve possuir ao menos 20 caracteres."
                    }
                },
                submitHandler: function(form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $(form).ajaxSubmit({
                        type: "POST",
                        data: $(form).serialize(),
                        url: $(form).attr('action'),
                        success: function() {
                            $('#contactForm :input').attr('disabled', 'disabled');
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $(this).find(':input').attr('disabled', 'disabled');
                                $(this).find('label').css('cursor', 'default');
                                $('#success').fadeIn()
                                $('.modal').modal('hide');
                                $('#success').modal('show');
                            })
                        },
                        error: function() {
                            $('#contactForm').fadeTo("slow", 1, function() {
                                $('#error').fadeIn()
                                $('.modal').modal('hide');
                                $('#error').modal('show');
                            })
                        }
                    })
                }
            })
        })

    })(jQuery)
})