<?php

namespace App\Http\Controllers;


use App\Models\Tabbar;
use Illuminate\Http\Request;

class TabbarController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = Tabbar::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}