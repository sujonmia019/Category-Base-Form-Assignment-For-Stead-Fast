<?php

namespace App\Http\Controllers\User;

use App\Models\Form;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormData;
use App\Traits\UploadAble;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    use UploadAble;

    public function dashboard(Request $request){
        // Authorized Access
        Gate::allows('user_access');

        if($request->ajax()){
            $getData = Form::with('category')->orderBy('id','desc');
            return DataTables::eloquent($getData)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if (!empty($request->category)) {
                        $query->where('category_id',$request->category);
                    }
                })
                ->addColumn('category', function($row){
                    return $row->category->name;
                })
                ->addColumn('created_at', function($row){
                    return dateFormat($row->created_at);
                })
                ->addColumn('action', function($row){
                    $action = '<div class="d-flex align-items-center justify-content-end">';
                    $action .= '<a href="'.route('user.form.view',['id'=>$row->id,'url'=>$row->url]).'" class="btn btn-sm btn-info"><i class="fa fa-share"></i></a>';
                    $action .= '</div>';

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['categories'] = Category::active()->orderBy('name','DESC')->pluck('name','id');

        page_title('Dashboard');
        return view('user-panel.dashboard',$data);
    }

    public function formView(int $id, string $url){
        $data['form'] = Form::with('category','fields')->where(['id'=>$id,'url'=>$url])->firstOrFail();
        page_title('Form Submit');
        return view('user-panel.form-view',$data);
    }

    public function formSubmit(Request $request){
        if($request->ajax()){
            try {
                if ($request->has('field')) {
                    $data = [];
                    foreach ($request->field as $key => $value) {
                        if ($value['type'] == 'select' || $value['type'] == 'checkbox') {
                            $data_value = json_encode($value['value']);
                        } else if($value['type'] == 'file'){
                            $data_value = $value['value'] ? $this->upload_file($value['value'],'form-file/') : null;
                        } else{
                            $data_value = $value['value'];
                        }

                        $data[] = [
                            'form_id'     => $request->form_id,
                            'category_id' => $request->category_id,
                            'type'        => $value['type'],
                            'label'       => $value['label'],
                            'value'       => $data_value,
                            'created_at'  => now(),
                            'updated_at'  => now()
                        ];
                    }
                    FormData::insert($data);

                    return $this->response_json('success','Form submit successful.',null);
                }else {
                    return $this->response_json('error','Something went wrong!',null);
                }
            } catch (\Exception $e) {
                return $this->response_json('error',$e->getMessage(),null);
            }
        }
    }
}
