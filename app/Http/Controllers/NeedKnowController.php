<?php

namespace App\Http\Controllers;


use App\Models\HeadPicture;
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
            ->where('navigation_id', 5)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['content'] = NeedKnow::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}