<?php

namespace App\Http\Controllers;


use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use App\Models\HomeHistory;
use App\Models\HomeShowMedia;

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

        $data['home_history'] = HomeHistory::query()
            ->limit(5)
            ->get()->toArray();

        $data['home_bespock'] = HomeBespockContent::query()
            ->orderByDesc('id')
            ->first();
        $media = HomeShowMedia::query()->orderByDesc('id')->first();

        $data['home_show_media']['img_url'] = '';
        $data['home_show_media']['vedio_url'] = $media->url;

        return $this->successData($data);
    }

}