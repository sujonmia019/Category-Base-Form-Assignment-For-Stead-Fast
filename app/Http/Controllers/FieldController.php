<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use App\Http\Requests\FieldRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FieldController extends Controller
{
    use ResponseMessage;

    public function formField(int $id){
        Gate::allows('admin_access');

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

    public function delete(Request $request){
        if ($request->ajax()) {
            $result = FormField::find($request->id);
            if($result){
                $result->delete();
                return $this->delete_message($result,'Field');
            }else{
                return $this->response_json('error','Data Cannot Delete',null,204);
            }
        }
    }

    public function ordering(Request $request){
        if ($request->ajax()) {
            try {
                $order = $request->order;
                foreach ($order as $key => $id) {
                    $item = FormField::find($id);
                    $item->ordering = $key + 1;
                    $item->save();
                }

                return response()->json(['status'=>'success','message'=>'Field order successfull.']);
            } catch (\Exception $e) {
                return response()->json(['status'=>'error','message'=>'Something went wrong!']);
            }
        }

    }
}
