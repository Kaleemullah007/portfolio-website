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


$apiKey = 'api_021PT1DoslYvBYqaRDxCty.0WaOjA0mf5NnCqieRRnDHO';  // Replace with your actual API key
$leadId = 'lead_Zukn4LIuVNcX2Py3uPoVu3uRD6MnN2nAUX9hMcWedZZ'; // Replace with your lead ID



// $data = [
//     "name" => "Bitslab",
//     "url" => "https://www.bitslap.io/",
//     "description" => "",
//     "contacts" => [
//         [
//             "name" => 'Lead',
//             "emails" => [
//                 [
//                     "type" => "office",
//                     "email" => "gob@example.com"
//                 ]
//             ],
            
//         ]
//     ]
// ];


// $ch = curl_init();

// curl_setopt_array($ch, [
//     CURLOPT_URL => "https://api.close.com/api/v1/lead/", // Close.io API endpoint
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => "",
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 30,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => "POST",
//     CURLOPT_POSTFIELDS => json_encode($data), // Encode data as JSON
//     CURLOPT_HTTPHEADER => [
//         "Authorization: Basic " . base64_encode($apiKey . ":"), // Basic Auth
//         "Content-Type: application/json" // Important: Set content type
//     ],
// ]);


// $response = curl_exec($ch);
// $err = curl_error($ch);

// curl_close($ch);

// if ($err) {
//     echo "cURL Error #:" . $err;
// } else {
//     $resp = json_decode($response, true); // Decode JSON response
//     print_r($resp);  // Print or process the response
// }
// die();




$data = [
    'lead_id' => $leadId,
    "name"=>explode('@',$email)[0],
    'emails' => [
        [
            'email' => $email, // The email address you want to send
            'type' => 'office'  // Or other type if appropriate
        ],        
        ]
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


if ($httpCode >= 200 && $httpCode < 300) {

    
    echo "Contact created successfully!\n";
    // Optionally process the response data (e.g., decode JSON)
    $responseData = json_decode($response, true);
//     echo "<pre>";
//     print_r($responseData);  // Print the response data
// die();

} else {

    echo "Error creating/updating contact: $response (HTTP code $httpCode)\n";
    // Handle the error appropriately (e.g., log it, display a message to the user)

}



?>

