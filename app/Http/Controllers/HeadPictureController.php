<?php

namespace App\Http\Controllers;

use App\Models\HeadPicture;
use Illuminate\Http\Request;

class HeadPictureController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $id = $request->get('id');
        $data = HeadPicture::query()
            ->where('navigation_id', $id)
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->pluck('img_url')
            ->toArray();
        return $this->successData($data);
    }

}