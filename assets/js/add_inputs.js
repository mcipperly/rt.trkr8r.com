$(document).ready(function() {
    var max_fields      = 25; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add-input"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).prepend('<div><select name="org_name" class="input_fields_input"><option value="org1">Volvo</option><option value="org2">Saab</option><option value="org3">Fiat</option><option value="org4">Audi</option></select>&nbsp;&nbsp;<img src="../assets/imgs/remove-icon.png" class="remove-input"></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove-input", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});