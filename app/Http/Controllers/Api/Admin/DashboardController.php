<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public $dashboardService;
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function rentalDetails()
    {
        return $this->dashboardService->rentalDetails();
    }
    public function topCarTypes()
    {
        return $this->dashboardService->topCarTypes();
    }
    public function lastTransaction()
    {
        return $this->dashboardService->lastTransaction();
    }
}
