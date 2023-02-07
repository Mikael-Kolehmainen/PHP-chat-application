<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\manager\ValidationManager;
use api\model\Database;

class CameraController
{
    /** @var Database */
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function showCamera(): void
    {
        ValidationManager::validaterUserLoggedIn();
        ValidationManager::validateGroupExistence($this->db, ServerRequestManager::getGroupIdFromUri());
        ValidationManager::validateUserGroupMembership();

        $this->showCameraPage();
    }

    private function showCameraPage()
    {
        $groupsId = ServerRequestManager::getGroupIdFromUri();

        echo "
            <title>Chat-app | Camera</title>
            <script src='/src/public_site/js/Style.js' defer></script>
            <script src='/src/public_site/js/ElementDisplay.js' defer></script>
            <script src='/src/api/js/data/Data.js' defer></script>
            <script src='/src/api/js/camera/Camera.js' defer></script>
            <script src='/src/api/js/camera/initialize-camera.js' defer></script>
            <script src='/src/api/js/camera/onclick-camera.js' defer></script>
        </head>
        <main id='camera'>
            <video id='camera-view' class='camera-mirror' autoplay playsinline></video>
            <canvas id='camera-sensor' class='camera-mirror'></canvas>
            <img src='' alt='' id='camera-output' class='camera-mirror' style='display: none;'>
            <button id='camera-trigger'><img src='/src/public_site/media/icons/camera-light.svg'></button>
            <button id='camera-flip'><img src='/src/public_site/media/icons/camera-flip.svg'></button>
            <div class='top'>
                <a href='/index.php/group/chat/$groupsId' class='btn round' id='close-camera'>
                    <i class='fa-solid fa-chevron-left'></i>
                </a>
            </div>
            <div class='bottom' id='image-options' style='display: none;'>
                <a class='btn' id='reject-image'>
                    <i class='fa-solid fa-xmark'></i>
                </a>
                <a class='btn' id='accept-image'>
                    <i class='fa-solid fa-check'></i>
                </a>
            </div>
        </main>
        ";
    }
}