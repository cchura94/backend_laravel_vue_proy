<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // /api/producto?page=1&limit=10&q=teclado
        $limit = isset($request->limit)?$request->limit:10;
        $q = $request->q;
        if($q){
            $productos = Producto::where("nombre", "like", "%$q%")
                                    ->orWhere("precio", "like", "%$q%")
                                    ->with(["categoria"])
                                    ->paginate($limit);
        }else{
            $productos = Producto::with(["categoria"])->paginate($limit);
        }

        return response()->json($productos, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required|min:3|max:255",
            "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->categoria_id = $request->categoria_id;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->save();

        return response()->json(["mensaje" => "Producto registrado correctamente"], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::with(["categoria"])->find($id);

        return response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required|min:3|max:255",
            "categoria_id" => "required"
        ]);

        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->categoria_id = $request->categoria_id;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->update();

        return response()->json(["mensaje" => "Producto modificado correctamente"], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
