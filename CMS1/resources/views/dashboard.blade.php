@extends('layouts.app')


@section('css')
<style>
    .card {
        box-shadow: 0 6px 8px 0 rgba(0, 0, 0, 0.4);
        transition: 0.4s;
        border-radius: 8px;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="header pb-6 pt-1 pt-md-6">
        <div class="container-fluid mt--6">
            <div class="card-deck">
                <div class="card text-center border-info">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div id="container_pedido"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card text-center border-info">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div id="container_productos"></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>
@endsection

@section('js')
    <!-- Pedidos -->
    <script type="module">
        var datas = <?php echo json_encode($datas); ?>;
        import Highcharts from 'https://code.highcharts.com/es-modules/masters/highcharts.src.js';
        import 'https://code.highcharts.com/es-modules/masters/modules/accessibility.src.js';

        Highcharts.chart('container_pedido', {
            title: {
                text: 'Incremento de Pedidos, 2021'
            },
            subtitle: {
                text: 'Fuente Tienda Virtual'
            },
            xAxis: {
                categories: ['Ene', 'Feb', 'Mzo', 'Abr', 'May', 'Jun', 'Jul', 'Agt', 'Sep', 'Oct', 'Nov', 'Dic']
            },
            yAxis: {
                title: {
                    text: 'Numero de pedidos'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true
                }
            },
            series: [{
                name: 'Nuevos Pedidos.',
                data: datas
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxwidth: 500
                    },
                    chartOption: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    </script>

    <!-- Producto mas venido top 3 -->
    <script type="module">
    var productos = [];
    var valores = [];
    var datapedido = <?php echo json_encode($producto_estadistica); ?>;
    for (let index = 0; index < datapedido.length; index++) {
        productos.push(datapedido[index].name);
        valores.push(parseInt(datapedido[index].cantidad));
    }

    // console.log(medicamentos)
    // console.log(valores)

    import Highcharts from 'https://code.highcharts.com/es-modules/masters/highcharts.src.js';
    import 'https://code.highcharts.com/es-modules/masters/modules/accessibility.src.js';

    Highcharts.chart('container_productos', {
        title: {
            text: 'Top 3 de productos, 2021'
        },
        subtitle: {
            text: 'Fuente tienda virtual'
        },
        xAxis: {
            categories: productos
        },
        yAxis: {
            title: {
                text: 'Numero de producto mas vendidos'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'productos',
            data: valores
        }],
        responsive: {
            rules: [{
                condition: {
                    maxwidth: 500
                },
                chartOption: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>
@endsection