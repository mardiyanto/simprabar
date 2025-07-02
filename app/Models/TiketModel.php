<?php
namespace App\Models;
use CodeIgniter\Model;

class TiketModel extends Model
{
    protected $table = 'tiket';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nomor_tiket',
        'ruangan_id',
        'barang_id',
        'deskripsi_kerusakan',
        'deskripsi_perbaikan',
        'foto_kerusakan',
        'foto_perbaikan',
        'status',
        'hasil_perbaikan',
        'created_at',
        'updated_at'
    ];
} 