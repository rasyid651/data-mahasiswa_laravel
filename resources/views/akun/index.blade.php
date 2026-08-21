@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h1><i class='fas fa-clipboard-list' style='font-size:36px'></i> Data Akun</h1>
            <hr>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Tombol Tambah hanya muncul untuk admin (level 1) --}}
            @if (Auth::user()->level == 1)
                <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#modalTambah">
                    Tambah
                </button>
            @endif

            <table id="example" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_akun as $akun)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $akun->nama }}</td>
                            <td>{{ $akun->username }}</td>
                            <td>{{ $akun->email }}</td>
                            <td>Password Dienkripsi</td>
                            <td class="text-center">
                                {{-- Tombol Ubah (untuk semua user, tapi data dibatasi) --}}
                                <button type="button" class="btn btn-success mb-1 btn-edit" data-id="{{ $akun->id_akun }}"
                                    data-nama="{{ $akun->nama }}" data-username="{{ $akun->username }}"
                                    data-email="{{ $akun->email }}" data-level="{{ $akun->level }}" data-toggle="modal"
                                    data-target="#modalUbah">
                                    <i class="fas fa-edit"></i> Ubah
                                </button>

                                {{-- Tombol Hapus hanya untuk admin --}}
                                @if (Auth::user()->level == 1)
                                    <button type="button" class="btn btn-danger mb-1 btn-hapus"
                                        data-id="{{ $akun->id_akun }}" data-nama="{{ $akun->nama }}" data-toggle="modal"
                                        data-target="#modalHapus">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- ============ MODAL TAMBAH (hanya admin) ============ --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('akun.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Akun</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required minlength="3">
                    </div>
                    <div class="mb-3">
                        <label>Level</label>
                        <select name="level" class="form-control" required>
                            <option value="">-- Pilih level --</option>
                            <option value="1">Admin</option>
                            <option value="2">Operator Barang</option>
                            <option value="3">Operator Mahasiswa</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL UBAH (global, diisi via JS) ============ --}}
    <div class="modal fade" id="modalUbah" tabindex="-1">
        <div class="modal-dialog">
            <form id="formUbah" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Ubah Akun</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                        <input type="password" name="password" class="form-control" minlength="3">
                    </div>

                    {{-- Dropdown level hanya muncul untuk admin --}}
                    @if (Auth::user()->level == 1)
                        <div class="mb-3">
                            <label>Level</label>
                            <select name="level" id="edit_level" class="form-control" required>
                                <option value="1">Admin</option>
                                <option value="2">Operator Barang</option>
                                <option value="3">Operator Mahasiswa</option>
                            </select>
                        </div>
                    @else
                        {{-- Non-admin: level dikirim hidden, tidak bisa diubah --}}
                        <input type="hidden" name="level" id="edit_level_hidden">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============ MODAL HAPUS (global, hanya admin) ============ --}}
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Hapus Akun</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus akun: <b id="hapus_nama"></b> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="formHapus" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // DataTables
            if ($("#example").length) $("#example").DataTable();

            // Isi data ke modal Ubah
            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                $('#edit_nama').val($(this).data('nama'));
                $('#edit_username').val($(this).data('username'));
                $('#edit_email').val($(this).data('email'));

                // Set action form ke /akun/{id}
                $('#formUbah').attr('action', '/akun/' + id);

                @if (Auth::user()->level == 1)
                    // Admin: dropdown level aktif
                    $('#edit_level').val($(this).data('level'));
                @else
                    // Non-admin: level dikirim hidden
                    $('#edit_level_hidden').val($(this).data('level'));
                @endif
            });

            // Isi data ke modal Hapus
            $('.btn-hapus').on('click', function() {
                const id = $(this).data('id');
                $('#hapus_nama').text($(this).data('nama'));
                $('#formHapus').attr('action', '/akun/' + id);
            });
        });
    </script>
@endpush
