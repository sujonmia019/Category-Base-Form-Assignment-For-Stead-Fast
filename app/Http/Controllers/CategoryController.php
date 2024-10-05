<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ResponseMessage;
use App\Traits\UploadAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use ResponseMessage;

    public function index(Request $request){
        // authorize
        Gate::authorize('admin_access');

        if($request->ajax()){

            $getData = Category::orderBy('id','desc');
            return DataTables::eloquent($getData)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if (!empty($request->search)) {
                        $query->where('name', 'LIKE', "%$request->search%");
                    }
                })
                ->addColumn('created_at', function($row){
                    return dateFormat($row->created_at);
                })
                ->addColumn('status', function($row){
                    return change_status($row->id,$row->status,$row->name);
                })
                ->addColumn('bulk_check', function($row){
                    return table_checkbox($row->id);
                })
                ->addColumn('action', function($row){
                    $action = '<div class="d-flex align-items-center justify-content-end">';
                    $action .= '<button type="button" class="btn btn-sm btn-primary edit_data mr-1" data-id="' . $row->id . '"><i class="fa fa-edit"></i></button>';

                    $action .= '<button type="button" class="btn btn-danger btn-sm delete_data" data-id="' . $row->id . '" data-name="' . $row->name . '"><i class="fa fa-trash"></i></button>';
                    $action .= '</div>';

                    return $action;
                })
                ->rawColumns(['bulk_check','status','action','image','status'])
                ->make(true);
        }

        page_title('Category List','Category List');
        return view('category.index');

    }


    public function storeOrUpdate(CategoryRequest $request){
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $collection = collect($request->validated());
                $created_at = $updated_at = Carbon::now();
                $created_by = $updated_by = auth()->user()->name;

                if($request->update_id){
                    $collection = $collection->merge(compact('updated_by','updated_at'));
                }else{
                    $collection = $collection->merge(compact('created_by','created_at'));
                }

                Category::updateOrCreate(['id'=>$request->update_id],$collection->all());
                DB::commit();
                return $this->response_json('success','Category has been saved succesful.');
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->response_json('error',$e->getMessage());
            }
        }
    }

    public function edit(Request $request){
        if($request->ajax()){
            $data = Category::find($request->id);
            if($data->count()){
                return $this->response_json('success',null,$data,201);
            }else{
                return $this->response_json('error','No Data Found',null,204);
            }
        }
    }

    /**
     * spacified delete resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        if ($request->ajax()) {
            $result = Category::find($request->id);
            if($result){
                $result->delete();
                return $this->delete_message($result);
            }else{
                return $this->response_json('error','Data Cannot Delete',null,204);
            }
        }else{
            return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
        }
    }

    /**
     * multiple destroy resource
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bulkDelete(Request $request){
        if ($request->ajax()) {
            $result = Category::destroy($request->ids);
            if($result){
                return $this->bulk_delete_message($result);
            }else{
                return $this->response_json('error','Data Cannot Delete',null,204);
                }
        }else{
            return $this->response_json('error',UNAUTORIZED_BLOCK,null,204);
        }
    }

    /**
     * spacified status update
     *
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request){
        if ($request->ajax()) {
            $result = Category::find($request->id);
            if ($result) {
                $result->update(['status'=>$request->status]);
                return $this->status_message($result);
            }else{
                return $this->response_json('error','Failed to change status',null,204);
            }
        }
    }
}
