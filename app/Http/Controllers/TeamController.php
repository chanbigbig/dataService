<?php

namespace App\Http\Controllers;


use App\Constant\Navigation;
use App\Models\FootPicture;
use App\Models\HeadPicture;
use App\Models\HomeBespockContent;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $ret['head_pic'] = HeadPicture::query()
            ->where('navigation_id', Navigation::TEAM)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();

        $ret['home_bespock'] = HomeBespockContent::query()
            ->where('navigation_id', Navigation::TEAM)
            ->orderByDesc('id')->first();

        $ret['data'] = Team::query()
            ->select(['id', 'name', 'summary', 'img_url'])
            ->paginate($request->get('per_page'));


        $ret['foot_pic'] = FootPicture::query()
            ->select(['img_url', 'remark'])
            ->orderBy('id')
            ->where('navigation_id', Navigation::TEAM)
            ->get();
        return $this->successData($ret);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = Team::query()->where('id', $request->get('id'))->first();
        return $this->successData($data);
    }

}