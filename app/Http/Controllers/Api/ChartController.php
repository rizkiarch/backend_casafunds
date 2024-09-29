<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function barChart()
    {
        $labels = collect(range(1, 12))->map(fn($month) => now()->startOfMonth()->month($month)->format('Y-m'));
        $nameMonth = $labels->map(fn($month) => \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F'));


        $payments = \DB::table('payments')
            ->select(\DB::raw('DATE_FORMAT(payment_date, "%Y-%m") as month,
                           SUM(iuran_kebersihan) as total_kebersihan,
                           SUM(iuran_satpam) as total_satpam,
                           SUM(iuran_kebersihan + iuran_satpam) as total'))
            ->where('payment_date', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total', 'month');

        $spendings = \DB::table('spendings')
            ->select(\DB::raw('DATE_FORMAT(spending_date, "%Y-%m") as month,
                               SUM(amount) as total'))
            ->where('spending_date', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total', 'month');

        $totalPaymentsSum = $payments->sum();
        $totalSpendingsSum = $spendings->sum();

        $nameMonth->push('Total');

        $data = [
            'labels' => $nameMonth,
            'datasets' => [
                [
                    'label' => 'Total Payments',
                    'backgroundColor' => '#3490dc',
                    'data' => $labels->map(fn($month) => $payments->get($month, 0))->concat([$totalPaymentsSum])->toArray()
                ],
                [
                    'label' => 'Total Spendings',
                    'backgroundColor' => '#e3342f',
                    'data' => $labels->map(fn($month) => $spendings->get($month, 0))->concat([$totalSpendingsSum])->toArray()
                ]
            ],
            'totalPayments' => $totalPaymentsSum,
            'totalSpendings' => $totalSpendingsSum,
        ];

        return response()->json([
            'message' => 200,
            'result' => 'ok',
            'data' => $data
        ]);
    }
}
