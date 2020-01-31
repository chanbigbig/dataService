<?php

namespace App\Http\Controllers;


use App\Models\Cooperation;
use Illuminate\Http\Request;

class CooperationController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItem(Request $request)
    {
        $data = Cooperation::query()->orderByDesc('id')->first();
        return $this->successData($data);
    }

}