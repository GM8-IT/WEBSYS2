<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
$sales = Sale::selectRaw('DATE_FORMAT(sale_date, "%b") as month, SUM(amount) as total')
    ->groupBy('month')
    ->orderBy('sale_date')
    ->get();

$labels = $sales->pluck('month');
$data = $sales->pluck('total');

    return view('dashboard', [
        'labels' => $labels,
        'data' => $data
    ]);
}
}


