@extends('layouts.app')

@section('content')
        <section class="content">
            <div class="container-fluid">
                <h1>Ubah Data Barang</h1>
                <hr>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" name="nama" value="{{ old('nama', $barang->nama) }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah"
                            value="{{ old('jumlah', $barang->jumlah) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Barang</label>
                        <input type="number" class="form-control" name="harga" value="{{ old('harga', $barang->harga) }}"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="float: right;">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </form>
            </div>
        </section>
@endsection
