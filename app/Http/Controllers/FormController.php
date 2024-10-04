<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormDataRequest;
use App\Models\Category;
use App\Models\Form;
use App\Traits\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FormController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $getData = Form::with('category')->orderBy('id','desc');
            return DataTables::eloquent($getData)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if (!empty($request->search)) {
                        $query->where('title', 'LIKE', "%$request->search%");
                    }
                })
                ->addColumn('category', function($row){
                    return $row->category->name;
                })
                ->addColumn('bulk_check', function($row){
                    return table_checkbox($row->id);
                })
                ->addColumn('created_at', function($row){
                    return date(config('settings.date_format'),strtotime($row->created_at));
                })
                ->addColumn('status', function($row){
                    return change_status($row->id,$row->status,$row->name);
                })
                ->addColumn('action', function($row){
                    $action = '<div class="d-flex align-items-center justify-content-end">';
                    $action .= '<a href="'.route('app.forms.fields.index',$row->id).'" class="btn btn-sm btn-success ml-1" data-id="' . $row->id . '"><i class="fa fa-sort-amount-asc"></i></a>';

                    $action .= '<button type="button" class="btn btn-sm btn-primary ml-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>';

                    $action .= '<button type="button" class="btn-danger btn btn-sm delete_data ml-1" data-id="' . $row->id . '" data-name="' . $row->reg_id . '"><i class="fa fa-trash"></i></button>';
                    $action .= '</div>';

                    return $action;
                })
                ->rawColumns(['bulk_check','status','action'])
                ->make(true);
        }

        page_title('Form List');
        return view('form.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['categories'] = Category::active()->pluck('name','id');
        page_title('New Form');
        return view('form.store_or_update',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormDataRequest $request)
    {
        if ($request->ajax()) {
            $collection = collect($request->all());
            $created_at = $updated_at = Carbon::now();
            $created_by = $updated_by = Auth::user()->name;
            $url = strtolower(Str::random(10));
            if ($request->update_id) {
                $collection = $collection->merge(compact('updated_at','updated_by'));
            }else {
                $collection = $collection->merge(compact('created_at','created_by','url'));
            }

            $result = Form::updateOrCreate(['id'=>$request->update_id],$collection->all());
            if($result){
                return $this->store_message($result,$request->update_id);
            }else{
                return $this->response_json('error','Data Cannot Save',null,204);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
