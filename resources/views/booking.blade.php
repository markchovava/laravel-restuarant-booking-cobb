<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .booking-ref {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 4px;
        }
        .booking-ref strong {
            color: #667eea;
            font-size: 18px;
        }
        .details-section {
            margin-bottom: 25px;
        }
        .details-section h2 {
            color: #667eea;
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .detail-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
            width: 140px;
            flex-shrink: 0;
        }
        .detail-value {
            color: #333;
            flex-grow: 1;
        }
        .notes-section {
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
        .notes-section h3 {
            margin: 0 0 10px;
            color: #f57c00;
            font-size: 16px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
        .highlight {
            background-color: #e3f2fd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            color: #1976d2;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                border-radius: 0;
            }
            .content {
                padding: 20px;
            }
            .detail-row {
                flex-direction: column;
            }
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 New Booking Received!</h1>
            <p>A new reservation has been made</p>
        </div>

        <div class="content">
            <div class="booking-ref">
                <strong>Booking Reference:</strong> {{ $data->bookingRef }}
            </div>

            <div class="details-section">
                <h2>📋 Customer Information</h2>
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value">{{ $data->fullName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $data->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $data->phone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Number of Guests:</span>
                    <span class="detail-value">{{ $data->guests }}</span>
                </div>
            </div>

            <div class="details-section">
                <h2>📅 Reservation Details</h2>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value highlight">{{ $data->date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value highlight">{{ $data->time }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Location:</span>
                    <span class="detail-value">{{ $data->locationName }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Table:</span>
                    <span class="detail-value">{{ $data->tableName }}</span>
                </div>
            </div>

            @if($data->notes)
            <div class="notes-section">
                <h3>📝 Special Notes:</h3>
                <p style="margin: 0; color: #333;">{{ $data->notes }}</p>
            </div>
            @endif
        </div>

        <div class="footer">
            <p><strong>Booking created on:</strong> {{ $data->created_at->format('F d, Y \a\t h:i A') }}</p>
            <p>This is an automated notification. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>