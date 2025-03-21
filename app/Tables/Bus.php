<?php
namespace App\Tables;

use App\Database\DB;
use PDO;

class Bus
{
    public $id;
    public $bus_number;
    public $capacity;
    public $license_plate;
    public $driver_id;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->bus_number = $data['bus_number'] ?? '';
        $this->capacity = $data['capacity'] ?? 0;
        $this->license_plate = $data['license_plate'] ?? '';
        $this->driver_id = $data['driver_id'] ?? null;
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM buses ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM buses WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM buses WHERE ";
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
            $stmt = $conn->prepare("UPDATE buses SET bus_number = ?, capacity = ?, license_plate = ?, driver_id = ? WHERE id = ?");
            return $stmt->execute([$this->bus_number, $this->capacity, $this->license_plate, $this->driver_id, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO buses (bus_number, capacity, license_plate, driver_id) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$this->bus_number, $this->capacity, $this->license_plate, $this->driver_id]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM buses WHERE id = ?");
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

    public function getDriver()
    {
        return Driver::find($this->driver_id);
    }

    public function getTrips()
    {
        return Trip::where(['bus_id' => $this->id]);
    }
}