## UTB Sport Facilities Booking System 

Project by: 
Muhammad Syabil Na’aim bin Muhammad Salleh [B20250312]
Muhammad Amirul Wa'ie Bin Rozailan [B20250218]
Mohammad Aqil Asnawi Bin Johari [B20250400]

GitHub Repository: https://github.com/gosuuuuu/asg_wd

## 1. Website Purpose
UTB Sport Facility is a PHP/MySQL for booking sports facilities. User can make booking and view the sporting facilities that are offered. Booking statuses, booking reports, booking deletion, and facility records can all be managed by administrators. 

## 2. Main Functions

- Home, Facilities, Booking, and About pages are all responsive
- A user booking form that is validated by the server
- Student / Staff Roll Number collection
- Booking conflict checking to reduce double-booking
- Log in and out as an administrator 
- CRUD for records of sporting facilities 
- Management of booking status
- Booking cancelation 
- Statement for database queries were created by PDO
- Administrator access is secured by a password and hashed 
- Used htmlspecialchars to escape the output
- Protected admin routes using sessions

##3. Database

The database stores information about the sports facilities, administrators and booking request 

Main tables include:
- admins - stores administer login information
- facilities - store available sports facility information
- bookings - stores user booking request and link each booking to a facility using facility_id

Important fields in the bookings table include:

- id
- customer_name
- customer_email
- roll_number
- facility_id
- booking_date
- start_time
- end_time
- purpose
- status

Booking statuses are:
- Pending
- Approved
- Rejected

## 4. Setup

1. Install XAMPP with PHP and MySQL
2. Copy the asg_wd folder into the web server directory, for example: 
	htdocs/asg_wd
3. Open phpMyAdmin and create the project database
4. Import the project's SQL/database file if provided
5. Open config.php and check the MySQL database connection settings
6. Start Apache and MySQL from the XAMPP Control Panel
7. Open the website in a browser:
	http://localhost/asg_wd/
8. Open the login page to access the administrator section

## 5. User Booking

Users can submit a booking request by providing:

- Name
- Email
- Student / Staff Roll Number
- Facility
- Booking Date
- Start Time
- End Time
- Purpose of Booking

The system validates the submitted information before storing the booking

The system checks:

- Required fields.
- Valid email address.
- Valid Student / Staff Roll Number.
- Existing facility.
- Booking date.
- Start and end time.
- Existing booking conflicts.

A new booking is initially given the status: "Pending"

## 6. Admin Functions

The administrator section provides access to:

- Dashboard
- Facility management
- Booking management
- Booking report
- Logout

Facility management

Administrators can:

- Create a facility
- View facilities
- Edit facility information
- Delete facilities

Booking management

Administrators can:

- View submitted bookings
- View customer information
- View Student / Staff Roll Number
- View facility, date and time
- View booking purpose
- Change booking status
- Delete bookings

## 7. Security 

- PDO prepared statements are used for database queries involving user-controlled values
- Administrator passwords are protected using password hashing where implemented
- Admin pages check for an authenticated administrator session
- Session-based access control is used to protect administrator routes
- User input is validated on the server side
- HTML output is escaped using htmlspecialchars
- Booking status values are restricted to the allowed statuses
- SQL queries use parameter binding instead of directly inserting user input into SQL statements

## 8. Project Structure

The main project files are organised as follows:

asg_wd/
│
├── admin/
│   ├── dashboard.php
│   ├── facilities.php
│   ├── bookings.php
│   └── report.php
│
├── assets/
│   └── style.css
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── about.php
├── booking.php
├── config.php
├── create_admin.php
├── facilities.php
├── index.php
├── login.php
├── logout.php
├── test_connection.php
└── README.md

## 9.Technnologies Used

- HTML
- CSS
- PHP
- MySQL
- PDO
- XAMPP
- phpMyAdmin
- Visual Studio Code

## 10. Known Limitations

The existing system may have drawbacks because it was created as an academic study

Possible future improvements include:

- Email notifications for booking approvals and rejection
- User accounts and booking history 
- Facility availability calendar
- Booking search and filtering
- Improved mobile navigation 
- More detailed reporting
- Auto cancellation of expired bookings 
 
## 11. Conclusion 

To view sports facilities and make reservations, UTB Sport Facilities offers easy to use online system. Facilities and booking can be effectively managed due to the administrator section. The project shows how to build a working web-based booking system using PHP, MySQL, PDO, HTML, CSS, sessions, form validation, and database operations
















