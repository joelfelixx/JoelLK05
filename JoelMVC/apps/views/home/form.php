<form method="POST">
  <div class="mb-3">
    <?php if (isset($data['id'])) : ?>
    <input type="hidden" name="id" value="<?= isset($data['id'])?  $data['id'] : "" ?>">
    <?php endif ?>
    <label for="inputNama">Nama Barang</label>
    <input name="nama" type="text" class="form-control" id="inputNama" aria-describedby="namaHelp" value="<?= isset($data['nama'])?  $data['nama'] : "" ?>">
    <div id="namaHelp" class="form-text">Isikan nama barang!</div>
    <label for="inputJumlah">jumlah barang</label>
    <input name="qty" type="text" class="form-control" id="inputJumlah" aria-describedby="jumlahHelp" value="<?= isset($data['qty'])?  $data['qty'] : "" ?>">
    <div id="jumlahHelp" class="form-text">Isikan jumlah barang!</div>
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
</form>