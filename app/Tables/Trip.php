<?php
namespace App\Tables;

use App\Database\DB;

use PDO;

class Trip
{
    public $id;
    public $trip_date;
    public $trip_time;
    public $is_full;
    public $max_students;
    public $bus_id;
    public $route_id;
    public $status;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->trip_date = $data['trip_date'] ?? '';
        $this->trip_time = $data['trip_time'] ?? '';
        $this->is_full = $data['is_full'] ?? 0;
        $this->max_students = $data['max_students'] ?? 0;
        $this->bus_id = $data['bus_id'] ?? null;
        $this->route_id = $data['route_id'] ?? null;
        $this->status = $data['status'] ?? 'مجدول';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM trips ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM trips WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM trips WHERE ";
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
            $stmt = $conn->prepare("UPDATE trips SET trip_date = ?, trip_time = ?, is_full = ?, max_students = ?, bus_id = ?, route_id = ?, status = ? WHERE id = ?");
            return $stmt->execute([$this->trip_date, $this->trip_time, $this->is_full, $this->max_students, $this->bus_id, $this->route_id, $this->status, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO trips (trip_date, trip_time, is_full, max_students, bus_id, route_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$this->trip_date, $this->trip_time, $this->is_full, $this->max_students, $this->bus_id, $this->route_id, $this->status]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM trips WHERE id = ?");
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

    public function getBus()
    {
        return Bus::find($this->bus_id);
    }

    public function getRoute()
    {
        return Route::find($this->route_id);
    }

    public function getBookings()
    {
        return Booking::where(['trip_id' => $this->id]);
    }
}