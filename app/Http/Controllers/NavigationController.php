<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NavigationController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $data = Navigation::query()
            ->where('status', 1)
            ->with(['child','headPic'])
            ->get(['id', 'title', 'des as description', 'content'])
            ->toArray();

        foreach ($data as &$v) {
            $v['head_pic'] = Arr::pluck($v['head_pic'],'img_url');
        }
        unset($v);
        return $this->successData($data);
    }

}