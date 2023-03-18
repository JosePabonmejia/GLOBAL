<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'desc')->get();
        return view('categoria.index', compact('categorias'));
    }

    public function save(Request $request)
    {

        //Validar la información enviada por el usuario
        $request->validate([
            'nombre' => 'required'
        ]);

        Categoria::create([
            'nombre' => $request->nombre,
            'estado' => 'activa'
        ]);

        return back()->with('message', 'Categoria creada con éxito');
    }

    //Editar categoria
    public function edit($id)
    {
        //Buscando el registro del id
        $categoria = Categoria::find($id);
        return response()->json($categoria);
    }

    //Guardar la edición
    public function update(Request $request)
    {
        $id = $request->categoria_id;

        try {
            $categoria = Categoria::find($id);
            $categoria->nombre = $request->nombre_categoria;
            $categoria->estado = 'activa';
            $categoria->save();
            return back()->with('message', 'Categoria actualizada con éxito');
        } catch (\Throwable $th) {
            return back()->with('message', 'Error al actualizar la categoria');
        }
    }

    //Cambiar estado de categoria
    public function change_status($id)
    {
        $categoria = Categoria::find($id);

        //desactivar los productos que estan asociados a esa categoria
        foreach ($categoria->productos as $item) {
            $product = Product::find($item->id);
            $product->estado = 'inactivo';
            $product->save();
        }

        if ($categoria->estado == 'activa') {
            $categoria->estado = 'inactiva';
            $categoria->save();
        } else {
            $categoria->estado = 'activa';
            $categoria->save();
        }
        return back();
    }

    public function delete($id){
        try {
            $categoria = Categoria::find($id);
            $categoria->delete();
            return back();
        } catch (\Throwable $th) {
            return response()->json('error');
        }
    }
}
