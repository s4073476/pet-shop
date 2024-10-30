<?php
session_start(); // Start the session
$title = "Edit Pet Page";
include('include/db_connect.inc'); // Database connection
include('include/header.inc'); 
include('include/nav.inc'); 

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch pet details from the database
if (isset($_GET['id'])) {
    $petId = intval($_GET['id']); // Get pet ID from the URL
    $query = "SELECT id, name, type, description, age, location, image_path FROM pets WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $petId, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if pet exists
    if ($result->num_rows === 0) {
        echo "<div class='alert alert-danger'>No pet found with that ID.</div>";
        exit();
    }

    $pet = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<div class='alert alert-danger'>No pet ID provided.</div>";
    exit();
}

// Handle form submission for updating pet details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $petName = $_POST['petName'];
    $petType = $_POST['petType'];
    $petDescription = $_POST['petDescription'];
    $petAge = intval($_POST['petAge']);
    $petLocation = $_POST['petLocation'];
    
    // Handle image upload
    $imagePath = $pet['image_path']; // Keep existing image by default
    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "images/";
        $imageFileType = strtolower(pathinfo($_FILES['petImage']['name'], PATHINFO_EXTENSION));
        $targetFile = $targetDir . uniqid("pet_", true) . '.' . $imageFileType;

        // Validate image file size and type (optional)
        $check = getimagesize($_FILES['petImage']['tmp_name']);
        if ($check !== false && $_FILES['petImage']['size'] <= 50000000) { // 500KB
            if (move_uploaded_file($_FILES['petImage']['tmp_name'], $targetFile)) {
                $imagePath = $targetFile; // Update image path
            } else {
                echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>File is not an image or too large.</div>";
        }
    }

    // Update pet details in the database
    $updateQuery = "UPDATE pets SET name = ?, type = ?, description = ?, age = ?, location = ?, image_path = ? WHERE id = ? AND user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ssssssss", $petName, $petType, $petDescription, $petAge, $petLocation, $imagePath, $petId, $_SESSION['id']);

    if ($updateStmt->execute()) {
        echo "<div class='alert alert-success'>Pet details updated successfully!</div>";
        header("Location: user.php"); // Redirect to pets list page
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error updating pet details. Please try again.</div>";
    }

    $updateStmt->close();
}

?>

<main class="container my-4">
    <h1 class="text-center mb-4">Edit Pet: <?= htmlspecialchars($pet['name']) ?></h1>
    <p class="text-center mb-4">Update the details of your pet</p>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="petName" class="form-label">Pet Name: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="petName" name="petName" value="<?= htmlspecialchars($pet['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="petType" class="form-label">Type: <span class="text-danger">*</span></label>
            <select class="form-select" id="petType" name="petType" required>
                <option value="Dog" <?= $pet['type'] === 'Dog' ? 'selected' : '' ?>>Dog</option>
                <option value="Cat" <?= $pet['type'] === 'Cat' ? 'selected' : '' ?>>Cat</option>
                <option value="Bird" <?= $pet['type'] === 'Bird' ? 'selected' : '' ?>>Bird</option>
                <option value="Other" <?= $pet['type'] === 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="petDescription" class="form-label">Description: <span class="text-danger">*</span></label>
            <textarea class="form-control" id="petDescription" name="petDescription" rows="3" required><?= htmlspecialchars($pet['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="petImage" class="form-label">Select an Image:</label>
            <input type="file" class="form-control" id="petImage" name="petImage">
            <div class="form-text">Current Image: <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="pet-image" style="max-width: 150px; margin-top: 5px;"></div>
            <div class="form-text">MAX IMAGE SIZE: 500KB</div>
        </div>

        <div class="mb-3">
            <label for="petAge" class="form-label">Age (months): <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="petAge" name="petAge" value="<?= htmlspecialchars($pet['age']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="petLocation" class="form-label">Location: <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="petLocation" name="petLocation" value="<?= htmlspecialchars($pet['location']) ?>" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Pet</button>
            <button type="reset" class="btn btn-outline-secondary">Clear</button>
        </div>
    </form>
</main>

<?php include('include/footer.inc'); ?>
