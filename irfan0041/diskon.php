<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belanja Diskon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Kalkulator Diskon Belanja</h1>
    <form method="POST">
        <label for="member">Status Member</label>
        <select name="member" id="member">
            <option value="yes">Ya</option>
            <option value="no">Tidak</option>
        </select>

        <label for="total">Total Belanja</label>
        <input type="text" id="total" name="total" placeholder="Masukkan total belanja">

        <button type="submit" name="submit">Hitung Diskon</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $is_member = $_POST['member'] === 'yes';
        $total_belanja = floatval($_POST['total']);
        $diskon = 0;

        if ($is_member) {
            if ($total_belanja > 1000000) {
                $diskon = 15;
            } elseif ($total_belanja > 500000) {
                $diskon = 10;
            } else {
                $diskon = 10; 
            }
        } else {
            if ($total_belanja > 1000000) {
                $diskon = 10;
            } elseif ($total_belanja > 500000) {
                $diskon = 5;
            } else {
                $diskon = 0; 
            }
        }

        $jumlah_diskon = ($diskon / 100) * $total_belanja;
        $total_bayar = $total_belanja - $jumlah_diskon;

        echo "<h2>Diskon: $diskon%</h2>";
        echo "<h2>Jumlah Diskon: Rp " . number_format($jumlah_diskon, 0, ',', '.') . "</h2>";
        echo "<h2>Total Bayar: Rp " . number_format($total_bayar, 0, ',', '.') . "</h2>";
    }
    ?>
</div>

</body>
</html>