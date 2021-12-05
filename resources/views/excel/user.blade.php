<table class="table-style-one">
    <thead>
    <tr>
        <th><b>No</b></th>
        <th><b>NIP</b></th>
        <th><b>Nama</b></th>
        <th><b>Email</b></th>
        <th><b>Kantor</b></th>
    </tr>
    </thead>
    <tbody>
    @php $i=1 @endphp
    @foreach($user as $p)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{$p->nip}}</td>
            <td>{{$p->name}}</td>
            <td>{{$p->email}}</td>
            <td>{{$p->office ? $p->office['name'] : '-'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
