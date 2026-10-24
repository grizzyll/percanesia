<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        $this->ensureOwner($order);

        $order->load('items', 'payment');
        $this->expireIfNeeded($order);

        return view('payment.show', [
            'order' => $order,
            'payment' => $order->payment,
        ]);
    }

    /** Upload bukti transfer. Verifikasinya dilakukan admin (di luar bagian ini). */
    public function uploadProof(Request $request, Order $order)
    {
        $this->ensureOwner($order);

        $order->load('payment');
        $payment = $order->payment;
        $this->expireIfNeeded($order);

        if (! $payment->canUploadProof()) {
            return redirect()->route('payment.show', $order)
                ->with('error', 'Pembayaran ini sudah tidak bisa diubah.');
        }

        $request->validate([
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'proof.required' => 'Pilih file bukti transfer dulu.',
            'proof.mimes' => 'Format file harus JPG, PNG, atau PDF.',
            'proof.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        $payment->update([
            'proof_path' => $path,
            'status' => Payment::MENUNGGU_VERIFIKASI,
        ]);
        $order->update(['status' => Order::MENUNGGU_VERIFIKASI]);

        return redirect()->route('payment.show', $order)
            ->with('success', 'Bukti pembayaran terkirim. Kami akan memverifikasinya secepatnya.');
    }

    protected function ensureOwner(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 403);
    }

    /** Kalau lewat batas waktu dan belum bayar, tandai kedaluwarsa */
    protected function expireIfNeeded(Order $order): void
    {
        $payment = $order->payment;

        if ($payment->status === Payment::PENDING && $payment->isExpired()) {
            $payment->update(['status' => Payment::KEDALUWARSA]);
            $order->update(['status' => Order::DIBATALKAN]);
        }
    }
}
