<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Twiml;

class TwilioHelperController extends Controller
{
    /**
     * Twilio API Click-to-Call call implementation
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function call(Request $request)
    {
        // Get form input
        $userPhone = $request->adminPhone;
        $providerPhone = $request->providerPhone;
        // Set URL for outbound call - this should be your public server URL
        $host = parse_url(url()->full(), PHP_URL_HOST);;

        // Create authenticated REST client using account credentials in
        // <project root dir>/.env.php
        $client = new Client(
            getenv('TWILIO_ACCOUNT_SID'),
            getenv('TWILIO_AUTH_TOKEN')
        );

        try {
            $call = $client->calls->create(
                $userPhone, // The visitor's phone number
                getenv('TWILIO_NUMBER'), // A Twilio number in your account
                array(
                    "url" => "https://$host/outbound/$providerPhone"
                )
            );
        } catch (Exception $e) {
            // Failed calls will throw
            return $e;
        }

        // return a JSON response
        return [
          'message' => 'Call incoming!'
        ];
    }

    /**
     * Return user data as API resource
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function outbound(Request $request)
    {
      $providerPhone = $request->$providerPhone;
      // A message for Twilio's TTS engine to repeat
      $sayMessage = 'Thanks for contacting truecare24. Our
          next available representative will take your call.';

      $twiml = new Twiml();
      $twiml->say($sayMessage, array('voice' => 'alice'));
      $twiml->dial($providerPhone);

      $response = Response::make($twiml, 200);
      $response->header('Content-Type', 'text/xml');
      return $response;
    }
}
