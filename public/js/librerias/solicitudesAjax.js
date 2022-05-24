

function precioCompraProducto(){

    id_producto= $("#idproducto").val();
    token =  $("meta[name='csrf-token']").attr("content");
    $.ajax({
        type: "POST",
        url: "ajax-consultas",
        data: {_token: token, funcion: 'precio_compra_por_producto',idproducto: id_producto},
        dataType: "json",
        success: function (response) {
        
            if(response.length>0){

                datos = [];

                for(i=0; i<response.length; i++){

                    dato = {t:response[i].t, y: response[i].y}
                    datos.push(dato);
                }    

                var dataset = charPrecioCompra.config.data.datasets[0];
                dataset.data = datos;	
                charPrecioCompra.update();
           }else{

            datos = [];
            var dataset = charPrecioCompra.config.data.datasets[0];
            dataset.data = datos;	
            charPrecioCompra.update();

            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'El producto seleccionado no tiene compras registradas',
              
                })
       }

        },error: function (response) {
            console.log(response);
        }
    });
}

function ventasPorVendedor(){

    idvendedor= $("#idvendedor").val();
    token =  $("meta[name='csrf-token']").attr("content");
    $.ajax({
        type: "POST",
        url: "ajax-consultas",
        data: {_token: token, funcion: 'ventas_por_vendedor',idvendedor: idvendedor},
        dataType: "json",
        success: function (response) {
        
            if(response.length>0){

                ventas = [];

                for(i=0; i<response.length; i++){

                    dato = {t:response[i].t, y: response[i].y}
                    ventas.push(dato);
                }    

                var dataset = charVentasPorVendedor.config.data.datasets[0];
                dataset.data = ventas;	
                charVentasPorVendedor.update();
           
            }else{
                ventas = [];
                var dataset = charVentasPorVendedor.config.data.datasets[0];
                dataset.data = ventas;	
                charVentasPorVendedor.update();

                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'El vendedor seleccionado no tiene ventas registradas',
                  
                    })
           }

        },error: function (response) {
            console.log(response);
        }
    });

}



function ventasPorProducto(){

    idproducto= $("#productoVenta").val();
    token =  $("meta[name='csrf-token']").attr("content");
    $.ajax({
        type: "POST",
        url: "ajax-consultas",
        data: {_token: token, funcion: 'ventas_por_producto',idproducto: idproducto},
        dataType: "json",
        success: function (response) {
        
            if(response.length>0){

                ventasProducto = [];

                for(i=0; i<response.length; i++){

                    dato = {t:response[i].t, y: response[i].y}
                    ventasProducto.push(dato);
                }    

                var dataset = charVentasPorProducto.config.data.datasets[0];
                dataset.data = ventasProducto;	
                charVentasPorProducto.update();
           
            }else{
                ventasProducto = [];
                var dataset = charVentasPorProducto.config.data.datasets[0];
                dataset.data = ventasProducto;	
                charVentasPorProducto.update();

                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'El producto seleccionado no tiene ventas registradas',
                  
                    })
           }

        },error: function (response) {
            console.log(response);
        }
    });

}

function autoCompleteProductosVentas(){

    token =  $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "../ajax-consultas",
            dataType: "json",
            type: 'post',
            data: {_token: token, funcion: 'productos_venta'},
            async: false,
            success: function (response) {

                $("#autocompletad_pv").autocomplete({				
                    autoFocus: false,
                    minLength: 1,
                    source: response,
                // appendTo: buscBarrioDialog,
                    open: function () {
                        setTimeout(function () {
                            $('.ui-autocomplete').css('z-index', 100);
                        }, 0);
                    },
                    select: function (event, ui) {
                        $("#id_producto").val(ui.item.id);
                        $(this).val("");
                        mostrarValores();
                        return false;
                    }
                });

            }
        });

}



function autoCompleteProductosCompras(){

    token =  $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "../ajax-consultas",
            dataType: "json",
            type: 'post',
            data: {_token: token, funcion: 'productos_compra'},
            async: false,
            success: function (response) {

                $("#autocompletad_pv").autocomplete({				
                    autoFocus: false,
                    minLength: 1,
                    source: response,
                // appendTo: buscBarrioDialog,
                    open: function () {
                        setTimeout(function () {
                            $('.ui-autocomplete').css('z-index', 100);
                        }, 0);
                    },
                    select: function (event, ui) {
                        $("#id_producto").val(ui.item.id);
                        $(this).val("");
                        return false;
                    }
                });

            }
        });

}



function autoCompleteProductosFaltantes(){

    token =  $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "../ajax-consultas",
            dataType: "json",
            type: 'post',
            data: {_token: token, funcion: 'productos_faltante'},
            async: false,
            success: function (response) {

                $("#autocompletad_pv").autocomplete({				
                    autoFocus: false,
                    minLength: 1,
                    source: response,
                // appendTo: buscBarrioDialog,
                    open: function () {
                        setTimeout(function () {
                            $('.ui-autocomplete').css('z-index', 100);
                        }, 0);
                    },
                    select: function (event, ui) {
                        $("#id_producto").val(ui.item.id);
                        $(this).val("");
                        mostrarStockMaximo();
                        return false;
                    }
                });

            }
        });
     

}


function autoCompleteProductosAgregacion(){

    token =  $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "../ajax-consultas",
            dataType: "json",
            type: 'post',
            data: {_token: token, funcion: 'productos_agregacion'},
            async: false,
            success: function (response) {

                $("#autocompletad_pv_agregacion").autocomplete({				
                    autoFocus: false,
                    minLength: 1,
                    source: response,
                // appendTo: buscBarrioDialog,
                    open: function () {
                        setTimeout(function () {
                            $('.ui-autocomplete').css('z-index', 100);
                        }, 0);
                    },
                    select: function (event, ui) {
                        $("#id_producto_agregacion").val(ui.item.id);
                        $(this).val("");
                        stockActualAgregacion();
                        return false;
                    }
                });

            }
        });
     

}



function autoCompleteProductosRecetas(){

    token =  $("meta[name='csrf-token']").attr("content");

        $.ajax({
            url: "../ajax-consultas",
            dataType: "json",
            type: 'post',
            data: {_token: token, funcion: 'productos_receta'},
            async: false,
            success: function (response) {

                $("#autocompletad_pv").autocomplete({				
                    autoFocus: false,
                    minLength: 1,
                    source: response,
                // appendTo: buscBarrioDialog,
                    open: function () {
                        setTimeout(function () {
                            $('.ui-autocomplete').css('z-index', 100);
                        }, 0);
                    },
                    select: function (event, ui) {
                        $("#id_insumo").val(ui.item.id);
                        $(this).val("");
                        return false;
                    }
                });

            }
        });
    }


    function autoCompleteProductosRecetasEditar(id){

        token =  $("meta[name='csrf-token']").attr("content");
    
            $.ajax({
                url: "../../ajax-consultas",
                dataType: "json",
                type: 'post',
                data: {_token: token, funcion: 'productos_receta_edit',idproducto: id},
                async: false,
                success: function (response) {
    
                    $("#autocompletad_pv").autocomplete({				
                        autoFocus: false,
                        minLength: 1,
                        source: response,
                    // appendTo: buscBarrioDialog,
                        open: function () {
                            setTimeout(function () {
                                $('.ui-autocomplete').css('z-index', 100);
                            }, 0);
                        },
                        select: function (event, ui) {
                            $("#id_insumo").val(ui.item.id);
                            $(this).val("");
                            return false;
                        }
                    });
    
                }
            });
        }