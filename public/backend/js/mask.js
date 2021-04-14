//Script to format a celphone number
$(document).ready(function() {
    $("#telefone").mask("(00) 00000-0000");
});

//Script to format a CPF number
$(document).ready(function() {
    var $CPF = $("#CPF");
    $CPF.mask('000.000.000-00', {
        reverse: true
    });
});

$(document).ready(function() {
    var CEP = $("#CEP");
    CEP.mask('00.000-000', {
        reverse: true
    });
});