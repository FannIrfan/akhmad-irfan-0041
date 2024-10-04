<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kasir dengan Diskon</title>
    <!-- Link CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS Custom untuk menghilangkan spinner -->
    <style>
        /* Hilangkan spinner di input number */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Judul -->
        <div class="text-center mb-4">
            <h1 class="display-5 fw-bold">Program Kasir</h1>
            <p class="lead text-muted">Hitung total belanja Anda dengan diskon otomatis!</p>
        </div>
        
        <!-- Card Form -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <form action="" method="post">
                        <!-- Input Total Belanja -->
                        <div class="mb-3">
                            <label for="total_belanja" class="form-label">Total Belanja (Rp)</label>
                            <input type="number" id="total_belanja" name="total_belanja" placeholder="Masukkan total belanja" required class="form-control">
                        </div>

                        <!-- Input Status Keanggotaan -->
                        <div class="mb-3">
                            <label class="form-label">Status Keanggotaan</label><br>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="member" name="is_member" value="1" required class="form-check-input">
                                <label for="member" class="form-check-label">Member</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" id="non_member" name="is_member" value="0" required class="form-check-input">
                                <label for="non_member" class="form-check-label">Non-Member</label>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" name="submit" class="btn btn-primary w-100">Hitung Diskon</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hasil Perhitungan Diskon -->
        <?php
        if (isset($_POST['submit'])) {
            $totalBelanja = $_POST['total_belanja'];
            $isMember = $_POST['is_member'];

            // Fungsi untuk menghitung diskon
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

            // Tampilkan hasil perhitungan
            echo "
            <div class='row justify-content-center mt-4'>
                <div class='col-md-6'>
                    <div class='card shadow-lg p-4'>
                        <h2 class='text-center'>Detail Transaksi</h2>
                        <p><strong>Total Belanja:</strong> Rp " . number_format($totalBelanja, 0, ',', '.') . "</p>
                        <p><strong>Diskon Diberikan:</strong> Rp " . number_format($diskonDiberikan, 0, ',', '.') . "</p>
                        <p><strong>Total Setelah Diskon:</strong> Rp " . number_format($totalSetelahDiskon, 0, ',', '.') . "</p>
                    </div>
                </div>
            </div>";
        }
        ?>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
