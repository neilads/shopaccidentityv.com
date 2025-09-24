<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\GameService;
use App\Helpers\UploadHelper;

class ServicesController extends Controller
{
    public function index()
    {
        return view('admin.dich-vu.index');
    }

    public function cayThue()
    {
        $service = GameService::firstOrCreate(
            ['slug' => 'cay-thue'],
            ['name' => 'Cày Thuê', 'thumbnail' => '', 'description' => '', 'type' => 'leveling', 'active' => 1]
        );
        return view('admin.dich-vu.cay-thue', [
            'currentService' => $service
        ]);
    }

    public function choThue()
    {
        $service = GameService::firstOrCreate(
            ['slug' => 'cho-thue'],
            ['name' => 'Cho Thuê', 'thumbnail' => '', 'description' => '', 'type' => 'leveling', 'active' => 1]
        );
        return view('admin.dich-vu.cho-thue', [
            'currentService' => $service
        ]);
    }

    public function napEchoes()
    {
        $service = GameService::firstOrCreate(
            ['slug' => 'nap-echoes'],
            ['name' => 'Nạp Echoes', 'thumbnail' => '', 'description' => '', 'type' => 'leveling', 'active' => 1]
        );
        $identityText = config_get('identity_text', '');
        return view('admin.dich-vu.nap-echoes', [
            'identityText' => $identityText,
            'currentService' => $service
        ]);
    }

    public function updateIdentityText(Request $request)
    {
        $request->validate([
            'identity_text' => 'required|string'
        ]);

        config_set('identity_text', $request->identity_text);
        config_clear_cache();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật nội dung thành công'
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = 'dich-avatar-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/avatars', $filename);
            
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật ảnh đại diện thành công',
                'avatar_url' => Storage::url($path)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật ảnh'
        ]);
    }

    public function updateServiceThumbnail(Request $request)
    {
        $request->validate([
            'scope' => 'required|in:cay-thue,cho-thue,nap-echoes',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $slug = $request->input('scope');
        $defaults = [
            'cay-thue' => ['name' => 'Cày Thuê'],
            'cho-thue' => ['name' => 'Cho Thuê'],
            'nap-echoes' => ['name' => 'Nạp Echoes']
        ];
        $service = GameService::firstOrCreate(
            ['slug' => $slug],
            array_merge($defaults[$slug], ['thumbnail' => '', 'description' => '', 'type' => 'leveling', 'active' => 1])
        );

        $url = UploadHelper::upload($request->file('thumbnail'), 'services/thumbnails');
        $service->thumbnail = $url;
        $service->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật ảnh dịch vụ thành công',
            'thumbnail_url' => $url
        ]);
    }
}
