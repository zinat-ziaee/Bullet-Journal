<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        private DashboardService $dashboardService
    ) {
    }

    public function index()
    {
        $collectionId = request('collection_id');

        return view(
            'dashboard.index',
            $this->dashboardService->getData($collectionId)
        );
    }
}