<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // GET /api/books - Mengambil semua data buku dengan fitur pencarian
    public function index(Request $request)
    {
        $query = Book::query();

        // Fitur pencarian berdasarkan judul atau penulis
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        return BookResource::collection($query->orderBy('title')->get());
    }

    // POST /api/books - Menambah buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:200',
            'author'      => 'required|string|max:150',
            'isbn'        => 'required|string|max:20|unique:books,isbn',
            'category'    => 'nullable|string|max:100',
            'publisher'   => 'nullable|string|max:150',
            'year'        => 'nullable|integer|min:1900|max:2100',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan.',
            'data'    => new BookResource($book),
        ], 201);
    }

    // GET /api/books/{id} - Detail satu buku
    public function show(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new BookResource($book)
        ]);
    }

    // PUT /api/books/{id} - Update data buku (TUGAS MAHASISWA)
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        // Validasi partial update (menggunakan 'sometimes')
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:200',
            'author'      => 'sometimes|required|string|max:150',
            'isbn'        => 'sometimes|required|string|max:20|unique:books,isbn,' . $id,
            'category'    => 'nullable|string|max:100',
            'publisher'   => 'nullable|string|max:150',
            'year'        => 'nullable|integer|min:1900|max:2100',
            'stock'       => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $book->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diperbarui.',
            'data'    => new BookResource($book)
        ], 200);
    }

    // DELETE /api/books/{id} - Hapus buku (TUGAS MAHASISWA)
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku tidak ditemukan.'
            ], 404);
        }

        // Cek stok sebelum hapus (Ketentuan Tugas)
        if ($book->stock > 0) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menghapus! Buku '{$book->title}' masih memiliki stok: {$book->stock}."
            ], 422);
        }

        $title = $book->title;
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => "Buku '{$title}' berhasil dihapus."
        ], 200);
    }
}