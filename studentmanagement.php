<?php
// db connection
$conn = new mysqli("localhost", "root", "", "dzamora_db");

// Add / Update Student
if (isset($_POST['save']) || isset($_POST['update'])) {
    $id   = $_POST['id'] ?? null;
    $name = $_POST['name'];
    $prog = $_POST['program_id'];
    $allow = $_POST['allowance'];

    if (isset($_POST['save'])) {
        $conn->query("INSERT INTO student_tbl (name, program_id, ALLOWANCE) 
                      VALUES ('$name','$prog','$allow')");
    } else {
        $conn->query("UPDATE student_tbl SET name='$name', program_id='$prog', ALLOWANCE='$allow' 
                      WHERE stud_id=$id");
    }
    header("Location: students.php");
}

// Delete Student
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM student_tbl WHERE stud_id=" . $_GET['delete']);
    header("Location: students.php");
}

// Edit Mode
$edit = false; $id = $name = $prog = $allow = "";
if (isset($_GET['edit'])) {
    $edit = true;
    $res = $conn->query("SELECT * FROM student_tbl WHERE stud_id=" . $_GET['edit']);
    $row = $res->fetch_assoc();
    $id = $row['stud_id']; $name = $row['name']; $prog = $row['program_id']; $allow = $row['ALLOWANCE'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <style>
        body { font-family: Arial; margin:20px; }
        table { border-collapse: collapse; width:100%; margin-top:10px; }
        th,td { border:1px solid #aaa; padding:8px; text-align:center; }
        th { background:#4CAF50; color:#fff; }
        input { margin:5px; padding:5px; }
    </style>
</head>
<body>
<h2>Student Management</h2>

<!-- Student Table -->
<table>
<tr><th>ID</th><th>Name</th><th>Program</th><th>Allowance</th><th>Action</th></tr>
<?php
$res = $conn->query("SELECT * FROM student_tbl");
while ($r = $res->fetch_assoc()) {
    echo "<tr>
            <td>{$r['stud_id']}</td>
            <td>{$r['name']}</td>
            <td>{$r['program_id']}</td>
            <td>{$r['ALLOWANCE']}</td>
            <td>
              <a href='?edit={$r['stud_id']}'>Edit</a> | 
              <a href='?delete={$r['stud_id']}'>Delete</a>
            </td>
          </tr>";
}
?>
</table>

<!-- Add / Edit Form -->
<form method="POST">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="text" name="name" placeholder="Name" value="<?= $name ?>" required>
    <input type="number" name="program_id" placeholder="Program ID" value="<?= $prog ?>" required>
    <input type="number" name="allowance" placeholder="Allowance" value="<?= $allow ?>" required>
    <button type="submit" name="<?= $edit ? 'update':'save' ?>">
        <?= $edit ? 'Update' : 'Save' ?>
    </button>
</form>
</body>
</html>
