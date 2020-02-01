<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use App\Models\NeedKnow;
use Illuminate\Http\Request;

class NeedKnowController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data['head_pic'] = HeadPicture::query()
            ->where('navigation_id', Navigation::NEED_KNOW)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['home_bespock'] = HomeBespockContent::query()
            ->where('navigation_id', Navigation::NEED_KNOW)
            ->orderByDesc('id')->first();

        $data['content'] = NeedKnow::query()->orderByDesc('id')->first();

        $data['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::NEED_KNOW)
            ->get();
        return $this->successData($data);
    }

}