<?php

// 1. Get data from AJAX request

$email = $_POST['email']??'';




// 2. Validate data (very important!)  Sanitize input to prevent security vulnerabilities.
if(empty($email)){

    http_response_code(400);
    echo("Bad request");

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "InValid email address";
    exit;
    // Proceed with your logic (e.g., saving to database)
} 


$apiKey = 'yourkey';  // Replace with your actual API key



$data = [
    "name" => $email,
    "url" => "https://www.yourwebsite.com/",
    "description" => "",
    "contacts" => [
        [
            "name" => 'Lead',
            "emails" => [
                [
                    "type" => "office",
                    "email" => $email
                ]
            ],
            
        ]
    ]
];


$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.close.com/api/v1/lead/", // Close.io API endpoint
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data), // Encode data as JSON
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic " . base64_encode($apiKey . ":"), // Basic Auth
        "Content-Type: application/json" // Important: Set content type
    ],
]);


$response = curl_exec($ch);
$err = curl_error($ch);

curl_close($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode >= 200 && $httpCode < 300) {

    
    echo "Lead created successfully!\n";

} else {

    echo "Error : $response (HTTP code $httpCode)\n";
 

}

?>

