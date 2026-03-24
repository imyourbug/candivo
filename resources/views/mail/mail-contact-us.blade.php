<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Inquiry</title>
</head>

<body style="font-family: Arial, sans-serif; color: #0f172a; line-height: 1.5;">
    <h2 style="margin-bottom: 12px;">New Contact Inquiry</h2>
    <p style="margin: 0 0 12px;">A new message was submitted from the Contact Us page.</p>

    <table cellpadding="8" cellspacing="0" border="0" style="border-collapse: collapse;">
        <tr>
            <td style="font-weight: bold;">Full name:</td>
            <td>{{ $full_name !== '' ? $full_name : '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Email:</td>
            <td>{{ $email }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Subject:</td>
            <td>{{ $subject_line }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Message:</td>
            <td>{{ $message_body }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Submitted at:</td>
            <td>{{ $submitted_at }}</td>
        </tr>
    </table>
</body>

</html>
