<?php

namespace App\Http\Controllers;


use App\Models\Advises;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use App\Models\HomeHistory;
use App\Models\HomeShowMedia;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * @return mixed
     */
    public function getHomepageData()
    {
        $data['head_urls'] = HeadPicture::query()
            ->where('type', 0)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();

        $data['home_history'] = HomeHistory::query()->limit(5)->get()->toArray();

        $data['home_bespock'] = HomeBespockContent::query()->orderByDesc('id')->first();

        $media = HomeShowMedia::query()->orderByDesc('id')->first();
        $data['home_show_media']['img_url'] = $media->url . "?vframe/jpg/offset/1";
        $data['home_show_media']['vedio_url'] = $media->url;

        return $this->successData($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function advise(Request $request)
    {
        $requestData = $this->validate($request, [
            'name' => 'required|string|max:128',
            'email' => 'required|email',
            'content' => 'required|string|max:500',
        ], '提交信息有误,请您核对再提交。');

        Advises::query()->create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'content' => $requestData['content'],
        ]);

        return $this->success();
    }
}