<?php
namespace App\Tables;

use App\Database\DB;

use PDO;

class Route
{
    public $id;
    public $start_location;
    public $end_location;
    public $description;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->start_location = $data['start_location'] ?? '';
        $this->end_location = $data['end_location'] ?? '';
        $this->description = $data['description'] ?? '';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM routes ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM routes WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM routes WHERE ";
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
            $stmt = $conn->prepare("UPDATE routes SET start_location = ?, end_location = ?, description = ? WHERE id = ?");
            return $stmt->execute([$this->start_location, $this->end_location, $this->description, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO routes (start_location, end_location, description) VALUES (?, ?, ?)");
            $result = $stmt->execute([$this->start_location, $this->end_location, $this->description]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM routes WHERE id = ?");
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

    public function getTrips()
    {
        return Trip::where(['route_id' => $this->id]);
    }
}