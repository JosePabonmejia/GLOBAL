<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Argon CSS -->
    <title>Información E-Commerce</title>

    <style>
        @import url('fonts/BrixSansRegular.css');
        @import url('fonts/BrixSansBlack.css');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        p,
        label,
        span,
        table {
            font-family: 'BrixSansRegular';
            font-size: 9pt;
        }

        .h2 {
            font-family: 'BrixSansBlack';
            font-size: 16pt;
        }

        .h3 {
            font-family: 'BrixSansBlack';
            font-size: 12pt;
            display: block;
            background: #0a4661;
            color: #FFF;
            text-align: center;
            padding: 3px;
            margin-bottom: 5px;
        }

        #page_pdf {
            width: 95%;
            margin: 15px auto 10px auto;
        }

        #factura_head,
        #factura_cliente,
        #factura_detalle {
            width: 100%;
            margin-bottom: 10px;
        }

        .info_empresa {
            width: 50%;
            text-align: center;
        }

        .info_factura {
            width: 20%;
        }

        .info_cliente {
            width: 100%;
        }

        .datos_cliente {
            width: 100%;
        }

        .datos_cliente tr td {
            width: 50%;
        }

        .datos_cliente {
            padding: 10px 10px 0 10px;
        }

        .datos_cliente label {
            width: 75px;
            display: inline-block;
        }

        .datos_cliente p {
            display: inline-block;
        }

        .textright {
            text-align: right;
        }

        .textleft {
            text-align: left;
        }

        .textcenter {
            text-align: center;
        }

        .round {
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        .round p {
            padding: 0 15px;
        }

        #factura_detalle {
            border-collapse: collapse;
        }

        #factura_detalle thead th {
            background: #058167;
            color: #FFF;
            padding: 5px;
        }

        #detalle_productos tr:nth-child(even) {
            background: #ededed;

        }

        #detalle_totales span {
            font-family: 'BrixSansBlack';
        }

        .nota {
            font-size: 8pt;
        }

        .label_gracias {
            font-family: verdana;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            margin-top: 20px;
        }

        .anulada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        .entregada {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }

        #customers td,
        #customers th {
            border: 0px solid #ddd;
            padding: 8px;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #0a4661;
            color: white;
        }
      
    </style>

</head>

<body>
    <h3>{{ $pedido->user->name }} Actualización de su pedido {{ $pedido->id }}</h3> 
    Estado: <h4 style="color: yellowgreen;">{{ $pedido->estado }}</h4>
    <div class="card">
        <div id="page_pdf">
            <table id="factura_head">
                <tr>
                    <td class="info_empresa">
                        <div>
                            <h1>E-commerce</h1>
                            <p>Avenida Alto San Pedro 3er anillo (interno)</p>
                            <p>Teléfono: +(591) 65949863</p>
                            <p>Email: sergiofernandorodriguez@gmail.com</p>
                        </div>
                    </td>
                    <td class="info_factura" style="text-align: center;">
                        <div class="round">
                            <span class="h3">Nota Pedido</span>
                            <h2>No. Nota: <strong>0000{{ $pedido->id }}</strong></h2>
                            <h4>Fecha: {{ date('d/m/Y', strtotime($pedido->fecha)) }}</h4>
                            <h4>Provincia: {{ $pedido->provincia }}</h4>
                            <h4>Localidad: {{ $pedido->localidad }}</h4>
                            <h4>Dirección: {{ $pedido->direccion }}</h4>
                        </div>
                    </td>
                </tr>
            </table>
            <table id="factura_cliente">
                <tr>
                    <td class="info_cliente">
                        <div class="round">
                            <span class="h3">Cliente</span>
                            <table class="datos_cliente">
                                <tr>
                                    <td><label>Ci/Nit:</label>
                                        <p>{{ $pedido->user->ci }}</p>
                                    </td>
                                    <td><label>Nombre:</label>
                                        <p>{{ $pedido->user->name }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label>Teléfono:</label>
                                        <p>{{ $pedido->user->telefono }}</p>
                                    </td>
                                    <td><label>Correo Electrónico:</label>
                                        <p>{{ $pedido->user->email }}</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-10 text-center">
                    <div class="table-responsive">
                        <div class="round">
                            <table id="customers">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Costo Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedido->productos as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->pivot->cantidad }}</td>
                                        <td class="text-center">$. {{ $item->pivot->costo_unitario }}</td>
                                        <td class="text-center">$. {{ $item->pivot->subtotal }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot id="detalle_totales">
                                    <tr>
                                        <td colspan="3" class="textright"><span>TOTAL A.</span></td>
                                        <td class="text-center"><span>$ {{$pedido->costo_total}} </span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h4 class="label_gracias">¡Gracias por su preferencia!</h4>
            </div>

        </div>
    </div>

</body>

</html>