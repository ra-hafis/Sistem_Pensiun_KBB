<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route Login
$routes->get('/login', 'Admin\Auth::login');
$routes->post('/login/process', 'Admin\Auth::processLogin');
$routes->get('/logout', 'Admin\Auth::logout');

// Lupa Password
$routes->get('/forgot-password', 'Admin\Auth::forgotPassword');
$routes->post('/forgot-password/process', 'Admin\Auth::processForgotPassword');

// Reset Password
$routes->get('/reset-password', 'Admin\Auth::resetPassword');
$routes->post('/reset-password/process', 'Admin\Auth::processResetPassword');

// ADMIN (BKPSDM)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {

    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Profil Admin
    $routes->get('profil', 'Admin\Profil::index');
    $routes->get('profil/edit', 'Admin\Profil::edit');
    $routes->post('profil/update', 'Admin\Profil::update');

    $routes->get('pengajuanDaftar', 'Admin\PengajuanDaftar::index');
    $routes->get('pengajuanKelola', 'Admin\PengajuanKelola::index');
    $routes->get('pengajuanKelola/updateStatus/(:num)/(:any)', 'Admin\PengajuanKelola::updateStatus/$1/$2');
    $routes->get('pengajuanDetail/(:num)', 'Admin\PengajuanDetail::index/$1');
    $routes->get('pengajuanFile/view/(:any)', 'Admin\PengajuanFile::view/$1');
    $routes->get('hapusdaftarpengajuan/(:num)', 'Admin\HapusDaftarPengajuan::index/$1');
    $routes->post('hapusdaftarpengajuan/(:num)', 'Admin\HapusDaftarPengajuan::hapus/$1');

    // Data Akun Dinas
    $routes->get('dataakundinas', 'Admin\DataAkunDinas::index');
    $routes->get('tambahdinas', 'Admin\TambahDinas::index');
    $routes->post('tambahdinas/simpan', 'Admin\TambahDinas::simpan');
    $routes->get('editdinas/(:num)', 'Admin\EditDinas::index/$1');
    $routes->post('editdinas/update/(:num)', 'Admin\EditDinas::update/$1');
    $routes->get('hapusdinas/(:num)', 'Admin\HapusDinas::index/$1');
    $routes->get('tes', 'Admin\DataPegawai::api');
});
$routes->get('/admin/data-pegawai', 'Admin\DataPegawai::index');


// DINAS (UNIT PEGAWAI)
$routes->group('dinas', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Dinas\Dashboard::index');

    // Pengajuan Dinas
    $routes->group('pengajuan', function ($routes) {
        $routes->get('/', 'Dinas\Pengajuan::index');
        $routes->get('tambah', 'Dinas\Pengajuan::tambah');
        $routes->post('simpan', 'Dinas\Pengajuan::store');
        $routes->get('detail/(:num)', 'Dinas\Pengajuan::detail/$1');
        $routes->post('update/(:num)', 'Dinas\Pengajuan::update/$1');
    });
});
$routes->get('testemail', 'TestEmail::index');
