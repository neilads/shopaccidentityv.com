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

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\BankAccount;
use App\Models\GameAccount;
use App\Models\ServiceHistory;  // Fix the import here
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\LuckyWheelHistory;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(Request $request): View
    {
        return view('user.profile.profile', [
            'user' => $request->user(),
            'title' => 'Thông tin tài khoản'
        ]);
    }

    public function viewChangePassword(Request $request)
    {
        $title = 'Đổi mật khẩu';
        return view('user.profile.change-password', [
            'user' => $request->user(),
            'title' => $title
        ]);
    }

    /**
     * Handle the password change form submission.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (!Hash::check($value, $request->user()->password)) {
                        $fail('Mật khẩu hiện tại không chính xác.');
                    }
                }
            ],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.change-password')->with('success', 'Mật khẩu đã được cập nhật thành công.');
    }


    public function purchasedAccounts(Request $request)
    {
        $title = 'Tài khoản đã mua';
        $transactions = GameAccount::where('buyer_id', Auth::id())->where('status', 'sold')->paginate(perPage: 10);
        return view('user.profile.purchased-accounts', [
            'user' => $request->user(),
            'transactions' => $transactions,
            'title' => $title
        ]);
    }

    public function servicesHistory(Request $request)
    {
        $title = 'Dịch vụ đã thuê';
        $serviceHistories = ServiceHistory::with(['gameService'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.services-history', [
            'user' => $request->user(),
            'serviceHistories' => $serviceHistories,
            'title' => $title
        ]);
    }

    public function getServiceDetail($id)
    {
        try {
            $service = ServiceHistory::with(['gameService'])
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $service->id,
                'created_at' => $service->created_at,
                'game_service' => [
                    'name' => $service->gameService->name
                ],
                'game_account' => $service->game_account,
                'server' => $service->server,
                'price' => $service->price,
                'status_html' => display_status_service($service->status),
                'admin_note' => $service->admin_note ?? 'Không có ghi chú'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin dịch vụ'
            ], 500);
        }
    }


    

    /**
     * Display the user's lucky wheel history.
     */
    public function luckyWheelHistory(Request $request)
    {
        $title = 'Lịch sử vận may';
        $wheelHistories = LuckyWheelHistory::with('luckyWheel')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.profile.wheels-history', [
            'user' => $request->user(),
            'wheelHistories' => $wheelHistories,
            'title' => $title
        ]);
    }

    /**
     * Get lucky wheel history detail.
     */
    public function getLuckyWheelDetail($id)
    {
        try {
            $history = LuckyWheelHistory::with('luckyWheel')
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'id' => $history->id,
                'created_at' => $history->created_at,
                'lucky_wheel' => [
                    'name' => $history->luckyWheel->name
                ],
                'spin_count' => $history->spin_count,
                'total_cost' => $history->total_cost,
                'reward_type' => $history->reward_type,
                'reward_amount' => $history->reward_amount,
                'description' => $history->description
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tải thông tin vòng quay may mắn'
            ], 500);
        }
    }

}
