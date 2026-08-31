<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CounselingSession;
use Illuminate\Support\Str;

class CounselingController extends Controller
{
    public function mode()
    {
        return view('public.counseling.mode');
    }

    public function identity()
    {
        return view('public.counseling.identity');
    }

    public function create($type)
    {
        if (!in_array($type, ['anonymous', 'open'])) {
            abort(404);
        }
        return view('public.counseling.form', compact('type'));
    }

    public function store(Request $request)
    {   
        $request->validate([
            'identity_type'     => 'required|in:anonymous,open',
            'issue_description' => 'required|string|max:2000',
            'name'              => 'required_if:identity_type,open|nullable|string|max:255',
            'email'             => 'required_if:identity_type,open|nullable|email|max:255',
            'phone_number'      => 'required_if:identity_type,open|nullable|string|max:20',
            'user_status'       => 'required_if:identity_type,open|nullable|string|max:255',
            'employee_id'       => 'required_if:identity_type,open|nullable|string|max:255',
            'rumpun'            => 'required_if:identity_type,open|nullable|string|max:255',
            'prodi'             => 'required_if:identity_type,open|nullable|string|max:255',
            'topic'             => 'required|string',
            'duration'          => 'required|string',
        ]);

        $user = auth()->user();

        $counseling = CounselingSession::create([
            'identity_type'     => $request->identity_type,
            'name'              => $request->identity_type === 'open' ? $request->name : null,
            'email'             => $request->identity_type === 'open' ? ($request->email ?? ($user ? $user->email : null)) : ($user ? $user->email : null),
            'phone_number'      => $request->identity_type === 'open' ? $request->phone_number : null,
            'user_status'       => $request->identity_type === 'open' ? $request->user_status : null,
            'employee_id'       => $request->identity_type === 'open' ? $request->employee_id : null,
            'division'          => $request->identity_type === 'open' ? $request->rumpun : null,
            'jabatan'           => $request->identity_type === 'open' ? $request->prodi : null,
            'topic'             => $request->topic,
            'duration'          => $request->duration,
            'issue_description' => $request->issue_description,
            'status'            => 'pending',
        ]);

        return redirect()->route('counseling.confirmation', ['code' => $counseling->tracking_code]);
    }

    public function confirmation($code)
    {
        $session = CounselingSession::where('tracking_code', $code)->firstOrFail();
        return view('public.counseling.confirmation', compact('session'));
    }

    public function chat($code)
    {
        $session = CounselingSession::where('tracking_code', $code)->firstOrFail();
        return view('public.counseling.chat', compact('session'));
    }

    public function sendMessage(Request $request, $code)
    {
        $session = CounselingSession::where('tracking_code', $code)->firstOrFail();

        // Block messages on completed sessions
        if ($session->status === 'completed') {
            return response()->json(['error' => 'Sesi sudah selesai.'], 403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $session->messages()->create([
            'sender_type' => 'user',
            'message' => $request->message,
        ]);

        return response()->json($message);
    }

    public function getMessages($code)
    {
        $session = CounselingSession::where('tracking_code', $code)->firstOrFail();
        return response()->json($session->messages);
    }
}