<?php

require 'vendor/autoload.php';

class GoogleClient
{
    protected $client_id = '<CLIENT_ID>';
    protected $client_secret = '<CLIENT_SECRET>';
    protected $redirect_uri = '<REDIRECTED_URI>';
    
    protected $scopes = array('https://www.googleapis.com/auth/drive',);

    protected $client;
    protected $service;

    public function __construct() {
        $this->client = new \Google_Client();
        $this->client->setClientId($this->client_id);
        $this->client->setClientSecret($this->client_secret);
        $this->client->setRedirectUri($this->redirect_uri);
        $this->client->setAccessType('offline');
        $this->client->setScopes($this->scopes);
        if (isset($_SESSION['GOOGLE_ACCESS_TOKEN'])) {
            $this->client->setAccessToken($_SESSION['GOOGLE_ACCESS_TOKEN']);
            if($this->client->isAccessTokenExpired()){
                $client->refreshToken($_SESSION['GOOGLE_REFRESH_TOKEN']);
                $access_token = $this->client->getAccessToken();
                $_SESSION['GOOGLE_ACCESS_TOKEN'] = $access_token;
            }
        }
    }

    public function isLoggedIn(){
        if (isset($_SESSION['GOOGLE_ACCESS_TOKEN'])) {
            return true;
        } else {
            return false;
        }
    }

    public function authenticate($code) {
        $this->client->authenticate($code);
        $_SESSION['GOOGLE_ACCESS_TOKEN'] = $this->client->getAccessToken();
        $_SESSION['GOOGLE_REFRESH_TOKEN'] =  $this->client->getRefreshToken();
    }

    public function setAccessToken($accessToken) {
        $this->client->setAccessToken($accessToken);
    }

    public function getAuthUrl() {
        return $this->client->createAuthUrl();
    }

    public function getClient() {
        return $this->client;
    }

    public function initDriveService() {
        $this->service = new \Google_Service_Drive($this->client);
    }

    /**
     *  Upload file to given folder
     *  @param string $parentId parent folder id or root where folder will be upload
     *  @param string $filePath file local path of file which will be upload
     *  @param string $fileName file name of the uploaded copy at google drive
     *  @return string id of uploaded file
     */
    public function uploadFile($parentId, $filePath, $fileName = "none") {
        // If file name is 'none' then give the orignal file name
        if ($fileName=="none") {
            $fileName = end(explode('/', $filePath));
        }

        // Creating file matadata
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $fileName,
            'parents' => array($parentId)
        ));

        // Getting file into variable
        $content = file_get_contents($filePath);

        // Uploading file and getting uploaded file ID as result
        $file = $this->service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'));
        
        // Returning file id of newly uploaded file
        return $file->id;
    }
}