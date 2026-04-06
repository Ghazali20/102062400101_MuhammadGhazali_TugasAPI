<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Resources\MemberResource;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // GET /api/members - Daftar semua member dengan fitur pencarian dan filter status
    public function index(Request $request)
    {
        $query = Member::query(); 

        // Filter berdasarkan status (active, inactive, suspended)
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Cari berdasarkan nama atau kode member
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('member_code', 'like', '%' . $request->search . '%');
        }

        return MemberResource::collection($query->orderBy('name')->get());
    }

    // POST /api/members - Daftar member baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:150',
            'member_code' => 'required|string|max:20|unique:members,member_code',
            'email'       => 'required|email|unique:members,email',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'status'      => 'nullable|in:active,inactive,suspended',
            'joined_at'   => 'nullable|date',
        ]);

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil didaftarkan.',
            'data'    => new MemberResource($member),
        ], 201);
    }

    // GET /api/members/{id} - Detail satu member
    public function show(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new MemberResource($member)
        ]);
    }

    // PUT /api/members/{id} - Update data member (TUGAS MAHASISWA)
    public function update(Request $request, string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.'
            ], 404);
        }

        // Validasi field unik dan partial update
        $validated = $request->validate([
            'name'        => 'sometimes|required|string|max:150',
            'member_code' => 'sometimes|required|string|max:20|unique:members,member_code,' . $id,
            'email'       => 'sometimes|required|email|unique:members,email,' . $id,
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'status'      => 'nullable|in:active,inactive,suspended',
            'joined_at'   => 'nullable|date',
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil diperbarui.',
            'data'    => new MemberResource($member)
        ], 200);
    }

    // DELETE /api/members/{id} - Hapus member (TUGAS MAHASISWA)
    public function destroy(string $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak ditemukan.'
            ], 404);
        }

        // Tolak penghapusan jika status "active" (Ketentuan Tugas)
        if ($member->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => "Gagal menghapus! Member '{$member->name}' masih berstatus active."
            ], 422);
        }

        $name = $member->name;
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => "Member '{$name}' berhasil dihapus."
        ], 200);
    }
}