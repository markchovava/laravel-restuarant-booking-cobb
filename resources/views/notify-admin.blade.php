<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking Notification</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">New Booking Received</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="margin: 0 0 20px; color: #333333; font-size: 16px; line-height: 1.6;">
                                Dear Admin,
                            </p>
                            
                            <p style="margin: 0 0 30px; color: #555555; font-size: 14px; line-height: 1.6;">
                                A new booking has been received and requires your attention.
                            </p>
                            
                            <!-- Booking Details Card -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; border-radius: 6px; border-left: 4px solid #667eea;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h2 style="margin: 0 0 20px; color: #333333; font-size: 18px; font-weight: bold;">Booking Details</h2>
                                        
                                        <table width="100%" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; width: 40%;">Booking REF:</td>
                                                <td style="color: #333333; font-size: 14px;">{{ $bookingRef }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Customer Name:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">{{ $fullName }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Email:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">
                                                    <a href="mailto:{{ $email }}" style="color: #667eea; text-decoration: none;">{{ $email }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Phone:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">
                                                    <a href="tel:{{ $phone }}" style="color: #667eea; text-decoration: none;">{{ $phone }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Date:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">{{ $date }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Time:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">{{ $time }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px;">Number of Guests:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px;">{{ $numberOfGuests }}</td>
                                            </tr>
                                            @if($notes)
                                            <tr>
                                                <td style="color: #666666; font-size: 14px; font-weight: bold; padding-top: 8px; vertical-align: top;">Notes:</td>
                                                <td style="color: #333333; font-size: 14px; padding-top: 8px; line-height: 1.6;">{{ $notes }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Action Button -->
                           <!--  <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/admin/bookings/' . $bookingRef) }}" style="display: inline-block; padding: 14px 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;">
                                            View Booking Details
                                        </a>
                                    </td>
                                </tr>
                            </table> -->
                            
                            <p style="margin: 30px 0 0; color: #555555; font-size: 14px; line-height: 1.6;">
                                Please review and confirm this booking at your earliest convenience.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0 0 5px; color: #666666; font-size: 14px;">Best regards,</p>
                            <p style="margin: 0; color: #333333; font-size: 14px; font-weight: bold;">Booking System</p>
                        </td>
                    </tr>
                    
                </table>
                
                <!-- Footer Note -->
                <table width="600" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                    <tr>
                        <td style="text-align: center; color: #999999; font-size: 12px; line-height: 1.6;">
                            <p style="margin: 0;">This is an automated notification from your booking system.</p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>
</body>
</html>