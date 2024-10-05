<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('user_access');

        $data['submissionDatas'] = FormSubmission::with(['values','form','user'])
            ->when($request->form,function($query,$form){
                $query->where('form_id',$form);
            })->when($request->category, function($query, $category) {
                $query->where('category_id', $category);
            })->where('user_id',Auth::id())->paginate(10)->appends($request->all());

        $data['categories'] = Category::active()->orderBy('name','asc')->pluck('name','id');
        $data['forms'] = Form::active()->orderBy('created_at','desc')->pluck('title','id');

        page_title('Report List');
        return view('user-panel.report',$data);
    }
}
