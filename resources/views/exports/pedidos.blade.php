<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>FECHA</th>
        <th>CLIENTE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pedidos as $ped)
        <tr>
            <td>{{ $ped->id }}</td>
            <td bgcolor="yellow">{{ $ped->fecha }}</td>
            <td>{{ $ped->cliente->nombre_completo }} - {{ $ped->cliente->telefono }}</td>
        </tr>
    @endforeach
    </tbody>
</table>