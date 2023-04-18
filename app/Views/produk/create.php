<div class="modal fade" id="tambahData" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="tambahData" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahData">Tambah Produk Baru</h5>
        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?= base_url('produk/create'); ?>" method="post">
          <?= csrf_field(); ?>
      <div class="modal-body">
        <div class="mb-2">
            <label for="namaProduk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="nama_produk" id="namaProduk">
        </div>
        <div class="mb-2">
            <label for="stokProduk" class="form-label">Stok Produk</label>
            <input type="number" class="form-control" name="stok_produk" id="stokProduk">
        </div>
        <div class="mb-2">
            <label for="satuanProduk" class="mb-1">Satuan Produk</label>
            <select name="satuan_produk" id="jenisproduk" class="form-select">
                <option value="Gram">Gram</option>
                <option value="KG">KG</option>
                <option value="Drum">Drum</option>
                <option value="Pcs">Pcs</option>
            </select>
        </div>
        <div class="mb-2">
          <label for="hargaProduk" class="form-label">Harga Produk</label>
          <input type="number" class="form-control" name="harga_produk" id="hargaProduk">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger text-white" data-coreui-dismiss="modal"><i class="fas fa-times"></i>&nbsp;Batal</button>
        <button type="submit" id="simpanTambah" class="btn btn-success text-white"><i class="fas fa-save"></i>&nbsp;Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>