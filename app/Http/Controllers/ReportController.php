<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::allows('admin_access');

        $data['submissionDatas'] = FormSubmission::with(['values','form','user'])
            ->when($request->form,function($query,$form){
                $query->where('form_id',$form);
            })->when($request->category, function($query, $category) {
                $query->where('category_id', $category);
            })->paginate(1)->appends($request->all());

        $data['categories'] = Category::active()->orderBy('name','asc')->pluck('name','id');
        $data['forms'] = Form::active()->orderBy('created_at','desc')->pluck('title','id');

        page_title('Report List');
        return view('report.index',$data);
    }

    public function formReport(int $id){
        $data['submissionDatas'] = FormSubmission::with(['values.field', 'form.category'])->get();

        page_title('Report List');
        return view('report.list',$data);
    }
}
