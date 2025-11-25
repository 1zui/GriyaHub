<?php

$products = [
    [
        'id' => 1,
        'name' => 'Semen Tiga Roda',
        'price' => 25000,
        'image' => 'asset/semen tiga roda.png',
        'category' => 'semen'
    ],
    [
        'id' => 2,
        'name' => 'Semen Gresik',
        'price' => 27000,
        'image' => 'asset/semen gresik.png',
        'category' => 'semen'
    ],
    [
        'id' => 3,
        'name' => 'Cat Tembok DUlux(5kg)',
        'price' => 55000,
        'image' => 'asset/cat dulux.jpg',
        'category' => 'cat'
    ],
    [
        'id' => 4,
        'name' => 'Kermik Motif 40x40 (Dus)',
        'price' => 75000,
        'image' => 'asset/keramik motif.jpg',
        'category' => 'keramik'
    ],
    [
        'id' => 5,
        'name' => 'Kuas Cat 3 inch',
        'price' => 8000,
        'image' => 'asset/kuas cat.jpg',
        'category' => 'perkakas'
    ],
    [
        'id' => 6,
        'name' => 'Cat Tembok Nippon Paint (5kg)',
        'price' => 60000,
        'image' => 'asset/cat nippon paint.jpg',
        'category' => 'cat'
    ],
    [
        'id' => 7,
        'name' => 'Keramik Putih 40x40 (Dus)',
        'price' => 65000,
        'image' => 'asset/keramik putih.jpg',
        'category' => 'keramik'
    ],
];

$toko_info = [
    'nama' => 'GriyaHub',
    'slogan' => 'Solusi Bangun & Material Anda',
    'alamat' => 'Jl. Pahlawan No. 45, Surakarta',
    'telepon' => '0812-3456-7890'
];

function getProductPriceFromServer($productName, $products)
{
    foreach ($products as $product) {
        if ($product['name'] === $productName) {
            return $product['price'];
        }
    }
    return 0;
}

