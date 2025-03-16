<?php
namespace App\Tables;

use App\Database\DB;

use PDO;

class Student
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $address;
    public $district;
    public $street;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->address = $data['address'] ?? '';
        $this->district = $data['district'] ?? '';
        $this->street = $data['street'] ?? '';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM students ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM students WHERE ";
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
            $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ?, password = ?, address = ?, district = ?, street = ? WHERE id = ?");
            return $stmt->execute([$this->name, $this->email, $this->phone, $this->password, $this->address, $this->district, $this->street, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO students (name, email, phone, password, address, district, street) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$this->name, $this->email, $this->phone, $this->password, $this->address, $this->district, $this->street]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
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

    public function getBookings()
    {
        return Booking::where(['student_id' => $this->id]);
    }
}
