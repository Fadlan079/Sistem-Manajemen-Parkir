<!DOCTYPE html>
<html>
<head>
    <title>Print Tiket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .ticket {
            width: 300px;
            border: 1px dashed #333;
            padding: 15px;
        }
        .barcode {
            text-align: center;
            margin-bottom: 10px;
        }
        .barcode span {
            display: block;
            letter-spacing: 3px; /* jarak angka */
            margin-top: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body onload="window.print()">

<div class="ticket">

    <h3 style="text-align:center;">TIKET PARKIR</h3>

    <div class="barcode">
        <?php 
            // generate barcode code128 tanpa gambar (HTML)
            echo "<div style='font-family: \"Libre Barcode 128\", cursive; font-size: 50px;'>*$tiket[barcode]*</div>";
        ?>
        <span><?= $tiket['barcode']; ?></span>
    </div>

    <p><b>No. Polisi:</b> <?= $tiket['nomor_polisi']; ?></p>
    <p><b>Jenis Kendaraan:</b> <?= $tiket['jenis_kendaraan']; ?></p>
    <p><b>Tanggal Masuk:</b> <?= $tiket['tgl_masuk']; ?></p>
    <p><b>Petugas:</b> <?= $tiket['id_petugas_masuk']; ?></p>

</div>

<!-- Google Fonts barcode -->
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+128&display=swap" rel="stylesheet">

</body>
</html>