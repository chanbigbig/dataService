<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\About;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data['head_pic'] = HeadPicture::query()
            ->where('navigation_id', Navigation::ABOUT_US)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['content'] = About::query()->orderByDesc('id')->first();

        $data['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::ABOUT_US)
            ->get();
        return $this->successData($data);
    }

}