$struk_data = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_barang = $_POST['nama-barang'] ?? 'N/A';
    $harga_aman = getProductPriceFromServer($nama_barang, $products);

    $struk_data = [
        'no_struk'  => 'GRY-' . date('YmdHis'),
        'pelanggan' => $_POST['nama-pelanggan'] ?? 'N/A',
        'tanggal'   => $_POST['tanggal-pembelian'] ?? date('Y-m-d'), 
        'waktu'     => date('H:i:s'), 
        'barang'    => $nama_barang,
        'jumlah'    => (int)($_POST['jumlah-beli'] ?? 0),
        'harga'     => $harga_aman,
        'jenis'     => $_POST['jenis-beli'] ?? 'eceran',
        'uang'      => (float)($_POST['uang-pelanggan'] ?? 0),
        'diskon'    => 0,
        'total'     => 0,
        'kembalian' => 0
    ];

    $total_normal = $struk_data['harga'] * $struk_data['jumlah'];

    if ($struk_data['jenis'] == 'grosir') {
        $struk_data['diskon'] = $total_normal * 0.10;
    }

    $struk_data['total'] = $total_normal - $struk_data['diskon'];
    $struk_data['kembalian'] = $struk_data['uang'] - $struk_data['total'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($toko_info['nama']); ?> - POS</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e0e0e0;
            gap: 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .logo img {
            width: 150px;
            height: auto;
            object-fit: contain;
        }

        .search-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .search-container label {
            font-size: 16px;
            font-weight: 600;
        }

        .search-container input[type="text"] {
            width: 70%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
        }

        main {
            display: flex;
            gap: 20px;
        }

        .products-section {
            flex: 3;
        }

        .products-section h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 16px;
            color: #007bff;
            margin-bottom: 5px;
        }

        .product-card p {
            font-size: 14px;
            font-weight: bold;
            color: #28a745;
        }

        .checkout-section {
            flex: 1;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e0e0e0;
        }

        .checkout-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkout-icon {
            color: #ff6600;
            margin-right: 10px;
        }

        .checkout-header h2 {
            font-size: 24px;
            text-transform: uppercase;
        }

        .checkout-form label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .checkout-form input[type="text"],
        .checkout-form input[type="date"],
        .checkout-form input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .checkout-form input#nama-barang,
        .checkout-form input#harga {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 5px;
        }

        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: normal;
        }

        .total-display {
            margin-top: 20px;
            border-top: 2px dashed #ccc;
            padding-top: 20px;
        }

        .total-display p {
            font-size: 16px;
            font-weight: 600;
        }

        .total-display h3 {
            font-size: 28px;
            color: #d9534f;
            text-align: right;
        }

        .button-group {
            margin-top: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .button-group button {
            padding: 12px;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .button-group button:hover {
            opacity: 0.9;
        }

        .btn-cetak {
            grid-column: 1 / -1;
            background-color: #28a745;
        }

        .btn-reset {
            background-color: #007bff;
        }

        .btn-keluar {
            background-color: #dc3545;
        }

        .struk-container {
            background-color: #fff;
            border: 2px dashed #333;
            padding: 15px;
            margin-bottom: 20px;
            font-family: 'Courier New', Courier, monospace;
            margin-top: 30px;
        }

        .struk-container h3 {
            text-align: center;
            border-bottom: none;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }

        .struk-container p {
            font-size: 14px;
            line-height: 1.6;
            display: flex;
            justify-content: space-between;
        }

        .struk-container .total {
            font-weight: bold;
            border-top: 1px dashed #333;
            margin-top: 10px;
            padding-top: 10px;
        }

        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 992px) {
            main {
                flex-direction: column;
            }

            .checkout-section {
                flex: none;
                width: 100%;
            }

            .product-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-container {
                width: 100%;
                justify-content: flex-start;
                margin-top: 10px;
            }

            .search-container input[type="text"] {
                width: 100%;
            }

            .logo {
                flex-direction: column;
                text-align: center;
            }

            .logo img {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <div class="logo">
                <img src="asset/Untitled design.png" alt="Logo GriyaHub">
            </div>

            <div class="search-container">
                <label for="product-search-input"><i class="fa-solid fa-search"></i>&nbsp; Filter Kategori:</label>
                <input type="text" id="product-search-input" list="category-list" placeholder="Ketik kategori (cth: Semen, Cat...)">
            </div>

            <datalist id="category-list">
                <option value="Semen">
                <option value="Cat">
                <option value="Keramik">
                <option value="Perkakas">
            </datalist>

        </header>

        <main>
            <section class="products-section">
                <h2>Semua Produk</h2>

                <div class="product-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card"
                            data-name="<?php echo htmlspecialchars($product['name']); ?>"
                            data-price="<?php echo $product['price']; ?>"
                            data-category="<?php echo htmlspecialchars($product['category']); ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p>Rp.<?php echo number_format($product['price'], 0, ',', '.'); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <aside class="checkout-section">
                <div class="checkout-header">
                    <i class="fa-solid fa-cart-shopping fa-2x checkout-icon"></i>
                    <h2>check out</h2>
                </div>

                <form class="checkout-form" id="checkoutForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <label for="nama-pelanggan">Nama Pelanggan</label>
                    <input type="text" id="nama-pelanggan" name="nama-pelanggan">

                    <label for="tanggal-pembelian">Tanggal Pembelian</label>
                    <input type="date" id="tanggal-pembelian" name="tanggal-pembelian" value="<?php echo date('Y-m-d'); ?>">

                    <label for="nama-barang">Nama barang</label>
                    <input type="text" id="nama-barang" name="nama-barang" readonly required>

                    <label for="jumlah-beli">Jumlah Beli</label>
                    <input type="number" id="jumlah-beli" name="jumlah-beli" value="1" min="1">

                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" readonly required>

                    <label>Jenis Pembelian</label>
                    <div class="radio-group">
                        <label for="eceran"><input type="radio" id="eceran" name="jenis-beli" value="eceran" checked> Eceran</label>
                        <label for="grosir"><input type="radio" id="grosir" name="jenis-beli" value="grosir"> Grosir</label>
                    </div>

                    <label for="uang-pelanggan">Uang Pelanggan</label>
                    <input type="number" id="uang-pelanggan" name="uang-pelanggan" required min="0">

                    <div class="total-display">
                        <p>Total :</p>
                        <h3 id="total-price">Rp.0</h3>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn-cetak">CETAK</button>
                        <button type="button" class="btn-reset" id="btn-reset">RESET</button>
                        <button type="button" class="btn-keluar" id="btn-keluar">KELUAR</button>
                    </div>
                </form>
            </aside>
        </main>

        <?php if ($struk_data): ?>
            <div class="struk-container">
                <h3><?php echo htmlspecialchars($toko_info['nama']); ?></h3>
                <p style="text-align:center; display:block; margin-top:-5px; font-size:12px;"><?php echo htmlspecialchars($toko_info['alamat']); ?></p>
                <p style="text-align:center; display:block; font-size:12px; border-bottom: 1px solid #333; padding-bottom: 5px; margin-bottom: 10px;"><?php echo htmlspecialchars($toko_info['telepon']); ?></p>

                <p><span>No. Struk</span> <span><?php echo htmlspecialchars($struk_data['no_struk']); ?></span></p>
                <p><span>Nama Pelanggan</span> <span><?php echo htmlspecialchars($struk_data['pelanggan']); ?></span></p>
                <p><span>Tanggal</span> <span><?php echo htmlspecialchars($struk_data['tanggal']); ?></span></p>

                <p><span>Waktu</span> <span><?php echo htmlspecialchars($struk_data['waktu']); ?></span></p>
                <p>-----------------------------------</p>
                <p><span>Barang</span> <span><?php echo htmlspecialchars($struk_data['barang']); ?></span></p>
                <p><span>Jumlah</span> <span><?php echo $struk_data['jumlah']; ?> x</span></p>
                <p><span>Harga Satuan</span> <span>Rp. <?php echo number_format($struk_data['harga'], 0, ',', '.'); ?></span></p>
                <p><span>Diskon (<?php echo htmlspecialchars($struk_data['jenis']); ?>)</span> <span>- Rp. <?php echo number_format($struk_data['diskon'], 0, ',', '.'); ?></span></p>
                <p class="total"><span>TOTAL</span> <span>Rp. <?php echo number_format($struk_data['total'], 0, ',', '.'); ?></span></p>
                <p><span>UANG DIBAYAR</span> <span>Rp. <?php echo number_format($struk_data['uang'], 0, ',', '.'); ?></span></p>

                <?php if ($struk_data['kembalian'] < 0): ?>
                    <p style="color: red; font-weight: bold;"><span>UANG KURANG</span> <span>Rp. <?php echo number_format(abs($struk_data['kembalian']), 0, ',', '.'); ?></span></p>
                <?php else: ?>
                    <p><span>KEMBALIAN</span> <span>Rp. <?php echo number_format($struk_data['kembalian'], 0, ',', '.'); ?></span></p>
                <?php endif; ?>

                <p>-----------------------------------</p>
                <p style="text-align:center; display:block;">Terima Kasih!</p>
            </div>
        <?php endif; ?>
    </div>

    <script>

        const productMap = new Map();
        <?php foreach ($products as $product): ?>
            productMap.set(<?php echo json_encode($product['name']); ?>, {
                price: <?php echo $product['price']; ?>,
                name: <?php echo json_encode($product['name']); ?>
            });
        <?php endforeach; ?>

        document.addEventListener('DOMContentLoaded', function() {

            const namaBarangInput = document.getElementById('nama-barang');
            const hargaInput = document.getElementById('harga');
            const jumlahBeliInput = document.getElementById('jumlah-beli');
            const totalDisplay = document.getElementById('total-price');
            const radioJenisBeli = document.querySelectorAll('input[name="jenis-beli"]');
            const form = document.getElementById('checkoutForm');
            const productSearchInput = document.getElementById('product-search-input');
            const productCards = document.querySelectorAll('.product-card');

            const btnKeluar = document.getElementById('btn-keluar');
            const btnReset = document.getElementById('btn-reset');


            function calculateTotal() {
                const harga = parseFloat(hargaInput.value) || 0;
                const jumlah = parseInt(jumlahBeliInput.value) || 0;
                const jenis = document.querySelector('input[name="jenis-beli"]:checked').value;
                let total = harga * jumlah;

                if (jenis === 'grosir') {
                    total = total * 0.90;
                }
                totalDisplay.textContent = 'Rp.' + total.toLocaleString('id-ID');
                return total;
            }

            function fillFormWithProduct(nama, harga) {
                namaBarangInput.value = nama;
                hargaInput.value = harga;
                jumlahBeliInput.value = 1;
                calculateTotal();
            }

            productCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    const namaProduk = card.dataset.name;
                    const hargaProduk = card.dataset.price;
                    fillFormWithProduct(namaProduk, hargaProduk);
                });
            });

            productSearchInput.addEventListener('input', function(e) {
                const filterValue = e.target.value.toLowerCase().trim();

                productCards.forEach(function(card) {
                    const cardCategory = card.dataset.category.toLowerCase();

                    if (cardCategory.includes(filterValue) || filterValue === "") {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            jumlahBeliInput.addEventListener('input', calculateTotal);

            radioJenisBeli.forEach(function(radio) {
                radio.addEventListener('change', calculateTotal);
            });

            btnReset.addEventListener('click', function() {
                window.location.href = window.location.pathname;
            });

            btnKeluar.addEventListener('click', function() {
                window.location.href = 'http://localhost/WEB2';
            });

            form.addEventListener('submit', function(e) {
                const total = calculateTotal();
                const uang = parseFloat(document.getElementById('uang-pelanggan').value) || 0;
                const barang = namaBarangInput.value;

                if (barang === '' || barang === null) {
                    e.preventDefault();
                    alert('ERROR: Silakan pilih produk terlebih dahulu!');
                    return;
                }

                if (uang < total) {
                    e.preventDefault();
                    alert('ERROR: Uang pelanggan (Rp.' + uang.toLocaleString('id-ID') + ') tidak mencukupi untuk total (Rp.' + total.toLocaleString('id-ID') + ').');
                    return;
                }
            });
        });
    </script>

</body>

</html>