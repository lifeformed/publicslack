<?php
        include('config.php');

        $message = '';
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $success = register($email, $message);

        if($success) {
                $title = "Invitaci&oacute;n enviada.";
                html_main($title, $message, '');
                exit();
        }
        else {
                $title = "Error enviando invitaci&oacute;n.";
                $extraHTML = "<div class='try-again'><a href='./'>Intenta nuevamente.</a></div>";
                html_main($title, $message, $extraHTML);
                exit();
        }

        function register($email, &$message)
        {
                date_default_timezone_set('America/Montevideo');
                mb_internal_encoding("UTF-8");

                if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                        $message = "No parece una direcci&oacute;n de correo v&aactute;lida.";
                        return false;
                }

                $email = filter_var($email, FILTER_SANITIZE_EMAIL);

                $slackHostName= $GLOBALS['slackHostName'];
                $slackAutoJoinChannels= $GLOBALS['slackAutoJoinChannels'];
                $slackAuthToken= $GLOBALS['slackAuthToken'];
                $slackInviteUrl='https://'.$slackHostName.'.slack.com/api/users.admin.invite?t='.time();

                $fields = array(
                        'email' => urlencode($email),
                        'channels' => urlencode($slackAutoJoinChannels),
                        'first_name' => '',
                        'token' => $slackAuthToken,
                        'set_active' => urlencode('true'),
                        '_attempts' => '1'
                );

                // url-ify the data for the POST
                $fields_string='';
                foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
                rtrim($fields_string, '&');

                // open connection
                $ch = curl_init();
                // set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $slackInviteUrl);
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch,CURLOPT_POST, count($fields));
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

                // exec
                $replyRaw = curl_exec($ch);
                $reply=json_decode($replyRaw,true);

                // close connection
                curl_close($ch);

                if($reply['ok']==false) {
                        switch ($reply['error']) {
                        case 'bad_address':
                                $message = "No parece una direcci&oacute;n de correo v&aactute;lida.";
                                return false;
                        case 'sent_recently':
                        case 'already_invited':
                                $message = "Una invitaci&oacute;n ya fue enviada a esa direcci&oacute;n de correo";
                                return false;
                        case 'already_in_team':
                                $message = "La direcci&oacute;n de correo ya se encuentra registrada.";
                                return false;
                        default:
                                $url = "<a href='".$GLOBALS['meetupUrl'].">Meetup</a>";
                                $message = "Error inesperado. Por favor, reporta el problema en nuestro sitio en <a href='".$GLOBALS['meetupUrl'].">Meetup</a>.";
                                return false;
                        }
                }
                else {
                        $message = "La invitaci&oacute;n ha sido enviada a: <em>" . $email ."</em>";
                        return true;
                }
        }

        function html_main($title, $message, $extraHTML)
        {
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
                <title><?php echo $title; ?></title>
                <link href='http://fonts.googleapis.com/css?family=Lato:400,400italic' rel='stylesheet' type='text/css'>
                <link href="styles.css" rel="stylesheet" type="text/css" />     
        <body>
                <div class="bg">
                        <div class="bg-inner">
                                <div class="main">
                                <div class="info"><?php echo $message; ?></div>
                                <?php echo $extraHTML; ?>
                                <div class="info-bottom">S&iacute;genos en <a href="<?php echo $GLOBALS['meetupUrl']; ?>">Meetup</a>.
                                        </div>
                                </div>
                        </div>
                </div>
        </body>
        </html>

        <?php
        }

?>