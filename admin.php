<?php
// ----------------------
// DATABASE CONNECTION
// ----------------------
$conn = new mysqli('localhost', 'root', '', 'test1');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// ----------------------
// DELETE STUDENT
// ----------------------
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM studentinfo WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']); // refresh page
    exit;
}

// ----------------------
// ADD STUDENT
// ----------------------
if (isset($_POST['add'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $name       = $conn->real_escape_string($_POST['name']);
    $email      = $conn->real_escape_string($_POST['email']);
    $course     = $conn->real_escape_string($_POST['course']);
    $year       = $conn->real_escape_string($_POST['year']);

    $stmt = $conn->prepare("INSERT INTO studentinfo (student_id, name, email, course, year) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $student_id, $name, $email, $course, $year);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']); // refresh page
    exit;
}

// ----------------------
// FETCH STUDENTS
// ----------------------
$result = $conn->query("SELECT * FROM studentinfo");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <style>
        body { font-family: Arial; background-color: #f8f9fa; padding: 20px; }
        table { border-collapse: collapse; width: 80%; margin: auto; background: white; }
        th, td { padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background-color: #007bff; color: white; }
        .delete-btn { background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; text-decoration: none; }
        form { text-align: center; margin-top: 20px; }
        input, select { padding: 5px; margin: 3px; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Student Registration</h2>

    <!-- Add Student Form -->
    <form method="POST" action="">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <select name="course" required>
            <option value="">Select Course</option>
            <option value="BSIT">BSIT</option>
            <option value="BSCS">BSCS</option>
            <option value="BSECE">BSECE</option>
            <option value="BSIS">BSIS</option>
        </select>
        <select name="year" required>
            <option value="">Select Year</option>
            <option value="1st Year">1st Year</option>
            <option value="2nd Year">2nd Year</option>
            <option value="3rd Year">3rd Year</option>
            <option value="4th Year">4th Year</option>
        </select>
        <button type="submit" name="add">Add Student</button>
    </form>

    <!-- Student Table -->
    <table>
        <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Course</th>
            <th>Year</th>
            <th>Action</th>
        </tr>

        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['course']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['student_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6">No data found</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
