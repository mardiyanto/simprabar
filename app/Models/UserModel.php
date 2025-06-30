<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role', 'nama'];

    // Cari user berdasarkan username
    public function findByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
