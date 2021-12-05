<html>
<head>
    <title>Data Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @include('pdf.style')
</head>
<body>

<img src="{{ public_path('/images/header.png') }}" alt="Logo" height="80px"/>
<center>
    <h5 class="text-primary mt-2">Data Pengguna ID FACE</h5>
</center>

<table width="100%" class="table-style-one">
    <thead>
    <tr>
        <th width="20px" class="text-center">No</th>
        <th>NIP</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Kantor</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($user as $p)
        <tr>
            <td class="text-center">{{ $i++ }}</td>
            <td>{{$p->nip}}</td>
            <td>{{$p->name}}</td>
            <td>{{$p->email}}</td>
            <td>{{$p->office ? $p->office['name'] : '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
