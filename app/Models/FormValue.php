<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormValue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_id',
        'form_field_id',
        'type',
        'value'
    ];

    public function field(){
        return $this->belongsTo(FormField::class,'form_field_id','id');
    }
}
