<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// استدعاء ملف الإعدادات
require_once("config.php");
$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

switch ($method) {
    case 'POST':

        // if ($endpoint == 'signup') {
        //     // التحقق من أن الطلب هو POST
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //         // قراءة البيانات المرسلة من الواجهة الأمامية
        //         $data = json_decode(file_get_contents('php://input'), true);
        //         // ا
        //         // جلتحقق من وجود جميع الحقول المطلوبة
        //         if (isset($data['full_name'], $data['phone'], $data['email'], $data['password'], $data['confirm_password'], $data['role'])) {
        //             $full_name = $data['full_name'];
        //             $phone = $data['phone'];
        //             $email = $data['email'];
        //             $password = $data['password'];
        //             $confirm_password = $data['confirm_password'];
        //             $role = $data['role']; // 'renter' أو 'customer'
        //             // التحقق من تطابق كلمة المرور
        //             if ($password !== $confirm_password) {
        //                 http_response_code(400); // Bad Request
        //                 echo json_encode(array('error' => 'كلمة المرور غير متطابقة'));
        //                 exit;
        //             }
        //             // التحقق من أن البريد الإلكتروني غير مسجل مسبقًا
        //             $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        //             $stmt->bind_param("s", $email);
        //             $stmt->execute();
        //             $result = $stmt->get_result();
        //             if ($result->num_rows > 0) {
        //                 http_response_code(400); // Bad Request
        //                 echo json_encode(array('error' => 'البريد الإلكتروني مسجل مسبقًا'));
        //                 exit;
        //             }
        //             // تشفير كلمة المرور
        //             $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        //             // إدخال المستخدم الجديد في قاعدة البيانات
        //             $stmt = $conn->prepare("INSERT INTO users (name, phone, email, password, role) VALUES (?, ?, ?, ?, ?)");
        //             $stmt->bind_param("sssss", $full_name, $phone, $email, $hashed_password, $role);
        //             if ($stmt->execute()) {
        //                 http_response_code(201); // Created
        //                 echo json_encode(array('message' => 'تم تسجيل المستخدم بنجاح'));
        //             } else {
        //                 http_response_code(500); // Internal Server Error
        //                 echo json_encode(array('error' => 'فشل في تسجيل المستخدم'));
        //             }
        //         } else {
        //             http_response_code(400); // Bad Request
        //             echo json_encode(array('error' => 'جميع الحقول مطلوبة'));
        //         }
        //     } else {
        //         http_response_code(405); // Method Not Allowed
        //         echo json_encode(array('error' => 'الطريقة غير مسموحة'));
        //     }
        // }
        if ($endpoint == 'signup') {
            // التحقق من أن الطلب هو POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // قراءة البيانات المرسلة من الواجهة الأمامية
                $data = json_decode(file_get_contents('php://input'), true);
        
                // التحقق من وجود جميع الحقول المطلوبة
                if (isset($data['name'], $data['national_id'], $data['phone'], $data['email'], $data['password'], $data['role'])) {
                    $name = $data['name'];
                    $national_id = $data['national_id'];
                    $phone = $data['phone'];
                    $email = $data['email'];
                    $password = $data['password'];
                    $role = $data['role']; // 'renter' أو 'customer'
        
                    // التحقق من أن البريد الإلكتروني غير مسجل مسبقًا
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
        
                    if ($result->num_rows > 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(array('error' => 'البريد الإلكتروني مسجل مسبقًا'));
                        exit;
                    }
        
                    // التحقق من أن الرقم الوطني غير مسجل مسبقًا
                    $stmt = $conn->prepare("SELECT * FROM users WHERE national_id = ?");
                    $stmt->bind_param("s", $national_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
        
                    if ($result->num_rows > 0) {
                        http_response_code(400); // Bad Request
                        echo json_encode(array('error' => 'الرقم الوطني مسجل مسبقًا'));
                        exit;
                    }
        
                    // تشفير كلمة المرور
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
                    // إدخال المستخدم الجديد في قاعدة البيانات
                    $stmt = $conn->prepare("INSERT INTO users (name, national_id, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $name, $national_id, $phone, $email, $hashed_password, $role);
        
                    if ($stmt->execute()) {
                        http_response_code(201); // Created
                        echo json_encode(array('message' => 'تم تسجيل المستخدم بنجاح'));
                    } else {
                        http_response_code(500); // Internal Server Error
                        echo json_encode(array('error' => 'فشل في تسجيل المستخدم'));
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(array('error' => 'جميع الحقول مطلوبة'));
                }
            } else {
                http_response_code(405); // Method Not Allowed
                echo json_encode(array('error' => 'الطريقة غير مسموحة'));
        
            }
        
        }

        if($endpoint === 'book_car') {
            // قراءة البيانات المرسلة من الواجهة الأمامية
            $data = json_decode(file_get_contents("php://input"), true);
        
            // التحقق من وجود جميع الحقول المطلوبة
            if (isset($data['car_id'], $data['user_id'], $data['pickup_date'], $data['return_date'], $data['total_price'])) {
                $carId = $data['car_id'];
                $userId = $data['user_id'];
                $pickupDate = $data['pickup_date'];
                $returnDate = $data['return_date'];
                $totalPrice = $data['total_price'];
        
                // إدخال بيانات الحجز في قاعدة البيانات
                $query = "INSERT INTO bookings (car_id, user_id, pickup_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iissd", $carId, $userId, $pickupDate, $returnDate, $totalPrice);
        
                if ($stmt->execute()) {
                    // تحديث حالة السيارة إلى "محجوزة"
                    $updateQuery = "UPDATE cars SET status = 'rented' WHERE id = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("i", $carId);
                    $updateStmt->execute();
        
                    // إرجاع رسالة نجاح
                    http_response_code(201); // Created
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'تم حجز السيارة بنجاح'
                    ]);
                } else {
                    // إرجاع رسالة خطأ في حالة فشل الإدخال
                    http_response_code(500); // Internal Server Error
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'فشل في حجز السيارة'
                    ]);
                }
            } }
        if ($endpoint == 'login') {
            // التحقق من أن الطلب هو POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // قراءة البيانات المرسلة من الواجهة الأمامية
                $data = json_decode(file_get_contents('php://input'), true);
        
                // التحقق من وجود جميع الحقول المطلوبة
                if (isset($data['email'], $data['password'])) {
                    $email = $data['email'];
                    $password = $data['password'];
        
                    // البحث عن المستخدم باستخدام البريد الإلكتروني
                    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
        
                    if ($result->num_rows > 0) {
                        $user = $result->fetch_assoc();
        
                        // التحقق من كلمة المرور
                        if (password_verify($password, $user['password'])) {
                            // التحقق من وجود عملية إيجار مرتبطة بالمستخدم
                            $stmt = $conn->prepare("SELECT * FROM rentals WHERE user_id = ?");
                            $stmt->bind_param("i", $user['id']);
                            $stmt->execute();
                            $rentalResult = $stmt->get_result();
        
                            $hasRental = $rentalResult->num_rows > 0;
        
                            // تسجيل الدخول ناجح
                            http_response_code(200); // OK
                            echo json_encode(array(
                                'message' => 'تم تسجيل الدخول بنجاح',
                                'user' => array(
                                    'id' => $user['id'],
                                    'name' => $user['name'],
                                    'role' => $user['role']
                                ),
                                'hasRental' => $hasRental
                            ));
                        } else {
                            // كلمة المرور غير صحيحة
                            http_response_code(401); // Unauthorized
                            echo json_encode(array('error' => 'كلمة المرور غير صحيحة'));
                        }
                    } else {
                        // البريد الإلكتروني غير مسجل
                        http_response_code(404); // Not Found
                        echo json_encode(array('error' => 'البريد الإلكتروني غير مسجل'));
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(array('error' => 'جميع الحقول مطلوبة'));
                }
            } else {
                http_response_code(405); // Method Not Allowed
                echo json_encode(array('error' => 'الطريقة غير مسموحة'));
            }
        }
        // if ($endpoint == 'login') {
        //     // التحقق من أن الطلب هو POST
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //         // قراءة البيانات المرسلة من الواجهة الأمامية
        //         $data = json_decode(file_get_contents('php://input'), true);
        //         // التحقق من وجود جميع الحقول المطلوبة
        //         if (isset($data['email'], $data['password'])) {
        //             $email = $data['email'];
        //             $password = $data['password'];
        //             // البحث عن المستخدم باستخدام البريد الإلكتروني
        //             $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        //             $stmt->bind_param("s", $email);
        //             $stmt->execute();
        //             $result = $stmt->get_result();
        //             if ($result->num_rows > 0) {
        //                 $user = $result->fetch_assoc();
        //                 // التحقق من كلمة المرور
        //                 if (password_verify($password, $user['password'])) {
        //                     // تسجيل الدخول ناجح
        //                     http_response_code(200); // OK
        //                     echo json_encode(array('message' => 'تم تسجيل الدخول بنجاح', 'user' => $user));
        //                 } else {
        //                     // كلمة المرور غير صحيحة
        //                     http_response_code(401); // Unauthorized
        //                     echo json_encode(array('error' => 'كلمة المرور غير صحيحة'));
        //                 }
        //             } else {
        //                 // البريد الإلكتروني غير مسجل
        //                 http_response_code(404); // Not Found
        //                 echo json_encode(array('error' => 'البريد الإلكتروني غير مسجل'));
        //             }
        //         } else {
        //             http_response_code(400); // Bad Request
        //             echo json_encode(array('error' => 'جميع الحقول مطلوبة'));
        //         }
        //     } else {
        //         http_response_code(405); // Method Not Allowed
        //         echo json_encode(array('error' => 'الطريقة غير مسموحة'));
        //     }
        // }

        if ($endpoint == 'add_car') {
            // التحقق من أن الطلب هو POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // التحقق من وجود جميع الحقول المطلوبة
                if (isset($_POST['brand'], $_POST['model'], $_POST['colors'], $_POST['type'], $_POST['price'], $_FILES['image'])) {
                    $brand = $_POST['brand'];
                    $model = $_POST['model'];
                    $colors = $_POST['colors'];
                    $type = $_POST['type'];
                    $price = $_POST['price'];
                    // معالجة صورة السيارة
                    $target_dir = "uploads/";
                    $image_name = basename($_FILES["image"]["name"]);
                    $target_file = $target_dir . $image_name;
        
                    // تحقق من أن الملف هو صورة
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                    if (!in_array($imageFileType, $allowedExtensions)) {
                        http_response_code(400); // Bad Request
                        echo json_encode(["status" => "error", "message" => "نوع الملف غير مدعوم. يرجى تحميل صورة (JPG, JPEG, PNG, GIF)"]);
                        exit;
                    }
                    // تحميل الصورة إلى المجلد المحدد
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        // إدخال السيارة الجديدة في قاعدة البيانات باستخدام Prepared Statements
                        $query = "INSERT INTO cars (brand, model, colors, type, price, image, status) 
                                  VALUES (?, ?, ?, ?, ?, ?, 'available')";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ssssds", $brand, $model, $colors, $type, $price, $target_file);
        
                        if ($stmt->execute()) {
                            http_response_code(201); // Created
                            echo json_encode(["status" => "success", "message" => "تمت إضافة السيارة بنجاح"]);
                        } else {
                            http_response_code(500); // Internal Server Error
                            echo json_encode(["status" => "error", "message" => "فشل في إضافة السيارة"]);
                        }
                    } else {
                        http_response_code(500); // Internal Server Error
                        echo json_encode(["status" => "error", "message" => "فشل في تحميل الصورة"]);
                    }
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["status" => "error", "message" => "جميع الحقول مطلوبة"]);
                }
            } else {
                http_response_code(405); // Method Not Allowed
                echo json_encode(["status" => "error", "message" => "الطريقة غير مسموحة"]);
            }
        }
        if ($endpoint == 'add_images_specs'){
     // قراءة البيانات المرسلة من الواجهة الأمامية
     $data = json_decode(file_get_contents("php://input"), true);
     if (isset($data['car_id'], $data['user_id'], $data['pickup_date'], $data['return_date'], $data['total_price'])) {
         $carId = $data['car_id'];
         $userId = $data['user_id'];
         $pickupDate = $data['pickup_date'];
         $returnDate = $data['return_date'];
         $totalPrice = $data['total_price'];
 
         // إدخال بيانات الحجز في قاعدة البيانات
         $query = "INSERT INTO bookings (car_id, user_id, pickup_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)";
         $stmt = $conn->prepare($query);
         $stmt->bind_param("iissd", $carId, $userId, $pickupDate, $returnDate, $totalPrice);
 
         if ($stmt->execute()) {
             // تحديث حالة السيارة إلى "محجوزة"
             $updateQuery = "UPDATE cars SET status = 'rented' WHERE id = ?";
             $updateStmt = $conn->prepare($updateQuery);
             $updateStmt->bind_param("i", $carId);
             $updateStmt->execute();
 
             // إرجاع رسالة نجاح
             http_response_code(201); // Created
             echo json_encode([
                 'status' => 'success',
                 'message' => 'تم حجز السيارة بنجاح'
             ]);
         } else {
             // إرجاع رسالة خطأ في حالة فشل الإدخال
             http_response_code(500); // Internal Server Error
             echo json_encode([
                 'status' => 'error',
                 'message' => 'فشل في حجز السيارة'
             ]);
         }
     } else {
         // إرجاع رسالة خطأ إذا كانت البيانات غير مكتملة
         http_response_code(400); // Bad Request
         echo json_encode([
             'status' => 'error',
             'message' => 'جميع الحقول مطلوبة'
         ]);
     }
}
        if ($endpoint == 'add_images_specs') {
            // التحقق من أن الطلب هو POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // التحقق من وجود جميع الحقول المطلوبة
                if (isset($_POST['car_id'], $_POST['type'], $_POST['model'], $_POST['engine'], $_POST['color'], $_POST['price'], $_FILES['images'])) {
                    $carId = $_POST['car_id'];
                    $type = $_POST['type'];
                    $model = $_POST['model'];
                    $engine = $_POST['engine'];
                    $color = $_POST['color'];
                    $price = $_POST['price'];
                    // تحويل المواصفات إلى JSON
                    $specifications = json_encode([
                        'type' => $type,
                        'model' => $model,
                        'engine' => $engine,
                        'color' => $color,
                        'price' => $price
                    ]);
                    // معالجة الصور
                    $target_dir = "uploads/cars/";
                    $uploadedImages = [];
                    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                        $image_name = basename($_FILES['images']['name'][$key]);
                        $target_file = $target_dir . $image_name;
                        // تحقق من أن الملف هو صورة
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
                        if (!in_array($imageFileType, $allowedExtensions)) {
                            http_response_code(400); // Bad Request
                            echo json_encode(["status" => "error", "message" => "نوع الملف غير مدعوم. يرجى تحميل صورة (JPG, JPEG, PNG, GIF)"]);
                            exit;
                        }
                        // تحميل الصورة إلى المجلد المحدد
                        if (move_uploaded_file($tmp_name, $target_file)) {
                            $uploadedImages[] = $target_file;
                        } else {
                            http_response_code(500); // Internal Server Error
                            echo json_encode(["status" => "error", "message" => "فشل في تحميل الصورة: $image_name"]);
                            exit;
                        }
                    }
                    // إدخال الصور والمواصفات في الجدول الجديد
                    foreach ($uploadedImages as $image) {
                        $query = "INSERT INTO car_images_specs (car_id, image_url, specifications) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("iss", $carId, $image, $specifications);
        
                        if (!$stmt->execute()) {
                            http_response_code(500); // Internal Server Error
                            echo json_encode(["status" => "error", "message" => "فشل في إضافة الصور والمواصفات"]);
                            exit;
                        }
                    }
                    http_response_code(201); // Created
                    echo json_encode(["status" => "success", "message" => "تمت إضافة الصور والمواصفات بنجاح"]);
                } else {
                    http_response_code(400); // Bad Request
                    echo json_encode(["status" => "error", "message" =>  " اااااااااااااااااااااجميع الحقول مطلوبة"]);
                }
            } else {
                http_response_code(405); // Method Not Allowed
                echo json_encode(["status" => "error", "message" => "الطريقة غير مسموحة"]);
            }
        }
        // if ($endpoint == 'add_car') {
        //     // التحقق من أن الطلب هو POST
        //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //         // قراءة البيانات المرسلة من الواجهة الأمامية
        //         $data = json_decode(file_get_contents('php://input'), true);
        //         // التحقق من وجود جميع الحقول المطلوبة
        //         if (isset($data['brand'], $data['model'], $data['colors'], $data['type'], $data['price'])) {
        //             $brand = $data['brand'];
        //             $model = $data['model'];
        //             $colors = $data['colors'];
        //             $type = $data['type'];
        //             $price = $data['price'];
        //             // إدخال السيارة الجديدة في قاعدة البيانات
        //             $stmt = $conn->prepare("INSERT INTO cars (brand, model, colors, type, price, status) VALUES (?, ?, ?, ?, ?, 'available')");
        //             $stmt->bind_param("ssssd", $brand, $model, $colors, $type, $price);
        
        //             if ($stmt->execute()) {
        //                 http_response_code(201); // Created
        //                 echo json_encode(array('message' => 'تمت إضافة السيارة بنجاح'));
        //             } else {
        //                 http_response_code(500); // Internal Server Error
        //                 echo json_encode(array('error' => 'فشل في إضافة السيارة'));
        //             }
        //         } else {
        //             http_response_code(400); // Bad Request
        //             echo json_encode(array('error' => 'جميع الحقول مطلوبة'));
        //         }
        //     } else {
        //         http_response_code(405); // Method Not Allowed
        //         echo json_encode(array('error' => 'الطريقة غير مسموحة'));
        //     }
        // }


        // if ($endpoint == 'add_car') {
        //     $brand = $_POST['brand'];
        //     $model = $_POST['model'];
        //     $price = $_POST['price'];
            
        //     $target_dir = "uploads/";
        //     $image_name = basename($_FILES["image"]["name"]);
        //     $target_file = $target_dir . $image_name;
        //     if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        //         $query = "INSERT INTO cars (brand, model, price, image, status) 
        //                   VALUES ('$brand', '$model', '$price', '$target_file', 'available')";
        //         if ($conn->query($query) === TRUE) {

        //             echo json_encode( value: ["status" => "success","message" => "Car added successfully"]);
        //         } else {
        //             echo json_encode(["status" => "error","error" => "Failed to add car"]);
        //         }
        //     } else {
        //         echo json_encode(["error" => "Failed to upload image"]);
        //     }
        // }
        break;
    
 
    case 'PUT':
        if ($endpoint == 'update_price') {
            $data = json_decode(file_get_contents("php://input"), true);
            $car_id = $data['car_id'];
            $new_price = $data['price'];
            $query = "UPDATE cars SET price='$new_price' WHERE id='$car_id'";
            if ($conn->query($query) === TRUE) {
                echo json_encode(["message" => "Price updated successfully"]);
            } else {
                echo json_encode(["error" => "Failed to update price"]);
            }
        }
        break;

    case 'GET':
        // if ($endpoint == 'get_cars') {
        //     $result = $conn->query("SELECT * FROM cars ");
        //     $cars = $result->fetch_all(MYSQLI_ASSOC);
        //     echo json_encode($cars);
        // }
        if ($endpoint == 'getimages') {
            // التحقق من وجود معرف السيارة في الطلب
            if (isset($_GET['id'])) {
                $carId = $_GET['id'];
                // استعلام لجلب الصور والمواصفات من جدول car_images_specs
                $query = "SELECT image_url, specifications FROM car_images_specs WHERE car_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $carId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $images = [];
                    $specifications = null;
                    // تجميع الصور والمواصفات
                    while ($row = $result->fetch_assoc()) {
                        $images[] = $row;
                        if ($specifications === null) {
                            $specifications = $row['specifications'];
                        }
                    }
                    // إرجاع البيانات كـ JSON
                    echo json_encode([
                        'status' => 'success',
                        'images' => $images,
                        'specifications' => $specifications
                    ]);
                } else {
                    // إرجاع رسالة خطأ إذا لم يتم العثور على بيانات
                    http_response_code(404); // Not Found
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'لا توجد بيانات لهذه السيارة'
                    ]);
                }
            } else {
                // إرجاع رسالة خطأ إذا لم يتم تقديم معرف السيارة
                http_response_code(400); // Bad Request
                echo json_encode([
                    'status' => 'error',
                    'message' => 'معرف السيارة مطلوب'
                ]);
            }
        }

        if ($endpoint == 'get_car_details') {
            // التحقق من وجود معرف السيارة في الطلب
            if (isset($_GET['id'])) {
                $carId = $_GET['id'];

                // استعلام لجلب تفاصيل السيارة
                $query = "SELECT * FROM cars WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $carId);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $car = $result->fetch_assoc();
                    // إرجاع تفاصيل السيارة كـ JSON
                    echo json_encode($car);
                } else {
                    // إرجاع رسالة خطأ إذا لم يتم العثور على السيارة
                    http_response_code(404); // Not Found
                    echo json_encode(array('error' => 'السيارة غير موجودة'));
                }
            } else {
                // إرجاع رسالة خطأ إذا لم يتم تقديم معرف السيارة
                http_response_code(400); // Bad Request
                echo json_encode(array('error' => 'معرف السيارة مطلوب'));
            }
        }
        
        if ($endpoint == 'get_carsws') {
            // التحقق من وجود بيانات المستخدم في الطلب (مثل معرف المستخدم أو الدور)
            $user_role = isset($_GET['user_role']) ? $_GET['user_role'] : null;
            if ($user_role === 'admin') {
                // إذا كان المستخدم مسؤولًا، جلب جميع السيارات
                $query = "SELECT * FROM cars";
            } else {
                // إذا كان المستخدم زائرًا أو مستأجرًا، جلب السيارات المتاحة فقط
                $query = "SELECT * FROM cars WHERE status = 'available'";
            }
            $result = $conn->query($query);
            if ($result) {
                $cars = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($cars);
            } else {
                http_response_code(500); // Internal Server Error
                // echo json_encode(["status" => "error", "message" => "فشل في جلب بيانات صصصصصصصالسيارات"]);
                echo json_encode(array('error' => 'Failed to fetch rented cars'));
            }
        }
        if ($endpoint == 'rented_cars') {
            // استعلام لجلب السيارات المؤجرة مع معلومات المستأجر ومدة التأجير
            $query = "SELECT cars.id, cars.brand, cars.model, cars.price, users.name AS renter_name, 
                             DATEDIFF(bookings.return_date, bookings.pickup_date) AS rental_duration 
                      FROM cars 
                      JOIN bookings ON cars.id = bookings.car_id 
                      JOIN users ON bookings.user_id = users.id 
                      WHERE cars.status='rented'";
            $result = $conn->query($query);
        
            if ($result) {
                $cars = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($cars);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'Failed to fetch rented cars'));
            }
        }
        if ($endpoint == 'available_cars') {
            $result = $conn->query("SELECT * FROM cars WHERE status='available'");
            if ($result) {
                $cars = $result->fetch_all(MYSQLI_ASSOC);       
                // إضافة المسار الكامل لصورة السيارة
                foreach ($cars as &$car) {
                    $car['image'] = "http://localhost/ApiCarAAPP/" . $car['image'];
                }
                // إرجاع البيانات كـ JSON
                header('Content-Type: application/json');
                echo json_encode($cars);
            } else {
                // إرجاع رسالة خطأ في حالة فشل الاستعلام
                header('Content-Type: application/json');
                echo json_encode(array('error' => 'Failed to fetch available cars'));
            }
        }
        
        // if ($endpoint == 'renter_info') {
        //     $national_id = $_GET['national_id'];
        //     $result = $conn->query("SELECT * FROM users WHERE national_id='$national_id'");
        //     $user = $result->fetch_assoc();
        //     echo json_encode($user);
        // }

        if ($endpoint == 'all_renters_info') {
            // استعلام لجلب معلومات جميع المستأجرين مع تفاصيل الإيجارات
            $query = "SELECT users.name AS renter_name, users.national_id, cars.brand, cars.model, 
                             DATEDIFF(bookings.return_date, bookings.pickup_date) AS rental_duration, 
                             bookings.pickup_date AS rental_date 
                      FROM users 
                      JOIN bookings ON users.id = bookings.user_id 
                      JOIN cars ON bookings.car_id = cars.id 
                      WHERE users.role = 'renter'"; // افترضنا أن المستأجرين لديهم دور 'renter'
            $result = $conn->query($query);
        
            if ($result) {
                $renters = $result->fetch_all(MYSQLI_ASSOC);
                echo json_encode($renters);
            } else {
                // إرجاع رسالة خطأ في حالة فشل الاستعلام
                http_response_code(500); // Internal Server Error
                echo json_encode(array('error' => 'فشل في جلب بيانات المستأجرين'));
            }
        }

        if ($endpoint == 'renter_info') {
            // التحقق من وجود national_id في الطلب
            if (isset($_GET['national_id'])) {
                $national_id = $_GET['national_id'];
        
                // استعلام لجلب معلومات المستأجر مع تفاصيل الحجوزات
                $query = "SELECT 
                            users.name AS renter_name, 
                            cars.brand, 
                            cars.model, 
                            bookings.pickup_date, 
                            bookings.return_date, 
                            bookings.total_price 
                          FROM users 
                          JOIN bookings ON users.id = bookings.user_id 
                          JOIN cars ON bookings.car_id = cars.id 
                          WHERE users.national_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $national_id);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $bookings = $result->fetch_all(MYSQLI_ASSOC);
                    echo json_encode([
                        'status' => 'success',
                        'bookings' => $bookings
                    ]);
                } else {
                    // إرجاع رسالة خطأ إذا لم يتم العثور على بيانات
                    http_response_code(404); // Not Found
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'لا توجد حجوزات لهذا المستخدم'
                    ]);
                }
            } else {
                // إرجاع رسالة خطأ إذا لم يتم تقديم national_id
                http_response_code(400); // Bad Request
                echo json_encode([
                    'status' => 'error',
                    'message' => 'الرقم الوطني مطلوب'
                ]);
            }
        }

        if ($endpoint == 'get_car_specs') {
            // التحقق من وجود معرف السيارة في الطلب
            if (isset($_GET['id'])) {
                $carId = $_GET['id'];
                // استعلام لجلب المواصفات من جدول car_images_specs
                $query = "SELECT specifications FROM car_images_specs WHERE car_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $carId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $specs = $result->fetch_assoc();
                    echo json_encode($specs);
                } else {
                    // إرجاع رسالة خطأ إذا لم يتم العثور على بيانات
                    http_response_code(404); // Not Found
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'لا توجد مواصفات لهذه السيارة'
                    ]);
                }
            } else {
                // إرجاع رسالة خطأ إذا لم يتم تقديم معرف السيارة
                http_response_code(400); // Bad Request
                echo json_encode([
                    'status' => 'error',
                    'message' => 'معرف السيارة مطلوب'
                ]);
            }
        }
        if ($endpoint == 'renter_info') {
            // التحقق من وجود national_id في الطلب
            if (isset($_GET['national_id'])) {
                $national_id = $_GET['national_id'];
        
                // استعلام لجلب معلومات المستأجر مع تفاصيل الإيجارات
                $query = "SELECT users.name AS renter_name, cars.brand, cars.model, rentals.rental_duration 
                          FROM users 
                          JOIN rentals ON users.id = rentals.user_id 
                          JOIN cars ON rentals.car_id = cars.id 
                          WHERE users.national_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $national_id);
                $stmt->execute();
                $result = $stmt->get_result();
        
                if ($result->num_rows > 0) {
                    $rentals = $result->fetch_all(MYSQLI_ASSOC);
                    echo json_encode($rentals);
                } else {
                    // إرجاع رسالة خطأ إذا لم يتم العثور على بيانات
                    http_response_code(404); // Not Found
                    echo json_encode(array('error' => 'لا توجد بيانات للمستأجر'));
                }
            } else {
                // إرجاع رسالة خطأ إذا لم يتم تقديم national_id
                http_response_code(400); // Bad Request
                echo json_encode(array('error' => 'الرقم الوطني مطلوب'));
            }
        }
            if ($endpoint == 'get_cars') {
                $query = "SELECT id,brand FROM cars";
                $result = $conn->query($query);
                $cars = array();                
    // if ($result) {
    //     $cars = array();
    //     while ($row = $result->fetch_assoc()) {
    //         $cars[] = $row;
    //     }
    //     echo json_encode($cars);
    // } else {
    //     echo json_encode(array('error' => 'Failed to fetch cars'));
    
    //         }
    if ($result) {
        $cars = array();
        while ($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
        // إرجاع البيانات كـ JSON
        header('Content-Type: application/json');
        echo json_encode($cars);
       
    } else {
        // إرجاع رسالة خطأ كـ JSON
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'Failed to fetch cars'));
       
    }
      
}

if ($endpoint == 'get_user_bookings') {
    // التحقق من وجود معرف المستخدم في الطلب
    if (isset($_GET['user_id'])) {
        $userId = $_GET['user_id'];
        // استعلام لجلب بيانات الحجز من جدول bookings
        $query = "SELECT * FROM bookings WHERE user_id = ?";
        $stmt = $conn->prepare(query: $query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $bookings = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(value: [
                'status' => 'success',
                'bookings' => $bookings
            ]);
        } else {
            // إرجاع رسالة خطأ إذا لم يتم العثور على بيانات
            http_response_code(404); // Not Found
            echo json_encode([
                'status' => 'error',
                'message' => 'لا توجد حجوزات لهذا المستخدم'
            ]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode([
            'status' => 'error',
            'message' => 'معرف المستخدم مطلوب'
        ]);
    }}
            break;
            
     

    default:
        echo json_encode(["error" => "Invalid Request"]);
}

$conn->close();
?>
