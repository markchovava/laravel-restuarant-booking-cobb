<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycle Mate Notification</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px 20px;
        }
        p {
            margin-bottom: 15px;
        }
        .greeting {
            font-weight: 600;
        }
        .signature {
            margin-top: 30px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="greeting">Hi {{ $customerName }},</p>
        <p>We would like to notify you that your request has 
            been received by {{ $recyclerName }} for the center {{ $centerName }}.
        </p>
        <p>Kindly login to see a detailed report.</p>
        <p class="signature">Recycle Mate</p>
    </div>
</body>
</html>