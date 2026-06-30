<?php

namespace App;

class Validator
{
    public static function isNotEmpty(string $value): bool
    {
        return trim($value) !== '';
    }

    public static function validateRequired(array $fields): array
    {
        $errors = [];
        foreach ($fields as $name => $value) {
            if (!self::isNotEmpty($value)) {
                $errors[] = "$name tidak boleh kosong!";
            }
        }
        return $errors;
    }

    public static function validateNim(string $nim): bool
    {
        $nim = trim($nim);
        return $nim !== '' && preg_match('/^[0-9]+$/', $nim) === 1;
    }

    public static function validateNid(string $nid): bool
    {
        $nid = trim($nid);
        return $nid !== '' && preg_match('/^[A-Za-z0-9\-]+$/', $nid) === 1;
    }

    public static function validatePhone(string $phone): bool
    {
        $phone = trim($phone);
        if ($phone === '') {
            return true;
        }
        return preg_match('/^[0-9\+\-\s]+$/', $phone) === 1;
    }

    public static function validateSks(string $sks): bool
    {
        $sks = trim($sks);
        return $sks !== '' && preg_match('/^[0-9]+$/', $sks) === 1 && (int) $sks > 0 && (int) $sks <= 8;
    }

    public static function validateKodeMk(string $kode): bool
    {
        $kode = trim($kode);
        return $kode !== '' && preg_match('/^[A-Za-z0-9\-]+$/', $kode) === 1;
    }

    public static function validateUsername(string $username): bool
    {
        $username = trim($username);
        return $username !== '' && strlen($username) >= 3 && strlen($username) <= 50;
    }

    public static function validatePassword(string $password): bool
    {
        $password = trim($password);
        return $password !== '' && strlen($password) >= 3;
    }

    public static function sanitize(string $value): string
    {
        return trim($value);
    }
}
