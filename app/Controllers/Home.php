<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $helpers = ['form'];

    /**
     * Data produk sementara. Ganti dengan ProdukModel
     * (mis. $this->produkModel->findAll()) saat database siap.
     */
    private function daftarProduk(): array
    {
        return [
            ['id' => 1, 'nama' => 'Sneakers Urban Lite',   'kategori' => 'Fashion',    'harga' => 349000, 'diskon' => 20, 'warna' => '#FFD23F'],
            ['id' => 2, 'nama' => 'Headphone Nirkabel X2', 'kategori' => 'Elektronik', 'harga' => 459000, 'diskon' => 15, 'warna' => '#9FB4FF'],
            ['id' => 3, 'nama' => 'Tas Ransel Harian',     'kategori' => 'Fashion',    'harga' => 275000, 'diskon' => 0,  'warna' => '#C9F2E1'],
            ['id' => 4, 'nama' => 'Lampu Meja Fleksibel',  'kategori' => 'Rumah',      'harga' => 129000, 'diskon' => 10, 'warna' => '#FFC7B8'],
            ['id' => 5, 'nama' => 'Smartwatch Fit S',      'kategori' => 'Elektronik', 'harga' => 799000, 'diskon' => 25, 'warna' => '#D9C8FF'],
            ['id' => 6, 'nama' => 'Set Gelas Keramik',     'kategori' => 'Rumah',      'harga' => 89000,  'diskon' => 0,  'warna' => '#BFE3F5'],
        ];
    }

    public function index(): string
    {
        $produk = $this->daftarProduk();

        $data = [
            'title'    => 'ShopEase – Belanja online tanpa antre',
            'unggulan' => array_slice($produk, 0, 4),
            'demo'     => array_slice($produk, 0, 3),
            'langkah'  => [
                ['judul' => 'Pilih produk',         'isi' => 'Lihat produk, harga, dan diskon terbaru tanpa datang ke toko.'],
                ['judul' => 'Masukkan keranjang',   'isi' => 'Kumpulkan beberapa barang sekaligus, ubah jumlahnya kapan saja.'],
                ['judul' => 'Bayar dan konfirmasi', 'isi' => 'Selesaikan checkout lalu kirim konfirmasi pembayaran.'],
                ['judul' => 'Terima di rumah',      'isi' => 'Pesanan dikirim lewat jasa pengiriman ke alamat Anda.'],
            ],
            'peran'    => [
                ['nama' => 'Pengunjung', 'isi' => 'Melihat katalog dan mendaftar sebagai pelanggan.'],
                ['nama' => 'Pelanggan',  'isi' => 'Berbelanja, menulis komentar, dan memberi testimoni produk.'],
                ['nama' => 'Admin',      'isi' => 'Mengelola produk, stok, transaksi, dan menerima notifikasi pesanan baru.'],
            ],
        ];

        return view('home/index', $data);
    }

    public function produk(): string
    {
        $kategori = $this->request->getGet('kategori');
        $semua    = $this->daftarProduk();
        $produk   = $semua;

        if ($kategori) {
            $produk = array_filter($semua, static fn ($p) => strcasecmp($p['kategori'], $kategori) === 0);
        }

        return view('home/produk', [
            'title'    => 'Semua produk – ShopEase',
            'produk'   => $produk,
            'kategori' => array_values(array_unique(array_column($semua, 'kategori'))),
            'aktif'    => $kategori,
        ]);
    }

    public function tentang(): string
    {
        return view('home/tentang', ['title' => 'Tentang ShopEase']);
    }

    public function berlangganan()
    {
        $rules = ['email' => 'required|valid_email|max_length[100]'];

        if (! $this->validate($rules)) {
            return redirect()->to(base_url('/') . '#promo')
                ->withInput()
                ->with('error', 'Alamat email belum valid. Periksa lagi penulisannya.');
        }

        // TODO: simpan ke tabel `subscribers` melalui model.
        return redirect()->to(base_url('/') . '#promo')
            ->with('success', 'Terima kasih! Info diskon akan dikirim ke ' . esc($this->request->getPost('email')) . '.');
    }
}
