<?php

require 'php/TextToSpeech.php';

if (empty($_POST['text'])) {
	header('HTTP 1.1 500 Server Error');
}

$tts = new TextToSpeech($_POST['text']);
$data = $tts->jsonData();

header('Application/json');

echo $data;