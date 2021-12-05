<html>
<head>
    <title>Data Saksi / Tersangka</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    @include('pdf.style')
</head>
<body>

<img src="{{ public_path('/images/header.png') }}" alt="Logo" height="80px"/>
<center>
    <h5 class="text-primary mt-2">Data Saksi / Tersangka</h5>
</center>


<img src="{{ public_path($biodata->photo) }}" alt="Logo" height="120px"/>

<div class="title">Identitas</div>
<table class="table-style-one">
    <thead>
    <tr>
        <th width="20px" class="text-center">No</th>
        <th>Label</th>
        <th>Nomor</th>
        <th>Deskripsi</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($identity as $id)
        <tr>
            <td class="text-center">{{ $i++ }}</td>
            <td>{{$id->label}}</td>
            <td>{{$id->number}}</td>
            <td>{{$id->description ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="title">Media Sosial</div>
<table class="table-style-one">
    <thead>
    <tr>
        <th width="20px" class="text-center">No</th>
        <th>Label</th>
        <th>Username</th>
        <th>Link</th>
        <th>Deskripsi</th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($socialMedia as $sc)
        <tr>
            <td class="text-center">{{ $i++ }}</td>
            <td>{{$sc->label}}</td>
            <td>{{$sc->username}}</td>
            <td>{{$sc->link ?: '-'}}</td>
            <td>{{$sc->description ?: '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
