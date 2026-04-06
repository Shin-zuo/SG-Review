<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <h2>New Inquiry from SG-Review</h2>
    
    <p><strong>Name:</strong> {{ $formData['name'] }}</p>
    <p><strong>Email:</strong> {{ $formData['email'] }}</p>
    <p><strong>Subject:</strong> {{ $formData['subject'] }}</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    
    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap;">{{ $formData['message'] }}</p>

</body>
</html>