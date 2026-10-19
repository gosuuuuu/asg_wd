<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config.php";

$message = "";
$error = "";


/* CREATE */

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["add_facility"])
) {

    $name = trim($_POST["name"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if (
        $name === ""
        || $location === ""
    ) {

        $error = "Please complete all required fields.";

    } 
    
    else {

        $sql = "
            INSERT INTO facilities
            (name, location, description)
            VALUES (?, ?, ?)
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $name,
            $location,
            $description
        ]);

        $message = "Facility added successfully.";
    }
}


/* UPDATE */

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["update_facility"])
) {

    $id = $_POST["id"] ?? "";
    $name = trim($_POST["name"] ?? "");
    $location = trim($_POST["location"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if (
        $name === ""
        || $location === ""
    ) {

        $error = "Please complete all required fields.";

    } else {

        $sql = "
            UPDATE facilities
            SET name = ?,
                location = ?,
                description = ?
            WHERE id = ?
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $name,
            $location,
            $description,
            $id
        ]);

        $message = "Facility updated successfully";
    }
}


/* DELETE */

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["delete_facility"])
) {

    $id = $_POST["id"] ?? "";

    try {

        $sql = "
            DELETE FROM facilities
            WHERE id = ?
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([$id]);

        $message = "Facility deleted successfully.";

    } catch (PDOException $e) {

        $error = "This facility cannot be deleted because it may have bookings.";
    }
}


/* READ */

$stmt = $pdo->query("
    SELECT *
    FROM facilities
    ORDER BY name ASC
");

$facilities = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Facilities</title>

    <link rel="stylesheet"
          href="/asg_wd/assets/style.css">

</head>

<body>

<header>

    <h1>Manage Facilities</h1>

    <nav>

        <a href="dashboard.php">Dashboard</a>
        <a href="facilities.php">Facilities</a>
        <a href="bookings.php">Bookings</a>
        <a href="report.php">Report</a>
        <a href="../logout.php">Logout</a>

    </nav>

</header>

<main>

<section>

    <h2>Add Facility</h2>

    <?php if ($message !== ""): ?>

        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>

    <?php if ($error !== ""): ?>

        <div class="error">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <label>Name</label>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

        <label>Location</label>

        <input
            type="text"
            name="location"
            required
        >

        <br><br>

        <label>Description</label>

        <textarea
            name="description"
            rows="4"
        ></textarea>

        <br><br>

        <button
            type="submit"
            name="add_facility"
        >
            Add Facility
        </button>

    </form>

</section>


<section>

    <h2>Existing Facilities</h2>

    <?php foreach ($facilities as $facility): ?>

        <article>

            <h3>
                <?php echo htmlspecialchars($facility["name"]); ?>
            </h3>

            <p>
                Location:
                <?php echo htmlspecialchars($facility["location"]); ?>
            </p>

            <p>
                <?php echo htmlspecialchars($facility["description"]); ?>
            </p>

            <!-- Side-by-side action buttons container -->
            <div class="facility-actions" style="display: flex; align-items: center; gap: 10px; margin-top: 15px; position: relative;">

                <details class="edit-dropdown">
                    <summary class="edit-btn" style="display: inline-block; padding: 10px 15px; background-color: #800080; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold; cursor: pointer;">Edit Facility</summary>

                    <div class="edit-form-box" style="position: absolute; background: #ffffff; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10; margin-top: 10px; width: 300px;">
                        <form method="POST">
                            <input
                                type="hidden"
                                name="id"
                                value="<?php echo $facility["id"]; ?>"
                            >

                            <input
                                type="text"
                                name="name"
                                value="<?php echo htmlspecialchars($facility["name"]); ?>"
                                required
                                style="width: 100%; margin-bottom: 10px; padding: 8px;"
                            >

                            <input
                                type="text"
                                name="location"
                                value="<?php echo htmlspecialchars($facility["location"]); ?>"
                                required
                                style="width: 100%; margin-bottom: 10px; padding: 8px;"
                            >

                            <textarea
                                name="description"
                                rows="3"
                                style="width: 100%; margin-bottom: 10px; padding: 8px;"
                            ><?php echo htmlspecialchars($facility["description"]); ?></textarea>

                            <button
                                type="submit"
                                name="update_facility"
                                style="background-color: #800080; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;"
                            >
                                Update
                            </button>
                        </form>
                    </div>
                </details>

                <form method="POST" style="margin: 0;">
                    <input
                        type="hidden"
                        name="id"
                        value="<?php echo $facility["id"]; ?>"
                    >

                    <button
                        type="submit"
                        name="delete_facility"
                        class="delete-btn"
                        style="display: inline-block; padding: 10px 15px; background-color: #800080; color: white; border: none; border-radius: 5px; font-size: 14px; font-weight: bold; cursor: pointer;"
                    >
                        Delete
                    </button>
                </form>

            </div>

        </article>

        <hr>

    <?php endforeach; ?>

</section>

</main>

<footer>

    <p>&copy; 2026 UTB Sport Facilities</p>

</footer>

</body>

</html>