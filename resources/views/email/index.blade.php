@extends('layouts.app')

@section('title', 'Kirim Email')

@section('content')
<section class="content">
    <div class="container-fluid">
        <h1><i class="fas fa-envelope"></i> Kirim Email</h1>
        <hr>

        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

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

        <form action="{{ route('email.kirim') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email_penerima" class="form-label">Email Penerima</label>
                <input type="email" class="form-control" name="email_penerima" id="email_penerima"
                       placeholder="Email Penerima" value="{{ old('email_penerima') }}" required>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject"
                       placeholder="Subject" value="{{ old('subject') }}" required>
            </div>

            <div class="mb-3">
                <label for="pesan" class="form-label">Pesan</label>
                <textarea name="pesan" id="pesan" cols="30" rows="10" class="form-control" required>{{ old('pesan') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="float: right;">
                Kirim
            </button>
        </form>
    </div>
</section>
@endsection
