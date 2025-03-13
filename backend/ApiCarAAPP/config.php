<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";
$conn = new mysqli($servername, $username, $password);
// التحقق من الاتصال
if ($conn->connect_error) {
    die(json_encode(["error" => "فشل الاتصال بقاعدة البيانات"]));
}

// إنشاء قاعدة البيانات إذا لم تكن موجودة
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// إنشاء جدول المستخدمين
$conn->query("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        national_id VARCHAR(20) UNIQUE NOT NULL,
        phone VARCHAR(15) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('renter', 'customer') NOT NULL
    )");

// إنشاء جدول السيارات
$conn->query("CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(100),
    model VARCHAR(100),
    price DECIMAL(10,2),
    image VARCHAR(255),
    colors VARCHAR(255) NOT NULL,
    type VARCHAR(50) NOT NULL,
    status ENUM('available', 'rented') DEFAULT 'available',
    renter_id INT,
    FOREIGN KEY (renter_id) REFERENCES users(id) ON DELETE SET NULL
)");

$conn->query("CREATE TABLE IF NOT EXISTS car_images_specs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    specifications TEXT,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
)");

$conn->query("CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_id INT NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

 // إنشاء جدول الإيجارات (إذا لم يكن موجودًا)
 $createRentalsTableQuery = "CREATE TABLE IF NOT EXISTS rentals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_id INT NOT NULL,
    rental_duration INT NOT NULL,
    rental_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";
$conn->query($createRentalsTableQuery);

?>
