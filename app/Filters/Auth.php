<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // belum login
        if (!$session->get('role')) {
            return redirect()->to('/login');
        }

        // kalau ada argumen role (misalnya 'admin' atau 'user')
        if ($arguments && isset($arguments[0])) {
            $requiredRole = $arguments[0];
            $currentRole = $session->get('role');

            if ($currentRole !== $requiredRole) {
                if ($currentRole === 'admin') {
                    return redirect()->to('/admin/dashboard')->with('error', 'Akses ditolak.');
                } elseif ($currentRole === 'dinas') {
                    return redirect()->to('/dinas/dashboard')->with('error', 'Akses ditolak.');
                } else {
                    return redirect()->to('/login')->with('error', 'Tidak punya akses!');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak dipakai
    }
}
