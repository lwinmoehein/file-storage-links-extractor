<?php
# goutte_xpath.php

require 'vendor/autoload.php';

if(!isset($_POST['media_link']))
    echo json_encode(["message"=>"No Link Provided"]);

$requestLink = $_POST['media_link'];

class LINKTYPES {
    public const GOOGLE_DRIVE_LINK="GOOGLE_DRIVE_LINK";
    public const MEDIA_FIRE_LINK = "MEDIA_FIRE_LINK";    
}

$mediaFireLinkPattern = "/mediafire.com/i";
$googleDriveLinkPattern = "/drive.google.com/i";

$mediaFireLinkIdToBeScraped = "#downloadButton";
$googleDriveLinkIdToBeScraped = "#uc-download-link";


$linkObject = new stdClass();
$linkObject->url = $requestLink;

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
        $linkObject->absoluteLink = $crawler->filter($linkObject->linkPattern)->link()->getUri();
    default :
        $linkObject->absoluteLink = $crawler->filter($linkObject->linkPattern)->link()->getUri();
}

echo json_encode($linkObject);
