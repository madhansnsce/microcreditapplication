<?php
session_start(); // Start the session to access stored user data

// Check if the user is logged in (session contains their data)
if (!isset($_SESSION['user_data'])) {
    header('Location: registration.php'); // Redirect to the registration page if not registered
    exit();
}

// Access user data from the session
$userData = $_SESSION['user_data'];

// Initialize variables to store loan-related data
$eligibleForLoan = false;
$loanAmount = 0;
$repaymentPeriod = 0;
$emi = 0;
$riskScore = 0;

// Process the loan application form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["apply_loan"])) {
    // Collect user input from the form (ensure proper validation)
    $currentSalary = floatval($_POST["current_salary"]);
    $previousSalary = floatval($_POST["previous_salary"]);
    $ownHouse = $_POST["own_house"] == 'yes' ? true : false;
    // ... Collect other loan application details ...

    // Perform loan eligibility calculations and risk assessment (simplified for illustration)
    if ($currentSalary > 0 && $currentSalary >= $previousSalary) {
        $eligibleForLoan = true;
        $loanAmount = $currentSalary * 2; // Example loan calculation
        $repaymentPeriod = 12; // Example repayment period
        $emi = $loanAmount / $repaymentPeriod; // Example EMI calculation
        $riskScore = calculateRiskScore($currentSalary, $previousSalary, $ownHouse);
    }
}

// Function to calculate a simplified risk score (you can implement a more complex algorithm)
function calculateRiskScore($currentSalary, $previousSalary, $ownHouse) {
    $riskScore = 0;
    if ($currentSalary > $previousSalary) {
        $riskScore += 10;
    }
    if ($ownHouse) {
        $riskScore += 5;
    }
    // Add more factors to calculate a comprehensive risk score
    return $riskScore;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loan Application</title>
</head>
<body>
    <h2>Loan Application</h2>
    
    <?php
    // Display loan eligibility and details
    if ($eligibleForLoan) {
        echo "<p>Congratulations! You are eligible for a loan.</p>";
        echo "<p>Loan Amount: $loanAmount</p>";
        echo "<p>Repayment Period: $repaymentPeriod months</p>";
        echo "<p>Estimated Monthly Installment (EMI): $emi</p>";
        echo "<p>Risk Score: $riskScore</p>";
    } else {
        echo "<p>Sorry, you are not eligible for a loan at this time.</p>";
    }
    ?>

    <!-- Loan Application Form (simplified for illustration) -->
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Current Salary:</label>
        <input type="number" name="current_salary" required><br>
        <label>Previous Salary:</label>
        <input type="number" name="previous_salary" required><br>
        <label>Do you own a house?</label>
        <input type="radio" name="own_house" value="yes" required> Yes
        <input type="radio" name="own_house" value="no" required> No<br>
        <!-- Add more input fields for other loan application details -->
        <input type="submit" name="apply_loan" value="Apply for Loan">
    </form>
</body>
</html>
