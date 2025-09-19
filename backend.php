<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dzamora_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
?>


<?php
header("Content-Type: application/json");
include "db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // 📌 Get all students
    case "GET":
        $result = $conn->query("SELECT * FROM student_tbl");
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        echo json_encode($students);
        break;

    // Add student
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['name'];
        $program = $data['program_id'];
        $allow = $data['allowance'];

        $sql = "INSERT INTO student_tbl (name, program_id, ALLOWANCE) VALUES ('$name', '$program', '$allow')";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Student added"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    // Update student
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        $id   = $data['stud_id'];
        $name = $data['name'];
        $program = $data['program_id'];
        $allow = $data['allowance'];

        $sql = "UPDATE student_tbl SET name='$name', program_id='$program', ALLOWANCE='$allow' WHERE stud_id=$id";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Student updated"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    // Delete Student
    case "DELETE":
        parse_str(file_get_contents("php://input"), $data);
        $id = $data['stud_id'];

        $sql = "DELETE FROM student_tbl WHERE stud_id=$id";
        if ($conn->query($sql)) {
            echo json_encode(["message" => "Student deleted"]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
}
?>
