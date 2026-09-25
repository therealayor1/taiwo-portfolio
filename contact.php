<?php
header('Content-Type: text/html; charset=UTF-8');

$to = 'taiwoomoniyi90@gmail.com';
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
$honeypot = trim($_POST['website'] ?? '');

function page($title, $message) {
    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#070a12"><title>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</title><style>body{margin:0;min-height:100vh;display:grid;place-items:center;background:#070a12;color:#f6f7fb;font-family:Arial,sans-serif;padding:24px}.card{max-width:620px;width:100%;padding:32px;border:1px solid #283047;border-radius:24px;background:#0b1020;box-sizing:border-box}.btn{display:inline-block;margin-top:18px;padding:13px 18px;border-radius:999px;background:linear-gradient(100deg,#6f4df1,#558ff8);color:#fff;text-decoration:none;font-weight:700}</style></head><body><div class="card"><h1>'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</h1><p>'.htmlspecialchars($message, ENT_QUOTES, 'UTF-8').'</p><a class="btn" href="index.html">Back to portfolio</a></div></body></html>';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') page('Invalid request', 'Please use the contact form on the portfolio.');
if ($honeypot !== '') page('Message not sent', 'Spam protection was triggered.');
if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) page('Check your details', 'Please enter your name, a valid email address, and a message.');
if (strlen($message) > 2000) page('Message too long', 'Please keep your message under 2000 characters.');

$safeName = preg_replace('/[\r\n]+/', ' ', $name);
$safeEmail = preg_replace('/[\r\n]+/', '', $email);
$subject = 'Portfolio enquiry from ' . $safeName;
$body = "Name: {$safeName}\nEmail: {$safeEmail}\n\nMessage:\n{$message}";
$headers = "From: Portfolio Contact <{$to}>\r\n";
$headers .= "Reply-To: {$safeEmail}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $subject, $body, $headers);
if ($sent) page('Message sent', 'Thanks! Your message has been sent successfully. I will get back to you as soon as possible.');
page('Could not send message', 'Your hosting server did not accept the email. Please use WhatsApp or the email button instead.');
?>
