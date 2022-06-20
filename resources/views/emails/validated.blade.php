<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='x-ua-compatible' content='ie=edge'>
    <title></title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style type='text/css'>
        @media screen {
            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local('Source Sans Pro Regular'), local('SourceSansPro-Regular'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format('woff');
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 700;
                src: local('Source Sans Pro Bold'), local('SourceSansPro-Bold'), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format('woff');
            }
        }

        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        /**
							* Fix centering issues in Android 4.4.
							*/
        div[style*='margin: 16px 0;'] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /**
							* Collapse table borders to avoid space between cells.
							*/
        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>

</head>

<body style='background-color: #ffffff;'>
    <div class='preheader'
        style='display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;'>
    </div>

    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
            <td align='left' bgcolor='#ffffff'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='left' bgcolor='#ffffff'
                            style='padding: 36px 24px 0; font-family: &quot;Source Sans Pro&quot;, Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;'>
                            <h1
                                style='margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;'>
                               @lang('emails.notify_validated')</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align='left' bgcolor='#ffffff'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='left' bgcolor='#ffffff'>
                            <table border='0' cellpadding='0' cellspacing='0' width='90%' style='margin:4px;'>
                                <tr>
                                    <td colspan='2' align='left' bgcolor='#ffffff' style='padding: 12px;'>
                                        <p style='margin: 0;'>@lang('emails.header_validated')</p>
                                        <p style='margin: 0;'>@lang('emails.tittle_validated')</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>@lang('emails.your_validated'):</td>
                                    <td><a class="btn btn-sm btn-primary" href="{{ url('confirmation-email/'.Crypt::encryptString($user->id))}}" style="font-size: 35px; font-weight: 700"> Link </a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align='left' bgcolor='#ffffff'
                            style='padding: 24px; font-family: &quot;Source Sans Pro&quot;, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf'>
                            <p style='margin: 0;'>{{ env('APP_ADM_TITLE') }}</p>
                        </td>
                    </tr>


                </table>

            </td>
        </tr>
        <tr>
            <td align='center' bgcolor='#ffffff' style='padding: 24px;'>
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 600px;'>
                    <tr>
                        <td align='center' bgcolor='#e9ecef'
                            style='padding: 12px 24px; font-family: &quot;Source Sans Pro&quot;, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;'>
                            <p style='margin: 0;'>@lang('emails.footer_pass')</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
