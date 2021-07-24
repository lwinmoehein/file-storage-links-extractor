<?php
# goutte_xpath.php

require 'vendor/autoload.php';

class LINKTYPES {
    public const GOOGLE_DRIVE_LINK="GOOGLE_DRIVE_LINK";
    public const MEDIA_FIRE_LINK = "MEDIA_FIRE_LINK";    
}

$mediaFireLinkPattern = "/mediafire.com/i";
$googleDriveLinkPattern = "/drive.google.com/i";

$mediaFireLinkIdToBeScraped = "#downloadButton";
$googleDriveLinkIdToBeScraped = "#uc-download-link";

$mediaFire = 'https://www.mediafire.com/file/fa07cvryrx3lvel/The_Easiest_Way_To_Learn_Hiragana.mp4/file';
$googleDrive =  'https://drive.google.com/u/0/uc?id=115Dxnbm0L0BX7t1qYh5JEAk4aAyOGwCN&export=download';


$linkObject = new stdClass();
$linkObject->url = $mediaFire;

if(preg_match($mediaFireLinkPattern, $linkObject->url)){
    $linkObject->type = LINKTYPES::MEDIA_FIRE_LINK;
    $linkObject->linkPattern = $mediaFireLinkIdToBeScraped;
}else {
    $linkObject->type = LINKTYPES::GOOGLE_DRIVE_LINK;
    $linkObject->linkPattern = $googleDriveLinkIdToBeScraped;
}


$client = new \Goutte\Client();

$crawler = $client->request('GET',$linkObject->url);

switch($linkObject->type){
    case LINKTYPES::MEDIA_FIRE_LINK:
        $link = $crawler->filter($linkObject->linkPattern)->link();
    default :
        $link = $crawler->filter($linkObject->linkPattern)->link();
}
echo $linkObject->type."::";
echo $link->getUri().PHP_EOL;