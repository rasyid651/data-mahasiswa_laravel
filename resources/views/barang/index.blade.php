@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">Dashboard</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Data Barang</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Grafik --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary"><h3 class="card-title">Grafik Harga Barang</h3></div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:300px;">
                            <canvas id="hargaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Data --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Data Barang</h3></div>
                    <div class="card-body">
                        <a href="{{ route('barang.create') }}" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah Barang</a>
                        <button type="button" class="btn btn-success btn-sm px-3 py-2 mb-2" data-toggle="modal" data-target="#modalFilter">
                            <i class="fas fa-search"></i> Filter Data
                        </button>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th><th>Nama</th><th>Jumlah</th><th>Harga</th>
                                        <th>Barcode</th><th>Tanggal</th><th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_barang as $barang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $barang->nama }}</td>
                                        <td>{{ $barang->jumlah }}</td>
                                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <svg class="barcode"
                                                jsbarcode-value="{{ $barang->barcode }}"
                                                jsbarcode-format="CODE128"
                                                jsbarcode-width="2"
                                                jsbarcode-height="30"
                                                jsbarcode-displayvalue="false">
                                            </svg>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($barang->tanggal)->format('d/m/Y | H:i:s') }}</td>
                                        <td width="20%" class="text-center">
                                            <a href="{{ route('barang.edit', $barang->id_barang) }}" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                                            <form action="{{ route('barang.destroy', $barang->id_barang) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-2 justify-content-end d-flex">
                            {{ $data_barang->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal Filter Tanggal --}}
<div class="modal fade" id="modalFilter" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('barang.index') }}" method="GET">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-search"></i> Filter Data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                    <button type="submit" class="btn btn-success btn-sm" name="filter" value="1">Cari Tanggal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- Menambahkan JS khusus halaman ini menggunakan @push --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        JsBarcode(".barcode").init();

        const canvas = document.getElementById("hargaChart");
        if (canvas) {
            new Chart(canvas, {
                type: "bar",
                data: {
                    labels: @json($namaBarang),
                    datasets: [{
                        label: "Harga Barang",
                        data: @json($hargaBarang),
                        backgroundColor: ["#007bff", "#28a745", "#ffc107", "#dc3545"],
                        borderRadius: 8
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        }
    });
</script>
@endpush
