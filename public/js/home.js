$(document).ready(function(){
    $("#carga").hide();
    map = new GMaps({
        el: '#map',
        lat: 19.394208,
        lng: -99.028858
    });
});

$("#estado").change(function(){
    $("#municipio").html('');
    var estado = $("#estado").val();
    var data = {'c_estado':estado};
    $("#carga").show();
    $.ajax({
        url:'/getmunicipios/' + estado + '',
        type:'get',
        dataType:'json',
        data: data,
        success:function(result){
            $.each(result, function(id,value){
                $("#municipio").append('<option value="'+value.c_mnpio+'">'+value.d_mnpio+'</option>');
            });
            $("#carga").hide();
        }
    });
});

$("#buscar").click(function (){
    var estado = $('select[name="estado"] option:selected').text();//$("#estado").val();
    var municipio = $('select[name="municipio"] option:selected').text();//$("#municipio").val();
    var order = $("#orden").val();
    var data = { 'estado':estado, 'municipio': municipio, 'order':order };
    $("#carga").show();
    $("#table-data tbody").html('');
    $.ajax({
        url:'/api/precio/gasolina?estado=' + estado + '&municipio='+ municipio +'&order='+ order +'',
        type:'get',
        dataType:'json',
        data: data,
        success:function(result){
            result = result.info;
            if(result === undefined){
                alert("No se encuentran datos disponibles");
            }else{
                result.forEach(function (item){
                    map.addMarker({
                        lat: item.ubicacion.latitude,
                        lng: item.ubicacion.longitud,
                        title: "Precio de gasolina",
                        infoWindow: {
                            content: '<p>Precio Regular:'+ item.precios.regular +'</p><p>Precio Premium:'+ item.precios.premium +'</p><p>Precio Diesel:'+ item.precios.diesel +'</p><p>Dirección:'+ item.direccion +'</p>'
                        }
                    });
                    var tr = $("<tr/>").append(
                        $("<td/>").html(item.direccion),
                        $("<td/>").html(item.precios.regular),
                        $("<td/>").html(item.precios.premium),
                        $("<td/>").html(item.precios.diesel),
                        $("<td/>").html(item.ubicacion.latitude),
                        $("<td/>").html(item.ubicacion.longitud),
                    );
                    $("#table-data tbody").append(tr);
                });
            }
            $("#carga").hide();
        }
    });
});
