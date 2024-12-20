<a href="<?= BASE_URL.'index.php?r=home/insertbarang'?>" class="btn btn-primary">Tambah Barang</a>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>QTY</th>
        </tr>
    </thead>
        <?php foreach ($data as $item) : ?>
        <tbody>
        <tr scope="row">
            <td><?= $item['id'] ?></td>
            <td><?= $item['nama'] ?></td>
            <td><span class="badge text-bg-<?= $item['qty']>50? 'success' : 'danger'?>"> <?= $item['qty'] ?></span></td>
            <td><a href="<?= BASE_URL.'index.php?r=home/updatebarang/'.$item['id']?>" class="btn btn-secondary">Update</a></td>
            <td><a href="<?= BASE_URL.'index.php?r=home/deletebarang/'.$item['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Delete</a></td>
        </tr>
        </tbody>
        <?php endforeach ?>
    </table>