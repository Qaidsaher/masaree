<?php 
namespace App\Tables;
use App\Database\DB;
use PDO;

class Student {
 
    public $id;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $address;
    public $district;
    public $street;

    protected static $pdo;

    /**
     * Set the PDO instance for database operations.
     *
     * @param PDO $pdo
     */
    public static function setPDO(PDO $pdo)
    {
        self::$pdo = $pdo;
    }

    /**
     * Constructor. Optionally initialize properties with an associative array.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->id       = $data['id'] ?? null;
        $this->name     = $data['name'] ?? '';
        $this->email    = $data['email'] ?? '';
        $this->phone    = $data['phone'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->address  = $data['address'] ?? '';
        $this->district = $data['district'] ?? '';
        $this->street   = $data['street'] ?? '';
    }

    /**
     * Retrieve all students from the database.
     *
     * @return array An array of Student objects.
     */
    public static function all()
    {
        $conn = DB::getConnection();
        $stmt = $conn->query("SELECT * FROM students ORDER BY id DESC");
        return array_map(fn($row) => new self($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Find a student by ID.
     *
     * @param mixed $id
     * @return self|null A Student object if found, otherwise null.
     */
    public static function find($id)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($data) : null;
    }

    /**
     * Retrieve students matching given conditions.
     *
     * @param array $conditions Associative array of column => value.
     * @return array An array of Student objects.
     */
    public static function where(array $conditions)
    {
        $conn = DB::getConnection();
        if (empty($conditions)) {
            return [];
        }
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

    /**
     * Save the student data to the database.
     * If the student has an ID, update the record; otherwise, insert a new record.
     *
     * @return bool True on success, false on failure.
     */
    public function save()
    {
        $conn = DB::getConnection();
        if ($this->id) {
            $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, phone = ?, password = ?, address = ?, district = ?, street = ? WHERE id = ?");
            return $stmt->execute([
                $this->name,
                $this->email,
                $this->phone,
                $this->password,
                $this->address,
                $this->district,
                $this->street,
                $this->id
            ]);
        } else {
            $stmt = $conn->prepare("INSERT INTO students (name, email, phone, password, address, district, street) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([
                $this->name,
                $this->email,
                $this->phone,
                $this->password,
                $this->address,
                $this->district,
                $this->street
            ]);
            if ($result) {
                $this->id = $conn->lastInsertId();
            }
            return $result;
        }
    }

    /**
     * Delete the student record from the database.
     *
     * @return bool True on success, false on failure.
     */
    public function delete()
    {
        if (!$this->id) {
            return false;
        }
        $conn = DB::getConnection();
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Fill the student model properties from an associative array.
     *
     * @param array $data
     */
    public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Retrieve bookings associated with this student.
     *
     * @return array An array of Booking objects.
     */
    public function getBookings()
    {
        // Adjust the namespace if your Booking model is in a different namespace.
        return \App\Tables\Booking::where(['student_id' => $this->id]);
    }
}
?>

`