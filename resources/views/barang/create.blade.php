@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h1>Tambah Data Barang</h1>
            <hr>

            {{-- Validasi Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" value="{{ old('jumlah') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Barang</label>
                    <input type="number" class="form-control" name="harga" value="{{ old('harga') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="float: right;">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </form>
        </div>
    </section>
@endsection
