<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'description',
        'url',
        'status',
        'created_by',
        'updated_by'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function fields(){
        return $this->hasMany(FormField::class)->orderBy('ordering','ASC');
    }
}
