<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $now = now();
        $lastMonth = now()->subMonth();

        $totalBalance = $user->wallets()->sum('balance');
        $monthlyIncome = Transaction::whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
            ->where('type', 'income')->whereMonth('happened_at', $now->month)->whereYear('happened_at', $now->year)->sum('amount');

        $monthlyExpenses = Transaction::whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
            ->where('type', 'expense')->whereMonth('happened_at', $now->month)->whereYear('happened_at', $now->year)->sum('amount');

        $lastMonthlyIncome = Transaction::whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
            ->where('type', 'income')->whereMonth('happened_at', $lastMonth->month)->whereYear('happened_at', $lastMonth->year)->sum('amount');

        $lastMonthlyExpenses = Transaction::whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
            ->where('type', 'expense')->whereMonth('happened_at', $lastMonth->month)->whereYear('happened_at', $lastMonth->year)->sum('amount');

        $calculateTrend = function ($current, $previous) {
            if ($previous <= 0)
                return $current > 0 ? 100 : 0;
            return round((($current - $previous) / $previous) * 100);
        };

        $incomeTrend = $calculateTrend($monthlyIncome, $lastMonthlyIncome);
        $expenseTrend = $calculateTrend($monthlyExpenses, $lastMonthlyExpenses);

        $days = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('d M'));
        $dailyData = collect(range(6, 0))->map(function ($i) use ($user) {
            return Transaction::whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
                ->whereDate('happened_at', '<=', now()->subDays($i))
                ->sum(DB::raw("CASE WHEN type = 'income' THEN amount ELSE -amount END"));
        });

        $recentTransactions = Transaction::with(['wallet', 'tags'])
            ->whereHas('wallet', fn($q) => $q->where('user_id', $user->id))
            ->latest('happened_at')->limit(5)->get();

        return view("index", compact(
            'totalBalance',
            'monthlyIncome',
            'monthlyExpenses',
            'incomeTrend',
            'expenseTrend',
            'recentTransactions',
            'days',
            'dailyData'
        ));
    }
}
