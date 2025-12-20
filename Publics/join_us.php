<?php
session_start();
include "../db/config.php";
include "../includes/top_header.php";
include "../includes/navbar.php";

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Composer autoload
// OR if manual: require '../path/to/PHPMailer/src/Exception.php';
// require '../path/to/PHPMailer/src/PHPMailer.php';
// require '../path/to/PHPMailer/src/SMTP.php';

$msg = "";
$msg_type = ""; // success/error

if(isset($_POST['submit'])) {
    
    // Collect form data
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    
    // File upload handling
    $upload_errors = [];
    $allowed_image = ['jpg', 'jpeg', 'png', 'gif'];
    $allowed_docs = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
    
    // Profile picture
    $profile_name = $_FILES['profile']['name'];
    $profile_tmp = $_FILES['profile']['tmp_name'];
    $profile_ext = strtolower(pathinfo($profile_name, PATHINFO_EXTENSION));
    $profile_new = time().'_'.preg_replace('/[^a-zA-Z0-9\.]/', '', $profile_name);
    
    // National card
    $card_name = $_FILES['card']['name'];
    $card_tmp = $_FILES['card']['tmp_name'];
    $card_ext = strtolower(pathinfo($card_name, PATHINFO_EXTENSION));
    $card_new = time().'_'.preg_replace('/[^a-zA-Z0-9\.]/', '', $card_name);
    
    // Validate file types
    if(!in_array($profile_ext, $allowed_image)) {
        $upload_errors[] = "Profile picture must be JPG, PNG, or GIF.";
    }
    if(!in_array($card_ext, $allowed_docs)) {
        $upload_errors[] = "ID card must be JPG, PNG, PDF, DOC, or DOCX.";
    }
    
    // Check file sizes (max 2MB)
    if($_FILES['profile']['size'] > 2097152) {
        $upload_errors[] = "Profile picture must be less than 2MB.";
    }
    if($_FILES['card']['size'] > 5242880) {
        $upload_errors[] = "ID card must be less than 5MB.";
    }
    
    // If no upload errors, proceed
    if(empty($upload_errors)) {
        // Upload files
        $profile_path = "../admin/uploads/profile/".$profile_new;
        $card_path = "../admin/uploads/documents/".$card_new;
        
        if(move_uploaded_file($profile_tmp, $profile_path) && 
           move_uploaded_file($card_tmp, $card_path)) {
            
            // Insert into database
            $sql = "INSERT INTO admissions 
                    (first_name, last_name, email, phone, dob, gender, city, state, 
                     country, qualification, course, profile_pic, national_card, applied_date) 
                    VALUES 
                    ('$fname', '$lname', '$email', '$phone', '$dob', '$gender', '$city', 
                     '$state', '$country', '$qualification', '$course', '$profile_new', '$card_new', NOW())";
            
            if($conn->query($sql)) {
                $application_id = $conn->insert_id;
                
                // ==================== EMAIL SYSTEM ====================
                try {
                    $mail = new PHPMailer(true);
                    
                    // SMTP Configuration for Gmail
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your-email@gmail.com'; // Your Gmail
                    $mail->Password = 'your-app-password'; // Use App Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    // Sender info
                    $mail->setFrom('noreply@trimurti.edu', 'Trimurti Educational Consultancy');
                    $mail->addReplyTo('info@trimurti.edu', 'Information Desk');
                    
                    // ========== 1. EMAIL TO APPLICANT ==========
                    $mail->clearAddresses();
                    $mail->addAddress($email, $fname.' '.$lname);
                    
                    $mail->isHTML(true);
                    $mail->Subject = 'Application Received - Trimurti Educational Consultancy';
                    
                    $applicant_message = "
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #243b55; color: white; padding: 20px; text-align: center; }
                            .content { padding: 20px; background: #f9f9f9; }
                            .footer { background: #eee; padding: 15px; text-align: center; font-size: 12px; }
                            .highlight { background: #e3f2fd; padding: 10px; border-left: 4px solid #2196F3; }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <div class='header'>
                                <h2>Trimurti Educational Consultancy</h2>
                            </div>
                            <div class='content'>
                                <h3>Dear $fname,</h3>
                                <p>Thank you for submitting your application to <strong>Trimurti Educational Consultancy</strong>.</p>
                                
                                <div class='highlight'>
                                    <p><strong>Application Details:</strong></p>
                                    <p><strong>Application ID:</strong> TEC-$application_id</p>
                                    <p><strong>Full Name:</strong> $fname $lname</p>
                                    <p><strong>Course:</strong> $course</p>
                                    <p><strong>Applied Date:</strong> ".date('F d, Y')."</p>
                                </div>
                                
                                <p>We have received your application for <strong>$course</strong> course. Our team will review your application and contact you within 3-5 working days.</p>
                                
                                <p><strong>Next Steps:</strong></p>
                                <ol>
                                    <li>Document verification</li>
                                    <li>Counseling session</li>
                                    <li>Admission process</li>
                                </ol>
                                
                                <p>If you have any questions, please contact us at:</p>
                                <p>📞 +977-1-XXXXXXX<br>
                                📧 info@trimurti.edu<br>
                                🌐 www.trimurti.edu.np</p>
                            </div>
                            <div class='footer'>
                                <p>© ".date('Y')." Trimurti Educational Consultancy. All rights reserved.</p>
                                <p>This is an automated email, please do not reply.</p>
                            </div>
                        </div>
                    </body>
                    </html>
                    ";
                    
                    $mail->Body = $applicant_message;
                    $mail->AltBody = "Dear $fname,\n\nThank you for submitting your application to Trimurti Educational Consultancy.\n\nApplication ID: TEC-$application_id\nCourse: $course\n\nWe will review your application and contact you within 3-5 working days.\n\nBest regards,\nTrimurti Educational Consultancy";
                    
                    $mail->send();
                    
                    // ========== 2. EMAIL TO ADMIN ==========
                    $mail->clearAddresses();
                    $mail->addAddress('admin@trimurti.edu', 'Admin');
                    $mail->addCC('manager@trimurti.edu', 'Manager');
                    
                    $mail->Subject = 'New Application Received - ID: TEC-'.$application_id;
                    
                    $admin_message = "
                    <html>
                    <body>
                        <h3>New Application Submission</h3>
                        <p><strong>Application ID:</strong> TEC-$application_id</p>
                        <p><strong>Applicant:</strong> $fname $lname</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Phone:</strong> $phone</p>
                        <p><strong>Course:</strong> $course</p>
                        <p><strong>Qualification:</strong> $qualification</p>
                        <p><strong>Applied Date:</strong> ".date('Y-m-d H:i:s')."</p>
                        <br>
                        <p>Please check the admin panel for complete details.</p>
                        <p><a href='https://yourwebsite.com/admin/view-application.php?id=$application_id'>View Application</a></p>
                    </body>
                    </html>
                    ";
                    
                    $mail->Body = $admin_message;
                    $mail->AltBody = "New Application:\nID: TEC-$application_id\nName: $fname $lname\nEmail: $email\nPhone: $phone\nCourse: $course";
                    
                    $mail->send();
                    
                    // Success message
                    $msg = "Application submitted successfully! Confirmation email sent to $email.";
                    $msg_type = "success";
                    
                    // Clear form (optional)
                    echo '<script>document.querySelector("form").reset();</script>';
                    
                } catch (Exception $e) {
                    // Email failed but application saved
                    $msg = "Application submitted successfully! (Email notification failed: " . $mail->ErrorInfo . ")";
                    $msg_type = "warning";
                }
                
            } else {
                $msg = "Database error: " . $conn->error;
                $msg_type = "error";
            }
            
        } else {
            $msg = "File upload failed!";
            $msg_type = "error";
        }
    } else {
        $msg = implode("<br>", $upload_errors);
        $msg_type = "error";
    }
}

$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trimurti Educational Consultancy | Join Us</title>
<meta name="description" content="Trimurti Educational Consultancy is a trusted education consultancy in Nepal providing admission guidance, study abroad services, and career counseling.">
<meta name="keywords" content="Trimurti, Trimurti Educational Consultancy, Trimurti Nepal, Education Consultancy Nepal, Study Abroad Nepal">
<meta name="author" content="Trimurti Educational Consultancy">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* container */
.form-box{
    max-width:760px;
    background: #fff;
    margin: auto;
    padding:25px;
    border-radius:14px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
    margin-top:20px;
    margin-bottom:20px;
}

/* logo */
.logo{
    text-align:center;
    margin-bottom:20px;
}
.logo img{
    width:150px;
    height:auto;
}

/* heading */
h2{
    text-align:center;
    margin-bottom:25px;
    color:#243b55;
    font-size:28px;
}

/* rows */
.form-row{
    display:flex;
    gap:20px;
    margin-bottom:20px;
}
.field{
    flex:1;
}

/* labels */
label{
    display:block;
    margin-bottom:8px;
    font-weight:500;
    color:#555;
}

/* inputs */
input, select{
    width:100%;
    padding:12px 15px;
    border-radius:8px;
    border:1px solid #ddd;
    font-size:15px;
    transition:border 0.3s;
}
input:focus, select:focus{
    border-color:#243b55;
    outline:none;
    box-shadow:0 0 0 3px rgba(36,59,85,0.1);
}

/* file inputs */
input[type="file"]{
    padding:10px;
    background:#f9f9f9;
    border:1px dashed #ccc;
}

/* checkbox wrapper */
.checkbox{
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 20px 0;
}

/* checkbox input */
.checkbox input[type="checkbox"]{
    width: 20px;
    height: 20px;
    accent-color: #243b55;
    cursor: pointer;
}

/* checkbox text */
.checkbox label{
    font-size: 15px;
    color: #333;
    cursor: pointer;
}
.checkbox label a{
    color:#243b55;
    text-decoration:none;
}
.checkbox label a:hover{
    text-decoration:underline;
}

/* button */
button{
    width:100%;
    padding:16px;
    background:linear-gradient(135deg, #243b55, #1a2f47);
    color:#fff;
    border:none;
    font-size:17px;
    font-weight:600;
    border-radius:8px;
    cursor:pointer;
    transition:all 0.3s;
}
button:hover{
    background:linear-gradient(135deg, #1a2f47, #243b55);
    transform:translateY(-2px);
    box-shadow:0 5px 15px rgba(36,59,85,0.3);
}

/* message alerts */
.alert{
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    text-align:center;
    font-weight:500;
}
.success{
    background:#d4edda;
    color:#155724;
    border:1px solid #c3e6cb;
}
.error{
    background:#f8d7da;
    color:#721c24;
    border:1px solid #f5c6cb;
}
.warning{
    background:#fff3cd;
    color:#856404;
    border:1px solid #ffeaa7;
}

/* file preview */
.file-preview{
    margin-top:5px;
    font-size:13px;
    color:#666;
}

/* responsive */
@media(max-width:768px){
    .form-row{
        flex-direction:column;
        gap:15px;
    }
    .form-box{
        padding:20px;
        margin:15px;
    }
    h2{
        font-size:24px;
    }
}
</style>

<script>
// File preview and validation
document.addEventListener('DOMContentLoaded', function() {
    // File size validation
    const profileInput = document.querySelector('input[name="profile"]');
    const cardInput = document.querySelector('input[name="card"]');
    
    profileInput.addEventListener('change', function() {
        validateFile(this, 2, ['jpg', 'jpeg', 'png', 'gif']);
    });
    
    cardInput.addEventListener('change', function() {
        validateFile(this, 5, ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);
    });
    
    function validateFile(input, maxMB, allowedExt) {
        if(input.files.length > 0) {
            const file = input.files[0];
            const ext = file.name.split('.').pop().toLowerCase();
            const sizeMB = file.size / (1024 * 1024);
            
            if(!allowedExt.includes(ext)) {
                alert(`Invalid file type. Allowed: ${allowedExt.join(', ')}`);
                input.value = '';
                return;
            }
            
            if(sizeMB > maxMB) {
                alert(`File too large. Maximum ${maxMB}MB allowed.`);
                input.value = '';
                return;
            }
            
            // Show preview
            const preview = input.nextElementSibling || 
                           (input.parentNode.appendChild(document.createElement('div')));
            preview.className = 'file-preview';
            preview.textContent = `Selected: ${file.name} (${sizeMB.toFixed(2)}MB)`;
        }
    }
    
    // Form submission confirmation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const checkbox = document.querySelector('input[type="checkbox"]');
        if(!checkbox.checked) {
            e.preventDefault();
            alert('Please agree to the Terms & Conditions');
            return false;
        }
        
        // Show loading
        const btn = document.querySelector('button[name="submit"]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span>Processing... Please wait</span>';
        btn.disabled = true;
        
        // Re-enable after 5 seconds (in case of error)
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 5000);
    });
});
</script>
</head>

<body>

<div class="form-box">

    <div class="logo">
        <img src="../img/468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" alt="Trimurti Logo">
    </div>

    <h2>Join Us – Trimurti Educational Consultancy</h2>

    <?php if($msg): ?>
        <div class="alert <?php echo $msg_type; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" id="applicationForm">

        <!-- name -->
        <div class="form-row">
            <div class="field">
                <label>First Name *</label>
                <input type="text" name="fname" placeholder="First Name" required>
            </div>
            <div class="field">
                <label>Last Name *</label>
                <input type="text" name="lname" placeholder="Last Name" required>
            </div>
        </div>

        <!-- email / phone -->
        <div class="form-row">
            <div class="field">
                <label>Email Address *</label>
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="field">
                <label>Phone Number *</label>
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>
        </div>

        <!-- dob / gender -->
        <div class="form-row">
            <div class="field">
                <label>Date of Birth *</label>
                <input type="date" name="dob" required>
            </div>
            <div class="field">
                <label>Gender *</label>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
        </div>

        <!-- address -->
        <div class="form-row">
            <div class="field">
                <label>City *</label>
                <input type="text" name="city" placeholder="City" required>
            </div>
            <div class="field">
                <label>State/Province *</label>
                <input type="text" name="state" placeholder="State" required>
            </div>
        </div>

        <div class="form-row">
            <div class="field">
                <label>Country *</label>
                <input type="text" name="country" placeholder="Country" required>
            </div>
        </div>
       
        <!-- qualification / course -->
        <div class="form-row">
            <div class="field">
                <label>Highest Qualification *</label>
                <select name="qualification" required>
                    <option value="">Select Qualification</option>
                    <option>SEE</option>
                    <option>High School</option>
                    <option>Bachelor</option>
                    <option>Master</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="field">
                <label>Select Course *</label>
                <select name="course" required>
                    <option value="">Choose Course</option>
                    <option>Japanese</option>
                    <option>Korean</option>
                    <option>English</option>
                    <option>German</option>
                    <option>Chinese</option>
                </select>
            </div>
        </div>

        <!-- uploads -->
        <div class="form-row">
            <div class="field">
                <label>Profile Picture *</label>
                <input type="file" name="profile" accept=".jpg,.jpeg,.png,.gif" required>
                <div class="file-preview">Max 2MB (JPG, PNG, GIF)</div>
            </div>
            <div class="field">
                <label>National ID Card *</label>
                <input type="file" name="card" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required>
                <div class="file-preview">Max 5MB (JPG, PNG, PDF, DOC)</div>
            </div>
        </div>

        <!-- terms -->
        <div class="checkbox">
            <input type="checkbox" id="terms" required>
            <label for="terms">I agree to the <a href="../terms.php" target="_blank">Terms & Conditions</a> and <a href="../privacy.php" target="_blank">Privacy Policy</a></label>
        </div>

        <button type="submit" name="submit">
            <span>Submit Application</span>
        </button>

    </form>
    
    <div style="text-align:center; margin-top:20px; color:#666; font-size:14px;">
        <p>📧 Confirmation email will be sent after submission</p>
        <p>📞 Contact: +977-1-XXXXXXX | info@trimurti.edu</p>
    </div>
</div>

</body>
</html>
<?php
include "../includes/footer.php";
?>