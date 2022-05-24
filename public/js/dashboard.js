    


        
        // Al abrir modal para agregar disparo change del select para cambiar los campos segun el tipo de persona
        $('.modal').on('show.bs.modal', function (event) {
            $(this).find('.modal-body .tipo_persona_id').trigger("change");
        })  


        // Persona fisica o juridica
        // Evento al cambiar el listobox
        $('.tipo_persona_id').on("change",function(e) {
            // Fisica
            if( this.value == 1 || this.value == "" ){
                $( ".tipo_persona_id" ).val(1);
                $( ".persona_juridica" ).slideUp();
                $( ".denominacion" ).slideUp();
                $( ".nombres" ).slideDown();
                $( ".documentos" ).slideDown();
                $( ".fecha_nacimiento" ).slideDown();
                $( ".conyuge" ).slideDown();
                $( ".persona_sexo" ).slideDown();
                $( ".persona_fallecida" ).slideDown();
                
                // Cambio elementos requeridos
                for (let index = 0; index < document.getElementsByName("persona_nombre").length; index++) {
                    document.getElementsByName("persona_nombre")[index].required = true;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_apellido").length; index++) {
                    document.getElementsByName("persona_apellido")[index].required = true;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_denominacion").length; index++) {
                    document.getElementsByName("persona_denominacion")[index].required = false;                    
                }                
                for (let index = 0; index < document.getElementsByName("tipo_documento_id").length; index++) {
                    document.getElementsByName("tipo_documento_id")[index].required = true;                    
                }  
                for (let index = 0; index < document.getElementsByName("tipo_persona_juridica_id").length; index++) {
                    document.getElementsByName("tipo_persona_juridica_id")[index].required = false;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_nro_doc").length; index++) {
                    document.getElementsByName("persona_nro_doc")[index].required = true;                    
                }

            }
            // Juridica
            else if( this.value == 2 ){
                $( ".persona_juridica" ).slideDown();
                $( ".denominacion" ).slideDown();
                $( ".nombres" ).slideUp();
                $( ".documentos" ).slideUp();
                $( ".fecha_nacimiento" ).slideUp();
                $( ".conyuge" ).slideUp();
                $( ".persona_sexo" ).slideUp();
                $( ".persona_fallecida" ).slideUp();

                // Cambio elementos requeridos
                for (let index = 0; index < document.getElementsByName("persona_nombre").length; index++) {
                    document.getElementsByName("persona_nombre")[index].required = false;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_apellido").length; index++) {
                    document.getElementsByName("persona_apellido")[index].required = false;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_denominacion").length; index++) {
                    document.getElementsByName("persona_denominacion")[index].required = true;                    
                }                
                for (let index = 0; index < document.getElementsByName("tipo_documento_id").length; index++) {
                    document.getElementsByName("tipo_documento_id")[index].required = false;                    
                }  
                for (let index = 0; index < document.getElementsByName("tipo_persona_juridica_id").length; index++) {
                    document.getElementsByName("tipo_persona_juridica_id")[index].required = true;                    
                }                
                for (let index = 0; index < document.getElementsByName("persona_nro_doc").length; index++) {
                    document.getElementsByName("persona_nro_doc")[index].required = false;                    
                }            
            }
        });

        



        // Validar CUIT en envio de formulario
        $(document).ready(function(){
            $("#formStorePersona").on("submit", function(e){       
                return ValidateCUITCUIL( $("#persona_cuit").val());
            })  
        })

         // Si el CUIT ya existe
         $( "#persona_cuit" ).keyup(function(e) {
            if(this.value){
                existeCUITCUIL(this);
            }else{
                // Limpiar error
                $(".existente-cuil").addClass("d-none");
                $(".existente-cuil").removeClass("d-block");
                this.style.backgroundColor = "#ffffff";
            }
        });       
        

// Validar CUIT
function ValidateCUITCUIL(cuit)
{
    cuit = cuit.toString().replace(/[-_]/g, "");
    var mult = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];
    var total = 0;
    for (var i = 0; i < mult.length; i++) {
        total += parseInt(cuit[i]) * mult[i];
    }
    var mod = total % 11;
    var digito = mod == 0 ? 0 : mod == 1 ? 9 : 11 - mod;

    // Si no tiene guiones y tiene mas de 11 digitos devuelvo falso 
    if((!cuit.includes("-") && cuit.length > 11) || (cuit == "00000000000")){
        return false;
    }
    return digito == parseInt(cuit[10]);
}

function existeCUITCUIL(val){
    $.ajax({
        type: "GET",
        url: "consultarCuit",
        async: true,
        data: {cuit:val.value},
        success: function (response) {     
            if(response.existe){
                // Si ya existe agrego error
                $(".existente-cuil").addClass("d-block");
                $(".existente-cuil").removeClass("d-none");
            }else{
                $(".existente-cuil").addClass("d-none");
                $(".existente-cuil").removeClass("d-block");
            }
        }
    });
}

