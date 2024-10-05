<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','form_id','user_id'];


    public function form() {
        return $this->belongsTo(Form::class,'form_id','id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function values() {
        return $this->hasMany(FormValue::class,'submission_id','id');
    }
}
