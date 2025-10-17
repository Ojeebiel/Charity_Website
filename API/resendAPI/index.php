<?php

// Include Composer autoload file to load Resend SDK classes...
require __DIR__ . '/vendor/autoload.php';

// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...
$resend = Resend::client('re_eT8mX51s_CS75UzAFYBTtxXA2twn3erXn');

try {
    // Send the email
    $result = $resend->emails->send([
        'from' => 'Charity Organization <charityWebsite@kindpeso.uk>',
        'to' => ['wensamwar5@gmail.com'],
        'subject' => 'Give Hope Today 💖',
        'html' => '
            <div style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <h2 style="color: #e74c3c;">Hunger doesn’t take a break — and neither do we.</h2>
                <p>With your help, we can deliver <strong>meals, medicine, and hope</strong> to those who’ve lost everything.</p>
                <p><strong>Every peso counts. Every act of kindness heals. 💖</strong></p>
                <p>
                    <a href="https://your-donation-link.com" 
                       style="display:inline-block; background-color:#27ae60; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;">


                       
                       Give hope today →
                    </a>
                </p>
            </div>
        ',
        'tags' => [
            [
                'name' => 'category',
                'value' => 'charity_campaign',
            ]
        ]
    ]);

    echo "Email sent successfully!";
} catch (\Exception $e) {
    exit('Error: ' . $e->getMessage());
}

// Show the response of the sent email to be saved in a log...
// echo $result->toJson();


//testing.owen-resend.com