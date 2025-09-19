
Edielyn
<?php
header("Content-Type: application/json");
require_once _DIR_ . "/../../db_connection.php";

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['program_name'],$data['ins_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "Missing required fields: program_name, ins_id"
    ]);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO program_tbl (program_name, ins_id) VALUES (?, ?)");
    $stmt->execute([
        $data['program_name'],
        $data['ins_id']
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Program added successfully",
        "program_id" => $conn->lastInsertId() 
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
