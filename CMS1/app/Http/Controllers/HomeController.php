<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
     
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        // // var_dump($ultimos_pedidos);
        // // die();
        //  //Sacar los ultimos 3 pedidos
        //  $pedidos = Product::latest()->take(3)->get();
        //  session()->put('ultimos_pedidos', $pedidos);

        $categoria = Categoria::count();
        $productos = Product::count();
        $users     = User::count();
        $pedidos   = Pedido::count();

        //Sacar el total de ventas diarias
        $pedidos_diarios = Pedido::where('created_at', date('Y-m-d'))->sum('costo_total');
        $pedidos_mes     = Pedido::whereMonth('created_at', date('m'))->sum('costo_total');
        $pedidos_year     = Pedido::whereYear('created_at', date('Y'))->sum('costo_total');

        // Sacar la cantidad de pedidos por mes
        $pedidos_d = Pedido::select(DB::raw("COUNT(*)as count"))
            ->whereYear('fecha', date('Y'))
            ->groupBy(DB::raw("Month(fecha)"))
            ->pluck('count');

        $months = Pedido::select(DB::raw("Month(fecha)as month"))
            ->whereYear('fecha', date('Y'))
            ->groupBy(DB::raw("Month(fecha)"))
            ->pluck('month');

        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        foreach ($months as $index => $month) {
            $datas[$month - 1] = $pedidos_d[$index];
        }


        $productos_e = new Product();
        $producto_estadistica = $productos_e->dashboard();


        return view('dashboard', compact('categoria', 'productos', 'users', 'pedidos', 'datas', 'producto_estadistica', 'pedidos_diarios', 'pedidos_mes', 'pedidos_year'));
    }
}
