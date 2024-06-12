<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "employees";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $conn->real_escape_string($_POST['name']);
    $father_husband_name = $conn->real_escape_string($_POST['father_husband_name']);
    $reference_by = $conn->real_escape_string($_POST['reference_by']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $joining_date = $conn->real_escape_string($_POST['joining_date']);
    $joining_age = $conn->real_escape_string($_POST['joining_age']);
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $otherQualification = $conn->real_escape_string($_POST['otherQualification']);
    $select_languages = $conn->real_escape_string($_POST['select_languages']);
    $enter_character = $conn->real_escape_string($_POST['enter_character']);
    $experience_years = $conn->real_escape_string($_POST['experience_years']);
    $experience_months = $conn->real_escape_string($_POST['experience_months']);
    $designation = $conn->real_escape_string($_POST['designation']);
    $salary = $conn->real_escape_string($_POST['salary']);
    $presentAddress = $conn->real_escape_string($_POST['presentAddress']);
    $presentState = $conn->real_escape_string($_POST['presentState']);
    $presentCity = $conn->real_escape_string($_POST['presentCity']);
    $otherCity = $conn->real_escape_string($_POST['otherCity']);
    $presentPincode = $conn->real_escape_string($_POST['presentPincode']);
    $permanentAddress = $conn->real_escape_string($_POST['permanentAddress']);
    $permanentState = $conn->real_escape_string($_POST['permanentState']);
    $permanentCity = $conn->real_escape_string($_POST['permanentCity']);
    $otherpermanentCity = $conn->real_escape_string($_POST['otherpermanentCity']);
    $permanentPincode = $conn->real_escape_string($_POST['permanentPincode']);
    $primary_no = $conn->real_escape_string($_POST['primary_no']);
    $alternative_no = $conn->real_escape_string($_POST['alternative_no']);
    $whatsapp_Number = $conn->real_escape_string($_POST['whatsapp_Number']);
    $e_mail = $conn->real_escape_string($_POST['e_mail']);
    $permanent_phone = $conn->real_escape_string($_POST['permanent_phone']);
    $marital_status = $conn->real_escape_string($_POST['marital_status']);
    $spouse_name = $conn->real_escape_string($_POST['spouse_name']);
    $Spouse_number = $conn->real_escape_string($_POST['Spouse_number']);
    $acno = $conn->real_escape_string($_POST['acno']);
    $ifsc = $conn->real_escape_string($_POST['ifsc']);
    $branch = $conn->real_escape_string($_POST['branch']);
    $esi_number = $conn->real_escape_string($_POST['esi_number']);
    $pf_number = $conn->real_escape_string($_POST['pf_number']);
    $site_name = $conn->real_escape_string($_POST['site_name']);
    $aadhar_no = $conn->real_escape_string($_POST['aadhar_no']);
    
    // $adhaar_image = $conn->real_escape_string($_POST['adhaar_image']);
    $other_id = $conn->real_escape_string($_POST['other_id']);
    $documented_by = $conn->real_escape_string($_POST['documented_by']);
    

//    $upload_dir = "uploads/adhaar";


    $sql = "INSERT INTO employees (name, father_husband_name,reference_by,dob,joining_date,joining_age,qualification,otherQualification,select_languages,enter_character,
    experience_years,experience_months,designation,salary,presentAddress,presentState,presentCity,otherCity,presentPincode,permanentAddress,permanentState,
    permanentCity,otherpermanentCity,permanentPincode,primary_no,alternative_no,whatsapp_Number,e_mail,permanent_phone,marital_status,spouse_name,Spouse_number,acno,ifsc,branch,esi_number,
    pf_number,site_name,aadhar_no,documented_by)

    VALUES ('$name', '$father_husband_name', '$reference_by','$dob','$joining_date','$joining_age','$qualification','$otherQualification','$select_languages','$enter_character',
    '$experience_years','$experience_months','$designation','$salary','$presentAddress','$presentState','$presentCity','$otherCity','$presentPincode','$permanentAddress',
    '$permanentState','$permanentCity','$otherpermanentCity','$permanentPincode','$primary_no','$alternative_no','$whatsapp_Number','$e_mail','$permanent_phone',
    '$marital_status','$spouse_name','$Spouse_number','$acno','$ifsc','$branch','$esi_number','$pf_number','$site_name','$aadhar_no','$documented_by')";


if ($conn->query($sql) === TRUE) {
    $userId = $conn->insert_id; 
    echo "User ID: " . $userId;

    $img_path_t = $userId;

    $sql = "insert into employees (img_url , value = $userid, WHERE id = $userId)";
 

    $adhaarFile = $_FILES['adhaar_img_file'];
    $otherIdFile = $_FILES['other_id_image'];
    $profileImageFile = $_FILES['profile_image'];
    $employeeSignatureFile = $_FILES['employee_signature'];
    
    $allowedExts = array("pdf", "jpg", "png");
    
    
    function handleFileUpload($file, $destinationFolder, $userId) {
        global $allowedExts;
    
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
        if (in_array($fileExt, $allowedExts)) {
            $newFileName = uniqid($userId.'_').'.'.$fileExt;
            $destination = $destinationFolder.$newFileName;
            move_uploaded_file($fileTmpName, $destination);
    
            
            $newDestination = $destinationFolder . $userId . '.png';
            rename($destination, $newDestination);
            echo "{$file['name']} uploaded successfully.<br>";
        } else {
            echo "Only PDF, JPG, and PNG files are allowed for {$file['name']}<br>";
        }
    }
    
    
    $adhaarDestinationFolder = "uploads/adhaar/";
    handleFileUpload($adhaarFile, $adhaarDestinationFolder, $userId);
    
   
    $otherIdDestinationFolder = "uploads/other/";
    handleFileUpload($otherIdFile, $otherIdDestinationFolder, $userId);
    
    
    $profileImageDestinationFolder = "uploads/profile/";
    handleFileUpload($profileImageFile, $profileImageDestinationFolder, $userId);
    
   
    $employeeSignatureDestinationFolder = "uploads/signature/";
    handleFileUpload($employeeSignatureFile, $employeeSignatureDestinationFolder, $userId);
    
    


    
    $sql = "UPDATE employees SET img_url = '$userId' WHERE id = '$userId'";
echo "test";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
} else {
echo "File upload failed!";
}



$conn->close();
?>