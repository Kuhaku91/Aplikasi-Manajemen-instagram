<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Produk;
use App\Models\JurnalDetail;
use App\Models\JurnalHeader;
use App\Models\TransaksiDetail;
use App\Models\TransaksiHeader;
use Config\Services;

class TransaksiTunaiController extends BaseController
{
    public function __construct()
    {
        $this->title = "Transaksi Tunai";
        $this->header = new TransaksiHeader;
        $this->detail = new TransaksiDetail;
        $this->services = new Services;
        $this->produk = new Produk;
        $this->jurnalHeader = new JurnalHeader;
        $this->jurnalDetail = new JurnalDetail;
    }
    public function index()
    {
        $data['validation'] = $this->services::validation();
        $data['title'] = $this->title;
        $data['listProduk'] = $this->produk->get()->getResultArray();
        $data['breadcrumb'] = $this->breadcrumb($this->title);

        $data['id'] = "TRX-" . date("Ymd") . "-" . date("Hi") . "-" . date("s");
        return view('transaksi/tunai/index', $data);
    }

    public function tambahKeranjang() {
        $cart = \Config\Services::cart();
        $produk = $this->produk->where('id_produk', $this->request->getVar('id_produk'))->first();
        $cart->insert([
            'id'    => $this->request->getVar('id_produk'),
            'qty'   => $this->request->getVar('quantity_produk'),
            'price' => $produk['harga_produk'],
            'name'  => $produk['nama_produk'],
        ]);
        return json_encode([
            'status' => 'success',
            'pesan' => 'Produk berhasil ditambah ke keranjang'
        ]);

    }

    public function lihatKeranjang() {
        if($this->request->isAJAX()) {
            $cart = \Config\Services::cart();
            $response = $cart->contents();
            return json_encode($response);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function hapusKeranjang($id) {
        if($this->request->isAJAX()){
            $cart = \Config\Services::cart();
            $cart->remove($id);
            return json_encode([
                'status' => 'success',
                'pesan' => 'Produk berhasil dihapus dari keranjang'
            ]);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function cekSubtotal() {
        if($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $qty = $this->request->getVar('qty');
            $produk = $this->produk->where('id_produk', $id)->first();
            $subtotal = $produk['harga_produk'] * $qty;
            return json_encode([
                'status' => 'success',
                'produk' => $produk,
                'data' => $subtotal
            ]);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function create() {
        $data['validation'] = $this->services::validation();
        $total = 0;
        $cart = \Config\Services::cart();
        // Simpan data transaksi detail
        foreach($cart->contents() as $item) {
            $this->detail->save([
                'id_transaksi_header' => $this->request->getVar('id_transaksi_header'),
                'id_produk' => $item['id'],
                'quantity_produk' => $item['qty'],
                'subtotal_transaksi' => $item['subtotal'],
            ]);
            // update stok produk
            $produk = $this->produk->where('id_produk', $item['id'])->first();
            $stok = $produk['stok_produk'] - $item['qty'];
            $this->produk->save([
                'id_produk' => $item['id'],
                'stok_produk' => $stok], ['id_produk' => $item['id']
            ]);
            // menghitung total transaksi
            $total += $item['subtotal'];
        }
        $cart->destroy();

        if ($total == 0) {
            session()->setFlashdata('danger', 'Tidak ada data transaksi');
            return redirect()->to(base_url('transaksi-tunai'));
        }
        
        // simpan data transaksi header
        $this->header->insert([
            'id_transaksi_header' => $this->request->getVar('id_transaksi_header'),
            'id_pelanggan' => null,
            'jenis_transaksi' => 'Tunai',
            'tanggal_transaksi' => $this->request->getVar('tanggal_transaksi'),
            'tanggal_jatuh_tempo_transaksi' => null,
            'total_transaksi' => $total,
            'piutang_transaksi' => 0,
            'status_transaksi' => 'Lunas',
            'keterangan_transaksi' => $this->request->getVar('keterangan_transaksi'),
        ]);
        // simpan data jurnal header
        $idJurnal = str_replace("TRX-","JU-",$this->request->getVar('id_transaksi_header'));
        $this->jurnalHeader->insert([
            'id_jurnal_header' => $idJurnal,
            'status_posting_jurnal' => 'Belum Posting',
            'tanggal_jurnal' => $this->request->getVar('tanggal_transaksi'),
            'id_transaksi_header' => $this->request->getVar('id_transaksi_header'),
            'keterangan_jurnal' => 'Penjualan'
        ]);
        // simpan data jurnal detail
        $this->jurnalDetail->insertBatch([
            [
                'id_jurnal_header' =>  $idJurnal,
                'id_akun' => '101',
                'debit' => $total,
                'kredit' => 0
            ],
            [
                'id_jurnal_header' =>  $idJurnal,
                'id_akun' => '400',
                'debit' => 0,
                'kredit' => $total
            ]
        ]);
        session()->setFlashdata('success', 'Data transaksi berhasil disimpan');
        return redirect()->to(base_url('transaksi-tunai'));

    }
}
