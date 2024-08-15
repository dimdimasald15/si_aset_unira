<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Ceklogin implements FilterInterface
{
  protected $session;

  public function __construct()
  {
    $this->session = session();
  }

  public function errorPage403($title, $msg)
  {
    $data = [
      'title' => $title,
      'msg' => $msg,
    ];
    return $data;
  }

  public function before(RequestInterface $request, $arguments = null)
  {
    if (!session('isLoggedIn')) {
      return redirect()->to('auth');
    }
    // Exclude specific paths from token verification
    $excludedPaths = [
      "/admin/dashboard",
      "/admin/kategori",
      "/admin/gedung",
      "/admin/ruang",
      "/admin/notification",
      "/admin/laporan",
      "/admin/profile",
      "/admin/pengguna",
      "/admin/anggota",
      "/admin/peminjaman-barang",
      "/admin/permintaan-barang",
      "/admin/kelola-barang",
    ];
    $path = $request->uri->getPath();
    if (!in_array($path, $excludedPaths, true)) {
      $header = $request->getServer("HTTP_AUTHORIZATION");
      if (!$header) {
        $response = service('response');
        $data = $this->errorPage403('Unauthorized', 'Access denied');
        $response->setStatusCode(403);
        return $response->setBody(view('errors/mazer/error-403', $data));
      } else {
        try {
          $token = explode(' ', $header)[1];
          $decoded = decodeJWT($token);
          $request->user = $decoded;
          $this->session->set('user', (array)$decoded);
        } catch (Exception $e) {
          $response = service("response");
          $data = $this->errorPage403('Unauthorized', 'Token invalid: ' . $e->getMessage());
          $response->setStatusCode(403);
          return $response->setBody(view('errors/mazer/error-403', $data));
        }
      }
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
