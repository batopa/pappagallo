<?php

class TextToSpeech
{
    
    protected $engines = array(
        'googleTranslate' => array(
            'url' => 'http://translate.google.com/translate_tts?tl=%s&q=%s'
        )
    );

    protected $text = array();

    protected $lang = 'it';

    private $engineUsed = 'googleTranslate'; 

    public function __construct($text = '', $engine = null)
    {
        $this->setEngine($engine);
        $this->setText($text);
    }

    public function setEngine($engine)
    {
        if (array_key_exists($engine, $this->engines)) {
            $this->engineUsed = $engine;
        }
    }

    public function setText($text)
    {
        if ($this->engineUsed == 'googleTranslate') {
            $this->text = array($text);
        } else {
            $this->text = array($text);
        }
    }

    public function getSpeech()
    {
        $audioFileName = '';
        $audioFiles = array();
        foreach ($this->text as $t) {
            $text = urlencode(trim($t));
            $url = sprintf($this->engines[$this->engineUsed]['url'], $this->lang, $text);
            $mp3data = file_get_contents($url);
            $fileName = md5($url);
            $fileName = 'tts-files/' . $fileName . '.mp3';
            // echo "url: ". $url;exit;
            file_put_contents($fileName, $mp3data);
            $audioFiles[] = $fileName;    
        }

        // build one file merging chunks
        if (count($audioFiles) > 1) {

        } else {
            $audioFileName = $audioFiles[0];
        }
        
        return $fileName;
    }

    public function jsonData()
    {
        $data = array();
        $data['text'] = $this->text;
        $data['src'] = $this->getSpeech();
        return json_encode($data);
    }

}

