<?php
/**
 * Copyright (c) 2025 FPT University
 *
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\GameAccount;
use App\Models\GameService;
 
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index()
    {
        // Tài khoản mới về
        $latestAccounts = GameAccount::where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Dịch vụ cày thuê - chỉ lấy 3 dịch vụ đầu tiên
        $services = GameService::where('active', '1')->orderBy('updated_at', 'desc')->limit(3)->get();


        


        $notifications = Notification::orderBy('created_at', 'desc')->get();

        return view('user.home', compact(
            'latestAccounts',
            'services',
            'notifications'
        ));
    }
}
