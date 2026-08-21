@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1><i class="fa fa-list-ul" style="font-size: 36px;"></i> Data Pegawai</h1>
        <hr>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                </tr>
            </thead>
            <tbody id="live-data">
                {{-- diisi otomatis oleh AJAX --}}
            </tbody>
        </table>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        getPegawai();
        setInterval(getPegawai, 2000); // realtime tiap 2 detik, persis project lama
    });

    function getPegawai() {
        $.ajax({
            url: "{{ route('pegawai.live') }}",
            type: "GET",
            success: function (response) {
                $('#live-data').html(response);
            }
        });
    }
</script>
@endpush
