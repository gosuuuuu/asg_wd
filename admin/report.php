<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

require_once "../config.php";


$sql = "
    SELECT
        facilities.name AS facility_name,
        COUNT(bookings.id) AS total_bookings

    FROM facilities

    LEFT JOIN bookings
        ON facilities.id = bookings.facility_id

    GROUP BY
        facilities.id,
        facilities.name

    ORDER BY
        total_bookings DESC
";

$stmt = $pdo->query($sql);

$report = $stmt->fetchAll(PDO::FETCH_ASSOC);


$totalStmt = $pdo->query("
    SELECT COUNT(*)
    FROM bookings
");

$totalBookings = $totalStmt->fetchColumn();

/* STATUS COUNT QUERY */

$statusSql = "
    SELECT
        status,
        COUNT(*) AS count
    FROM bookings
    GROUP BY status
";

$statusStmt = $pdo->query($statusSql);
$statusCounts = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Ensure all statuses have a default of 0 if they don't exist yet
$pendingCount = $statusCounts['Pending'] ?? 0;
$approvedCount = $statusCounts['Approved'] ?? 0;
$rejectedCount = $statusCounts['Rejected'] ?? 0;

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Booking Report</title>

    <link rel="stylesheet"
          href="/asg_wd/assets/style.css">

</head>

<body>

<header>

    <h1>Booking Report</h1>

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

    <h2>Bookings by Facility</h2>

    <p>
        Total bookings:
        <strong>
            <?php echo $totalBookings; ?>
        </strong>
    </p>

    <table>
        <colgroup>
            <col style="width: 70%;">
            <col style="width: 30%; text-align: center;">
        </colgroup>
        <thead>
            <tr>
                <th>Facility</th>
                <th style="text-align: center;">Total Bookings</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($report as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["facility_name"]); ?></td>
                    <td style="text-align: center;"><?php echo htmlspecialchars($row["total_bookings"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2 style="margin-top: 40px;">Bookings by Status</h2>

    <table>
        <colgroup>
            <col style="width: 70%;">
            <col style="width: 30%; text-align: center;">
        </colgroup>
        <thead>
            <tr>
                <th>Status</th>
                <th style="text-align: center;">Count</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pending</td>
                <td style="text-align: center;"><?php echo $pendingCount; ?></td>
            </tr>
            <tr>
                <td>Approved</td>
                <td style="text-align: center;"><?php echo $approvedCount; ?></td>
            </tr>
            <tr>
                <td>Rejected</td>
                <td style="text-align: center;"><?php echo $rejectedCount; ?></td>
            </tr>
        </tbody>
    </table>

</section>

</main>

<footer>

    <p>&copy; 2026 UTB Sport Facilities</p>

</footer>

</body>

</html>