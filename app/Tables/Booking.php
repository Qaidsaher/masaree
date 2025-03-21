<?php
namespace App\Tables;
use App\Database\DB;
use PDO;
class Booking
{
    public $id;
    public $student_id;
    public $trip_id;
    public $booking_date;
    public $booking_status;

    protected static $pdo;

    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->student_id = $data['student_id'] ?? null;
        $this->trip_id = $data['trip_id'] ?? null;
        $this->booking_date = $data['booking_date'] ?? date('Y-m-d');
        $this->booking_status = $data['booking_status'] ?? 'قيد الانتظار';
    }

    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) return [];
        $query = "SELECT * FROM bookings WHERE ";
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
            $stmt = $conn->prepare("UPDATE bookings SET student_id = ?, trip_id = ?, booking_date = ?, booking_status = ? WHERE id = ?");
            return $stmt->execute([$this->student_id, $this->trip_id, $this->booking_date, $this->booking_status, $this->id]);
        } else {
            $stmt = $conn->prepare("INSERT INTO bookings (student_id, trip_id, booking_date, booking_status) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$this->student_id, $this->trip_id, $this->booking_date, $this->booking_status]);
            if ($result) $this->id = $conn->lastInsertId();
            return $result;
        }
    }

    public function delete()
    {
        if (!$this->id) return false;
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
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

    public function getStudent()
    {
        return Student::find($this->student_id);
    }

    public function getTrip()
    {
        return Trip::find($this->trip_id);
    }
}