// Validar CUIT al escribir sobre el campo
$( "#persona_cuit" ).keyup(function(e) {
    if(this.value){
        // Actualizo el href de el cuit ya existe
        document.getElementById("cuit_param").href = "./personas?persona_cuit=" + this.value;
        if(ValidateCUITCUIL(this.value)){
            //this.style.backgroundColor = "#ccffcc";
            // Limpiar error
            $(".valid-cuil").addClass("d-none");
            $(".valid-cuil").removeClass("d-block");
        }else{
            //this.style.backgroundColor = "#ffcccc";
            // Agregar error
           $(".valid-cuil").addClass("d-block");
            $(".valid-cuil").removeClass("d-none");
    
        }
    }else{
        // Limpiar error
        $(".valid-cuil").addClass("d-none");
        $(".valid-cuil").removeClass("d-block");

        this.style.backgroundColor = "#ffffff";
    }
});





$(document).ready(function () {

    $('input[type="text"]').attr("autocomplete","off");
    $('input[type="number"]').attr("autocomplete","off");

    /*========================
        LIMPIAR CUALQUIR TIPO DE BUSQUEDA
    ======================*/
    $(".limpiar").on("click",function () {
        $(":input[type='text']").val("");
        $(":input[type='number']").val("");
        $(":input[type='hidden']").val("");
     });

        $('[data-mask]').inputmask()    


});


         
    var STR_PAD_LEFT = 1;
    var STR_PAD_RIGHT = 2;
    var STR_PAD_BOTH = 3;

    //Autocompleta los espacios en blanco de la nomenclatura por 0 
    function armarNomencla(str, len, pad, dir) {
 
        if (typeof(len) == "undefined") { var len = 0; }
        if (typeof(pad) == "undefined") { var pad = ' '; }
        if (typeof(dir) == "undefined") { var dir = STR_PAD_RIGHT; }

        if (len + 1 >= str.length) {

                switch (dir){

                        case STR_PAD_LEFT:
                                str = Array(len + 1 - str.length).join(pad) + str;
                        break;

                        case STR_PAD_BOTH:
                                var right = Math.ceil((padlen = len - str.length) / 2);
                                var left = padlen - right;
                                str = Array(left+1).join(pad) + str + Array(right+1).join(pad);
                        break;

                        default:
                                str = str + Array(len + 1 - str.length).join(pad);
                        break;

                } // switch

        }
        return str;
    }


    
    switch (RUTA) {
        case 'parcelas':
            $("#submenu2").collapse("show");
        break;
        case 'padron.show':
            $("#submenu2").collapse("show");
        break;
        case 'modulo_personas':
            $("#submenu2").collapse("show");
        break;
        case 'modulo_union':
            $("#submenu2").collapse("show");
        break;
        case 'modulo_desglose':
            $("#submenu2").collapse("show");
        break;
        case 'Direccion':
            $("#submenu2").collapse("show");
        break;
        case 'user':
            $("#submenu1").collapse("show");
        break;
        case 'seccion':
            $("#submenu1").collapse("show");
        break;
        case 'bloqueo':
            $("#submenu1").collapse("show");
        break;  
        case 'tipo_de_condicion':
            $("#submenu3").collapse("show");
            $("#submenu4").collapse("show");
        break;    
        case 'tipo_de_instrumento':
            $("#submenu3").collapse("show");
            $("#submenu4").collapse("show");
        break;    
        case 'tipo_de_parcela':
            $("#submenu3").collapse("show");
            $("#submenu4").collapse("show");
        break;                  
        case 'tipo_de_profesional':
            $("#submenu3").collapse("show");
            $("#submenu4").collapse("show");
        break;    
        case 'tipo_de_servicio':
            $("#submenu3").collapse("show");
            $("#submenu4").collapse("show");
        break; 
        case 'tipo_de_documento':
            $("#submenu3").collapse("show");
            $("#submenu5").collapse("show");
        break;
        case 'tipo_de_persona_parcela':
            $("#submenu3").collapse("show");
            $("#submenu5").collapse("show");
        break;
        case 'tipo_de_mejora':
            $("#submenu3").collapse("show");
            $("#submenu6").collapse("show");
        break;
        case 'tipo_de_mejora_destino':
            $("#submenu3").collapse("show");
            $("#submenu6").collapse("show");
        break;
        case 'tipo_de_afectacion':
            $("#submenu3").collapse("show");
        break;
        case 'tipo_de_estado':
            $("#submenu7").collapse("show");
        break;
        case 'tipos_de_destinos':
            $("#submenu7").collapse("show");
        break;
        case 'tipos_de_zonas':
            $("#submenu7").collapse("show");
        break;
        case 'tipo_de_uso':
            $("#submenu7").collapse("show");
        break;
        case 'tipo_de_construccion':
            $("#submenu7").collapse("show");
        break;
        default:
        break;
}
