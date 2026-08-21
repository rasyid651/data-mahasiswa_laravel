@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1>Tambah Data Mahasiswa</h1>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
            </div>

            <div class="row">
                <div class="mb-3 col-6">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi" class="form-control" required>
                        <option value="">-- pilih Prodi --</option>
                        <option value="Teknik Informatika" {{ old('prodi')=='Teknik Informatika'?'selected':'' }}>Teknik Informatika</option>
                        <option value="Teknik Mesin" {{ old('prodi')=='Teknik Mesin'?'selected':'' }}>Teknik Mesin</option>
                        <option value="Teknik Listrik" {{ old('prodi')=='Teknik Listrik'?'selected':'' }}>Teknik Listrik</option>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jk" class="form-control" required>
                        <option value="">-- Jenis Kelamin --</option>
                        <option value="laki-laki" {{ old('jk')=='laki-laki'?'selected':'' }}>Laki-Laki</option>
                        <option value="perempuan" {{ old('jk')=='perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="number" class="form-control" name="telepon" value="{{ old('telepon') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" onchange="previewImg()">
                <img src="" class="img-thumbnail img-preview mt-2" alt="" width="100px" style="display:none;">
            </div>

            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary" style="float:right;">
                <i class="fa fa-plus"></i> Tambah
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script>
    // Inisialisasi CKEditor untuk textarea alamat
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('alamat');
    }

    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');
        if (foto.files && foto.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            };
            reader.readAsDataURL(foto.files[0]);
        }
    }
</script>
@endpush
@endsection
