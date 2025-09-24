<?php
/**
 * Copyright (c) 2025 FPT University
 * 
 * @author    Phạm Hoàng Tuấn
 * @email     phamhoangtuanqn@gmail.com
 * @facebook  fb.com/phamhoangtuanqn
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // Danh sách user
    public function index()
    {
        $title = 'Danh sách người dùng';
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('title', 'users'));
    }

    public function edit($id)
    {
        $title = 'Sửa người dùng #' . $id;
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('title', 'user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|in:member,admin',
                'banned' => 'required|in:0,1'
            ], [
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã được sử dụng',
                'role.required' => 'Vai trò không được để trống',
                'role.in' => 'Vai trò không hợp lệ',
                'banned.required' => 'Trạng thái không được để trống',
                'banned.in' => 'Trạng thái không hợp lệ'
            ]);

            DB::beginTransaction();

            try {
                $user->update([
                    'email' => $validated['email'],
                    'role' => $validated['role'],
                    'banned' => $validated['banned']
                ]);

                DB::commit();
                return redirect()->route('admin.users.index')
                    ->with('success', 'Cập nhật thông tin người dùng thành công!');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin: ' . $e->getMessage());
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Không tìm thấy người dùng hoặc có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        // Prevent deleting own account
        if ($id == auth()->id()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa tài khoản của chính mình!'
                ]);
            }
        }

        $user = User::findOrFail($id);
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành viên thành công!'
            ]);
        }
    }
}
