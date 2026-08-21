@extends('layouts.app')

@section('title', 'Ubah Mahasiswa')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1>Ubah Data Mahasiswa</h1>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.update', $mahasiswa->id_mahasiswa) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="fotoLama" value="{{ $mahasiswa->foto }}">

            <div class="mb-3">
                <label class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
            </div>

            <div class="row">
                <div class="mb-3 col-6">
                    <label class="form-label">Program Studi</label>
                    <select name="prodi" class="form-control" required>
                        @foreach (['Teknik Informatika','Teknik Mesin','Teknik Listrik'] as $p)
                            <option value="{{ $p }}" {{ old('prodi', $mahasiswa->prodi)==$p?'selected':'' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jk" class="form-control" required>
                        <option value="laki-laki" {{ old('jk', $mahasiswa->jk)=='laki-laki'?'selected':'' }}>Laki-Laki</option>
                        <option value="perempuan" {{ old('jk', $mahasiswa->jk)=='perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="number" class="form-control" name="telepon" value="{{ old('telepon', $mahasiswa->telepon) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat">{{ old('alamat', $mahasiswa->alamat) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $mahasiswa->email) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" onchange="previewImg()">
                <img src="{{ $mahasiswa->foto ? asset('assets/img/' . $mahasiswa->foto) : '' }}"
                     class="img-thumbnail img-preview mt-2"
                     alt="" width="100px"
                     style="{{ $mahasiswa->foto ? '' : 'display:none;' }}">
            </div>

            <div class="d-flex justify-content-end mt-4 mb-2">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
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
