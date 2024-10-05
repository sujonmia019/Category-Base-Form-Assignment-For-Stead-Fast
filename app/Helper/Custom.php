<?php

define('USER_AVATAR_PATH','users/');
define('UNAUTORIZED_BLOCK','Unauthorized Access Block!');
define('TABLE_PAGE_LENGTH',10);
define('STATUS',[
    1=>'Published',
    2=>'Pending'
]);

if(!function_exists('page_title'))
{
    function page_title($title){
        return view()->share(['title'=>$title]);
    }
}

if (!function_exists('tooltip')) {
    function tooltip($title,$direction = 'top'){
        return 'data-toggle="tooltip" data-placement="'.$direction.'" title="'.$title.'"';
    }
}

if (!function_exists('change_status')) {
    function change_status(int $id,int $status,string $name = null){
        return $status == 1 ? '<span class="badge badge-success change_status" data-id="' . $id . '" data-name="' . $name . '" data-status="2" style="cursor:pointer;">Published</span>' :
        '<span class="badge badge-danger change_status" data-id="' . $id . '" data-name="' . $name . '" data-status="1" style="cursor:pointer;">Pending</span>';
    }
}

if (!function_exists('table_checkbox')) {
    function table_checkbox($row_id){
        return '<div class="form-checkbox">
            <input type="checkbox" class="form-check-input select_data" id="checkbox-'.$row_id.'" value="'.$row_id.'" onClick="select_single_item('.$row_id.')">
            <label class="form-check-label" for="checkbox-'.$row_id.'"></label>
        </div>';
    }
}

if (!function_exists('table_image')) {
    function table_image($path,$image,$name){
        return $image ? "<img src='".asset('/')."uploads/".$path.$image."' alt='".$name."' style='width:40px;'/>"
        : "<img src='".asset('/')."img/default.svg' alt='Default Image' style='width:40px;'/>";
    }
}

if (!function_exists('user_image')) {
    function user_image($path,$image,$name,$class=null,$style=null){
        if ($image){
            return '<img src="'.asset('/').'uploads/'.$path.'/'.$image.'" alt="'.$name.'" style="'.$style.'" class="'.$class.'">';
        }else{
            return '<img src="'.asset('/').'uploads/users/user.png" alt="'.$name.'" class="'.$class.'" style="'.$style.'">';
        }
    }
}

if(!function_exists('dateFormat')){
    function dateFormat($date,$format='d-m-Y H:i A'){
        return date($format,strtotime($date));
    }
}
