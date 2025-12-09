<?php

namespace App\Http\Controllers;

use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display user's reading history
     */
    public function index()
    {
        $history = ReadingHistory::where('user_id', Auth::id())
            ->orderBy('accessed_at', 'desc')
            ->paginate(20);

        return view('history', [
            'history' => $history,
            'total' => $history->total()
        ]);
    }

    /**
     * Remove a book from reading history
     */
    public function destroy($id)
    {
        $history = ReadingHistory::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$history) {
            return back()->with('error', 'History tidak ditemukan');
        }

        $history->delete();

        return back()->with('success', 'Buku berhasil dihapus dari history');
    }

    /**
     * Clear all reading history
     */
    public function clear()
    {
        ReadingHistory::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Semua history berhasil dihapus');
    }
}