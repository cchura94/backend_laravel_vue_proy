<style>
    .container{
        width: 80%;
        max-height: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 16px;
        color: #333;
    }

    .header{
        text-align: center;
        margin-bottom: 20px;
    }
    .header h2{
        margin: 0;
        font-size: 24px;
        color: #0077ff;
    }

    .header p{
        margin: 5px 0;
        font-size: 14px;
        color: #555;
    }
    .section {
        margin-bottom: 20px;
    }

    .section-titulo{
        font-weight: bold;
        margin-bottom: 5px;
    }

    .section-contenido{
        font-size: 14px;
        color: #555;
    }

    .tabla-productos{
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .tabla-productos th, .tabla-productos td{
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

</style>
<div class="container">

    <div class="header">
        <h2>Recibo de Venta</h2>
        <p>Fecha: {{ $data->fecha }}</p>
        <p>Pedido: {{ $data->id }}</p>

    </div>

    <div class="section">
        <div class="section-titulo">Cliente</div>
        <div class="section-contenido">{{ $data->cliente->nombre_completo }}</div>
    </div>

    <div class="section">
    <div class="section-titulo">Atendido Por</div>
        <div class="section-contenido">{{ $data->user->email }}</div>
    </div>

    <div class="section">
        <div class="section-titulo">Recibo de Pedido</div>
        <table class="tabla-productos">
            <thead>
                <tr>
                    <th>COD</th>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->productos as $prod)
                <tr>
                    <td>{{$prod->id }}</td>
                    <td>{{$prod->nombre}}</td>
                    <td>{{$prod->pivot->cantidad}}</td>
                    <td>{{$prod->precio}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>