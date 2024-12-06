<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PedidoExport implements /*FromCollection*/ FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*
    public function collection()
    {
        return Pedido::all();
    }
    */

    public function view(): View
    {
        return view('exports.pedidos', [
            'pedidos' => Pedido::all()
        ]);
    }

}
