
<table class="table-style-one">
    <thead>
    <tr>
        <th class="text-center">No</th>
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
