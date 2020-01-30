<?php

namespace App\Http\Controllers;


use App\Models\NeedKnow;
use Illuminate\Http\Request;

class NeedKnowController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = NeedKnow::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}