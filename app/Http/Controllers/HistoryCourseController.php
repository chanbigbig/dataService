<?php

namespace App\Http\Controllers;


use App\Models\HeadPicture;
use App\Models\HistoryCourse;
use Illuminate\Http\Request;

class HistoryCourseController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $ret['data'] = HistoryCourse::query()
            ->select(['id', 'title', 'summary', 'img_url'])
            ->paginate($request->get('per_page'));
        $ret['head_pic'] = HeadPicture::query()
            ->where('navigation_id', 3)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        return $this->successData($ret);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = HistoryCourse::query()
            ->where('id', $request->get('id'))
            ->first();
        return $this->successData($data);
    }

}