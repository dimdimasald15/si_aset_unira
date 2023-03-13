<?php

namespace Config;

class CustomValidation
{
  public function validuniqueruang(string $nama_ruang, ?string $nama_lantai, ?int $gedung_id, ?string &$error = null): bool
  {
    $ruang = new \App\Models\Ruang();

    if (!$ruang->uniqueRuang($nama_ruang, $nama_lantai, $gedung_id)) {
      $error = 'Ruang dengan nama yang sama sudah ada pada gedung dan lantai tersebut';
      return false;
    }

    return true;
  }
}
