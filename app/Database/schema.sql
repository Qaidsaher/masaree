- Drop tables in the correct order to prevent foreign key issues
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS trips;
DROP TABLE IF EXISTS routes;
DROP TABLE IF EXISTS buses;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS drivers;
DROP TABLE IF EXISTS admins;

-- Create the admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Create the drivers table
CREATE TABLE drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE
);

-- Create the students table with password, district, and street
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL, -- Added password field
    address VARCHAR(255) NOT NULL,
    district VARCHAR(100) NOT NULL, -- Added district field
    street VARCHAR(100) NOT NULL -- Added street field
);

-- Create the buses table
CREATE TABLE buses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_number VARCHAR(50) NOT NULL UNIQUE,
    capacity INT NOT NULL CHECK (capacity > 0),
    license_plate VARCHAR(20) NOT NULL UNIQUE,
    driver_id INT NOT NULL,
    FOREIGN KEY (driver_id) REFERENCES drivers(id) ON DELETE CASCADE
);

-- Create the routes table
CREATE TABLE routes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    start_location VARCHAR(100) NOT NULL,
    end_location VARCHAR(100) NOT NULL,
    description TEXT
);

-- Create the trips table
CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_date DATE NOT NULL,
    trip_time TIME NOT NULL,
    is_full TINYINT(1) DEFAULT 0,
    max_students INT NOT NULL CHECK (max_students > 0),
    bus_id INT NOT NULL,
    route_id INT NOT NULL,
    status ENUM('مجدول', 'مكتمل', 'ملغى') NOT NULL DEFAULT 'مجدول',
    FOREIGN KEY (bus_id) REFERENCES buses(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE
);

-- Create the bookings table
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    trip_id INT NOT NULL,
    booking_date DATE NOT NULL DEFAULT (CURRENT_DATE),
    booking_status ENUM('مؤكد', 'قيد الانتظار', 'ملغى') NOT NULL DEFAULT 'قيد الانتظار',
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
);

-- Insert sample data for admins
INSERT INTO admins (username, password, email) VALUES
('Masaree1', 'password1', 'admin1@masari.com'),
('Masaree2', 'password2', 'admin2@masari.com'),
('Masaree3', 'password3', 'admin3@masari.com'),
('Masaree4', 'password4', 'admin4@masari.com'),
('Masaree5', 'password5', 'admin5@masari.com');

-- Insert sample data for drivers
INSERT INTO drivers (name, phone, email) VALUES
('سائق ١', '0100000001', 'driver1@masari.com'),
('سائق ٢', '0100000002', 'driver2@masari.com'),
('سائق ٣', '0100000003', 'driver3@masari.com'),
('سائق ٤', '0100000004', 'driver4@masari.com'),
('سائق ٥', '0100000005', 'driver5@masari.com');

-- Insert sample data for students with password, district, and street
INSERT INTO students (name, email, phone, password, address, district, street) VALUES
('طالب ١', 'student1@masari.com', '0111111111', 'Student@123', 'القاهرة', 'مدينة نصر', 'شارع عباس العقاد'),
('طالب ٢', 'student2@masari.com', '0111111112', 'Password@234', 'الجيزة', 'الدقي', 'شارع التحرير'),
('طالب ٣', 'student3@masari.com', '0111111113', 'Secure#Pass3', 'الإسكندرية', 'سموحة', 'شارع فوزي معاذ'),
('طالب ٤', 'student4@masari.com', '0111111114', 'Pass!word4', 'طنطا', 'حي الجامعة', 'شارع الجيش'),
('طالب ٥', 'student5@masari.com', '0111111115', 'Masari@2025', 'أسيوط', 'المعلمين', 'شارع الهلالي');

-- Insert sample data for buses
INSERT INTO buses (bus_number, capacity, license_plate, driver_id) VALUES
('حافلة ١', 40, '123-أ', 1),
('حافلة ٢', 35, '456-ب', 2),
('حافلة ٣', 45, '789-ج', 3),
('حافلة ٤', 50, '101-د', 4),
('حافلة ٥', 30, '111-ه', 5);

-- Insert sample data for routes
INSERT INTO routes (start_location, end_location, description) VALUES
('القاهرة', 'الجيزة', 'طريق سريع من القاهرة إلى الجيزة'),
('القاهرة', 'الإسكندرية', 'رحلة طويلة من القاهرة إلى الإسكندرية'),
('الجيزة', 'الإسكندرية', 'طريق مباشر بين الجيزة والإسكندرية'),
('القاهرة', 'أسوان', 'رحلة من القاهرة إلى أسوان'),
('القاهرة', 'طنطا', 'طريق محلي من القاهرة إلى طنطا');

-- Insert sample data for trips
INSERT INTO trips (trip_date, trip_time, is_full, max_students, bus_id, route_id, status) VALUES
('2025-04-01', '08:00:00', 0, 35, 1, 1, 'مجدول'),
('2025-04-02', '09:00:00', 0, 30, 2, 2, 'مجدول'),
('2025-04-03', '10:00:00', 0, 40, 3, 3, 'مجدول'),
('2025-04-04', '11:00:00', 0, 45, 4, 4, 'مجدول'),
('2025-04-05', '12:00:00', 0, 25, 5, 5, 'مجدول');

-- Insert sample data for bookings
INSERT INTO bookings (student_id, trip_id, booking_date, booking_status) VALUES
(1, 1, '2025-03-20', 'مؤكد'),
(2, 2, '2025-03-21', 'مؤكد'),
(3, 3, '2025-03-22', 'قيد الانتظار'),
(4, 4, '2025-03-23', 'مؤكد'),
(5, 5, '2025-03-24', 'قيد الانتظار');