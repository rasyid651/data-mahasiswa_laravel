@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<section class="content">
    <div class="container-fluid pb-5">
        <h1>Data {{ $mahasiswa->nama }}</h1>
        <hr>

        <table class="table table-bordered table-striped">
            <tr><td width="30%">Nama</td><td>{{ $mahasiswa->nama }}</td></tr>
            <tr><td>Prodi</td><td>{{ $mahasiswa->prodi }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>{{ $mahasiswa->jk }}</td></tr>
            <tr><td>Telepon</td><td>{{ $mahasiswa->telepon }}</td></tr>
            <tr><td>Alamat</td><td>{!! $mahasiswa->alamat !!}</td></tr>
            <tr><td>Email</td><td>{{ $mahasiswa->email }}</td></tr>
            <tr>
                <td>Foto</td>
                <td>
                    @if ($mahasiswa->foto)
                        <a href="{{ asset('assets/img/' . $mahasiswa->foto) }}" target="_blank">
                            <img src="{{ asset('assets/img/' . $mahasiswa->foto) }}" alt="foto" width="50%">
                        </a>
                    @else
                        <i class="text-muted">Tidak ada foto</i>
                    @endif
                </td>
            </tr>
        </table>

        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm" style="float:right;">Kembali</a>
    </div>
</section>
@endsection
