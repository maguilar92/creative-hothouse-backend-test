<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class CoreAdminController extends Controller
{
    public function index()
    {
        // dd(request()->todos);
        return view('layouts.master');
    }
}
