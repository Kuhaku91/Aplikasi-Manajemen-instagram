<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Produk;
use Config\Services;

class ProdukController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Produk';
        $this->services = new Services;
        $this->produk = new Produk;
    }

    public function index()
    {
        $data['validation'] = $this->services::validation();
        $data['title'] = $this->title;
        $data['breadcrumb'] = $this->breadcrumb($this->title);
        $data['listProduk'] = $this->produk->get()->getResultArray();
        return view('produk/index', $data);
    }

    public function create()
    {
        // validasi input data
        $validation = $this->services::validation();
        $produk = [
            'nama_produk' => ucfirst($this->request->getVar('nama_produk')),
            'stok_produk' => $this->request->getVar('stok_produk'),
            'satuan_produk' => $this->request->getVar('satuan_produk'),
            'harga_produk' => $this->request->getVar('harga_produk')
        ];
        // jika validasi sukses
        if($validation->run($produk, 'createProduk')) {
            $this->produk->save($produk);
            session()->setFlashdata('success', 'Data produk berhasil disimpan');
            return redirect()->to(base_url('produk'));
        // jika validasi gagal
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('produk'));             
        }
    }

    public function edit($id_produk)
    {
        // Panggil library validasi
        $validation = $this->services::validation();
        // ambil data dari form
        $produk = [
            'id_produk' => $id_produk,
            'nama_produk' => ucfirst($this->request->getVar('nama_produk')),
            'stok_produk' => $this->request->getVar('stok_produk'),
            'satuan_produk' => $this->request->getVar('satuan_produk'),
            'harga_produk' => $this->request->getVar('harga_produk')
        ];
        // validasi data
        if ($validation->run($produk, 'editProduk')) {
            // jika benar save
            $this->produk->save($produk, ['id_produk' => $id_produk]);
            session()->setFlashdata('success', 'Data produk berhasil diubah');
            return redirect()->to(base_url('produk'));
        } else {
            session()->setFlashdata('errors', $validation->getErrors());
           return redirect()->to(base_url('produk'));
        }
    }

    public function delete($id_produk)
    {
        $this->produk->delete(['id_produk' => $id_produk]);
        session()->setFlashdata('success', 'Data produk berhasil dihapus');
        return redirect()->to(base_url('produk'));
    }
}
