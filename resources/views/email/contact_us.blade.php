<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email template</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800');

        body {
            font-family: 'Montserrat', sans-serif;
        }
        img{
            max-width: 100%;
        }

        /* header top */
        #email-header-top{
            border-bottom: 1px solid #ededed;
            padding: 8px 0;
        }
        #email-header-top tr{
            margin-bottom: 10px;
        }
        #email-header-top tr td{
            font-size: 12px;
            font-weight: 600;
            color: #504f5a;
        }
        #email-header-top tr td:last-child{
            width: 128px;
            border-left: 1px solid #ededed;
        }
        #email-header-top tr td a{
            text-decoration: none;
            color: #272633;
        }

        /* email-header-bottom */
        #email-header-bottom{
            padding: 20px 0;
        }
        #email-header-bottom tr td ul{
            margin: 0;
            padding: 0;
        }
        #email-header-bottom tr td ul li{
            display: inline-block;
            margin-left: 4px;
            width: 22px;
        }

        #main-logo{
            max-width: 220px;
        }

        /* email-body */
        #email-body {
            padding: 75px 40px 60px;
            margin-bottom: 25px;
            background: #fff;
            border-radius: 13px;
            box-shadow: 0 0 43px rgba(0,0,0,0.04)
        }
        #email-body h1,
        #email-body h2{
            font-size: 35px;
            line-height: 43px;
            text-transform: uppercase;
            color: #1e1b4d;
            font-weight: 900;
            letter-spacing: 0;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
        }
        #email-body h2{
            color: #ff5a00;
        }
        #email-body p{
            font-size: 14px;
            color: #1e1b4d;
            font-weight: 500;
            margin: 0;
            line-height: 21px;
        }
        #email-body strong{
            font-size: 15px;
            color: #1e1b4d;
        }
        .reset-pass-btn a {
            display: inline-block;
            height: 40px;
            line-height: 40px;
            padding: 0 40px;
            background: #70a83b;
            color: #fefefe;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            border-radius: 40px;
        }

        /* email footer */
        #email-footer{
            padding-bottom: 28px;
        }
        #footer-logo{
            width: 140px;
        }

        .email-footer-top p{
            font-size: 14px;
            color: #666;
        }
        .email-footer-top {
            border-bottom: 1px solid #dbdbdb;
            padding-bottom: 5px;
        }

        /* email-footer-bottom */
        .email-footer-bottom {
            padding-top: 15px;
        }
        .email-footer-bottom strong{
            font-size: 12px;
            color: #272633;
            font-weight: 600;
        }
        .email-footer-bottom a{
            font-size: 14px;
            font-weight: 600;
            color: #272633;
        }
        .email-footer-bottom a span{
            color: #ff5a00;
        }
        .email-footer-bottom p{
            font-size: 10px;
            color: #9593a2;
            margin-bottom: 0;
        }



        @media screen and (max-width:600px) {
            #emailContainer {
                width: 100%!important;
                padding: 0 15px!important;
            }
            #email-body {
                padding: 25px 15px;
            }
            #email-body h1, #email-body h2 {
                font-size: 37px;
                line-height: 42px;
            }
            #email-body .email-confirmation-icon {
                text-align: right;
            }


        }

        @media only screen and (max-width: 480px) {

            /* td[class="email-content-box"] table {
                text-align: left;
            } */

            #email-body h1, #email-body h2 {
                font-size: 30px;
                line-height: 34px;
            }


        }
    </style>
</head>

<body bgcolor="#ffffff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

<!-- Start Email Container -->
<table border="0" cellpadding="0" cellspacing="0" id="emailContainer" style="max-width:600px;margin:0 auto; padding: 0 35px;" bgcolor="#f6f6fc">
    <tr>
        <td align="center" valign="top" id="emailContainerCell">

            <!-- Start Email Header Area-->
            <!-- email header bottom start -->
            <table border="0" cellpadding="0" cellspacing="0" id="email-header-bottom"
                   style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                <tr>
                    <td id="main-logo"><img src="{{ $logo }}" alt="apperoni logo" style="max-width: 40px"></td>
                    {{--<td align="right">
                        <ul>
                            <li><a href="#"><img src="facebook.png" alt="facebook"></a></li>
                            <li><a href="#"><img src="twitter.png" alt="twitter"></a></li>
                            <li><a href="#"><img src="instagram.png" alt="instagram"></a></li>
                        </ul>
                    </td>--}}
                </tr>
            </table>
            <!-- email header bottom end -->
            <!-- End Email Header Area -->

            <!-- Start Email Body Area -->
            <table border="0" cellpadding="0" cellspacing="0" id="email-body"
                   style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                <tr>
                    <td>
                        <h1>{{ __('Contact') }}</h1>
                        <h2>{{ $company }}</h2>
                    </td>
                    <td valign="center" style="width: 70px;" class="email-confirmation-icon">
                        <img src="{{ asset('assets/images/email-confirmation-icon.png') }}" alt="email confirmation icon">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <br>
                        <strong>{{ __('Hi, :name', ['name' => $name]) }}</strong>
                        <br>
                        <br>
                        <p><strong>{{ $company }} </strong>{{ __('appreciates your contact. We will answer you as soon as possible') }}</p>
                        <br>
                        <br>
                        <p style="max-width: 500px">{{ __('Your message :') }} {{$data_message}}</p>
                        <br>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>{{ __('Thank you for your time.') }}</strong>
                        <p>{{ __('The :company TEAM.', ['company' => $company]) }}</p>
                    </td>
                </tr>
            </table>
            <!-- End Email Body Area -->

        </td>
    </tr>
</table>

</body>

</html>