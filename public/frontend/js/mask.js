//Script to format a celphone number
$(document).ready(function() {
    $("#phone").mask("(99) 99999-9999");
});

//Script to format a CPF number
$(document).ready(function() {
    var $CPF = $("#CPF");
    $CPF.mask('000.000.000-00', {
        reverse: true
    });
});

$(document).ready(function() {
    var $CEP = $("#CEP");
    $CEP.mask('00.000-000', {
        reverse: true
    });
});