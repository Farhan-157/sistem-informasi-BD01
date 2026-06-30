<?php

namespace App;

class AuthService
{
    private DatabaseWrapper $db;

    public function __construct(DatabaseWrapper $db)
    {
        $this->db = $db;
    }

    public function login(string $username, string $password): array
    {
        if (!Validator::validateUsername($username)) {
            return ['success' => false, 'error' => 'Username tidak valid!'];
        }

        if (!Validator::validatePassword($password)) {
            return ['success' => false, 'error' => 'Password tidak valid!'];
        }

        $username = $this->db->escapeString($username);
        $password = $this->db->escapeString($password);

        $result = $this->db->query(
            "SELECT * FROM tbl_users WHERE username='$username' AND password='$password'"
        );

        if ($result && $this->db->numRows($result) > 0) {
            return ['success' => true, 'username' => $username];
        }

        return ['success' => false, 'error' => 'Username atau Password salah!'];
    }

    public function register(string $username, string $password): array
    {
        if (!Validator::validateUsername($username)) {
            return ['success' => false, 'error' => 'Username tidak valid! Minimal 3 karakter.'];
        }

        if (!Validator::validatePassword($password)) {
            return ['success' => false, 'error' => 'Password tidak valid! Minimal 3 karakter.'];
        }

        $usernameEsc = $this->db->escapeString($username);

        $cek = $this->db->query(
            "SELECT * FROM tbl_users WHERE username='$usernameEsc'"
        );

        if ($cek && $this->db->numRows($cek) > 0) {
            return ['success' => false, 'error' => 'Username sudah digunakan!'];
        }

        $passwordEsc = $this->db->escapeString($password);

        $result = $this->db->query(
            "INSERT INTO tbl_users(username,password) VALUES('$usernameEsc','$passwordEsc')"
        );

        if ($result) {
            return ['success' => true, 'message' => 'Registrasi berhasil'];
        }

        return ['success' => false, 'error' => 'Gagal registrasi: ' . $this->db->error()];
    }

    public function findUser(string $username): array
    {
        if (!Validator::validateUsername($username)) {
            return ['found' => false, 'error' => 'Username tidak valid!'];
        }

        $usernameEsc = $this->db->escapeString($username);

        $result = $this->db->query(
            "SELECT * FROM tbl_users WHERE username='$usernameEsc'"
        );

        if ($result && $this->db->numRows($result) > 0) {
            return ['found' => true, 'username' => $username];
        }

        return ['found' => false, 'error' => 'Username tidak ditemukan'];
    }

    public function resetPassword(string $username, string $newPassword): array
    {
        if (!Validator::validateUsername($username)) {
            return ['success' => false, 'error' => 'Username tidak valid!'];
        }

        if (!Validator::validatePassword($newPassword)) {
            return ['success' => false, 'error' => 'Password baru tidak valid! Minimal 3 karakter.'];
        }

        $usernameEsc = $this->db->escapeString($username);
        $passwordEsc = $this->db->escapeString($newPassword);

        $result = $this->db->query(
            "UPDATE tbl_users SET password='$passwordEsc' WHERE username='$usernameEsc'"
        );

        if ($result) {
            return ['success' => true, 'message' => 'Password berhasil diubah'];
        }

        return ['success' => false, 'error' => 'Gagal mengubah password: ' . $this->db->error()];
    }
}
