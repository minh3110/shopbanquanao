<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sku','name','price','category_id','image','description','qty','qty_buy','supplier_id','status','colors','sizes'];
    protected $table = "products";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
