<?php

namespace App\Models;

use CodeIgniter\Model;

class Address_model extends Model
{
    protected $table = 'addresses';
    protected $primaryKey = 'address_id';
    protected $allowedFields = [
        'order_id', 'user_id', 'address_type', 'first_name', 'last_name',
        'company_name', 'address_line_1', 'address_line_2', 'city', 'state',
        'phone', 'email', 'order_notes', 'created_at'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = false;
}