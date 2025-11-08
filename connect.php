<?php
$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$course = $_POST['course'];
$year = $_POST['year'];

$conn = new mysqli('localhost', 'root', '', 'test1');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    // Insert data into 'studentinfo' table
    $stmt = $conn->prepare("INSERT INTO studentinfo (student_id, name, email, course, year) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_id, $name, $email, $course, $year);
    $stmt->execute();

    echo "✅ Registration successfully completed!";
    
    $stmt->close();
    $conn->close();
}
?>

<!-- Button to go back to index.php -->
<div style="text-align:center; margin-top:20px;">
    <form action="index.php" method="get">
        <button type="submit" style="padding:10px 20px; font-size:16px; cursor:pointer;">
            Go Back to Form
        </button>
    </form>
</div>
