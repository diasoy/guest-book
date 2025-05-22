<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorsExport;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalVisitors = Tamu::count();
        $visitorsThisMonth = Tamu::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $visitorsToday = Tamu::whereDate('created_at', Carbon::today())->count();

        $query = Tamu::query();

        $period = $request->input('period', 'all');
        switch ($period) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%");
            });
        }

        $query->latest();

        $perPage = $request->input('perPage', default: 10);
        $visitors = $query->paginate($perPage);

        return view('admin.dashboard', compact(
            'totalVisitors',
            'visitorsThisMonth',
            'visitorsToday',
            'visitors'
        ));
    }

    // Update the laporan method
    public function laporan(Request $request)
    {
        // Get date range from request
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        // Validate dates (ensure start date is before end date)
        if ($startDate->gt($endDate)) {
            return redirect()->back()->with('error', 'Tanggal mulai harus sebelum tanggal akhir');
        }

        // Get all visitor data within date range
        $query = Tamu::query()
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);

        // Apply purpose filter if provided
        if ($request->filled('purpose')) {
            $query->where('keperluan', 'like', '%' . $request->input('purpose') . '%');
        }

        // Get the results
        $visitors = $query->orderBy('created_at', 'desc')->get();

        // Prepare statistics
        $totalVisitors = $visitors->count();
        $dailyAverage = $startDate->diffInDays($endDate) > 0
            ? round($totalVisitors / ($startDate->diffInDays($endDate) + 1), 1)
            : $totalVisitors;

        // Group by date for chart
        $visitsByDate = $visitors->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m-d');
        })->map->count();

        $period = new \DatePeriod(
            $startDate,
            new \DateInterval('P1D'),
            $endDate->addDay() // Add a day to include the end date
        );

        // Prepare chart data with all dates in range
        $labels = [];
        $data = [];
        foreach ($period as $date) {
            $dateKey = $date->format('Y-m-d');
            $labels[] = $date->format('d M');
            $data[] = $visitsByDate[$dateKey] ?? 0;
        }

        // Group by purpose (keperluan)
        $visitsByPurpose = $visitors->groupBy('keperluan')
            ->map->count()
            ->sortDesc();

        // Get top 5 purposes
        $topPurposes = $visitsByPurpose->take(5);

        // For export purposes, prepare a list of all purposes
        $allPurposes = Tamu::distinct('keperluan')->pluck('keperluan')->filter();

        return view('admin.laporan', compact(
            'visitors',
            'totalVisitors',
            'dailyAverage',
            'startDate',
            'endDate',
            'labels',
            'data',
            'topPurposes',
            'allPurposes'
        ));
    }

    public function exportLaporan(Request $request)
    {
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::now()->endOfDay();

        $query = Tamu::query()
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);

        if ($request->filled('purpose')) {
            $query->where('tujuan', 'like', '%' . $request->input('purpose') . '%');
        }

        $visitors = $query->orderBy('created_at', 'desc')->get();

        $filename = 'Laporan_Pengunjung_' . $startDate->format('d-m-Y') . '_to_' . $endDate->format('d-m-Y') . '.xlsx';

        return Excel::download(new VisitorsExport($visitors), $filename);
    }
}
