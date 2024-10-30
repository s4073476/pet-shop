<?php
$title = "User's Pets Page";
include('include/db_connect.inc');
include('include/header.inc'); 
include('include/nav.inc'); 

$username = isset($_GET['username']) ? $_GET['username'] : '';

// Fetch user details and pets
$query = "SELECT p.id, p.name, p.image_path FROM pets p JOIN users u ON p.user_id = u.id WHERE u.username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<main class="container my-4">
    <h1 class="text-center mb-4"><?= htmlspecialchars($username) ?>'s Pets</h1>
    <div class="row g-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($pet = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="pet-card">
                        <a href="details.php?id=<?= $pet['id'] ?>" style="text-decoration: none;">
                            <img src="<?= htmlspecialchars($pet['image_path']) ?>" alt="<?= htmlspecialchars($pet['name']) ?>" class="img-fluid">
                            <div class="pet-name text-center"><?= htmlspecialchars($pet['name']) ?></div>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-md-12">
                <p class="text-center">No pets found for this user.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include('include/footer.inc'); ?>
