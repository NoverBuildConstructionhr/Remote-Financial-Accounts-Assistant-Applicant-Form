<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

/*
 * Replace this with the company's actual receiving mailbox.
 */
$to = 'applications@example.com';

function clean($value) {
    if (is_array($value)) {
        return implode(', ', array_map('clean', $value));
    }

    return trim(strip_tags((string)$value));
}

$fullname       = clean($_POST['fullname'] ?? '');
$preferred_name = clean($_POST['preferred_name'] ?? '');
$phone          = clean($_POST['phone'] ?? '');
$email          = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$city           = clean($_POST['city'] ?? '');
$location       = clean($_POST['location'] ?? '');

$education  = clean($_POST['education'] ?? '');
$school     = clean($_POST['school'] ?? '');
$field      = clean($_POST['field'] ?? '');
$graduation = clean($_POST['graduation'] ?? '');
$experience = clean($_POST['experience'] ?? '');

$software = clean($_POST['software'] ?? []);

$internet = clean($_POST['internet'] ?? '');
$computer = clean($_POST['computer'] ?? '');
$backup   = clean($_POST['backup'] ?? '');
$hours    = clean($_POST['hours'] ?? '');
$timezone = clean($_POST['timezone'] ?? '');

$schedule = clean($_POST['schedule'] ?? []);

$ref1_name         = clean($_POST['ref1_name'] ?? '');
$ref1_relationship = clean($_POST['ref1_relationship'] ?? '');
$ref1_contact      = clean($_POST['ref1_contact'] ?? '');

$ref2_name         = clean($_POST['ref2_name'] ?? '');
$ref2_relationship = clean($_POST['ref2_relationship'] ?? '');
$ref2_contact      = clean($_POST['ref2_contact'] ?? '');

$signature = clean($_POST['signature'] ?? '');
$date      = clean($_POST['date'] ?? '');


if (!$fullname || !$email || !$signature || !$date) {
    exit('Please complete all required fields.');
}


/*
 * Important:
 * Do NOT include SSN, government ID numbers,
 * passwords, authentication codes, or identity
 * document contents in an ordinary email.
 */

$subject = 'New Remote Financial & Accounts Assistant Application';

$message = "
NEW JOB APPLICATION

Applicant Information
---------------------
Full Name: $fullname
Preferred Name: $preferred_name
Email: $email
Phone: $phone
City/State: $city
Remote Work Location: $location

Education & Experience
----------------------
Education: $education
School/University: $school
Field of Study: $field
Graduation: $graduation

Experience:
$experience

Software Used:
$software

Remote Work
-----------
Internet Access: $internet
Computer Available: $computer
Backup Available: $backup
Hours Per Week: $hours
Time Zone: $timezone

Preferred Schedule:
$schedule

References
----------
Reference 1:
Name: $ref1_name
Relationship: $ref1_relationship
Contact: $ref1_contact

Reference 2:
Name: $ref2_name
Relationship: $ref2_relationship
Contact: $ref2_contact

Certification
-------------
Electronic Signature: $signature
Date: $date
";


$headers = [];

$headers[] = 'From: Website Application <no-reply@example.com>';
$headers[] = 'Reply-To: ' . $email;
$headers[] = 'Content-Type: text/plain; charset=UTF-8';


if (mail($to, $subject, $message, implode("\r\n", $headers))) {

    header('Location: application-success.html');
    exit;

} else {

    http_response_code(500);
    echo 'The application could not be submitted. Please try again later.';
}