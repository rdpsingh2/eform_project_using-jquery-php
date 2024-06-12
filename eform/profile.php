<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <title>Document</title>
</head>
<body>
  

<?php
// profile.php

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "employees";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $employee_id = $_POST['employee_id'];
    $employee_code = "EMP" . str_pad($employee_id, 4, '0', STR_PAD_LEFT);

    $update_sql = "UPDATE employees SET approval_status = 'Approved', employee_code = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $employee_code, $employee_id);
    $update_stmt->execute();
}

// Fetch the name from the URL
$name = $_GET['name'];

// Prepare and execute the SQL query
$sql = "SELECT * FROM employees WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

// Display the profile data
if ($result->num_rows > 0) {
    echo "<table border=1'>";
    echo "<tr>
    <th>Father/Husband Name</th><br><th>Date of Birth</th>
    <th>Joining Date</th><th>Age@joining</th><th>Qualification</th><th>OtherQualification</th><th>Select Languages</th><th>Enter Character</th><th>Experience Years</th><th>Experience Months</th><th>Designation</th><th>Salary</th><th>Present Address</th><th>Present State</th>
    <th>Present City</th><th>Other City</th><th>Present Pincode</th><th>Permanent Address</th><th>Permanent State</th> <th> Permanent City</th><th>Other Permanent City</th><th>Permanent Pincode</th><th>Primary No</th><th>Alternative No</th><th>WhatsApp No</th> <th>E-Mail ID</th>
    <th>Permanent Ph No</th><th>Marital Status</th><th>Spouse Name</th><th>Spouse No</th><th>Account Number</th><th>IFSC Code</th><th>Branch Name</th><th>ESI Number</th>
    <th>PF Number</th><th>Site Name</th><th>Adhaar No</th><th>Adhaar Image</th><th>Other_ID</th><th>Other ID Image</th><th>Employee Signature</th><th>Documented By</th><th>Approval Status</th><th>Actions</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["father_husband_name"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["joining_date"] . "</td>";
        echo "<td>" . $row["joining_age"] . "</td>";
        echo "<td>" . $row["qualification"] . "</td>";
        echo "<td>" . $row["otherQualification"] . "</td>";
        echo "<td>" . $row["select_languages"] . "</td>";
        echo "<td>" . $row["enter_character"] . "</td>";
        echo "<td>" . $row["experience_years"] . "</td>";
        echo "<td>" . $row["experience_months"] . "</td>";
        echo "<td>" . $row["designation"] . "</td>";
        echo "<td>" . $row["salary"] . "</td>";
        echo "<td>" . $row["presentAddress"] . "</td>";
        echo "<td>" . $row["presentState"] . "</td>";
        echo "<td>" . $row["presentCity"] . "</td>";
        echo "<td>" . $row["otherCity"] . "</td>";
        echo "<td>" . $row["presentPincode"] . "</td>";
        echo "<td>" . $row["permanentAddress"] . "</td>";
        echo "<td>" . $row["permanentState"] . "</td>";
        echo "<td>" . $row["permanentCity"] . "</td>";
        echo "<td>" . $row["otherpermanentCity"] . "</td>";   
        echo "<td>" . $row["permanentPincode"] . "</td>";
        echo "<td>" . $row["primary_no"] . "</td>";
        echo "<td>" . $row["alternative_no"] . "</td>";
        echo "<td>" . $row["whatsapp_Number"] . "</td>";
        echo "<td>" . $row["e_mail"] . "</td>";
        echo "<td>" . $row["permanent_phone"] . "</td>";
        echo "<td>" . $row["marital_status"] . "</td>";
        echo "<td>" . $row["spouse_name"] . "</td>";
        echo "<td>" . $row["Spouse_number"] . "</td>";
        echo "<td>" . $row["acno"] . "</td>";
        echo "<td>" . $row["ifsc"] . "</td>";
        echo "<td>" . $row["branch"] . "</td>";
        echo "<td>" . $row["esi_number"] . "</td>";
        echo "<td>" . $row["pf_number"] . "</td>";
        echo "<td>" . $row["site_name"] . "</td>";
        echo "<td>" . $row["aadhar_no"] . "</td>";
        

        // Add View buttons for images
        echo "<td><button type='button' class='btn btn-primary' data-xyz='adhaar' data-toggle='modal' data-target='#imageModal' data-image='" . $row["id"] . "'>View</button></td>";
        echo "<td>" . $row["other_id"] . "</td>";
        echo "<td><button type='button' class='btn btn-primary' data-xyz='other' data-toggle='modal' data-target='#imageModal' data-image='" . htmlspecialchars($row["id"]) . "'>View</button></td>";
        echo "<td><button type='button' class='btn btn-primary' data-xyz='signature' data-toggle='modal' data-target='#imageModal' data-image='" . htmlspecialchars($row["id"]) . "'>View</button></td>";
        
        echo "<td>" . $row["documented_by"] . "</td>";
        
        // Display approval status and add approve button
        echo "<td>" . $row["approval_status"] . "</td>";
        echo "<td>";
        if ($row["approval_status"] == 'Yet to Approve') {
            echo "<form method='post' action='profile.php?name=" . htmlspecialchars($name) . "'>";
            echo "<input type='hidden' name='employee_id' value='" . $row["id"] . "'>";
            echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
            echo "</form>";
        } else {
            echo "Approved (Employee Code: " . $row["employee_code"] . ")";
        }
        echo "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No profile found for " . htmlspecialchars($name);
}

$conn->close();
?>

<!-- Bootstrap Modal -->


<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="modalImage" class="img-fluid" alt="Profile Image">
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#imageModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var image = button.data('image') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#modalImage').attr('src', image)
    })
</script>
<script src="script.js"></script>
</body>
</html>
