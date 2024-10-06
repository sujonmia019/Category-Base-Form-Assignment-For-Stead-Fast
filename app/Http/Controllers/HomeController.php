<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Gate::authorize('admin_access');

        $data['totalUser']     = DB::table('users')->where('role_id',2)->count();
        $data['totalCategory'] = DB::table('categories')->count();
        $data['totalForm']     = DB::table('forms')->count();
        $data['totalRecord']   = DB::table('form_submissions')->count();

        page_title('Dashboard');
        return view('dashboard',$data);
    }
}
