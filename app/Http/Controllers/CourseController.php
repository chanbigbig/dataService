<?php

namespace App\Http\Controllers;


use App\Models\Course;
use App\Models\HeadPicture;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $data = Course::query()
            ->select(['id', 'title', 'summary', 'img_url'])
            ->paginate($request->get('per_page'));
        $headPic = HeadPicture::query()
            ->where('navigation_id', 2)
            ->orderByDesc('id')
            ->get()
            ->pluck('img_url')
            ->toArray();
        $ret = [
            'head_picture' => $headPic,
            'data' => $data,
        ];
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