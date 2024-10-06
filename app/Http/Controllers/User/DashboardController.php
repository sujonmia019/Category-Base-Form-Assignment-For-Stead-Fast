<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Form;
use App\Models\FormData;
use App\Models\FormSubmission;
use App\Models\FormValue;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    use UploadAble;

    public function dashboard(Request $request){
        // Authorized Access
        Gate::allows('user_access');

        if($request->ajax()){
            $getData = Form::active()->with('category')->orderBy('id','desc');
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
            DB::beginTransaction();
            try {
                $form = Form::with('fields')->find($request->form_id);
                if($form){
                    $submission = FormSubmission::create(['form_id'=>$request->form_id,'user_id'=>Auth::id(),'category_id'=>$form->category_id]);
                    $data = [];
                    foreach ($form->fields as $field) {
                        $value = $request->input('field_' . $field->id);
                        $type = $request->input('field_type_' . $field->id);
                        if ($type == 'select' || $type == 'checkbox') {
                            $value = json_encode($value);
                        } else if($type == 'file'){
                            $value = !empty($request->file('field_' . $field->id)) ? $this->upload_file($request->file('field_' . $field->id),FORM_FILE_PATH) : null;
                        } else{
                            $value = $value;
                        }

                        $data[] = [
                            'submission_id' => $submission->id,
                            'form_field_id' => $field->id,
                            'type'          => $type,
                            'value'         => $value,
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ];
                    }

                    FormValue::insert($data);

                    DB::commit();
                    return $this->response_json('success','Form submit successful.',null);
                }else{
                    return $this->response_json('error','Form not found!',null);
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->response_json('error',$e->getMessage(),null);
            }
        }
    }
}
