<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Product;

use App\Models\DetallePedido;
use Illuminate\Http\Request;

// Envio de emails
use App\Mail\InformacionMailable;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function shop()
    {

        $products = Product::orderBy('id', 'desc')->where('estado', 'disponible')->paginate(6);
        $categorias = Categoria::all();
        $pedidos    = Pedido::latest()->where('estado', 'pendiente')->take(2)->get();
        $count = Pedido::where('estado', 'pendiente')->count();
        return view('shop')->withTitle('E-commerce Tienda')->with(['products' => $products, 'categorias' => $categorias, 'pedidos' => $pedidos, 'count' => $count]);
    }

    //Listar tienda por categoria
    public function shopbycategoria($id){
        $products  = Product::where('category_id', '=', $id)->get();
        $category = Categoria::find($id);
        $categorias = Categoria::all();
        return view('shopbycategoria')->withTitle('E-commerce Tienda')->with(['products' => $products, 'categorias' => $categorias, 'category' => $category]);
    }

    public function cart()  {
        $cartCollection = \Cart::getContent();
        // $categorias = Categoria::all();
        return view('cart')->withTitle('E-commerce Tienda')->with(['cartCollection' => $cartCollection]);;
    }
    
    public function add(Request $request){
      
        \Cart::add([
            'id'    => $request->id,
            'name'  => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->img,
                'slug'  => $request->slug,
            ]
        ]);
        return redirect()->route('cart.index')->with('success_msg', 'Producto agregado');

    }
    public function update(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Carrito actulizado!');
    }
    public function remove(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Producto eliminado!');
    }
    public function clear(){
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Carrito vaciado!');
    }

    public function cheackout(Request $request){
        $login = auth()->user();

        if($login != null){
            $total = \Cart::getTotal();
            $cartCollection = \Cart::getContent();
           
            $request->validate([
                'provincia' => 'required',
                'localidad' => 'required',
                'direccion' => 'required',
                'provincia' => 'required',
                'fecha' => 'required',
            ]);
            
            $pedido = new Pedido();
            $pedido->users_id   = auth()->user()->id; 
            $pedido->provincia = $request->provincia; 
            $pedido->localidad = $request->localidad; 
            $pedido->direccion = $request->direccion; 
            $pedido->costo_total = $total; 
            $pedido->fecha = $request->fecha; 
            $pedido->estado = 'pendiente';
            $pedido->save(); 
    
            foreach($cartCollection as $item){
                $detalle_pedido                 = new DetallePedido();
                $detalle_pedido->pedido_id      = $pedido->id;
                $detalle_pedido->product_id     = $item->id;
                $detalle_pedido->cantidad       = $item->quantity;
                $detalle_pedido->costo_unitario = $item->price;
                $detalle_pedido->subtotal       = $item->quantity * $item->price;
                $detalle_pedido->save();
            }
            $correo = new InformacionMailable;
            Mail::to(auth()->user()->email)->send($correo);

            \Cart::clear();
            return redirect()->route('pedido.detalle', ['id' => $pedido->id])->with('confirmado', 'Tu pedido se realizó con éxito!!!');
            // return  view('pedidos.details', compact(''))
        }else{
            return back()->with('failed', 'Nesesita estar logeado para confirmar su pedido');
        }
    }
   
}
