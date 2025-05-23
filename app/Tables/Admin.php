<?php
namespace App\Tables;

use App\Database\DB;

use PDO;
class Admin
{
    public $id;
    public $username;
    public $password;
    public $email;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->email = $data['email'] ?? '';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM admins ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM admins WHERE ";
        $params = [];
        $conditionsArray = [];
        foreach ($conditions as $column => $value) {
            $conditionsArray[] = "$column = ?";
            $params[] = $value;
        }
        $query .= implode(" AND ", $conditionsArray) . " ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function save()
    {
        $conn = DB::getConnection();
        if ($this->id) {
            $stmt = $conn->prepare("UPDATE admins SET username = ?, password = ?, email = ? WHERE id = ?");
            return $stmt->execute([$this->username, $this->password, $this->email, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO admins (username, password, email) VALUES (?, ?, ?)");
            $result = $stmt->execute([$this->username, $this->password, $this->email]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}

