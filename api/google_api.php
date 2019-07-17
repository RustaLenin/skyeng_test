<?php

Class SkyEng_GoogleApi {

    public static function getClient() {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API PHP SkyEng' );
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY );
        $client->setAuthConfig(THEME_API . 'credentials.json' );
        $client->setAccessType('offline' );
        $client->setPrompt('select_account consent' );
        $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = THEME_API . 'token.json';
        if ( file_exists( $tokenPath ) ) {
            $accessToken = json_decode( file_get_contents( $tokenPath ), true );
            $client->setAccessToken( $accessToken );
        }

        // If there is no previous token or it's expired.
        if ( $client->isAccessTokenExpired() ) {
            // Refresh the token if possible, else fetch a new one.
            if ( $client->getRefreshToken() ) {
                $client->fetchAccessTokenWithRefreshToken( $client->getRefreshToken() );
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl );
                print 'Enter verification code: ';
                $authCode = trim( '4/iQF57_ZNrXXIIR1VMbgnzeqZ-8PWo1QSPMUhnmUzUYeysuRxpQEQhNM' );

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode( $authCode );
                $client->setAccessToken( $accessToken );

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken ) ) {
                    throw new Exception( join(', ', $accessToken ) );
                }
            }
            // Save the token to a file.
            if ( !file_exists( dirname( $tokenPath ) ) ) {
                mkdir( dirname( $tokenPath ), 0700, true );
            }
            file_put_contents( $tokenPath, json_encode( $client->getAccessToken() ) );
        }
        return $client;

    }

    public static function getService() {
        $client = self::getClient();
        $service = new Google_Service_Sheets( $client );
        return $service;
    }

    public static function getSheet() {
        $sheetID = '1t2Ux0jP0AK_Vvw1rzOq7pgRBePMHhkLpRS2m9CijIgE';
        $service = self::getService();
        $responce = $service->spreadsheets->get( $sheetID );
        return $responce;
    }

    public static function writeToSheet( $data ) {

        $answer = [
            'result' => 'error',
            'message' => 'Something happens ¯\_(ツ)_/¯',
        ];

        if ( !$data['user_email'] ) {
            $answer['message'] = 'No user_email received';
        } else {
            if ( !$data['user_name'] ) {
                $answer['message'] = 'No user_name received';
            } else {
                if ( !$data['form_type'] ) {
                    $answer['message'] = 'No form_type received';
                } else {

                    $registered_users = SkyEng_FormOptions::getOption( $data['form_type'] );
                    if ( $registered_users[$data['user_email']] ) {
                        $answer['message'] = 'Вы уже подписаны на эту рассылку';
                    } else {

                        $sheet_id = '1t2Ux0jP0AK_Vvw1rzOq7pgRBePMHhkLpRS2m9CijIgE';
                        $service = self::getService();

                        if ( $data['form_type'] === 'sherlock' ) {
                            $range = "A1:B1";
                        } else if ( $data['form_type'] === 'deal' ) {
                            $range = "D1:E1";
                        } else {
                            $range = "G1:H1";
                        }

                        $value = [ $data['user_name'], $data['user_email'] ];

                        $update_body = new Google_Service_Sheets_ValueRange([
                            'range' => $range,
                            'majorDimension' => 'ROWS',
                            'values' => [
                                $value
                            ]
                        ]);
                        $service->spreadsheets_values->append(
                            $sheet_id,
                            $range,
                            $update_body,
                            ['valueInputOption' => "RAW"]
                        );

                        $registered_users[$data['user_email']] = true;
                        SkyEng_FormOptions::updateOption( $data['form_type'], $registered_users );

                        $answer = array_merge( $answer, [
                            'result' => 'success',
                            'message' => 'Вы подписались на рассылку',
                            'payload' => [
                                'received_data' => $data,
                                'registered_users' => $registered_users
                            ]
                        ]);

                    }
                }
            }
        }

        return $answer;

    }

    public static function ajax_handler(){

        $answer = [
            'result' => 'error',
            'message' => 'Something happens ¯\_(ツ)_/¯',
        ];

        if ( !$_POST ) {
            $answer['message'] = 'No request received';
        } else {
            if ( !$_POST['command'] ) {
                $answer['message'] = 'No command received';
            } else {
                if ( !$_POST['payload'] ) {
                    $answer['message'] = 'No payload received';
                } else {

                    if ( method_exists(__CLASS__, $_POST['command'] ) ) {
                        $command = $_POST['command'];
                        $answer = self::$command($_POST['payload'] );
                    } else {
                        $answer['message'] = 'Unknown command ¯\_(ツ)_/¯';
                    }

                }
            }
        }

        $answer['source'][] = __METHOD__;
        echo json_encode($answer);
        wp_die();

    }

}

add_action( 'wp_ajax_google_api', ['SkyEng_GoogleApi', 'ajax_handler'] );
add_action( 'wp_ajax_nopriv_google_api', ['SkyEng_GoogleApi', 'ajax_handler'] );