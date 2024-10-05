<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormField extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_id',
        'label',
        'type',
        'options',
        'placeholder',
        'required',
        'multiple',
        'ordering',
        'created_by',
        'updated_by'
    ];

    public function formData(){
        return $this->hasOne(FormData::class,'form_field_id','id');
    }

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function values() {
        return $this->hasMany(FormValue::class);
    }
    
}
