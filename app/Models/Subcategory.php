<?php

namespace App\Models;

use CodeIgniter\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories'; // Matches the table name
    protected $primaryKey = 'subcategory_id';
    protected $returnType = 'array'; // Return results as arrays
    protected $useTimestamps = false; // No timestamps in your schema

    protected $allowedFields = [
        'category_id',
        'subcategory_name',
    ];

    // Relationship: A subcategory belongs to a category
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}