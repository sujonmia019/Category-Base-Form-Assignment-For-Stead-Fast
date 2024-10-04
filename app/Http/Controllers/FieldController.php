<?php

namespace App\Http\Controllers;

use App\Http\Requests\FieldRequest;
use App\Models\Form;
use App\Models\FormField;
use App\Traits\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FieldController extends Controller
{
    use ResponseMessage;

    public function formField(int $id){
        $data['form'] = Form::with('fields')->findOrFail($id);

        page_title('Form Field');
        return view('form.field.form',$data);
    }


    public function storeOrUpdate(FieldRequest $request){
        if($request->ajax()){
            $collection = collect($request->validated());
            $created_at = $updated_at = Carbon::now();
            $created_by = $updated_by = Auth::user()->name;

            if ($request->has('required')) {
                $required = 1;
                $collection = $collection->merge(compact('required'));
            }

            if ($request->update_id) {
                $collection = $collection->merge(compact('updated_at','updated_by'));
            }else {
                $collection = $collection->merge(compact('created_at','created_by'));
            }

            $result = FormField::updateOrCreate(['id'=>$request->update_id],$collection->all());
            if($result){
                return $this->store_message($result,$request->update_id);
            }else{
                return $this->response_json('error','Data Cannot Save',null,204);
            }
        }
    }
}
