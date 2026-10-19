<?php
require_once "config.php";
require_once "includes/header.php";
?>

<section>
    <h2>About UTB Sport Facility</h2>
    <p>
        UTB Sport Facilities is a web-based system for viewing sports facilities and submitting booking requests
    </p>
</section>

<!-- Side-by-side container -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: start;">

    <section style="margin-bottom: 0;">
        <h2>How It Works</h2>
        <ol style="padding-left: 20px; line-height: 1.8;">
            <li>View the available sports facilities</li>
            <li>Select a facility and submit a booking request</li>
            <li>Enter your preferred date and time</li>
            <li>Wait for the administrator to review your booking</li>
            <li>The administrator can approve or reject the request</li>
        </ol>
    </section>

    <section style="margin-bottom: 0;">
        <h2>Need Help?</h2>
        <p style="margin-bottom: 5px;">
            If you want to make a booking, visit our page below:
        </p>
        <a href="booking.php" style="margin-top: 7px;">Book a Facility</a>

        <p style="margin-top: 20px; margin-bottom: 7px;">
            To view the available facilities, visit our page below:
        </p>
        <a href="facilities.php" style="margin-top: 7px;">Sport Facilities</a>
    </section>

</div>

<?php
require_once "includes/footer.php";
?>