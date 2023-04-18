<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;
    protected $useTimestamps    = true;
    protected $allowedFields    = ['id_produk', 'nama_produk', 'stok_produk', 'satuan_produk', 'harga_produk'];
}
