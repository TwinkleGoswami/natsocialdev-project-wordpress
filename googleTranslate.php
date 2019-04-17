<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of googleTranslate
 *
 * @author NS-47
 */
class googleTranslate {
     private $myData;  
           //retains the original text to translate
           private $originalString;
           //a constant that retain the endpoint google api translate
           const GOOGLE_ENDPOINT = 'http://ajax.googleapis.com/ajax/services/language/translate';
           /*
            * @public contructor of class
            * @param (Array) a vector composed of these components:
            *                  Array('version'=>'version'(int)),
            *                        'q'=>'text to translate'(String),
            *                        'langpair'=>'language pair from and to'(String));
            * @return void.
            */          
           public function __construct($data) {
                  /* compose data translation */
                  $this->myData = array('v'=>$data['version'],
                                        'q'=>$data['q'],
                                        'langpair'=>$data['langpair']
                                        ); 
                  $this->originalString = $data['q'];
           }  
           /*
            * @public method
            *
            * call the method execute to grab the translated text and return it.
            * @param void
            * @return (String) text translated from google engine api 
            */
           public function translate() {
                  return $this->execute();
           }
           /*
            * @private method
            *
            * make the request to the Google Translate API using curl request for fetch the result.
            * @param void
            * @return (String) text translated from google engine api 
            */
           private function execute() {
                  //init curl connection
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, self::GOOGLE_ENDPOINT);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $this->myData);
                  //execute request
                  $response = curl_exec($ch);
                  //close connection
                  curl_close($ch);  
                  //get response from google api and decoded json
                  $oResponse = json_decode($response, true);
                  //if isset translated text then hold in a variable
                  if(isset($oResponse['responseData']['translatedText'])) {
                     $sResponse = $oResponse['responseData']['translatedText']; 
                  //otherwise, an error has occured and then return original text;
                  } else {
                     $sResponse = $this->originalText;  
                  }
             //return the translated text
             return $sResponse;                     
           }                      
  
}
