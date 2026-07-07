<?php
/**
 * Script Penanganan Error 403 Custom (LiteSpeed/Apache).
 * Mendeteksi referer asal input data dan mengalihkannya kembali dengan parameter ?upload_error=403
 * agar pesan peringatan kegagalan upload / pembatasan keamanan dapat ditampilkan secara bersahabat di halaman form.
 */

$referer = $_SERVER['HTTP_REFERER'] ?? null;

if ($referer) {
    // Dapatkan data query referer untuk menghindari penumpukan parameter
    $separator = (parse_url($referer, PHP_URL_QUERY) === null) ? '?' : '&';
    
    // Jangan tumpuk jika referer sudah memiliki parameter upload_error
    if (strpos($referer, 'upload_error=403') === false) {
        $redirectUrl = $referer . $separator . 'upload_error=403';
    } else {
        $redirectUrl = $referer;
    }
    
    header("Location: " . $redirectUrl);
    exit;
}

// Jika referrer tidak terdeteksi, arahkan sebagai fallback ke homepage
header("Location: /");
exit;
