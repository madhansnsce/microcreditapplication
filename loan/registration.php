<?php
// Start a session for user data persistence
session_start();

// Define an empty array to store validation errors
$errors = array();

// Handle user registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    // Collect user input
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $fullName = $_POST["full_name"];
    // ... Collect other user details ...

    // Validate user input (you should add more validation)
    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    // ... Add more validation rules ...

    // If no validation errors, proceed
    if (empty($errors)) {
        // Store user data in session for loan application
        $_SESSION["user_data"] = array(
            "email" => $email,
            "mobile" => $mobile,
            "full_name" => $fullName,
            // ... Store other user details ...
        );

        // Redirect to loan application page
        header("Location: loan_application.php");
        exit();
    }
}

// HTML form for user registration
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <?php
    // Display validation errors, if any
    if (!empty($errors)) {
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Mobile Number:</label>
        <input type="text" name="mobile" required><br>
        <label>Full Name:</label>
        <input type="text" name="full_name" required><br>
        <!-- Add more input fields for other user details -->
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
