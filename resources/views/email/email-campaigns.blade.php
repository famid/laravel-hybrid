<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email template</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800');

        img{
            max-width: 100%;
        }
        body {
            font-family: 'Montserrat', sans-serif;
        }

        #email-body strong{
            font-size: 15px;
            color: #1e1b4d;
            line-height: 20px;
        }
        #email-body strong a{
            color: #82d248;
        }

        .email-footer-bottom strong{
            font-size: 12px;
            color: #272633;
            font-weight: 600;
        }
        .email-footer-bottom a{
            font-size: 10px;
            font-weight: 600;
            color: #272633;
        }
        .email-footer-bottom a span{
            color: #ff5a00;
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

        }

        @media only screen and (max-width: 500px) {
            
            .confirm-your-account a {
                width: 100%;
                padding-left: 0;
                padding-right: 0;
                font-size: 13px;
                text-align: center;
            }
        
            #email-body h1, #email-body h2 {
                font-size: 24px;
                line-height: 30px;
            }
            img.shapes{
                left: 0;
                top: -10px;
            }
            
            #main-logo img,
            #main-logo{
                width: 180px;
            }


        }
    </style>
</head>

<body bgcolor="#ffffff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

    <!-- Start Email Container -->
    <table border="0" cellpadding="0" cellspacing="0" id="emailContainer" style="width:600px;margin:0 auto; padding: 0 35px;" bgcolor="{{ $color }}">
        <tr>
            <td align="center" valign="top" id="emailContainerCell">

                <!-- Start Email Header Area-->
                <!-- email header top start -->
                <table border="0" cellpadding="0" cellspacing="0" id="email-header-top"
                    style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; border-bottom: 1px solid #ededed;
            padding: 8px 0;">
                    <tr style="margin-bottom: 10px;">
                        
                        <td style="font-size: 12px; font-weight: 600; color: #fff;" align="right"><a style="text-decoration: none;
            color: rgb(255, 255, 255); mix-blend-mode: difference;" href="https://apperoni.com">www.apperoni.com</a></td>
                    </tr>
                </table>
                <!-- email header top end -->

                <!-- email header bottom start -->
                <table border="0" cellpadding="0" cellspacing="0" id="email-header-bottom"
                    style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; padding-top: 20px; padding-bottom: 20px;">
                    <tr>
                        <td align="center" id="main-logo"><img src="{{ $logo }}" alt="apperoni logo" style="max-width: 40px"></td>
                    </tr>
                </table>
                <!-- email header bottom end -->
                <!-- End Email Header Area -->
                <div style="position: relative; border-radius: 13px;">
                    <table border="0" cellpadding="0" cellspacing="0" id="email-body"
                        style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important;">
                        <tr>
                            <td>
                                <img src="{{ $image }}" alt="">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size: 14px; color: rgb(255, 255, 255); mix-blend-mode: difference; letter-spacing: 0; line-height: 23px;">{{ $body }}</p>
                                @if(isset($link))
                                    <a style="    display: inline-block; color: #ffffff; background: #1f2942; text-decoration: none; font-size: 13px; height: 35px; line-height: 35px; padding-left: 20px; padding-right: 20px; font-weight: 600;" href="{{ $link }}">{{ __('Read more') }}</a>
                                @endif
                                <br>
                                <br>
                            </td>
                        </tr>
                        @if (isset($articles) && count($articles) > 0)
                            <tr>
                                <td>
                                    <table id="articles">
                                        @foreach($articles as $article)
                                            <tr>
                                                <td style="width: 30%; padding-right: 10px;">
                                                    <img src="{{ $article['image'] }}" alt="">
                                                </td>
                                                <td colspan="2">
                                                    <p style="font-size: 14px; color: rgb(255, 255, 255); mix-blend-mode: difference; letter-spacing: 0; line-height: 23px;">{{ $article['news'] }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
                <!-- Start Email Body Area -->
                <!-- End Email Body Area -->

                <!-- Start Email Footer Area -->
                <table border="0" cellpadding="0" cellspacing="0" id="email-footer"
                    style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; padding-bottom: 28px;">
                    <tr>
                        <td align="right">
                            <!-- email-footer-bottom start -->
                            <table class="email-footer-bottom" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed;max-width:100% !important;width: 100% !important;min-width: 100% !important; padding-top: 15px;">
                                <tr>
                                    <td colspan="2">
                                        <p style="font-size: 10px; color: rgb(255, 255, 255); mix-blend-mode: difference; margin-bottom: 0;">Apperoni - O seu parceiro das aplicações móveis</p>
                                    </td>
                                </tr>
                                {{--<tr>
                                    <td colspan="2">
                                        <p><br><a style="font-size: 10px; font-weight: 600; color: #fff;" class="wp_unsubscribe_link" href="https://apperoni.com/contacto">Fale connosco</a></p>
                                    </td>
                                </tr>--}}
                            </table>
                            <!-- email-footer-bottom end -->
                        </td>
                    </tr>
                </table>
                <!-- End Email Footer Area -->

            </td>
        </tr>
    </table>

</body>

</html>