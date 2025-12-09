<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display trending books and popular books from Internet Archive
     */
    public function index(Request $request)
    {
        // Get time range filter (default: week)
        $range = $request->input('range', 'week');
        
        $days = match($range) {
            'week' => 7,
            'month' => 30,
            'year' => 365,
            default => 7
        };

        // Get trending books from database
        $trendingBooks = ReadingHistory::getTrending($days, 12);

        return view('index', [
            'trendingBooks' => $trendingBooks,
            'currentRange' => $range,
            'error' => null
        ]);
    }

    /**
     * Search books from Internet Archive
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (empty($query)) {
            return redirect('/');
        }

        try {
            $response = Http::timeout(10)->get('https://archive.org/advancedsearch.php', [
                'q' => '(title:(' . $query . ') OR creator:(' . $query . ')) AND mediatype:texts',
                'fl' => 'identifier,title,creator,year,downloads',
                'sort' => 'downloads desc',
                'rows' => 48,
                'page' => 1,
                'output' => 'json'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $books = $data['response']['docs'] ?? [];
                
                return view('search', [
                    'books' => $books,
                    'query' => $query,
                    'total' => count($books),
                    'error' => null
                ]);
            }

            return view('search', [
                'books' => [],
                'query' => $query,
                'total' => 0,
                'error' => 'Gagal mencari buku'
            ]);

        } catch (\Exception $e) {
            Log::error('Search API Error: ' . $e->getMessage());
            
            return view('search', [
                'books' => [],
                'query' => $query,
                'total' => 0,
                'error' => 'Terjadi kesalahan saat mencari. Silakan coba lagi.'
            ]);
        }
    }

    /**
     * Show book detail from Internet Archive and track view
     */
    public function show($id)
    {
        try {
            // Fetch metadata
            $response = Http::timeout(10)->get("https://archive.org/metadata/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract metadata
                $metadata = $data['metadata'] ?? [];
                $files = $data['files'] ?? [];
                
                // Find PDF or EPUB file
                $downloadFile = null;
                foreach ($files as $file) {
                    if (isset($file['format']) && in_array(strtolower($file['format']), ['pdf', 'epub'])) {
                        $downloadFile = $file;
                        break;
                    }
                }

                $book = [
                    'identifier' => $id,
                    'title' => $metadata['title'] ?? 'Tidak ada judul',
                    'creator' => is_array($metadata['creator'] ?? null) 
                        ? implode(', ', $metadata['creator']) 
                        : ($metadata['creator'] ?? 'Unknown'),
                    'year' => $metadata['year'] ?? $metadata['date'] ?? 'N/A',
                    'publisher' => is_array($metadata['publisher'] ?? null)
                        ? implode(', ', $metadata['publisher'])
                        : ($metadata['publisher'] ?? 'Unknown'),
                    'language' => is_array($metadata['language'] ?? null)
                        ? implode(', ', $metadata['language'])
                        : ($metadata['language'] ?? 'Unknown'),
                    'description' => is_array($metadata['description'] ?? null)
                        ? implode(' ', $metadata['description'])
                        : ($metadata['description'] ?? 'Tidak ada deskripsi tersedia.'),
                    'downloads' => $metadata['downloads'] ?? 0,
                    'download_link' => $downloadFile 
                        ? "https://archive.org/download/{$id}/" . ($downloadFile['name'] ?? '')
                        : "https://archive.org/details/{$id}",
                    'detail_link' => "https://archive.org/details/{$id}",
                    'cover' => "https://archive.org/services/img/{$id}"
                ];

                // Track view if user is logged in
                if (Auth::check()) {
                    ReadingHistory::trackView(Auth::id(), [
                        'identifier' => $book['identifier'],
                        'title' => $book['title'],
                        'author' => $book['creator'],
                        'cover' => $book['cover']
                    ]);
                }

                return view('buku', [
                    'book' => $book,
                    'error' => null
                ]);
            }

            return view('buku', [
                'book' => null,
                'error' => 'Buku tidak ditemukan'
            ]);

        } catch (\Exception $e) {
            Log::error('Book Detail API Error: ' . $e->getMessage());
            
            return view('buku', [
                'book' => null,
                'error' => 'Terjadi kesalahan saat memuat detail buku.'
            ]);
        }
    }
}