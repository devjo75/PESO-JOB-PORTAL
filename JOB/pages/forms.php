<?php
// Include the database connection file
include '../includes/config.php';

// Initialize variables to store form data
$user_id = 1; // Replace with the actual user ID (e.g., from session or authentication)
$surname = $firstname = $middlename = $suffix = $dob = $sex = $religion = $status = $address = $barangay = $city = $province = $height = $contact = $email = $employment_status = $ofw = $former_ofw = $latest_deployment = $return_philippines = $four_ps = $household_id = $job_preference = $preferred_local_work = $preferred_overseas_work = $languages = $education_level = $graduate_studies = $training = $institution = $skills_acquired = $license_type = $license_number = $issuing_agency = $work_experience = $other_skills = $signature = $date_signature = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $surname = htmlspecialchars($_POST['surname']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $suffix = htmlspecialchars($_POST['suffix']);
    $dob = htmlspecialchars($_POST['dob']);
    $sex = htmlspecialchars($_POST['sex']);
    $religion = htmlspecialchars($_POST['religion']);
    $status = htmlspecialchars($_POST['status']);
    $address = htmlspecialchars($_POST['address']);
    $barangay = htmlspecialchars($_POST['barangay']);
    $city = htmlspecialchars($_POST['city']);
    $province = htmlspecialchars($_POST['province']);
    $height = htmlspecialchars($_POST['height']);
    $contact = htmlspecialchars($_POST['contact']);
    $email = htmlspecialchars($_POST['email']);
    $employment_status = htmlspecialchars($_POST['employment']);
    $ofw = htmlspecialchars($_POST['ofw']);
    $former_ofw = htmlspecialchars($_POST['former_ofw']);
    $latest_deployment = htmlspecialchars($_POST['latest_deployment']);
    $return_philippines = htmlspecialchars($_POST['return_philippines']);
    $four_ps = htmlspecialchars($_POST['4ps']);
    $household_id = htmlspecialchars($_POST['household_id']);
    $job_preference = htmlspecialchars($_POST['occupation1'] . ', ' . $_POST['occupation2'] . ', ' . $_POST['occupation3']);
    $preferred_local_work = htmlspecialchars($_POST['local_work1'] . ', ' . $_POST['local_work2'] . ', ' . $_POST['local_work3']);
    $preferred_overseas_work = htmlspecialchars($_POST['overseas_work1'] . ', ' . $_POST['overseas_work2'] . ', ' . $_POST['overseas_work3']);
    $languages = htmlspecialchars($_POST['language']);
    $education_level = htmlspecialchars($_POST['level']);
    $graduate_studies = htmlspecialchars($_POST['graduate_studies']);
    $training = htmlspecialchars($_POST['training1'] . ', ' . $_POST['training2'] . ', ' . $_POST['training3']);
    $institution = htmlspecialchars($_POST['institution']);
    $skills_acquired = htmlspecialchars($_POST['skills_acquired']);
    $license_type = htmlspecialchars($_POST['license_type']);
    $license_number = htmlspecialchars($_POST['license_number']);
    $issuing_agency = htmlspecialchars($_POST['issuing_agency']);
    $work_experience = htmlspecialchars($_POST['company1'] . ', ' . $_POST['position1'] . ', ' . $_POST['months1']);
    $other_skills = htmlspecialchars($_POST['other_skills']);
    $signature = htmlspecialchars($_POST['signature']);
    $date_signature = htmlspecialchars($_POST['date_signature']);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO forms (
        user_id, surname, firstname, middlename, suffix, dob, sex, religion, status, address, barangay, city, province, height, contact, email, employment_status, ofw, former_ofw, latest_deployment, return_philippines, four_ps, household_id, job_preference, preferred_local_work, preferred_overseas_work, languages, education_level, graduate_studies, training, institution, skills_acquired, license_type, license_number, issuing_agency, work_experience, other_skills, signature, date_signature
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        'isssssssssssssssssssssssssssssssssssss',
        $user_id, $surname, $firstname, $middlename, $suffix, $dob, $sex, $religion, $status, $address, $barangay, $city, $province, $height, $contact, $email, $employment_status, $ofw, $former_ofw, $latest_deployment, $return_philippines, $four_ps, $household_id, $job_preference, $preferred_local_work, $preferred_overseas_work, $languages, $education_level, $graduate_studies, $training, $institution, $skills_acquired, $license_type, $license_number, $issuing_agency, $work_experience, $other_skills, $signature, $date_signature
    );

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Form submitted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NSRP Form 1 - Jobseeker Registration</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
    <div class="form-container">
        <h2>Republic of the Philippines - Jobseeker Registration Form</h2>
        <form method="POST" action="">
            <!-- Your existing HTML form fields go here -->
            <!-- Example: -->
            <div class="section">
                <h3>I. Personal Information</h3>
                <div class="input-group">
                    <label>Surname:</label>
                    <input type="text" name="surname" value="<?php echo $surname; ?>">
                </div>
                <!-- Add other fields similarly -->
                <div class="input-group">
                <label>First Name:</label>
                <input type="text" name="firstname" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Middle Name:</label>
                <input type="text" name="middlename">
            </div>
            <div class="input-group">
                <label>Suffix (Sr., Jr., III, etc.):</label>
                <input type="text" name="suffix" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Sex:</label>
                <input type="radio" name="sex" value="<?php echo $surname; ?>">> Male
                <input type="radio" name="sex" value="<?php echo $surname; ?>">> Female
            </div>
            <div class="input-group">
                <label>Religion:</label>
                <input type="text" name="religion" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Civil Status:</label>
                <input type="radio" name="status" value="<?php echo $surname; ?>">> Single
                <input type="radio" name="status" value="<?php echo $surname; ?>">> Married
                <input type="radio" name="status" value="<?php echo $surname; ?>">> Widowed
            </div>
            <div class="input-group">
                <label>Present Address:</label>
                <input type="text" name="address" placeholder="House No./Street/Village" value="<?php echo $surname; ?>">>
                <input type="text" name="barangay" placeholder="Barangay" value="<?php echo $surname; ?>">>
                <input type="text" name="city" placeholder="Municipality/City" value="<?php echo $surname; ?>">>
                <input type="text" name="province" placeholder="Province" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Height (ft):</label>
                <input type="text" name="height" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Contact Number:</label>
                <input type="text" name="contact" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $surname; ?>">>
            </div>
        </div>

        <div class="section">
            <h3 style="text-decoration:underline;">Employment Status / Type</h3>
            <div class="input-group">
                <label>Employment Status:</label>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">><b> Employed</b><br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Wage Employed<br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Self-employed 
                <input type="text" name="employment"  placeholder="Please specify" value="<?php echo $surname; ?>">>
                <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Fisherman/Fisherfolk <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Vendor/Retailer <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Home-based worker <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Transport <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Domestic Worker <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Freelancer <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Artisan/Craft Worker <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Other
                <input type="text" name="employment"  placeholder="Please specify" value="<?php echo $surname; ?>">>
            </div>
            <div class="input-group">
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> <b>Unemployed</b>
                <input type="text" name="employment" value="<?php echo $surname; ?>">> <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> new Entrant/Fresh Graduate <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Finished Contract <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Resigned <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Retired <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Terminated/Laid off due to calamity <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Terminated/Laid off (local) <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Terminated/Laid off (abroad)
                <input type="text" name="employment" placeholder="specify country" value="<?php echo $surname; ?>">>
                <br>
                <input type="checkbox" name="employment" value="<?php echo $surname; ?>">> Others
                <input type="text" name="employment" placeholder="please specify" value="<?php echo $surname; ?>">>
            
            </div>
            <div class="input-group">
                <label>If unemployed, reason:</label>
                <input type="checkbox" name="unemployed" value="<?php echo $surname; ?>">> New Graduate
                <input type="checkbox" name="unemployed" value="<?php echo $surname; ?>">> Laid off (local)
                <input type="checkbox" name="unemployed" value="<?php echo $surname; ?>">> Laid off (abroad)
                <input type="checkbox" name="unemployed" value="<?php echo $surname; ?>">> Resigned
                <input type="checkbox" name="unemployed" value="<?php echo $surname; ?>">> Retired
            </div>
            <div class="input-group">
                <label>Are you an OFW?</label>
                <input type="radio" name="ofw" value="Yes"> Yes
                <input type="radio" name="ofw" value="No"> No
                <input type="text" name="ofw_country" placeholder="Specify country">
            </div>

            <div class="input-group">
                    <label>Are you a former OFW?</label>
                    <input type="radio" name="former ofw" value="Yes"> Yes
                    <input type="radio" name="former ofw" value="No"> No
                    <input type="text" name="later_deployment" placeholder="Latest country of deployment">
                    <input type="text" name="return_philippines" placeholder="Month and year of return to Philippines">
            </div>

            <div class="input-group">
                <label>Are you a 4Ps beneficiary?</label>
                <input type="radio" name="4ps" value="Yes"> Yes
                <input type="radio" name="4ps" value="No"> No
                <input type="text" name="household_id" placeholder="Household ID (if Yes)">
            </div>
        </div>

        <div class="section">
            <h3>II. Job Preference</h3>
            <div class="input-group">
                <label>Preferred Occupation (List up to 3):</label>
                <input type="checkbox" name="part-time" value="part-time"> Part-time
                <input type="checkbox" name="full-time" value="full-time"> full-time
                <input type="text" name="occupation1">
                <input type="text" name="occupation2">
                <input type="text" name="occupation3">
            </div>
            <div class="input-group">
                <label>Preferred Work Location (Local):</label>
                <input type="text" name="local_work1">
                <input type="text" name="local_work2">
                <input type="text" name="local_work3">
            </div>
            <div class="input-group">
                <label>Preferred Work Location (Overseas):</label>
                <input type="text" name="overseas_work1">
                <input type="text" name="overseas_work2">
                <input type="text" name="overseas_work3">
            </div>
        </div>

        <div class="section">
            <h3>III. Language / Dialect Proficiency</h3>
            <label>Language/Dialect:</label>
            <input type="checkbox" name="language" value="English"> English
            <input type="checkbox" name="language" value="Filipino"> Filipino
            <input type="checkbox" name="language" value="Mandarin"> Mandarin
            <input type="checkbox" name="language" value="Others"> Others (please specify):
            <input type="text" name="other_language" placeholder="Specify other languages">
        </div>

        <h3>IV. Educational Background</h3>
    <div class="input-group">
        <label>Currently in school?</label>
        <input type="radio" name="schooling" value="Yes"> Yes
        <input type="radio" name="schooling" value="No"> No
    </div>
    <div class="input-group">
        <label>Educational Level:</label>
        <input type="checkbox" name="level" value="Elementary"> Elementary <br>
        <input type="checkbox" name="level" value="Secondary (Non-K12)"> Secondary (Non-K12) <br>
        <input type="checkbox" name="level" value="Secondary (K-12)"> Secondary (K-12) <br>
        <input type="text" name="senior_high_strand" placeholder="Senior High Strand">
    </div>
    <div class="input-group">
        <label>Graduate/Post-Graduate Studies:</label>
        <input type="text" name="graduate_studies">
    </div>
<!-- Technical/Vocational Training -->
<div class="section">
    <h3>V. Technical/Vocational and Other Training</h3>
    <div class="input-group">
        <label>Training/Vocational Courses:</label>
        <input type="text" name="training1" placeholder="Course">
        <input type="text" name="training2" placeholder="Course">
        <input type="text" name="training3" placeholder="Course">
    </div>
    <div class="input-group">
        <label>Institution:</label>
        <input type="text" name="institution">
    </div>
    <div class="input-group">
        <label>Skills Acquired:</label>
        <input type="text" name="skills_acquired">
    </div>
</div>

<!-- Professional License -->
<div class="section">
    <h3>VI. Eligibility / Professional License</h3>
    <div class="input-group">
        <label>Type of License:</label>
        <input type="text" name="license_type">
    </div>
    <div class="input-group">
        <label>License Number:</label>
        <input type="text" name="license_number">
    </div>
    <div class="input-group">
        <label>Issuing Agency:</label>
        <input type="text" name="issuing_agency">
    </div>
</div>

<!-- Work Experience -->
<div class="section">
    <h3>VII. Work Experience</h3>
    <div class="input-group">
        <label>Most Recent Employment:</label>
        <input type="text" name="company1" placeholder="Company Name">
        <input type="text" name="position1" placeholder="Position">
        <input type="text" name="months1" placeholder="Number of Months">
    </div>
</div>

<!-- Other Skills -->
<div class="section">
    <h3>VIII. Other Skills Acquired Without Certificate</h3>
    <input type="checkbox" name="skills" value="Auto Mechanic"> Auto Mechanic <br>
    <input type="checkbox" name="skills" value="Beautician"> Beautician <br>
    <input type="checkbox" name="skills" value="Carpentry Work"> Carpentry Work <br>
    <input type="checkbox" name="skills" value="Photography"> Photography <br>
    <input type="text" name="other_skills" placeholder="Other skills (Specify)">
</div>

<!-- Certification & Authorization -->
<div class="section">
    <h3>Certification/Authorization</h3>
    <p>This is to certify that all data/information I have provided in this form are true to the best of my knowledge.</p>
    <label>Signature of Applicant:</label>
    <input type="text" name="signature" placeholder="Sign here">
    <input type="date" name="date_signature">
</div>




        <button class="btn-submit">Submit</button>
    </div>
</body>
</html>