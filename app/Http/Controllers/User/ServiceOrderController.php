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
use App\Models\DiscountCode;
use App\Models\ServiceHistory;
use App\Models\GameService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    public function processOrder(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:game_services,id',
            'price' => 'required|numeric|min:0',
            'server' => 'required|integer|min:1|max:13',
            'game_account' => 'required|string|max:50',
            'game_password' => 'required|string|max:50',
            'note' => 'nullable|string|max:500',
            'giftcode' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy thông tin service
        $service = GameService::findOrFail($request->input('service_id'));
        $user = User::findOrFail(auth()->id());

        // Xử lý mã giảm giá
        $finalPrice = $request->input('price');
        $discountAmount = 0;

        // Check for discount code if provided
        if ($request->filled('giftcode')) {
            $discountCode = DiscountCode::where('code', $request->giftcode)
                ->where('is_active', '1')
                ->first();

            if ($discountCode) {
                // Calculate discount
                if ($discountCode->discount_type === 'percentage') {
                    $discountAmount = ($finalPrice * $discountCode->discount_value) / 100;
                    // Apply max discount if set
                    if ($discountCode->max_discount_value && $discountAmount > $discountCode->max_discount_value) {
                        $discountAmount = $discountCode->max_discount_value;
                    }
                } else {
                    $discountAmount = $discountCode->discount_value;
                }

                // Calculate final price
                $finalPrice = $finalPrice - $discountAmount;
                if ($finalPrice < 0) {
                    $finalPrice = 0;
                }
            }
        }


        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            // Tạo lịch sử dịch vụ
            $serviceHistory = ServiceHistory::create([
                'user_id' => auth()->id(),
                'game_service_id' => $request->input('service_id'),
                'game_account' => $request->input('game_account'),
                'game_password' => $request->input('game_password'),
                'server' => $request->input('server'),
                'note' => $request->input('note'),
                'price' => $finalPrice,
                'status' => 'pending',
            ]);


            // Apply discount code if provided
            if ($request->filled('giftcode') && isset($discountCode)) {
                // Update usage count directly in database
                DB::table('discount_codes')
                    ->where('id', $discountCode->id)
                    ->increment('usage_count');

                // Record usage details
                DB::table('discount_code_usages')->insert([
                    'discount_code_id' => $discountCode->id,
                    'user_id' => $user->id,
                    'context' => 'service',
                    'item_id' => $serviceHistory->id,
                    'original_price' => $request->input('price'),
                    'discounted_price' => $finalPrice,
                    'discount_amount' => $discountAmount,
                    'used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return back()->with('success', 'Đặt dịch vụ thành công. Chúng tôi sẽ xử lý trong thời gian sớm nhất.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }
}
