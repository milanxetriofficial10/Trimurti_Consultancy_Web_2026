<?php
include "../db/config.php";
include "../includes/top_header.php";
include "../includes/navbar.php";
$msg = "";

if(isset($_POST['submit'])) {

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $qualification = $_POST['qualification'];
    $course = $_POST['course'];

// file names
$profile = time().'_'.$_FILES['profile']['name'];
$card    = time().'_'.$_FILES['card']['name'];

move_uploaded_file($_FILES['profile']['tmp_name'], "../admin/uploads/profile/".$profile);
move_uploaded_file($_FILES['card']['tmp_name'], "../admin/uploads/documents/".$card);


    $sql = "INSERT INTO admissions
    (first_name,last_name,email,phone,dob,gender,city,state,country,qualification,course,profile_pic,national_card)
    VALUES
    ('$fname','$lname','$email','$phone','$dob','$gender','$city','$state','$country','$qualification','$course','$profile','$card')";

    if($conn->query($sql)){

        // email confirmation
        $to = $email;
        $subject = "Application Received";
        $message = "Dear $fname,\n\nYour application has been successfully submitted.\nWe will contact you soon.\n\nTrimurti Educational Consultancy";
        $headers = "From: noreply@trimurti.edu";

        mail($to, $subject, $message, $headers);

        $msg = "Application submitted successfully.";
    }
}
$news = $conn->query("SELECT * FROM top_news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Join Us</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

/* container */
.form-box{
    max-width:760px;
    background: traslate;
    margin: auto;
    padding:10px;
    border-radius:14px;
    box-shadow:0 20px 40px rgba(0,0,0,.25);
}

/* logo */
.logo{
    text-align:center;
    margin-bottom:15px;
}
.logo img{
    width:130px;
}

/* heading */
h2{
    text-align:center;
    margin-bottom:15px;
}

/* rows */
.form-row{
    display:flex;
    gap:30px;
    margin-bottom: 15px;
}
.field{
    flex:1;
}

/* inputs */
input, select{
    width:100%;
    padding:12px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:14px;
}

/* checkbox wrapper */
.checkbox{
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 15px 0;
    justify-content: flex-start;   /* force left alignment */
}

/* checkbox input */
.checkbox input[type="checkbox"]{
    width: 18px;
    height: 18px;
    accent-color: #243b55;         /* modern color */
    cursor: pointer;
}

/* checkbox text */
.checkbox label{
    font-size: 14px;
    color: #333;
    cursor: pointer;
}

/* button */
button{
    width:100%;
    padding:14px;
    background:#243b55;
    color:#fff;
    border:none;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
}
button:hover{
    background:#1a2f47;
}

/* success */
.success{
    text-align:center;
    color:green;
    margin-bottom:15px;
}

/* responsive */
@media(max-width:600px){
    .form-row{
        flex-direction:column;
    }
}
</style>
</head>

<body>

<div class="form-box">

    <div class="logo">
        <img src="../img /468819674_122128647596461823_8355324234216025560_n__1_-removebg-preview.png" alt="Logo">
    </div>

    <h2>Join Us – Trimurti Educational Consultancy</h2>

    <?php if($msg): ?>
        <div class="success"><?php echo $msg; ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <!-- name -->
        <div class="form-row">
            <div class="field">
                <input type="text" name="fname" placeholder="First Name" required>
            </div>
            <div class="field">
                <input type="text" name="lname" placeholder="Last Name" required>
            </div>
        </div>

        <!-- email / phone -->
        <div class="form-row">
            <div class="field">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>
            <div class="field">
                <input type="text" name="phone" placeholder="Phone Number" required>
            </div>
        </div>

        <!-- dob / gender -->
        <div class="form-row">
            <div class="field">
                <input type="date" name="dob" required>
            </div>
            <div class="field">
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
                <input type="text" name="city" placeholder="City" required>
            </div>
            <div class="field">
                <input type="text" name="state" placeholder="State" required>
            </div>
        </div>

        <div class="form-row">
            <div class="field">
 <input type="text" name="country" placeholder="Country" required>
            </div>
        </div>
       
        <!-- qualification / course -->
        <div class="form-row">
            <div class="field">
                <select name="qualification" required>
                    <option value="">Highest Qualification</option>
                    <option>SEE</option>
                    <option>High School</option>
                    <option>Bachelor</option>
                    <option>Master</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="field">
                <select name="course" required>
                    <option value="">Select Course</option>
                    <option>Japanese</option>
                    <option>Korean</option>
                    <option>English</option>
                </select>
            </div>
        </div>

        <!-- uploads -->
        <div class="form-row">
            <div class="field">
                <label>Profile Picture</label>
                <input type="file" name="profile" required>
            </div>
            <div class="field">
                <label>National ID Card</label>
                <input type="file" name="card" required>
            </div>
        </div>

        <!-- terms -->
        <div class="checkbox">
            <input type="checkbox" required>
            <label>I agree to Terms & Conditions</label>
        </div>

        <button name="submit">Submit Application</button>

    </form>
</div>
<br>
<br>
<br>

</body>
</html>
<?php
include "../includes/footer.php";
?>