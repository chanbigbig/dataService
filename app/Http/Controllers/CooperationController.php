<?php

namespace App\Http\Controllers;


use App\Models\Cooperation;
use App\Models\HeadPicture;
use Illuminate\Http\Request;

class CooperationController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data['head_pic'] = HeadPicture::query()
            ->where('navigation_id', 6)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        $data['content'] = Cooperation::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}