<!DOCTYPE html>
<html>
<head>
    <title>Vault Form Submission</title>
</head>
<body>
    <h2>New Vault Form Submission</h2>

    @if(!empty($data['date']))
        <p><strong>Date:</strong> {{ $data['date'] }}</p>
    @endif

    @if(!empty($data['company_name']))
        <p><strong>Company Name:</strong> {{ $data['company_name'] }}</p>
    @endif

    @if(!empty($data['contact_name']))
        <p><strong>Contact Name:</strong> {{ $data['contact_name'] }}</p>
    @endif

    @if(!empty($data['phone']))
        <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    @endif

    @if(!empty($data['email']))
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
    @endif

    @if(!empty($data['message']))
        <p><strong>Message:</strong> {{ $data['message'] }}</p>
    @endif

    <p>Thank you!</p>
</body>
</html>