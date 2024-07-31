<?php
if (!function_exists('countRowsWithSameNamaAnggota')) {
    function countRowsWithSameNamaAnggota($data, $currentNamaAnggota)
    {
        $count = 0;
        foreach ($data as $row) {
            if ($row['nama_anggota'] === $currentNamaAnggota) {
                $count++;
            }
        }
        return $count;
    }
}
if (!function_exists('obfuscateEmail')) {
    function obfuscateEmail($email)
    {
        list($username, $domain) = explode('@', $email);
        $firstChar = substr($username, 0, 1);
        $obfuscatedUsername = $firstChar . str_repeat('*', strlen($username) - 1);
        return $obfuscatedUsername . '@' . $domain;
    }
}
if (!function_exists('convert_string_to_array_items_photos')) {
    function convert_string_to_array_photos($path, $imgItems)
    {
        $decoded_items = html_entity_decode($imgItems, ENT_QUOTES, 'UTF-8');
        // Decode JSON menjadi array PHP
        $photos = json_decode($decoded_items, true);
        // Inisialisasi array untuk menyimpan hasil
        $imagesToLoad = [];
        // Proses data
        if (is_array($photos)) {
            foreach ($photos as $image) {
                $imagesToLoad[] = [
                    'Url' => base_url() . $path . $image,
                    'Name' => $image
                ];
            }
        }
        return $imagesToLoad;
    }
}
if (!function_exists('generateGalleryItems')) {
    function generateGalleryItems($path_foto, $images)
    {
        $html = '<div class="row justify-content-center">';
        $count = count($images);
        foreach ($images as $index => $image) {
            // Penggunaan operator ternary untuk class
            $col_class = ($count > 0 && $count < 3) ? "col-lg-6 col-md-6" : "col-lg-3 col-md-3";

            $html .= '
                <a href="#" class="' . $col_class . ' row justify-content-center mb-2" data-bs-toggle="modal" data-bs-target="#modalDetail">
                    <img data-bs-target="#lightboxCarousel" data-bs-slide-to="' . $index . '" src="' . base_url() . $path_foto . $image . '" class="img-fluid shadow-md responsive-img" alt="pict-' . $image . '">
                </a>';
        }
        $html .= '</div>';
        return $html;
    }
}

if (!function_exists('generateCarouselItems')) {
    function generateCarouselItems($path_foto, $images)
    {
        $html = "";
        if ($images) {
            $html .= '<div class="carousel-inner ratio ratio-16x9 bg-dark">';
            foreach ($images as $index => $image) {
                $activeClass = $index === 0 ? ' active' : '';
                $html .= '
                  <div class="carousel-item text-center' . $activeClass . '">
                      <img src="' . base_url() . $path_foto . $image . '" class="img-fluid mh-100" alt="pict-' . $image . '">
                  </div>';
            }
            $html .= '</div>';
        }
        return $html;
    }
}
