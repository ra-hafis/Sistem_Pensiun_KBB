<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use Config\Services;

class TestEmail extends Controller
{
    public function index()
    {
        $email = Services::email();

        $email->setTo('rwinandi01@gmail.com'); // ganti dengan email tujuan test
        $email->setSubject('Tes SMTP Gmail dari XAMPP');
        $email->setMessage('<p>Berhasil! SMTP Gmail via CodeIgniter sudah jalan.</p>');

        if ($email->send()) {
            echo "✅ Email berhasil dikirim!";
        } else {
            echo "❌ Email gagal dikirim.<br>";
            echo $email->printDebugger(['headers', 'subject', 'body']);
        }

        // Hapus object supaya destructor tidak memanggil fwrite ke koneksi mati
        unset($email);
    }
}
