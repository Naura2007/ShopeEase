<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id_product';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_category', 'name', 'slug', 'description',
        'price', 'stock', 'status',
    ];
    protected $useTimestamps = true;
}
