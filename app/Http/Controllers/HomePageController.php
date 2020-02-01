<?php

namespace App\Http\Controllers;


use App\Models\Advises;
use App\Models\Course;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use App\Models\HomeHistory;
use App\Models\HomeShowMedia;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    /**
     * @return mixed
     */
    public function getHomepageData()
    {
        $data['head_urls'] = HeadPicture::query()
            ->where('navigation_id', 1)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();

        $data['home_history'] = HomeHistory::query()->limit(5)->get()->toArray();

        $data['home_bespock'] = HomeBespockContent::query()->orderByDesc('id')->first();

        $data['course_list'] = Course::query()
            ->select(['id', 'title', 'summary', 'img_url'])
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $media = HomeShowMedia::query()
            ->select(['show_media_url', 'problem', 'url as vedio_url', 'img_url'])
            ->orderByDesc('id')->first();
        if ($media) {
            $data['home_show_media'] = $media->toArray();
            $search = ["\r\n", "\r", "\n"];
            $replace = '<br/>';
            $replaceResult = str_replace($search, $replace, $data['home_show_media']['problem']);
            $data['home_show_media']['problem'] = $replaceResult;
        }
        if (!is_null($media->img_url) && strlen(trim($media->img_url)) > 0) {
            $data['home_show_media']['img_url'] = $media->img_url;
        } else {
            $data['home_show_media']['img_url'] = $media->vedio_url . "?vframe/jpg/offset/1";
        }

        return $this->successData($data);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function advise(Request $request)
    {
        $requestData = $this->validate($request, [
            'name' => 'required|string|max:128',
            'email' => 'required|email',
            'content' => 'required|string|max:500',
        ], '提交信息有误,请您核对再提交。');

        Advises::query()->create([
            'name' => $requestData['name'],
            'email' => $requestData['email'],
            'content' => $requestData['content'],
        ]);

        return $this->success();
    }
}