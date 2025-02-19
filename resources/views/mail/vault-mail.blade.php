<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vault Form Submission</title>
</head>

<body style="background:#f6f6f6;">
    <div style="max-width: 600px; width: 100%; margin: 0px auto ; padding-top: 35px;">
        <img style="text-align: center; margin: 0 auto 35px; width:200px; display:block;"
            src="{{ asset('img/bp-logo-lg-new.png') }}">
        <section style="background-color: #F6F6F6; padding-top: 2.25rem; padding-bottom: 2.25rem;">
            <div style="max-width: 1280px; margin-left: auto; margin-right: auto;">
                <div style="max-width: 1280px; margin-left: auto; margin-right: auto;">
                    <div>
                        @if (!empty($data['date']))
                            <p><strong>Date:</strong> {{ $data['date'] }}</p>
                        @endif

                        @if (!empty($data['company_name']))
                            <p><strong>Company Name:</strong> {{ $data['company_name'] }}</p>
                        @endif

                        @if (!empty($data['contact_name']))
                            <p><strong>Contact Name:</strong> {{ $data['contact_name'] }}</p>
                        @endif

                        @if (!empty($data['phone']))
                            <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
                        @endif

                        @if (!empty($data['email']))
                            <p><strong>Email:</strong> {{ $data['email'] }}</p>
                        @endif

                        @if (!empty($data['message']))
                            <p><strong>Message:</strong> {{ $data['message'] }}</p>
                        @endif

                        <p>Thank you!</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
