<?php


namespace App\Http\Controllers\Web\Admin\Dashboard;


use Illuminate\Contracts\Foundation\Application;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller {

    /**
     * @return Application|Factory|View
     */
    public function dashboard() {
        return view('admin.dashboard.dashboard');
    }
}
