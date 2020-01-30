<?php

namespace App\Http\Controllers;


use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = About::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}