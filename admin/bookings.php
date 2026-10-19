<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config.php";

$message = "";


/* UPDATE STATUS */

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["update_status"])
) {

    $id = $_POST["id"] ?? "";
    $status = $_POST["status"] ?? "";

    $allowedStatuses = [
        "Pending",
        "Approved",
        "Rejected"
    ];

    if (in_array($status, $allowedStatuses, true)) {

        $sql = "
            UPDATE bookings
            SET status = ?
            WHERE id = ?
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $status,
            $id
        ]);

        $message = "Booking status updated";
    }
}


/* DELETE BOOKING */

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["delete_booking"])
) {

    $id = $_POST["id"] ?? "";

    $stmt = $pdo->prepare("
        DELETE FROM bookings
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    $message = "Booking deleted";
}


/* READ BOOKINGS */

$sql = "
    SELECT
        bookings.*,
        facilities.name AS facility_name

    FROM bookings

    INNER JOIN facilities
        ON bookings.facility_id = facilities.id

    ORDER BY
        bookings.booking_date DESC,
        bookings.start_time ASC
";

$stmt = $pdo->query($sql);

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Manage Bookings</title>

    <link rel="stylesheet"
          href="/asg_wd/assets/style.css">

</head>

<body>

<header>

    <h1>Manage Bookings</h1>

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

    <h2>Booking Requests</h2>

        <?php if ($message !== ""): ?>

        <div class="success">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php endif; ?>


    <?php if (count($bookings) === 0): ?>

        <p>No bookings found.</p>

    <?php else: ?>

        <?php foreach ($bookings as $booking): ?>

            <article>

                <h3>
                    <?php
                    echo htmlspecialchars(
                        $booking["facility_name"]
                    );
                    ?>
                </h3>

                <p>
                    <strong>Name:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["customer_name"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Email:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["customer_email"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Roll Number:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["roll_number"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Date:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["booking_date"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Time:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["start_time"]
                    );
                    ?>
                    -
                    <?php
                    echo htmlspecialchars(
                        $booking["end_time"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Purpose:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["purpose"]
                    );
                    ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php
                    echo htmlspecialchars(
                        $booking["status"]
                    );
                    ?>
                </p>

                <!-- Side-by-side action buttons container -->
                <div class="booking-actions" style="display: flex; align-items: center; gap: 10px; margin-top: 15px; position: relative;">

                    <!-- Dropdown for Update Status styled like a button -->
                    <details class="edit-dropdown">
                        <summary class="edit-btn" style="display: inline-block; padding: 10px 15px; background-color: #800080; color: white; text-decoration: none; border-radius: 5px; font-size: 14px; font-weight: bold; cursor: pointer;">Update Status</summary>

                        <div class="edit-form-box" style="position: absolute; background: #ffffff; border: 1px solid #ddd; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10; margin-top: 10px; width: 250px;">
                            <form method="POST">
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?php echo $booking["id"]; ?>"
                                >

                                <select name="status" style="width: 100%; margin-bottom: 10px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; background: #fff;">
                                    <option
                                        value="Pending"
                                        <?php if ($booking["status"] === "Pending") echo "selected"; ?>
                                    >
                                        Pending
                                    </option>
                                    <option
                                        value="Approved"
                                        <?php if ($booking["status"] === "Approved") echo "selected"; ?>
                                    >
                                        Approved
                                    </option>
                                    <option
                                        value="Rejected"
                                        <?php if ($booking["status"] === "Rejected") echo "selected"; ?>
                                    >
                                        Rejected
                                    </option>
                                </select>

                                <button
                                    type="submit"
                                    name="update_status"
                                    style="background-color: #800080; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;"
                                >
                                    Confirm
                                </button>
                            </form>
                        </div>
                    </details>

                    <!-- Delete Booking Form -->
                    <form method="POST" style="margin: 0;">
                        <input
                            type="hidden"
                            name="id"
                            value="<?php echo $booking["id"]; ?>"
                        >

                        <button
                            type="submit"
                            name="delete_booking"
                            class="delete-btn"
                            style="display: inline-block; padding: 10px 15px; background-color: #800080; color: white; border: none; border-radius: 5px; font-size: 14px; font-weight: bold; cursor: pointer;"
                        >
                            Delete Booking
                        </button>
                    </form>

                </div>

            </article>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>

</section>

</main>

<footer>

    <p>&copy; 2026 UTB Sport Facilities</p>

</footer>

</body>

</html>