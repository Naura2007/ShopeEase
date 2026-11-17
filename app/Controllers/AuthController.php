<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form'];
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // GET /register
    public function register()
    {
        return view('auth/register', ['title' => 'Registrasi – ShopEase']);
    }

    // POST /register
    public function store()
    {
        $rules = [
            'name' => [
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                ],
            ],
            'password_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak sama.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'name'     => trim($this->request->getPost('name')),
            'email'    => strtolower(trim($this->request->getPost('email'))),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer', // role selalu customer dari form publik
            'phone'    => $this->request->getPost('phone'),
            'address'  => $this->request->getPost('address'),
        ]);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    // GET /login
    public function login()
    {
        return view('auth/login', ['title' => 'Login – ShopEase']);
    }

    // POST /login
    public function authenticate()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');
        $user     = $this->userModel->where('email', $email)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        session()->regenerate(true); // cegah session fixation

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id_user'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);

        switch ($user['role']) {
            case 'admin':
                return redirect()->to('/admin');
            case 'operator':
                return redirect()->to('/operator');
            default:
                return redirect()->to('/');
        }
    }

    // POST /logout
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}
