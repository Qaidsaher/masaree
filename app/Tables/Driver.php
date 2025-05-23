<?php
namespace App\Tables;

use App\Database\DB;

use PDO;

class Driver
{
    public $id;
    public $name;
    public $phone;
    public $email;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id    = $data['id'] ?? null;
        $this->name  = $data['name'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->email = $data['email'] ?? '';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM drivers ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM drivers WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM drivers WHERE ";
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
            $stmt = $conn->prepare("UPDATE drivers SET name = ?, phone = ?, email = ? WHERE id = ?");
            return $stmt->execute([$this->name, $this->phone, $this->email, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO drivers (name, phone, email) VALUES (?, ?, ?)");
            $result = $stmt->execute([$this->name, $this->phone, $this->email]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM drivers WHERE id = ?");
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

    public function getBuses()
    {
        return Bus::where(['driver_id' => $this->id]);
    }
}
