<?php 
    session_start();
    require_once __DIR__ . '/../connect.php';

    if(isset($_POST['add'])){
        if(!empty($_POST['book_name']) && !empty($_POST['description']) && !empty($_POST['book_category'])&& isset($_POST['book_stock']) && !empty($_POST['book_status'])){
            $book_name = $connect->real_escape_string($_POST['book_name']);
            $description = $connect->real_escape_string($_POST['description']);
            $book_category = $connect->real_escape_string($_POST['book_category']);
            $book_stock = $connect->real_escape_string($_POST['book_stock']);
            $book_status = $connect->real_escape_string($_POST['book_status']);

            // ตั้งค่าโฟลเดอร์ปลายทาง
            $targetDir = "../../public/asset/book/";
            $fileType = pathinfo($_FILES["book_image"]["name"], PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        
            if (in_array(strtolower($fileType), $allowTypes)) {
                // สร้างชื่อไฟล์ใหม่ที่ไม่ซ้ำกัน
                $newFileName = uniqid() . "_" . basename($_FILES["book_image"]["name"]);
                $targetFilePath = $targetDir . $newFileName;

                $sql = "INSERT INTO `book` (`book_image`, `book_name`, `description`, `book_category`,  `book_stock`) 
                VALUES ('$newFileName', '$book_name', '$description', '$book_category',  '$book_stock')";

                // อัปโหลดไฟล์ไปยังเซิร์ฟเวอร์
                if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $targetFilePath) && $query = $connect->query($sql)) {
                        echo "success";
                        $_SESSION["alert"] = 'success';
                        header('Location: ../../public/admin/manage_book.php'); 
                        exit();
                } else {
                    echo "unsuccess";
                    $_SESSION["alert"] = 'unsuccess';
                    header('Location: ../../public/admin/manage_book.php'); 
                    exit();
                }
            } else {
                echo "Invalid file type.";
                $_SESSION["alert"] = 'unsuccess';
                header('Location: ../../public/admin/manage_book.php'); 
                exit();
            }
        }else{
            echo "unsuccess";
            $_SESSION["alert"] = 'unsuccess';
            header('Location: ../../public/admin/manage_book.php'); 
            exit();
        }
    }


if (isset($_POST['update'])) {
    if(!empty($_POST['book_name']) && !empty($_POST['description']) && !empty($_POST['book_category'])&& isset($_POST['book_stock']) && !empty($_POST['book_status']) && !empty($_POST['book_id']) ){
        $book_id = $connect->real_escape_string($_POST['book_id']);
        $book_name = $connect->real_escape_string($_POST['book_name']);
        $description = $connect->real_escape_string($_POST['description']);
        $book_category = $connect->real_escape_string($_POST['book_category']);
        $book_stock = $connect->real_escape_string($_POST['book_stock']);
        $book_status = $connect->real_escape_string($_POST['book_status']);

            // Retrieve current image filename from the database
    $sql_get_image = "SELECT `book_image` FROM `book` WHERE `book_id` = '$book_id'";
    $result = mysqli_query($connect, $sql_get_image);
    $currentImage = mysqli_fetch_assoc($result)['book_image'];

        
        if (!empty($_FILES['book_image']['name'])) {
            $targetDir = "../../public/asset/book/";
            $fileType = strtolower(pathinfo($_FILES['book_image']['name'], PATHINFO_EXTENSION));
            $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($fileType, $allowTypes)) {
                $newFileName = uniqid() . "_" . basename($_FILES['book_image']['name']);
                $targetFilePath = $targetDir . $newFileName;
                
                // Delete the old image if it exists
                if (!empty($currentImage) && file_exists($targetDir . $currentImage)) {
                    unlink($targetDir . $currentImage); // Remove old image
                }
    
                if (move_uploaded_file($_FILES['book_image']['tmp_name'], $targetFilePath)) {
                    // Update the query to include the new image
                    $sql = "UPDATE `book` SET `book_name` = '$book_name', `description` = '$description', `book_category` = '$book_category', `book_stock` = '$book_stock', `book_status` = '$book_status',  `book_image` = '$newFileName' WHERE `book_id` = '$book_id'";
                } else {
                    // echo "Failed to upload image.";
                    $_SESSION['alert'] = "unsuccess";
                    header('Location: ../../public/admin/manage_book.php');
                    exit;
                }
            } else {
                // echo "Invalid file type. Allowed types: jpg, jpeg, png, gif.";
                $_SESSION['alert'] = "unsuccess";
                header('Location: ../../public/admin/manage_book.php');
                exit;
            }
        } else {
            // Query without updating the image
            $sql = "UPDATE `book` SET `book_name` = '$book_name', `description` = '$description', `book_category` = '$book_category', `book_stock` = '$book_stock', `book_status` = '$book_status' WHERE `book_id` = '$book_id'";
        }
    
        // Execute query
        if ($connect->query($sql)) {
            echo "Update successful.";
            $_SESSION['alert'] = "success";
            header('Location: ../../public/admin/manage_book.php');
            exit;
        } else {
            echo "Update failed: " . mysqli_error($connect);
            $_SESSION['alert'] = "unsuccess";
            header('Location: ../../public/admin/manage_book.php');
        }
    
        mysqli_close($connect);
    } else {
        echo "Invalid request.";
        $_SESSION['alert'] = "unsuccess";
        header('Location: ../../public/admin/manage_book.php');
        exit;
        }
    }



if (isset($_POST['delete'])) {
    if (!empty($_POST['book_id'])) {
        $book_id = mysqli_real_escape_string($connect, $_POST['book_id']);

    // Retrieve the current image filename from the database
    $sql_get_image = "SELECT `book_image` FROM `book` WHERE `book_id` = '$book_id'";
    $result = $connect->query($sql_get_image);
    $currentImage = mysqli_fetch_assoc($result)['book_image'];

    // Check if the image exists and delete it
    if (!empty($currentImage)) {
        $targetDir = "../../public/asset/book/";
        $imagePath = $targetDir . $currentImage;

        if (file_exists($imagePath)) {
            unlink($imagePath); // Remove the old image
        }
    }

    // Delete the book record from the database
    $sql = "DELETE FROM book WHERE book_id = '$book_id'";
    $query = $connect->query($sql);

    if ($query) {
        echo "delete success";
        $_SESSION['alert'] = "success";
        header('Location: ../../public/admin/manage_book.php');
        exit;
    } else {
        echo "delete ไม่ได้";
        $_SESSION['alert'] = "unsuccess";
        header('Location: ../../public/admin/manage_book.php');
        exit;
    }
    }else{
        echo "delete ไม่ได้";
        $_SESSION['alert'] = "unsuccess";
        header('Location: ../../public/admin/manage_book.php');
        exit;        
    }

}











?>