<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categorias  = Categoria::all();
        return view('products.create', compact('categorias'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'details' => 'required',
            'price' => 'required',
            'shipping_cost' => 'required',
            'image_path' => 'required',
        ]);

        $producto = new Product();
        $producto->name = $request->name;
        $producto->category_id = $request->category_id;
        $producto->brand_id = 1;
        $producto->slug = $request->slug;
        $producto->details = $request->details;
        $producto->price = $request->price;
        $producto->shipping_cost = $request->shipping_cost;
        $producto->description = $request->description;
        $producto->estado = 'disponible';
        if ($request->hasFile('image_path')) {
            $imagen = $request->file('image_path');
            //Obtener el nombre del archivo de la imagen
            $nombre_imagen = $imagen->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            $imagen_definitiva = Storage::disk('images')->put($nombre_imagen, File::get($imagen));
        }

        $producto->image_path = $nombre_imagen;
        $producto->save();

        return back()->with('message', 'Producto creado con éxito!!!');
    }

    public function editar($id){
        $producto = Product::find($id);
        $categorias = Categoria::all();
        return view('products.edit', compact('producto', 'categorias'));
    }

     //sacar imagen del producto
     public function getImage($filename){

        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function update(Request $request){
        $producto = Product::find($request->producto_id);
        try {
            $request->validate([
                'name' => 'required',
                'slug' => 'required',
                'details' => 'required',
                'price' => 'required',
                'shipping_cost' => 'required',
                'image_path' => 'required',
            ]);

            
            $producto->name = $request->name;
            $producto->category_id = $request->category_id;
            $producto->brand_id = 1;
            $producto->slug = $request->slug;
            $producto->details = $request->details;
            $producto->price = $request->price;
            $producto->shipping_cost = $request->shipping_cost;
            $producto->description = $request->description;
            $producto->estado = 'disponible';

            if ($request->hasFile('image_path')) {
                $imagen = $request->file('image_path');
                //Obtener el nombre del archivo de la imagen
                $nombre_imagen = $imagen->getClientOriginalName();
                //indicamos que queremos guardar un nuevo archivo en el disco local
                $imagen_definitiva = Storage::disk('images')->put($nombre_imagen, File::get($imagen));
            }

            //Eliminar imagen del fichero para actualizarla
            Storage::disk('images')->delete($producto->image_path);
    
            $producto->image_path = $nombre_imagen;
            $producto->save();

            return back()->with('message', 'Producto actualizado con éxito!!!');

        } catch (\Throwable $th) {
            return back()->with('message_error', 'Error al actualizar el producto');
        }
    }

    //sacar el detalle del producto
    public function detalle($id){
        $producto = Product::find($id);
        return response()->json($producto);
    }

    //Actualizar el estado del producto
    public function change_status($id){
        $producto = Product::find($id);
        
        if($producto->categoria->estado == 'inactiva'){
            return response()->json('error');
        }else{
            if ($producto->estado == 'disponible') {
                $producto->estado = 'inactivo';
                $producto->save();
            } else {
                $producto->estado = 'disponible';
                $producto->save();
            }
            return back();
        }

    }
}
