<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact'); // file blade yang barusan kamu pakai
    }

    public function store(Request $request): RedirectResponse
    {
        // Honeypot anti-bot: kalau terisi, anggap spam & sukses palsu
        if (filled($request->string('website'))) {
            return back()->with('ok', 'Terima kasih!'); 
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
            // consent opsional
            'consent' => ['sometimes', 'accepted'],
        ]);

        $data['consent']    = $request->boolean('consent');
        $data['ip']         = $request->ip();
        $data['user_agent'] = (string) $request->userAgent();

        // 1) Simpan ke DB (pasti dilakukan)
        ContactMessage::create($data);

        // 2) (OPSIONAL) Notifikasi: aman-kan supaya tidak bikin timeout
        //    Untuk dev: set MAIL_MAILER=log agar tidak konek SMTP beneran.
        try {
            // Contoh minimal: tulis log saja (tidak ada network call).
            Log::info('New contact message', $data);

            // Kalau ingin email nanti, gunakan queue:
            // Mail::to(config('mail.from.address'))->queue(new \App\Mail\ContactMessageMail($data));
            // Pastikan queue worker jalan sebelum mengaktifkan kode di atas.
        } catch (\Throwable $e) {
            Log::warning('Contact notification failed: '.$e->getMessage());
        }

        return to_route('contact')->with('ok', 'Pesan berhasil dikirim. Terima kasih! 🙌');
    }
}
