<?php namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model{
    public $table = 'users';
    public $primaryKey = 'id';
    public $allowedFields = [
        'userName',
        'first_name',
        'last_name',
        'email',
        'password',
        'address',
        'user_type',
        'remember_token'
    ];
}
?>