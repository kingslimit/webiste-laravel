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

        // trending 
        $trendingBooks = ReadingHistory::getTrending($days, 12);

        return view('index', [
            'trendingBooks' => $trendingBooks,
            'currentRange' => $range,
            'error' => null
        ]);
    }

    /**
     * Search books 
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
     * Show book detail 
     */
    public function show($id)
    {
        try {
            // Fetch
            $response = Http::timeout(10)->get("https://archive.org/metadata/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                
                // Extract 
                $metadata = $data['metadata'] ?? [];
                $files = $data['files'] ?? [];
                

                $downloadLink = "https://archive.org/details/{$id}";
                // ARRAY
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
                'detail_link' => "https://archive.org/details/{$id}",
                'cover' => "https://archive.org/services/img/{$id}"
               ];

                
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

    /**
     * Download Pdf
     */

        public function downloadPdf($id)
{
    try {
       
        $response = Http::timeout(10)->get("https://archive.org/metadata/{$id}");
        
        if (!$response->successful()) {
            return abort(404, 'Buku tidak ditemukan.');
        }

        //array json
        $data = $response->json();
        $files = $data['files'] ?? [];
        $metadata = $data['metadata'] ?? [];
        
        // cari format pdfnya
        $downloadableFile = null;
        $pdfFormats = ['Text PDF', 'PDF', 'pdf', 'Additional Text PDF'];
        foreach ($files as $file) {
            $fileFormat = $file['format'] ?? '';
            
            if (in_array($fileFormat, $pdfFormats)) {
                $downloadableFile = $file;
                break;
            }
        }

        //no found
        if (!$downloadableFile) {
            Log::warning('No PDF file found', [
                'book_id' => $id, 
                'available_formats' => array_column($files, 'format')
            ]);
            return redirect()->back()->with('error', 'File PDF tidak tersedia untuk buku ini.');
        }

        $fileName = $downloadableFile['name'];
        $downloadUrl = "https://archive.org/download/{$id}/{$fileName}";

      // Change pdf file name
        $bookTitle = $metadata['title'] ?? 'Book';
        $bookTitle = preg_replace('/[^A-Za-z0-9\-]/', '_', $bookTitle); 
        $customFileName = substr($bookTitle, 0, 100) . '.pdf'; 


        // log
        Log::info('Proxying PDF download', [
            'book_id' => $id,
            'original_file' => $fileName,
            'custom_name' => $customFileName,
            'url' => $downloadUrl
        ]);

        // history user
        if (Auth::check()) {
            ReadingHistory::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_identifier' => $id,
                ],
                [
                    'action_type' => 'downloaded',
                    'accessed_at' => now(),
                ]
            );
        }

        // Download
        return response()->streamDownload(function() use ($downloadUrl) {
            $stream = Http::timeout(120) 
                         ->withOptions(['stream' => true])
                         ->get($downloadUrl)
                         ->toPsrResponse()
                         ->getBody();
            
            while (!$stream->eof()) {
                echo $stream->read(8192); 
                flush();
            }
        }, $customFileName, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);

    } catch (\Exception $e) {
        Log::error('Download PDF Error', [
            'book_id' => $id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh buku.');
    }
}
}