<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\Course;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $ret['head_pic'] = HeadPicture::query()
            ->where('navigation_id', Navigation::COURSE)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();

        $ret['home_bespock'] = HomeBespockContent::query()
            ->where('navigation_id', Navigation::COURSE)
            ->orderByDesc('id')->first();

        $ret['data'] = Course::query()
            ->where('is_history', 0)
            ->select(['id', 'title', 'summary', 'img_url'])
            ->paginate($request->get('per_page'));

        $ret['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::COURSE)
            ->get();
        return $this->successData($ret);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = Course::query()->where('id', $request->get('id'))->first();
        return $this->successData($data);
    }

}