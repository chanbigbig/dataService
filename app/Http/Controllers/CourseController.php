<?php

namespace App\Http\Controllers;


use App\Models\Course;
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
        return $this->successData($data);
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