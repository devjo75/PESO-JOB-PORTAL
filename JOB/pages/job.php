<?php
include '../includes/config.php';
include '../includes/header.php';

// Validate Job ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='alert alert-danger text-center'>Invalid Job ID.</div>";
    exit();
}

$id = $_GET['id'];

// Fetch job details with categories and positions
$stmt = $conn->prepare("
    SELECT 
        j.title, 
        j.description, 
        j.responsibilities, 
        j.requirements, 
        j.preferred_qualifications, 
        GROUP_CONCAT(DISTINCT c.name SEPARATOR ', ') AS categories,  -- Fetch multiple categories
        GROUP_CONCAT(DISTINCT p.position_name SEPARATOR ', ') AS positions,  -- Fetch multiple positions
        j.location, 
        j.created_at, 
        j.photo, 
        j.thumbnail 
    FROM jobs j
    LEFT JOIN job_categories jc ON j.id = jc.job_id
    LEFT JOIN categories c ON jc.category_id = c.id
    LEFT JOIN job_positions_jobs jp ON j.id = jp.job_id
    LEFT JOIN job_positions p ON jp.position_id = p.id
    WHERE j.id = ?
    GROUP BY j.id
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();

if (!$job) {
    echo "<div class='alert alert-danger text-center'>Job not found.</div>";
    exit();
}

$user_id = $_SESSION['user_id'] ?? null;
$user_role = $_SESSION['role'] ?? null;

// Count total applicants
$count_query = "SELECT COUNT(*) AS total_applicants FROM applications WHERE job_id = ?";
$stmt = $conn->prepare($count_query);
$stmt->bind_param("i", $id);
$stmt->execute();
$count_result = $stmt->get_result();
$count_data = $count_result->fetch_assoc();
$total_applicants = $count_data['total_applicants'] ?? 0;

// Check if the user has already applied
$user_applied = false;
if ($user_id) {
    $apply_check_query = "SELECT id FROM applications WHERE job_id = ? AND user_id = ?";
    $stmt = $conn->prepare($apply_check_query);
    $stmt->bind_param("ii", $id, $user_id);
    $stmt->execute();
    $apply_result = $stmt->get_result();
    $user_applied = $apply_result->num_rows > 0;
}

// Fetch user's resume file path
$resume_file = null;
$has_resume = false;
if ($user_id) {
    $resume_query = "SELECT resume_file FROM users WHERE id = ?";
    $stmt = $conn->prepare($resume_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $resume_result = $stmt->get_result();
    $user_data = $resume_result->fetch_assoc();
    $resume_file = $user_data['resume_file'];
    $has_resume = !empty($resume_file);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Description</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/JOB/assets/job.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center landscape-layout">
            <!-- Image Column -->
            <div class="col-md-6 image-column text-center">
                <?php if (!empty($job['photo']) && file_exists('../' . $job['photo'])): ?>
                    <img src="../<?= htmlspecialchars($job['photo']) ?>" alt="Job Image" class="img-fluid img-fluid-large rounded">
                <?php else: ?>
                    <div class="text-muted">No Image Available</div>
                <?php endif; ?>
            </div>

<!-- Details Column -->
<div class="col-md-6 details-column">
    <div class="card card-futuristic shadow-lg border-0 h-100">
        <div class="card-body p-5 scrollable-container">
            <!-- Job Title -->
            <h2 class="card-title text-center mb-4 text-futuristic"><?= htmlspecialchars($job['title']) ?></h2>

            <!-- Job Overview -->
            <div class="job-overview mb-4 text-center">
                <p class="text-muted">
                    <i class="fas fa-briefcase me-2"></i>
                    <strong>Category:</strong> <?= htmlspecialchars($job['categories'] ?? 'Not specified') ?>
                </p>
                <p class="text-muted">
                    <i class="fas fa-user-tie me-2"></i>
                    <strong>Position:</strong> <?= htmlspecialchars($job['positions'] ?? 'Not specified') ?>
                </p>
                <p class="text-muted">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    <strong>Location:</strong> <?= htmlspecialchars($job['location'] ?? 'Not specified') ?>
                </p>
                <p class="text-muted">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <strong>Date Posted:</strong> <?= date("F j, Y", strtotime($job['created_at'])) ?>
                </p>
            </div>
            <hr class="divider-futuristic">


                    <!-- Job Description -->
                    <div class="job-description">
                        <h5 class="section-title text-futuristic">Job Description</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($job['description'])) ?></p>
                    </div>
                    <hr class="divider-futuristic">
                    <!-- Responsibilities -->
                    <div class="job-responsibilities">
                        <h5 class="section-title text-futuristic">Responsibilities</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($job['responsibilities'])) ?></p>
                    </div>
                    <hr class="divider-futuristic">
                    <!-- Requirements -->
                    <div class="job-requirements">
                        <h5 class="section-title text-futuristic">Requirements</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($job['requirements'])) ?></p>
                    </div>
                    <hr class="divider-futuristic">
                    <!-- Preferred Qualifications -->
                    <div class="job-preferred-qualifications">
                        <h5 class="section-title text-futuristic">Preferred Qualifications</h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($job['preferred_qualifications'])) ?></p>
                    </div>
                        <hr class="divider-futuristic">

                        <!-- Requirements -->
                        <div class="job-requirements">
                            <h5 class="section-title text-futuristic">Requirements</h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($job['requirements'])) ?></p>
                        </div>
                        <hr class="divider-futuristic">

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <?php if ($user_role === 'admin'): ?>
                                <p><strong>Applicants:</strong> <?= $total_applicants ?></p>
                                <a href="../admin/view_applicants.php?job_id=<?= $id ?>" class="btn btn-futuristic-primary btn-action">
                                    <i class="fas fa-users me-2"></i> View Applicants
                                </a>
                            <?php elseif ($user_id): ?>
                                <?php if (!$user_applied): ?>
                                    <form action="apply.php" method="POST" enctype="multipart/form-data" class="d-inline" id="applyForm">
                                        <input type="hidden" name="job_id" value="<?= $id ?>">
                                        <!-- Resume Selection -->
                                        <div class="mb-3">
                                            <label class="form-label text-futuristic"><strong>Select Resume:</strong></label>
                                            <select name="resume_option" id="resume_option" class="form-select form-futuristic mb-2">
                                                <?php if ($has_resume): ?>
                                                    <option value="existing">Attach from Profile</option>
                                                <?php else: ?>
                                                    <option value="" disabled>No resume available in profile</option>
                                                <?php endif; ?>
                                                <option value="new" <?= !$has_resume ? 'selected' : '' ?>>Upload New Resume</option>
                                            </select>
                                        </div>
                                        <!-- File Upload Field -->
                                        <div id="resume_upload_field" class="mb-3" style="display: <?= !$has_resume ? 'block' : 'none' ?>;">
                                            <label for="resume" class="form-label text-futuristic">Upload Resume</label>
                                            <input type="file" name="resume" id="resume" class="form-control form-futuristic" accept=".pdf,.doc,.docx">
                                        </div>
                                        <!-- Submit Button -->
                                        <button type="submit" id="applyButton" class="btn btn-futuristic-success btn-action" disabled>
                                            <i class="fas fa-paper-plane me-2"></i> Apply Now
                                        </button>
                                    </form>
                                    <!-- JavaScript to Enable/Disable Apply Button -->
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const resumeOptionSelect = document.getElementById('resume_option');
                                            const resumeUploadField = document.getElementById('resume_upload_field');
                                            const resumeFileInput = document.getElementById('resume');
                                            const applyButton = document.getElementById('applyButton');
                                            // Function to check if the form is valid
                                            function validateForm() {
                                                const selectedOption = resumeOptionSelect.value;
                                                const fileUploaded = resumeFileInput.files.length > 0;
                                                if (selectedOption === 'existing' && <?= $has_resume ? 'true' : 'false' ?>) {
                                                    applyButton.disabled = false; // Enable button if attaching from profile
                                                } else if (selectedOption === 'new' && fileUploaded) {
                                                    applyButton.disabled = false; // Enable button if a new file is uploaded
                                                } else {
                                                    applyButton.disabled = true; // Disable button otherwise
                                                }
                                            }
                                            // Event listeners for changes
                                            resumeOptionSelect.addEventListener('change', function () {
                                                if (this.value === 'new') {
                                                    resumeUploadField.style.display = 'block'; // Show file upload field
                                                } else {
                                                    resumeUploadField.style.display = 'none'; // Hide file upload field
                                                }
                                                validateForm(); // Revalidate form after changing option
                                            });
                                            resumeFileInput.addEventListener('change', validateForm); // Revalidate form after file selection
                                            // Initial validation
                                            validateForm();
                                        });
                                    </script>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-action" disabled>
                                        <i class="fas fa-check me-2"></i> Applied
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>
                                    <a href="login.php" class="btn btn-outline-primary btn-action">
                                        <i class="fas fa-sign-in-alt me-2"></i> Login to Apply
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Back Button -->
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-futuristic-back" onclick="goBackOrCancel()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left-dashed">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12h6m3 0h1.5m3 0h.5" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
function goBackOrCancel() {
    // Check if there is a valid history entry to go back to
    if (document.referrer && document.referrer.includes(window.location.origin)) {
        window.history.back(); // Go back to the previous page
    } else {
        // If no valid referrer, redirect to a default fallback page (e.g., browse.php)
        window.location.href = '/JOB/pages/browse.php';
    }
}
</script>


