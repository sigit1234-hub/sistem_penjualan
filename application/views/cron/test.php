<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cronjob Test</title>
</head>

<body>
    <Table style="border-color: black; border: 1px">

        <?php
        $no = 1;
        foreach ($dataStok as $d) :
        ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $d['kode_produk'] ?></td>
                <td><?= tanggal_jam($d['tgl_input']) ?></td>
            </tr>
            <?php $no++; ?>
        <?php endforeach; ?>
    </Table>
</body>

</html>