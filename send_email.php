<?php

// 1. Get data from AJAX request

$email = $_POST['email'];




// 2. Validate data (very important!)  Sanitize input to prevent security vulnerabilities.
if(empty($email)){

    http_response_code(400);
    echo("Bad request");

    exit;
}
$apiKey = 'api_021PT1DoslYvBYqaRDxCty.0WaOjA0mf5NnCqieRRnDHO';  // Replace with your actual API key
$leadId = 'lead_QyNaWw4fdSwxl5Mc5daMFf3Y27PpIcH0awPbC9l7uyo'; // Replace with your lead ID

$data = [
    'lead_id' => $leadId,
    'emails' => [
        [
            'email' => 'john@example.com', // The email address you want to send
            'type' => 'office'  // Or other type if appropriate
        ]

    ]


    // ... other fields (name, title, phones, urls, custom fields) if needed
];



$jsonData = json_encode($data);

$ch = curl_init('https://api.close.com/api/v1/contact/');
curl_setopt_array($ch, [
    CURLOPT_USERPWD => "$apiKey:", // API key authentication
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $jsonData,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true // Return the response instead of outputting it
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Get HTTP status code

curl_close($ch);


// Handle the response
if ($httpCode >= 200 && $httpCode < 300) {
    echo "Contact created/updated successfully!\n";
    // Optionally process the response data (e.g., decode JSON)
    // $responseData = json_decode($response, true);
    // print_r($responseData);  // Print the response data


} else {

    echo "Error creating/updating contact: $response (HTTP code $httpCode)\n";
    // Handle the error appropriately (e.g., log it, display a message to the user)

}



?>

