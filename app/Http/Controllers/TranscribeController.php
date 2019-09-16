<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Transcribe;

class TranscribeController extends Controller
{
    /**
    * Twiml response endpoint
    */
    public function twimlResponse(){

     $model = new Transcribe();
     $response = $model->twiml();
     return Response::make($response, '200')->header('Content-Type', 'text/xml');

    }

    /**
     * send the Twilio transcript to Slack
     */
    public function saveTranscript(Request $request){
        $model = new Transcribe;
        $transcription = $request->TranscriptionText;
        $data = $model->postToSlackChannel($transcription);
        return $data;
    }

}
