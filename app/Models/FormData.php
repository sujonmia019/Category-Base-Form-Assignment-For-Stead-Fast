<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_datas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['form_id','category_id','label','type','value'];
}
