<?php
error_reporting(0);
include 'dbcon.php';


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$method = $_SERVER['REQUEST_METHOD'];

function get_students() {
    global $conn;
    $result = $conn->query("SELECT * FROM horizonstudents");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function create_student($Index_Number, $First_Name, $Last_Name, $City, $District, $Province, $Email_Address, $Mobile_Number) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO horizonstudents (Index_No, First_Name, Last_Name, City, District, Province, Email_Address, Mobile_Number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss",$Index_Number, $First_Name, $Last_Name, $City, $District, $Province, $Email_Address, $Mobile_Number);
    return $stmt->execute();

    if ($stmt->execute()) {
        return true;
    } else {
        // Log or handle the error
        echo "Error: " . $stmt->error;
        return false;
    }
}

function update_student($student_index, $First_Name, $Last_Name, $City, $District, $Province, $Email_Address, $Mobile_Number) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE horizonstudents SET First_Name=?, Last_Name=?, City=?, District=?, Province=?, Email_Address=?, Mobile_Number=? WHERE Index_No=?");
    $stmt->bind_param("sssssssi", $First_name, $Last_name, $City, $District, $Province, $Email_Address, $Mobile_number, $student_index);

    if ($stmt->execute()) {
        return true;
    } else {
        // Log or handle the error
        echo "Error: " . $stmt->error;
        return false;
    }
}

function delete_student($student_index) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM horizonstudents WHERE Index_No = ?");
    $stmt->bind_param("i", $student_index);

    if ($stmt->execute()) {
        return true;
    } else {
        // Log or handle the error
        echo "Error: " . $stmt->error;
        return false;
    }
}



switch ($method) {
    case 'GET':
        $data = get_students();
        echo json_encode($data);
        break;
    case 'POST':
        $post_data = json_decode(file_get_contents("php://input"), true);
        $success = create_student(
            $post_data['Index_Number'] ??'',
            $post_data['First_Name'] ??'',
            $post_data['Last_Name'] ??'',
            $post_data['City'] ??'',
            $post_data['District'] ??'',
            $post_data['Province'] ??'',
            $post_data['Email_Address'] ??'',
            $post_data['Mobile_Number'] ??''
        );
        echo json_encode(['success' => $success]);
        break;

        case 'PUT':
            $url_parts = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url_parts['query'], $query_params);
            $student_index = $query_params['id'] ?? 0;
        
            // Check if the ID is provided and not empty
            if (!empty($student_index)) {
                $put_data = json_decode(file_get_contents("php://input"), true);
        
                $success = update_student(
                    $student_index,
                    $put_data['First_Name'] ?? '',
                    $put_data['last_Name'] ?? '',
                    $put_data['city'] ?? '',
                    $put_data['district'] ?? '',
                    $put_data['province'] ?? '',
                    $put_data['Email_Address'] ?? '',
                    $put_data['Mobile_Number'] ?? ''
                );
        
                if ($success) {
                    http_response_code(200); // OK
                    echo json_encode(['status' => 'success', 'message' => 'Student updated successfully']);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update student']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['status' => 'error', 'message' => 'Invalid student ID']);
            }
            break;
        
    case 'DELETE':
            $url_parts = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url_parts['query'], $query_params);
            $student_index = $query_params['id'] ?? 0;
    
            // Check if the ID is provided and not empty
            if (!empty($student_index)) {
                $success = delete_student($student_index);
    
                // Provide a response based on the deletion result
                if ($success) {
                    http_response_code(200); // OK
                    echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully']);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete student']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['status' => 'error', 'message' => 'Invalid student ID']);
            }
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        header('Allow: GET, POST, PUT, DELETE');
        break;
}

?>