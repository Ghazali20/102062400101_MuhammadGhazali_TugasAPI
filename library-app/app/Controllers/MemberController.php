<?php

namespace App\Controllers;

use App\Services\LibraryService;

class MemberController extends BaseController
{
    protected LibraryService $library;

    public function __construct()
    {
        $this->library = new LibraryService();
    }

    public function index()
    {
        $result = $this->library->getMembers();
        return view('members/index', [
            'title'   => 'Daftar Member Perpustakaan',
            'members' => $result['data'] ?? [],
            'error'   => $result['error'] ?? null
        ]);
    }

    public function delete(int $id)
    {
        $result = $this->library->deleteMember($id);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        return redirect()->to('/members')->with('success', 'Member berhasil dihapus.');
    }
}