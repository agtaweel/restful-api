<?php

namespace App;

use App\Transformers\CategoryTransfomer;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    public $transfomer = CategoryTransfomer::class;

    protected $fillable =
        [
            'name',
            'description'
        ];

    protected $hidden= [
        'pivot'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
