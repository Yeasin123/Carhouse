<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subCategorys()
    {
        return $this->belongsTo('App\Models\SubCategory','category_id');
    }
}
