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
use App\Models\GameAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GameAccountController extends Controller
{
    /**
     * Đường dẫn thư mục lưu ảnh
     */
    private const UPLOAD_DIR = 'accounts';

    public function index()
    {
        $title = 'Danh sách tài khoản game';
        $accounts = GameAccount::with(['buyer'])->orderBy('id', "DESC")->get();
        return view('admin.accounts.index', compact('title', 'accounts'));
    }

    public function create()
    {
        $title = 'Thêm tài khoản game mới';
        return view('admin.accounts.create', compact('title'));
    }

    public function store(Request $request)
    {
        try {
            $files = $request->file('images', []);
            if (is_array($files)) {
                foreach ($files as $idx => $f) {
                    if ($f) {
                        Log::info('Upload image debug (store)', [
                            'index' => $idx,
                            'name' => $f->getClientOriginalName(),
                            'size' => $f->getSize(),
                            'error' => method_exists($f, 'getError') ? $f->getError() : null,
                            'is_valid' => method_exists($f, 'isValid') ? $f->isValid() : null,
                        ]);
                    }
                }
            }
            $request->validate([
                'price' => 'required|numeric|min:0',
                'planet' => 'required|in:earth,namek',
                'note' => 'nullable|string',
                'thumb' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
                'images' => 'nullable|array',
            ]);

            DB::beginTransaction();

            $data = $request->only(['price', 'planet', 'note']);

            // Defaults for required DB columns that are no longer exposed in UI
            $data['account_name'] = 'acc_' . Str::random(8);
            $data['password'] = Str::random(10);
            $data['server'] = 1;
            $data['registration_type'] = 'virtual';
            $data['status'] = 'available';
            $data['earring'] = false;

            // Store thumbnail
            if ($request->hasFile('thumb')) {
                $data['thumb'] = UploadHelper::upload($request->file('thumb'), self::UPLOAD_DIR . '/thumbnails');
            }

            // Store multiple images
            if ($request->hasFile('images')) {
                $imagePaths = [];
                $files = array_filter($request->file('images') ?? [], function ($f) {
                    return $f instanceof \Illuminate\Http\UploadedFile;
                });
                foreach ($files as $index => $image) {
                    if ($image->isValid()) {
                        try {
                            $path = UploadHelper::upload($image, self::UPLOAD_DIR . '/images');
                            $imagePaths[] = $path;
                            Log::info("Successfully uploaded image at index {$index}: {$path}");
                        } catch (\Exception $e) {
                            Log::error("Failed to upload image at index {$index}: " . $e->getMessage());
                        }
                    } else {
                        Log::error("Invalid image at index {$index}: " . $image->getError());
                    }
                }
                if (!empty($imagePaths)) {
                    $data['images'] = json_encode($imagePaths);
                }
            }

            GameAccount::create($data);

            DB::commit();

            return redirect()->route('admin.accounts.index')
                ->with('success', 'Tài khoản game đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating game account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function show(GameAccount $account)
    {
        $title = 'Chi tiết tài khoản game';
        return view('admin.accounts.show', compact('title', 'account'));
    }

    public function edit(GameAccount $account)
    {
        $title = 'Chỉnh sửa tài khoản game';
        return view('admin.accounts.edit', compact('title', 'account'));
    }

    public function update(Request $request, GameAccount $account)
    {
        try {
            $files = $request->file('images', []);
            if (is_array($files)) {
                foreach ($files as $idx => $f) {
                    if ($f) {
                        Log::info('Upload image debug (update)', [
                            'index' => $idx,
                            'name' => $f->getClientOriginalName(),
                            'size' => $f->getSize(),
                            'error' => method_exists($f, 'getError') ? $f->getError() : null,
                            'is_valid' => method_exists($f, 'isValid') ? $f->isValid() : null,
                        ]);
                    }
                }
            }
            $request->validate([
                'price' => 'required|numeric|min:0',
                'planet' => 'required|in:earth,namek',
                'note' => 'nullable|string',
                'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'images' => 'nullable|array',
            ]);

            // Debug: Log the request data
            Log::info('Update account request data:', $request->all());

            DB::beginTransaction();

            $data = $request->only(['price', 'planet', 'note']);
            
            // Debug: Check note field specifically
            Log::info('Note field value:', ['note' => $request->input('note')]);
            Log::info('Note in data array:', ['note' => $data['note'] ?? 'not set']);

            // Handle thumbnail delete/update
            if ($request->input('thumb_delete') === '1' && $account->thumb) {
                UploadHelper::deleteByUrl($account->thumb);
                $data['thumb'] = null;
            } elseif ($request->hasFile('thumb')) {
                // Delete old thumbnail
                if ($account->thumb) {
                    UploadHelper::deleteByUrl($account->thumb);
                }
                $data['thumb'] = UploadHelper::upload($request->file('thumb'), self::UPLOAD_DIR . '/thumbnails');
            }

            // Handle additional images update
            $currentImages = $account->images ? json_decode($account->images, true) : [];
            $imagesToKeep = $currentImages;
            
            // Handle deletion of selected images
            if ($request->filled('images_delete')) {
                $toDelete = $request->input('images_delete', []);
                $imagesToKeep = array_values(array_diff($currentImages, $toDelete));
                foreach ($toDelete as $imgUrl) {
                    UploadHelper::deleteByUrl($imgUrl);
                }
            }

            // Append new uploaded images
            $newImages = array_filter($request->file('images', []), function ($f) {
                return $f instanceof \Illuminate\Http\UploadedFile;
            });
            if (is_array($newImages) && count($newImages) > 0) {
                foreach ($newImages as $index => $image) {
                    if ($image->isValid()) {
                        try {
                            $path = UploadHelper::upload($image, self::UPLOAD_DIR . '/images');
                            $imagesToKeep[] = $path;
                            Log::info("Successfully uploaded image at index {$index}: {$path}");
                        } catch (\Exception $e) {
                            Log::error("Failed to upload image at index {$index}: " . $e->getMessage());
                        }
                    } else {
                        Log::error("Invalid image at index {$index}: " . $image->getError());
                    }
                }
            }

            // Only update images if there are changes
            if ($request->filled('images_delete') || (is_array($newImages) && count($newImages) > 0)) {
                $data['images'] = !empty($imagesToKeep) ? json_encode($imagesToKeep) : null;
            }

            // Debug: Log data before update
            Log::info('Data to update:', $data);
            Log::info('Account before update:', $account->toArray());

            // Always update the account with the provided data
            $result = $account->update($data);
            
            // Debug: Check if update was successful
            Log::info('Update result:', ['success' => $result]);

            // Debug: Log account after update
            $account->refresh();
            Log::info('Account after update:', $account->toArray());
            Log::info('Note field after update:', ['note' => $account->note]);

            DB::commit();

            return redirect()->route('admin.accounts.index')
                ->with('success', 'Tài khoản game đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating game account: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(GameAccount $account)
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($account->thumb) {
                UploadHelper::deleteByUrl($account->thumb);
            }

            // Delete additional images if exists
            if ($account->images) {
                $images = json_decode($account->images, true);
                foreach ($images as $image) {
                    UploadHelper::deleteByUrl($image);
                }
            }

            // Delete the account record
            $account->delete();

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting game account: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tài khoản game: ' . $e->getMessage()
            ]);
        }
    }
}
