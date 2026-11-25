<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CategoryController extends BaseController
{
    protected $helpers = ['url', 'form'];
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    // GET /admin/categories
    public function index()
    {
        return view('admin/categories/index', [
            'title'      => 'Kategori – ShopEase',
            'categories' => $this->categoryModel->findAll(),
        ]);
    }

    // GET /admin/categories/create
    public function create()
    {
        return view('admin/categories/create', ['title' => 'Tambah Kategori – ShopEase']);
    }

    // POST /admin/categories/store
    public function store()
    {
        if (! $this->validate($this->categoryRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $this->categoryModel->insert(
            $this->categoryData($name, url_title($name, '-', true) . '-' . time())
        );

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    // GET /admin/categories/edit/(id)
    public function edit($id)
    {
        $category = $this->categoryModel->find((int) $id);
        if (! $category) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/categories/edit', [
            'title'    => 'Edit Kategori – ShopEase',
            'category' => $category,
        ]);
    }

    // POST /admin/categories/update/(id)
    public function update($id)
    {
        $id = (int) $id;
        if (! $this->categoryModel->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }
        if (! $this->validate($this->categoryRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim((string) $this->request->getPost('name'));
        $this->categoryModel->update($id, $this->categoryData($name, url_title($name, '-', true) . '-' . $id));

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    // POST /admin/categories/delete/(id)
    public function delete($id)
    {
        $id = (int) $id;
        if (! $this->categoryModel->find($id)) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $hasProducts = (new ProductModel())->where('id_category', $id)->countAllResults();
        if ($hasProducts > 0) {
            return redirect()->back()->with('error', 'Kategori masih memiliki produk.');
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
    }

    private function categoryRules(): array
    {
        return ['name' => 'required|min_length[3]|max_length[100]'];
    }

    private function categoryData(string $name, string $slug): array
    {
        return [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
        ];
    }
}
