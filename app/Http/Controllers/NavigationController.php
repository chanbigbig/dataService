<?php

namespace App\Http\Controllers;

use App\Models\Navigation;
use Illuminate\Http\Request;

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
            ->with('child')
            ->get(['id', 'title', 'des as description', 'content']);
        return $this->successData($data);
    }

}