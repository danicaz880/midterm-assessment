<?php
header("Content-Type: application/json; charset=UTF-8");

require_once(_DIR_ . "/../../db_connection.php");

try {
    
    $stmt = $conn->prepare("
    SELECT  p.program_id,
   
    p.program_name
    FROM program_tbl p
    JOIN institute_tbl i ON i.ins_id = p.ins_id 
    ORDER BY p.program_id DESC"
);
    $stmt->execute();
    $program_tbl = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "data" => $program_tbl
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}
