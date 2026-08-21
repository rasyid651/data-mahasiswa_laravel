<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        return view('email.index');
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'email_penerima' => 'required|email',
            'subject' => 'required|string',
            'pesan' => 'required|string',
        ]);

        try {
            // Kirim email pakai Mail::raw (plain text, lebih reliable)
            Mail::raw($request->pesan, function ($message) use ($request) {
                $message->to($request->email_penerima)
                    ->subject($request->subject)
                    ->from(
                        config('mail.from.address'),
                        config('mail.from.name')
                    );
            });

            // Kalau sampai sini tanpa exception, email sudah terkirim
            Log::info('Email berhasil dikirim ke: '.$request->email_penerima);

            return redirect()->route('email.index')
                ->with('success', 'Email berhasil dikirimkan! Cek inbox atau folder Spam.');

        } catch (Exception $e) {
            Log::error('Email error: '.$e->getMessage());

            return redirect()->route('email.index')
                ->with('error', 'Email gagal dikirimkan! Error: '.$e->getMessage());
        }
    }
}
