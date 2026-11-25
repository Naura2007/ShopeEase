<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProductController extends BaseController
{
    protected $helpers = ['url', 'form'];

    private const UPLOAD_DIR   = 'uploads/products/';
    private const MIME_ALLOWED = ['image/jpeg', 'image/png', 'image/webp'];
    private const MAX_KB       = 2048;
    private const MAX_FILES    = 5;

    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;
    protected ProductImageModel $imageModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->imageModel    = new ProductImageModel();
    }

    // GET /admin/products  (pencarian dan filter kategori)
    public function index()
    {
        $keyword  = trim((string) $this->request->getGet('q'));
        $kategori = (int) $this->request->getGet('kategori');

        $builder = $this->productModel
            ->select('products.*, categories.name AS category_name')
            ->join('categories', 'categories.id_category = products.id_category');

        if ($keyword !== '') {
            $builder->like('products.name', $keyword);
        }
        if ($kategori > 0) {
            $builder->where('products.id_category', $kategori);
        }

        return view('admin/products/index', [
            'title'      => 'Produk – ShopEase',
            'products'   => $builder->orderBy('products.id_product', 'DESC')->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'keyword'    => $keyword,
            'kategori'   => $kategori,
        ]);
    }

    // GET /admin/products/create
    public function create()
    {
        return view('admin/products/create', [
            'title'      => 'Tambah Produk – ShopEase',
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    // POST /admin/products/store
    public function store()
    {
        if (! $this->validate($this->productRules())) {
            return $this->backWithErrors($this->validator->getErrors());
        }
        if ($error = $this->checkImages()) {
            return $this->backWithErrors([$error]);
        }

        $name = trim((string) $this->request->getPost('name'));
        $db   = \Config\Database::connect();

        $db->transStart();
        $idProduct = (int) $this->productModel->insert(
            $this->productData($name, url_title($name, '-', true) . '-' . time())
        );
        $saved = $this->saveImages($idProduct);
        $db->transComplete();

        if (! $db->transStatus()) {
            $this->removeFiles($saved);
            return redirect()->back()->withInput()->with('error', 'Produk gagal disimpan. Silakan coba lagi.');
        }

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    // GET /admin/products/edit/(id)
    public function edit($id)
    {
        $id      = (int) $id;
        $product = $this->productModel->find($id);
        if (! $product) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/products/edit', [
            'title'      => 'Edit Produk – ShopEase',
            'product'    => $product,
            'categories' => $this->categoryModel->findAll(),
            'images'     => $this->imageModel->where('id_product', $id)
                                ->orderBy('is_primary', 'DESC')->findAll(),
        ]);
    }

    // POST /admin/products/update/(id)
    public function update($id)
    {
        $id = (int) $id;
        if (! $this->productModel->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }
        if (! $this->validate($this->productRules())) {
            return $this->backWithErrors($this->validator->getErrors());
        }
        if ($error = $this->checkImages()) {
            return $this->backWithErrors([$error]);
        }

        $name = trim((string) $this->request->getPost('name'));
        $db   = \Config\Database::connect();

        $db->transStart();
        $this->productModel->update($id, $this->productData($name, url_title($name, '-', true) . '-' . $id));
        $saved = $this->saveImages($id);
        $db->transComplete();

        if (! $db->transStatus()) {
            $this->removeFiles($saved);
            return redirect()->back()->withInput()->with('error', 'Produk gagal diperbarui.');
        }

        return redirect()->to('/admin/products/edit/' . $id)
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // POST /admin/products/delete/(id)
    public function delete($id)
    {
        $id = (int) $id;
        if (! $this->productModel->find($id)) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $files = array_column($this->imageModel->where('id_product', $id)->findAll(), 'image');

        $db = \Config\Database::connect();
        $db->transStart();
        $this->productModel->delete($id); // baris product_images ikut terhapus (ON DELETE CASCADE)
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Produk gagal dihapus.');
        }

        $this->removeFiles($files);

        return redirect()->to('/admin/products')->with('success', 'Produk berhasil dihapus.');
    }

    // POST /admin/products/image/delete/(id_image)
    public function deleteImage($idImage)
    {
        $image = $this->imageModel->find((int) $idImage);
        if (! $image) {
            throw PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $this->imageModel->delete($image['id_image']);

        // Jika gambar utama dihapus, jadikan gambar pertama yang tersisa sebagai utama
        if ((int) $image['is_primary'] === 1) {
            $next = $this->imageModel->where('id_product', $image['id_product'])->first();
            if ($next) {
                $this->imageModel->update($next['id_image'], ['is_primary' => 1]);
            }
        }
        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->with('error', 'Gambar gagal dihapus.');
        }

        $this->removeFiles([$image['image']]);

        return redirect()->to('/admin/products/edit/' . $image['id_product'])
            ->with('success', 'Gambar berhasil dihapus.');
    }

    // POST /admin/products/image/primary/(id_image)
    public function setPrimary($idImage)
    {
        $image = $this->imageModel->find((int) $idImage);
        if (! $image) {
            throw PageNotFoundException::forPageNotFound();
        }

        $db = \Config\Database::connect();
        $db->transStart();
        $db->table('product_images')
            ->where('id_product', $image['id_product'])
            ->update(['is_primary' => 0]);
        $this->imageModel->update($image['id_image'], ['is_primary' => 1]);
        $db->transComplete();

        return redirect()->to('/admin/products/edit/' . $image['id_product'])
            ->with('success', $db->transStatus() ? 'Gambar utama diperbarui.' : 'Gagal mengubah gambar utama.');
    }

    /* ---------- helper private ---------- */

    private function productRules(): array
    {
        return [
            'id_category' => 'required|is_natural_no_zero|is_not_unique[categories.id_category]',
            'name'        => 'required|min_length[3]|max_length[150]',
            'price'       => 'required|decimal',
            'stock'       => 'required|is_natural',
            'status'      => 'required|in_list[tersedia,tidak_tersedia]',
        ];
    }

    private function productData(string $name, string $slug): array
    {
        return [
            'id_category' => (int) $this->request->getPost('id_category'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => (int) $this->request->getPost('stock'),
            'status'      => $this->request->getPost('status'),
        ];
    }

    private function uploadedImages(): array
    {
        $files = $this->request->getFileMultiple('images') ?? [];

        return array_values(array_filter($files, static fn ($f) => $f->isValid()));
    }

    // Validasi gambar di sisi server (tipe MIME dan ukuran, serta jumlah file)
    private function checkImages(): ?string
    {
        $files = $this->uploadedImages();

        if (count($files) > self::MAX_FILES) {
            return 'Maksimal ' . self::MAX_FILES . ' gambar per unggahan.';
        }
        foreach ($files as $file) {
            if (! in_array($file->getMimeType(), self::MIME_ALLOWED, true)) {
                return 'Format gambar harus JPG, PNG, atau WEBP.';
            }
            if ($file->getSizeByUnit('kb') > self::MAX_KB) {
                return 'Ukuran setiap gambar maksimal 2 MB.';
            }
        }

        return null;
    }

    // Menyimpan file dengan nama acak. Gambar pertama otomatis menjadi utama bila belum ada.
    private function saveImages(int $idProduct): array
    {
        $files = $this->uploadedImages();
        if (empty($files)) {
            return [];
        }

        $dir = FCPATH . self::UPLOAD_DIR;
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $hasPrimary = $this->imageModel
            ->where('id_product', $idProduct)
            ->where('is_primary', 1)
            ->countAllResults() > 0;

        $saved = [];
        foreach ($files as $file) {
            $filename = $file->getRandomName();
            $file->move($dir, $filename);

            $this->imageModel->insert([
                'id_product' => $idProduct,
                'image'      => $filename,
                'is_primary' => $hasPrimary ? 0 : 1,
            ]);

            $hasPrimary = true;
            $saved[]    = $filename;
        }

        return $saved;
    }

    private function removeFiles(array $files): void
    {
        foreach ($files as $file) {
            $path = FCPATH . self::UPLOAD_DIR . $file;
            if (is_file($path)) {
                unlink($path);
            }
        }
    }

    private function backWithErrors(array $errors)
    {
        return redirect()->back()->withInput()->with('errors', $errors);
    }
}
