<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReadingHistory extends Model
{
    use HasFactory;

    protected $table = 'reading_history';

    protected $fillable = [
        'user_id',
        'book_identifier',
        'book_title',
        'book_author',
        'book_cover',
        'action_type',
        'accessed_at',
    ];

    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the reading history.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get trending books based on time range.
     * 
     * @param int $days Number of days to look back (7, 30, 365)
     * @param int $limit Number of results to return
     * @return \Illuminate\Support\Collection
     */
    public static function getTrending($days = 7, $limit = 12)
    {
        return self::select(
                'book_identifier',
                'book_title',
                'book_author',
                'book_cover',
                DB::raw('COUNT(*) as total_views'),
                DB::raw('COUNT(DISTINCT user_id) as unique_readers'),
                DB::raw('MAX(accessed_at) as last_accessed')
            )
            ->where('action_type', 'viewed')
            ->where('accessed_at', '>=', now()->subDays($days))
            ->groupBy('book_identifier', 'book_title', 'book_author', 'book_cover')
            ->orderBy('total_views', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Save or update reading history for a user.
     */
    public static function trackView($userId, $bookData)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'book_identifier' => $bookData['identifier'],
            ],
            [
                'book_title' => $bookData['title'],
                'book_author' => $bookData['author'],
                'book_cover' => $bookData['cover'],
                'action_type' => 'viewed',
                'accessed_at' => now(),
            ]
        );
    }
}