<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter untuk mendeteksi ketika payload POST terbuang oleh PHP engine
 * karena melebihi kapasitas 'post_max_size' pada php.ini.
 */
class UploadSizeFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Deteksi jika method POST, tapi $_POST dan $_FILES kosong,
        // namun header CONTENT_LENGTH menunjukkan bahwa ada data yang dikirimkan.
        // Ini adalah indikasi kuat bahwa PHP membuang post body karena limit 'post_max_size'.
        if (strtoupper($request->getMethod()) === 'POST'
            && empty($_POST)
            && empty($_FILES)
            && isset($_SERVER['CONTENT_LENGTH'])
            && (int)$_SERVER['CONTENT_LENGTH'] > 0
        ) {
            $postMaxSize = ini_get('post_max_size');
            
            // Simpan flashdata untuk feedback ke user
            session()->setFlashdata('error', "Gagal menyimpan data karena ukuran berkas foto terlalu besar (melebihi batas maksimal server {$postMaxSize}). Silakan kompres atau perkecil resolusi foto Anda.");
            
            // Redirect kembali ke halaman asal
            return redirect()->back()->withInput();
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak diperlukan tindakan setelah request
    }
}
