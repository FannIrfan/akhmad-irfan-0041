<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kasir dengan Diskon</title>
</head>
<body>
    <h1>Program Kasir</h1>

    <form action="" method="post">
        <label for="total_belanja">Total Belanja (Rp): </label>
        <input type="number" id="total_belanja" name="total_belanja" required><br><br>

        <label>Status Keanggotaan: </label>
        <input type="radio" id="member" name="is_member" value="1" required>
        <label for="member">Member</label>
        <input type="radio" id="non_member" name="is_member" value="0" required>
        <label for="non_member">Non-Member</label><br><br>

        <input type="submit" name="submit" value="Hitung Diskon">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $totalBelanja = $_POST['total_belanja'];
        $isMember = $_POST['is_member'];

        // Fungsi untuk menghitung diskon berdasarkan status keanggotaan dan total belanja
        function hitungDiskon($totalBelanja, $isMember) {
            $diskon = 0;

            if ($isMember) { // Untuk member
                if ($totalBelanja > 1000000) {
                    $diskon = 15; // Diskon 15% jika total belanja lebih dari 1.000.000
                } elseif ($totalBelanja >= 500000) {
                    $diskon = 10; // Diskon 10% jika total belanja 500.000 atau lebih
                } else {
                    $diskon = 10; // Diskon 10% untuk member di bawah 500.000
                }
            } else { // Untuk non-member
                if ($totalBelanja > 1000000) {
                    $diskon = 10; // Diskon 10% jika total belanja lebih dari 1.000.000
                } elseif ($totalBelanja >= 500000) {
                    $diskon = 5; // Diskon 5% jika total belanja 500.000 atau lebih
                } else {
                    $diskon = 0; // Tidak ada diskon untuk non-member di bawah 500.000
                }
            }

            return $totalBelanja - ($totalBelanja * $diskon / 100);
        }

        // Hitung total setelah diskon
        $totalSetelahDiskon = hitungDiskon($totalBelanja, $isMember);
        $diskonDiberikan = $totalBelanja - $totalSetelahDiskon;

        // Tampilkan hasil
        echo "<h2>Detail Transaksi</h2>";
        echo "Total Belanja: Rp " . number_format($totalBelanja, 0, ',', '.') . "<br>";
        echo "Diskon Diberikan: Rp " . number_format($diskonDiberikan, 0, ',', '.') . "<br>";
        echo "Total Setelah Diskon: Rp " . number_format($totalSetelahDiskon, 0, ',', '.') . "<br>";
    }
    ?>
</body>
</html>
