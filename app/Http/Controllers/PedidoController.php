<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::orderBy('id', 'desc')
                            ->with(["cliente", "productos", "user"])->paginate(10);
        return response()->json($pedidos);
    }

    public function reciboPDF($id){
        $pedido = Pedido::with(["user", "cliente", "productos"])->findOrFail($id);
        $pdf = Pdf::loadView('pdf.recibo', ["data" => $pedido]);
        return $pdf->stream('recibo.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $request->validate([
            "cliente_id" => "required",
            "detalle_pedido" => "required"
        ]);

        // Transaction
        DB::beginTransaction();

        try {
            /*
            {
                cliente_id: 38,
                observacion: "NINGUNO",
                detalle_pedido: [
                    { "producto_id": 3, "cantidad": 1},
                    { "producto_id": 7, "cantidad": 2},
                    { "producto_id": 13, "cantidad": 1},
                    { "producto_id": 40, "cantidad": 4}                    
                ]
            }

            */
            // guardar pedido con cliente
            $usuario = Auth::user();
            // $usuario = $request->user();
            // $usuario_id = Auth::id();
            $pedido = new Pedido();
            $pedido->fecha = date("Y-m-d H:i:s");
            $pedido->estado = 1; // EN PROCESO
            $pedido->observacion = $request->observacion;
            $pedido->user_id = $usuario->id;
            $pedido->cliente_id = $request->cliente_id;
            $pedido->save();
            
            // adicionar productos
            $detalle_pedido = $request->detalle_pedido;
            foreach ($detalle_pedido as $producto) {
                $prod_id = $producto["producto_id"];
                $prod_cantidad = $producto["cantidad"];

                // verificar existencia de stock producto
                // Producto::find($prod_id);
                $pedido->productos()->attach($prod_id, ['cantidad' => $prod_cantidad]);
            }

            $pedido->estado = 2;
            $pedido->update();

            DB::commit();
            // all good
            // respuesta correcta
            return response()->json(["mensaje" => "Pedido Registrado"], 201);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            // respuesta error
            return response()->json(["mensaje" => "ocurrió un error al registrar el pedido", "error" => $e->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
