<?php $no = 1; ?>
@foreach ($data_pegawai as $pegawai)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $pegawai->nama }}</td>
        <td>{{ $pegawai->jabatan }}</td>
        <td>{{ $pegawai->email }}</td>
        <td>{{ $pegawai->telepon }}</td>
        <td>{{ $pegawai->alamat }}</td>
    </tr>
@endforeach
