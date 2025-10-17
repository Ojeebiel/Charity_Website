<?php

require __DIR__ . '/../API/resendAPI/vendor/autoload.php';

// use Resend\Resend;

function sendCharityEmail($recipient, $caption, $imagePath, $name) {

    if (!is_array($recipient)) {
        $recipients = [$recipient];
    }

    // Read the image file content and encode it in Base64
    if (!file_exists($imagePath)) {
        exit("Error: Image file not found at $imagePath");
    }
    $imageContent = base64_encode(file_get_contents($imagePath));
    $imageName = basename($imagePath);
    $imageMime = mime_content_type($imagePath); // e.g., image/jpeg, image/png

    // Initialize Resend client
    $resend = Resend::client('re_eT8mX51s_CS75UzAFYBTtxXA2twn3erXn');

    try {
        $result = $resend->emails->send([
            'from' => 'Charity Organization <charityWebsite@kindpeso.uk>',
            'to' => $recipient,
            'subject' => $name.' Posted a New Charity Post 💖',
            'html' => '
                <div style="font-family: Arial, sans-serif; color: #333;">
                    <h2 style="color:#2ecc71;">New Post!</h2>
                    <p>' . htmlspecialchars($caption) . '</p>
                    <p>Check it out below 👇</p>
                    <img src="cid:charity-image" style="max-width:100%;border-radius:10px;" alt="Post Image">
                    <br><br>
                    <a href="https://yourwebsite.com/view/gallery.php" 
                    style="background:#27ae60;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;">
                    View Gallery →
                    </a>
                </div>
            ',
            'attachments' => [
                [
                    'filename' => $imageName,
                    'content' => $imageContent,
                    'content_id' => 'charity-image',
                    'content_type' => $imageMime
                ]
            ],
            'tags' => [
                [
                    'name' => 'category',
                    'value' => 'gallery_post'
                ]
            ]
        ]);

        // Optional: print result for logging
        // echo $result->toJson();

    } catch (\Exception $e) {
        exit('Error: ' . $e->getMessage());
    }
}

// Example usage
// sendCharityEmail('recipient@example.com', 'We just uploaded a new post!', '/path/to/image.jpg');
