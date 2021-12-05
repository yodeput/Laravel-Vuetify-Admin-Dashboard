<html>
<head>
    <title>Data Master Kantor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @include('pdf.style')
</head>
<body>

<img src="{{ public_path('/images/header.png') }}" alt="Logo" height="80px"/>
<center>
    <h5 class="text-primary mt-2">Data Master Kantor ID FACE</h5>
</center>

<table width="100%" class="table-style-one">
    <thead>
    <tr>
        <th width="20px" class="text-center">No</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Deskripsi</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($data as $p)
        <tr>
            <td class="text-center">{{ $i++ }}</td>
            <td>{{$p->code}}</td>
            <td>{{$p->name}}</td>
            <td>{{$p->phone ?: '-'}}</td>
            <td>{{$p->address ?: '-'}}</td>
            <td>{{$p->description ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
