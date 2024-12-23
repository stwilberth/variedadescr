@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-1">
        <div class="col-md-5">

                <!-- Title -->
                    <h1>Envio</h1>
                    <!-- Text -->
                    <h2>Costo</h2>
                    <h3>CORREOS DE COSTA RICA</h3>
                    (COURRIER)
                    <ul>
                        <li>Dentro del GAM: ¢1500</li>
                        <li>Fuera del GAM: ¢2500</li>
                    </ul>                            
                    <h3>MENSAJERÍA</h3> 
                    <ul><li>Valor: ¢1500</li></ul>
                    <h2>Condiciones</h2>
                    <p>Se envía a domicilio, por medio de Correos de Costa Rica o por medio de nuestros mensajeros, a todo el país, a la dirección proporcionada por el cliente, con excepción de las zonas indicadas por Correos de Costa Rica en este <a href="https://www.correos.go.cr/servicios/serviciosexpress/">enlace</a>. 
                    </p>
        </div>
        <div class="col-md-7">
            <img src="img/envio.jpg" class="img-fluid" alt="">
            <a href='https://www.freepik.es/fotos-vectores-gratis/fondo' style="font-size: 13px; color: #DADADA;">Vector de Fondo creado por pikisuperstar - www.freepik.es</a>
        </div>
        <div class="col-md-12">
            <p> 
                Si el cliente pertenezca a esas zonas, sus productos serán enviados a la sucursal de Correos de Costa Rica más cercana.
                Con respecto a los envios por CORREOS DE COSTA RICA, los precios indicados son por unidad de producto vendida, 
                si tiene consultas en relación a que si en un paquete pueden entrar varios productos por favor consultar a <a href="mailto:ventas@variedadescr.com">ventas@variedadescr.com</a> 
                o por medio de nuestra <a href="/contactenos">página de contacto</a>.</p>
            <h2>Duración del envio</h2>  
            <p>No incluye feriados ni fines de semana</p>
            <h3>Correos de Costa Rica</h3>
            <p>Se realiza el envio en un período máximo de 24 horas después de confirmado el depósito.</p>
            <h3>Mensajería</h3>
            <p>Si utiliza el servicio de mensajería se realizara la entrega en un período máximo de 48 horas (Solo dentro del GAM).</p>
        </div>
    </div>
</div>
@endsection