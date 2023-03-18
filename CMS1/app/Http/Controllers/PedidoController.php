<?php

namespace App\Http\Controllers;

use App\Mail\PedidoEntregado;
use App\Mail\PedidoEnviado;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\PedidoPreparando;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function detalle($id){
        $pedido = Pedido::find($id);
        // var_dump($pedido->productos);
        // die();
        return view('pedidos.details', compact('pedido'));
    }

    public function mis_pedidos(){
        $user_id = (int)auth()->user()->id;
        $user = User::find($user_id);

        return view('pedidos.mis_pedidos', compact('user'));
    }

    public function pedidos(){
        $pedidos = Pedido::orderBy('id', 'desc')->get();
        return view('pedidos.pedidos', compact('pedidos'));

    }
    public function update(Request $request){
        
        try {
            $id = $request->pedido_id;
            $pedido = Pedido::find($id);
            $pedido->update(['estado' => $request->estado]);

            //Colocar la logica para enviar un email para cada estado
            if($request->estado  == 'preparando'){
                $email_user = $pedido->user->email;
                $correo = new PedidoPreparando($pedido);
                Mail::to($email_user)->send($correo);
            }
            if($request->estado  == 'enviado'){
                $email_user = $pedido->user->email;
                $correo = new PedidoEnviado($pedido);
                Mail::to($email_user)->send($correo);
            }
            if($request->estado  == 'entregado'){
                $email_user = $pedido->user->email;
                $correo = new PedidoEntregado($pedido);
                Mail::to($email_user)->send($correo);
            }
            
            return back()->with('correct', 'Pedido actualizado con éxito!!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Ocurrio un error al actualizar el pedido');
        }
        
    }
    
    //reporte diario de pedidos
    public function reporte_diario(){
        $pedidos = Pedido::orderBy('id', 'desc')->where('fecha', date('Y-m-d'))->get();
        $total   = Pedido::where('fecha', date('Y-m-d'))->sum('costo_total');

        return view('reporte.diario', compact('pedidos', 'total'));
    }

    //reporte mes de pedios
    public function reporte_mes(){
        $pedidos = Pedido::orderBy('id', 'desc')->whereMonth('fecha', date('m'))->get(); 
        $total   = Pedido::whereMonth('fecha', date('m'))->sum('costo_total'); 

        return view('reporte.mes', compact('pedidos', 'total'));
    }

    //reporte del año
    public function reporte_year(){
        $pedidos = Pedido::orderBy('id', 'desc')->whereYear('fecha', date('Y'))->get(); 
        $total   = Pedido::whereYear('fecha', date('Y'))->sum('costo_total'); 

        return view('reporte.year', compact('pedidos', 'total'));
    }

    //reporte personalizado
    public function reporte_personalizado(){
        
        $fecha_inicio = date('Y-m-d');
        $fecha_fin    = date('Y-m-d');
        $pedidos = Pedido::orderBy('id', 'desc')->whereBetween('fecha', [$fecha_inicio, $fecha_fin])->get();
        $total = Pedido::whereBetween('fecha', [$fecha_inicio, $fecha_fin])->sum('costo_total');

        return view('reporte.personalizado' , compact('pedidos', 'total'));
    }

    public function reporte(Request $request){
        $fecha_inicio = $request->fechainicio;
        $fecha_fin    = $request->fechafin;
        $pedidos = Pedido::orderBy('id', 'desc')->whereBetween('fecha', [$fecha_inicio, $fecha_fin])->get();
        $total = Pedido::whereBetween('fecha', [$fecha_inicio, $fecha_fin])->sum('costo_total');

        return view('reporte.personalizado' , compact('pedidos', 'total'));
    }
    
}
