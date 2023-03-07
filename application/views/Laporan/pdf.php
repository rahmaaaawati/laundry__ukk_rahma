<h1>Laporan Laundry Rahma</h1>
<table border='1' cellpadding="10" class="table table.bordered table.striped">
<thead>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Paket</th>
        <th>Outlet</th>
        <th>Harga</th>
        <th>Terjual</th>
        <th>Status Pembayaran</th>
        <th>Pendapatan</th>
    </tr>
</thead>
<tbody>
    <?php
    $total = 0;
     $index=1; foreach ($laporan as $row): ?>
        <tr>
            <td><?php echo $index++ ?></td>
            <td><?php echo $row['tgl'] ?></td>
            <td><?php echo $row['nama_paket'] ?></td>
            <td><?php echo $row['nama_outlet'] ?></td>
            <td><?php echo "Rp." . number_format($row['harga']) ?></td>
            <td><?php echo $row['terjual'] ?></td>
            <?php if ($row['dibayar'] == 'dibayar') : ?>
                <td><?php echo "Rp." . number_format($row['pendapatan']) ?></td>
            <?php else: ?>
                <td>Rp. 0</td>
            <?php endif; ?>
            <td><?php echo $row['dibayar'] ?></td>
        </tr>
            <?php if ($row['dibayar'] == 'dibayar') : ?>
                <?php $total += $row['pendapatan']  ?>
            <?php endif; ?>
        <?php endforeach ?>
        <tr>
            <td colspan="7">Total : </td>
            <td>Rp. <?= number_format($total) ?></td>
        </tr>
</tbody>
</table>