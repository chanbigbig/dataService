<?php

namespace App\Http\Controllers;


use App\Models\About;
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
            ->where('navigation_id', 7)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['content'] = About::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}