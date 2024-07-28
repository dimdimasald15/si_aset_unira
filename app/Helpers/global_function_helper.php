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
