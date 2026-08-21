<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounselingSession;
use Illuminate\Http\Request;
use App\Exports\CounselingExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CounselingController extends Controller
{
    /**
     * Export data to Excel
     */
    public function export(Request $request)
    {
        $query = CounselingSession::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('identity') && $request->identity != '') {
            $query->where('identity_type', $request->identity);
        }

        $query->latest();

        return Excel::download(new CounselingExport($query), 'data_konseling.xlsx');
    }

    /**
     * Export data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = CounselingSession::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('identity') && $request->identity != '') {
            $query->where('identity_type', $request->identity);
        }

        $sessions = $query->latest()->get();

        $pdf = Pdf::loadView('admin.counseling.pdf', compact('sessions'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('rekap_konseling_' . date('Ymd_His') . '.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CounselingSession::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('identity') && $request->identity != '') {
            $query->where('identity_type', $request->identity);
        }

        $sessions = $query->latest()->paginate(10)->withQueryString();

        return view('admin.counseling.index', compact('sessions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $session = CounselingSession::with('messages')->findOrFail($id);
        return view('admin.counseling.show', compact('session'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $session = CounselingSession::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $session->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function reply(Request $request, string $id)
    {
        $session = CounselingSession::findOrFail($id);

        // Block replies on completed or rejected sessions
        if (in_array($session->status, ['completed', 'rejected'])) {
            return back()->with('error', 'Sesi sudah selesai atau ditolak, tidak bisa membalas.');
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        // Check if this is the first admin reply (before creating the new message)
        $isFirstReply = $session->messages()->where('sender_type', 'konselor')->count() === 0;

        $session->messages()->create([
            'sender_type' => 'konselor',
            'message' => $request->message,
        ]);

        // Auto update status to in_progress if pending
        if ($session->status === 'pending') {
            $session->update(['status' => 'in_progress']);
        }

        // Send Email Notification only on first reply
        if ($isFirstReply && $session->email) {
            try {
                \Illuminate\Support\Facades\Mail::to($session->email)->send(new \App\Mail\CounselingReplyMail($session, $request->message));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Illuminate\Support\Facades\Log::error('Failed to send counseling reply email: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Balasan terkirim.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $session = CounselingSession::findOrFail($id);
        $session->messages()->delete();
        $session->delete();

        return redirect()->route('admin.counseling.index')->with('success', 'Sesi konseling berhasil dihapus.');
    }
}