<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use App\Models\HistoryCourse;
use App\Models\HomeBespockContent;
use Illuminate\Http\Request;

class HistoryCourseController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {

        $ret['head_pic'] = HeadPicture::query()
            ->where('navigation_id', 3)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();

        $ret['home_bespock'] = HomeBespockContent::query()
            ->where('navigation_id', Navigation::OLD_COURSE)
            ->orderByDesc('id')->first();


        $ret['data'] = HistoryCourse::query()
            ->select(['id', 'title', 'summary', 'img_url'])
            ->paginate($request->get('per_page'));

        $ret['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::OLD_COURSE)
            ->get();

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