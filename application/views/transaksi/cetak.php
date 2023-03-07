<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
        <style>
            td {
                font-size: 12px;
                font-family: sans-serif;
            }
            h3 {
                font-size: 16px;
            }
            hr {
                border: 0;
                border-top: 2px solid #FF99bb;
            }
            .table {
                border: 1px solid black;
                border-coLLapse: collapse;
            }

            th {
                font-family: sans-serif;
                font-size: 12px;
                background: lightblue;
            }
            </style>
        </head>

        <body>
            <table>
            <tr>
            <td width="400">
                <h3>Laundry Rahma</h3>
            </td>
            <td>
                <!-- <h3>Invoice</h3> -->
                <!-- <img src="<?= base_url('assets/img/logo.png') ?> " width="150"> -->
                </td>
            </tr>
            <tr>
                <td>Alamat : Jember</td>
            </tr>
            <tr>
                <td>Telp. : 0856049059020</td>
            </tr>
            <tr>
                <td>Email : rahmawati@gmail.com</td>
            </tr>
            <tr>
                <td>Kode Invoice : <?= $kode_invoice ?></td>
            </tr>
            <tr>
                <td>ID Member : <?= $transaksi[0]['id_member'] ?></td>
            </tr>
            <tr>
                <td>Nama Member : <?= $transaksi[0]['nama_member'] ?></td>
            </tr>
            <tr>
                <td>Tanggal : <?= $transaksi[0]['tgl'] ?></td>
            </tr>
            <tr>
                <td>Batas Waktu : <?= $transaksi[0]['tgl_diambil'] ?></td>
            </tr>
            <tr>
                <td>Outlet : <?= $transaksi[0]['nama_outlet'] ?></td>
            </tr>
            <tr>
                <td>Status Pembayaran : <?= $transaksi[0]['dibayar'] ?></td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran : <?= $transaksi[0]['tgl_bayar'] ?></td>
            </tr>
        </table>
        <hr><br>

        <table width="700" border="1" class="tabel">
            <tr>
                <th>No</th>
                <th>Nama Paket</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>

            <?php
            $total = 0; 
            $index=1; foreach ($transaksi as $row): ?>
                <tr>
                    <td><?= $index++ ?></td>
                    <td><?= $row['nama_paket'] ?></td>
                    <td><?= "Rp." . number_format($row['harga']) ?></td>
                    <td><?= $row['terjual'] ?></td>
                    <td><?= "Rp." . number_format($row['pendapatan']) ?></td>
                </tr>
                <?php $total += $row['pendapatan'] ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="4">Total : </td>
                <td>Rp. <?= number_format($total) ?></td>
            </tr>

            <!-- <tr>
                <td class="tabel"><?= $transaksi['id_member'] ?></td>
                <td class="tabel"><?= $transaksi['tgl'] ?></td>
                <td class="tabel"><?= $transaksi['nama'] ?></td>
                <td class="tabel"><?= "Rp. " . number_format($transaksi['total_bayar']) ?></td>
                <td class="tabel"><?= $transaksi['dibayar'] ?></td>
                <td class="tabel"><?= $transaksi['tgl_bayar'] ?></td>
            </tr> -->
            
            </table><br>

            <table>
                <tr>
                <td>Keterangan :</td>
            </tr>
            <tr>
                <td>
                <p>1. Pengambilan cucian harus membawa nota</p>
                <p>2. Cuci luntur bukan tanggung jawab kami</p>
                <p>3. Hitung dan periksa sebelum pergi</p>
                <p>4. Klaim kekurangan/kehilangan cucian setelah meninggalkan laundry tidak dilayani</p>
            </td>
        </tr>
    </table>

</body>
</html>
<script>
    window.print();
</script>