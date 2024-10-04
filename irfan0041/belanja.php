<?php
session_start();

if (!isset($_SESSION['transactions'])) {
    $_SESSION['transactions'] = [];
}

// Fungsi hitung diskon
function hitungDiskon($totalBelanja, $isMember) {
    $diskon1 = 0;
    $diskon2 = 0;

    if ($isMember) { // Member
        if ($totalBelanja > 1000000) {
            $diskon1 = 15; // Diskon 15% untuk belanja > 1 juta
            $diskon2 = 10; // Diskon member 10%
        } elseif ($totalBelanja >= 500000) {
            $diskon1 = 10; // Diskon 10% untuk belanja >= 500 ribu
            $diskon2 = 10; // Diskon member 10%
        } else {
            $diskon2 = 10; // Diskon member 10%
        }
    } else { // Non-member
        if ($totalBelanja > 1000000) {
            $diskon1 = 10; // Diskon 10% untuk belanja > 1 juta
        } elseif ($totalBelanja >= 500000) {
            $diskon1 = 5; // Diskon 5% untuk belanja >= 500 ribu
        }
    }

    // Menghitung diskon
    $jumlahDiskon1 = ($diskon1 / 100) * $totalBelanja;
    $jumlahDiskon2 = ($diskon2 / 100) * ($totalBelanja - $jumlahDiskon1);
    $totalSetelahDiskon = $totalBelanja - ($jumlahDiskon1 + $jumlahDiskon2);

    return [
        'total_bayar' => $totalSetelahDiskon,
        'diskon_diberikan' => $totalBelanja - $totalSetelahDiskon,
        'diskon1' => $diskon1,
        'diskon2' => $diskon2
    ];
}

// Menyimpan transaksi ke session
if (isset($_POST['submit'])) {
    $totalBelanja = floatval($_POST['total_belanja']);
    $isMember = $_POST['is_member'] == 1;

    if ($totalBelanja > 0) {
        $hasilDiskon = hitungDiskon($totalBelanja, $isMember);

        $transaksi = [
            'total_belanja' => $totalBelanja,
            'diskon1' => $hasilDiskon['diskon1'],
            'diskon2' => $hasilDiskon['diskon2'],
            'diskon_diberikan' => $hasilDiskon['diskon_diberikan'],
            'total_akhir' => $hasilDiskon['total_bayar'],
            'tanggal' => date("Y-m-d H:i:s")
        ];

        array_push($_SESSION['transactions'], $transaksi);
    } else {
        $error = "Total belanja harus lebih dari 0!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Kasir dengan Diskon</title>
    <!-- Link CDN Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS Custom untuk menghilangkan spinner -->
    <style>
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

                        <!-- Input Total Belanja -->
                        <div class="mb-3">
                            <label for="total_belanja" class="form-label">Total Belanja (Rp)</label>
                            <input type="number" id="total_belanja" name="total_belanja" placeholder="Masukkan total belanja" required class="form-control">
                        </div>

                        <!-- Tombol Konfirmasi -->
                        <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                            <i class="fas fa-calculator"></i> Hitung Diskon
                        </button>

                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin melanjutkan transaksi ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="submit" class="btn btn-primary">Ya, Lanjutkan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Hasil Perhitungan Diskon -->
        <?php if (isset($hasilDiskon)) : ?>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
            <div class="card shadow-lg p-4">
                    <h2 class="text-center">Detail Transaksi</h2>
                    <p><strong>Total Belanja:</strong> Rp <?= number_format($totalBelanja, 0, ',', '.'); ?></p>
                    <p><strong>Diskon yang Diberikan:</strong> Rp <?= number_format($hasilDiskon['diskon_diberikan'], 0, ',', '.'); ?></p>
                    <p><strong>Total Setelah Diskon:</strong> Rp <?= number_format($hasilDiskon['total_bayar'], 0, ',', '.'); ?></p>
                    <p><strong>Diskon 1:</strong> <?= $hasilDiskon['diskon1']; ?>% (Diskon pertama berdasarkan total belanja)</p>
                    <p><strong>Diskon 2:</strong> <?= $hasilDiskon['diskon2']; ?>% (Diskon tambahan untuk member)</p>
                </div>
            </div>
        </div>

        <!-- Penawaran untuk Non-Member -->
        <?php if (!$isMember) : ?>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="alert alert-info">Bergabunglah menjadi member untuk mendapatkan lebih banyak diskon di pembelian berikutnya!</div>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>

        <!-- Riwayat Transaksi -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <h2 class="text-center">Riwayat Transaksi</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Total Belanja</th>
                            <th>Diskon</th>
                            <th>Total Setelah Diskon</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['transactions']) && count($_SESSION['transactions']) > 0): ?>
                            <?php foreach ($_SESSION['transactions'] as $key => $transaksi): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td>Rp <?= number_format($transaksi['total_belanja'], 0, ',', '.'); ?></td>
                                    <td>Rp <?= number_format($transaksi['diskon_diberikan'], 0, ',', '.'); ?></td>
                                    <td>Rp <?= number_format($transaksi['total_akhir'], 0, ',', '.'); ?></td>
                                    <td><?= $transaksi['tanggal']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada transaksi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Notifikasi Error -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-4"><?= $error ?></div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
