<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Twilio\TwiML\VoiceResponse;
use GuzzleHttp\Client as GuzClient;


class Transcribe extends Model
{
  /**
   * TwiML for call
   * @return $this
   */
  public function twiml(){
     $response = new VoiceResponse();
     $response->say('Please leave a message at the beep. Press the star key when finished.');
     $response->record(['finishOnKey' => '*','transcribe' => 'true','maxLength' => 100,'transcribeCallback'=>'https://26644a6e.ngrok.io/api/save', 'method' => 'GET']);
     return $response;
  }

    /**
     * post message to slack channel
     *
     * @param $message
     *
     * @return mixed
     */
    public function postToSlackChannel( $message ) {
        $message=['text'=>$message];

        $client = new GuzClient([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);

        $response = $client->post( env( 'SLACK_WEBHOOK_URL' ),
            ['body' => json_encode($message)]
        );

        $data = json_decode( $response->getBody()->getContents() );

        return $data;
    }


}
