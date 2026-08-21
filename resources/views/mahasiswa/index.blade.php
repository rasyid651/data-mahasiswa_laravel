@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <h1><i class="fa fa-list-ul" style="font-size: 36px;"></i> Data Mahasiswa</h1>
            <hr>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-1">
                <i class="fas fa-plus"></i> Tambah
            </a>
            {{-- Tombol Excel & PDF untuk nanti kalau sudah ada kodenya --}}
            <a href="{{ route('mahasiswa.excel') }}" class="btn btn-success mb-1">
                <i class="fas fa-file-excel"></i> Download Excel
            </a>
            <a href="{{ route('mahasiswa.pdf') }}" class="btn btn-danger mb-1">
                <i class="fas fa-file-pdf"></i> Download PDF
            </a>

            <table id="serverside" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#serverside').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mahasiswa.data') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'no',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'prodi'
                    },
                    {
                        data: 'jk'
                    },
                    {
                        data: 'telepon'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endpush
