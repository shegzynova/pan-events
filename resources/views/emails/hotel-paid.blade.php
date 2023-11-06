<html>
<head>

    <!-- gmail fix 1 -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--end fix 1-->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Pan Events</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,700;1,400&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/brands.min.css"/>
    <style>
        /* -------------------------------------
            INLINED WITH htmlemail.io/inline
        ------------------------------------- */

        /* -------------------------------------
            RESPONSIVE AND MOBILE FRIENDLY STYLES
        ------------------------------------- */
        @media only screen and (max-width: 620px) {
            table[class=body] h1 {
                font-size: 28px !important;
                margin-bottom: 10px !important;
            }

            table[class=body] {
                padding: 10px !important;
            }

            table[class=body] p.title-label {
                font-size: 20px !important;
            }

            table[class=body] p,
            table[class=body] ul,
            table[class=body] ol,
            table[class=body] td,
            table[class=body] span,
            table[class=body] a {
                font-size: 15px !important;
            }

            table[class=body] .wrapper,
            table[class=body] .article {
                padding: 20px !important;
            }

            table[class=body] .content {
                padding: 0 !important;
            }

            table[class=body] .container {
                padding: 0 !important;
                width: 100% !important;
            }

            table[class=body] .main {
                border-left-width: 0 !important;
                border-radius: 0 !important;
                border-right-width: 0 !important;
            }

            table[class=body] .btn table {
                width: 100% !important;
            }

            table[class=body] .btn a {
                width: 100% !important;
            }

            table[class=body] .img-responsive {
                height: auto !important;
                max-width: 100% !important;
                width: auto !important;
            }
        }


        /* -------------------------------------
            PRESERVE THESE STYLES IN THE HEAD
        ------------------------------------- */
        @media all {
            .ExternalClass {
                width: 100%;
            }

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }

            .apple-link a {
                color: inherit !important;
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                text-decoration: none !important;
            }

            #MessageViewBody a {
                color: inherit;
                text-decoration: none;
                font-size: inherit;
                font-family: inherit;
                font-weight: inherit;
                line-height: inherit;
            }

            .btn-primary table td:hover {
                background-color: #34495E !important;
            }

            .btn-primary a:hover {
                background-color: #34495E !important;
                border-color: #34495E !important;
            }
        }
    </style>
</head>
<body class=""
      style="background-color: #F6F6F6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
<!-- Gmail hack ii -->
<div
        style="display:none; white-space:nowrap; font:15px courier; color:#ffffff; line-height:0; width:600px !important; min-width:600px !important; max-width:600px !important;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
<!-- /Gmail hack ii -->

<table border="0" cellpadding="0" cellspacing="0" class="body"
       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #F6F6F6;">
    <tr>
        <td style="font-family: 'DM Sans', sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        <td class="container"
            style="font-family:'DM Sans', sans-serif; font-size: 14px; vertical-align: top; display: block; Margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
            <div class="content"
                 style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">

                <!-- START CENTERED WHITE CONTAINER -->
                <table class="main"
                       style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #FFFFFF; border-radius: 4px; box-shadow: 0px 4px 14px rgba(0, 0, 0, 0.03);">

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper"
                            style="font-family: 'DM Sans', sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 38px;">
                            <table border="0" cellpadding="0" cellspacing="0"
                                   style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                                <tr>
                                    <td style="font-family: 'DM Sans', sans-serif; font-size: 14px; vertical-align: top;">
                                        <img width="200px" src="{{ asset(config('pan.site_logo')) }}" alt="Pan Events"
                                             style="margin-bottom: 40px;">
                                    <h2></h2>
                                        <h2>Dear {{ $data['name'] }},</h2>

                                        <p>We hope this email finds you well. We are excited to confirm your hotel accommodation payment for the upcoming {{ optional(optional($data)['event'])['title'] }}, which is scheduled to take place on {{ optional(optional($data)['event'])['date'] }} at {{ optional(optional($data)['event'])['location'] }}. Your payment has been duly received, and we are pleased to confirm that the transaction was completed without any issues.</p>

                                        <p>Total Amount Paid:</p>
                                        <ul>
                                            <li>NGN {{ number_format(optional($data)['amount'] ?? 0) }}</li>
                                        </ul>

                                        <p>Hotel Accommodation Details:</p>
                                        @if (!is_null(optional($data)['hotel']))
                                            <ul>
                                                <li>Hotel Name: {{ optional(optional($data)['hotel'])['name'] }}</li>
                                                <li>Number of Rooms: {{ optional($data)['quantity'] }}</li>
                                                <li>Hotel Address: {{ optional(optional($data)['hotel'])['address'] }}</li>
                                            </ul>
                                        @endif

                                        <p>Should you have any questions or require further assistance, please don't hesitate to contact our support team at {{ config('pan.phone_number') }} or {{ config('pan.email') }}.</p>

                                        <p>Thank you once again for choosing to be a part of {{ optional(optional($data)['event'])['title'] }}.</p>

                                        <p>Best regards,</p>
                                        <p>The {{ config('pan.site_name') }} team</p>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>

            </div>
        </td>
        <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
    </tr>
</table>
</body>
</html>
