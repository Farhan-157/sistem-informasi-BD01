<?php

namespace App;

class DatabaseWrapper
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function escapeString(string $value): string
    {
        return mysqli_real_escape_string($this->conn, $value);
    }

    public function query(string $sql)
    {
        return mysqli_query($this->conn, $sql);
    }

    public function numRows($result): int
    {
        return mysqli_num_rows($result);
    }

    public function fetchAssoc($result): ?array
    {
        return mysqli_fetch_assoc($result);
    }

    public function fetchArray($result): ?array
    {
        return mysqli_fetch_array($result);
    }

    public function error(): string
    {
        return mysqli_error($this->conn);
    }
}
