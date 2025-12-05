<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4a5568;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            color: #4a5568;
            margin-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .field-value {
            color: #333;
            font-size: 16px;
            padding: 10px;
            background-color: #f7fafc;
            border-left: 3px solid #4a5568;
            border-radius: 4px;
        }
        .message-box {
            background-color: #f7fafc;
            border-left: 3px solid #4a5568;
            padding: 15px;
            border-radius: 4px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            background-color: #f7fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Message from Reservation App</h1>
        </div>
        
        <div class="content">
            <p>You have received a new contact message from your reservation system.</p>
            
            <div class="field">
                <div class="field-label">Name</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>
            
            <div class="field">
                <div class="field-label">Email</div>
                <div class="field-value">
                    <a href="mailto:{{ $contact->email }}" style="color: #4299e1; text-decoration: none;">
                        {{ $contact->email }}
                    </a>
                </div>
            </div>
            
            <div class="field">
                <div class="field-label">Message</div>
                <div class="message-box">{{ $contact->message }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated message from your reservation contact system.</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>