<?php

namespace App\Services;

class LibraryService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('LIBRARY_API_URL') ?? 'http://localhost:8000/api';
    }

    // --- FITUR BOOKS ---
    public function getBooks(array $params = []): array
    {
        $url = $this->baseUrl . '/books';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $this->fetch($url);
    }

    public function getBook(int $id): array
    {
        $url = $this->baseUrl . '/books/' . $id;
        return $this->fetch($url);
    }

    // --- FITUR MEMBERS (TUGAS MAHASISWA) ---
    // Mengambil semua daftar member
    public function getMembers(array $params = []): array
    {
        $url = $this->baseUrl . '/members';
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return $this->fetch($url);
    }

    // Update data member (PUT)
    public function updateMember(int $id, array $data): array
    {
        $url = $this->baseUrl . '/members/' . $id;
        return $this->fetch($url, 'PUT', $data);
    }

    // Hapus member (DELETE)
    public function deleteMember(int $id): array
    {
        $url = $this->baseUrl . '/members/' . $id;
        return $this->fetch($url, 'DELETE');
    }

    // --- CORE FETCH ENGINE (Updated for PUT/DELETE) ---
    private function fetch(string $url, string $method = 'GET', array $body = []): array
    {
        $ch = curl_init();

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json'
            ],
        ];

        // Mendukung method POST, PUT, dan DELETE
        if ($method !== 'GET') {
            $options[CURLOPT_CUSTOMREQUEST] = $method;
            if (!empty($body)) {
                $options[CURLOPT_POSTFIELDS] = json_encode($body);
            }
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => 'Koneksi ke API Gagal: ' . $error];
        }

        $data = json_decode($response, true);

        // Menangani error dari Laravel 
        if ($httpCode >= 400) {
            return [
                'error' => $data['message'] ?? 'Terjadi kesalahan sistem.',
                'status_code' => $httpCode
            ];
        }

        return $data;
    }
}