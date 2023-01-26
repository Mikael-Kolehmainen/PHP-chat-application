<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;


class CameraController
{
    public function showCameraPage()
    {
        echo "
            <title>Chat-app | Camera</title>
            <script src='/src/public_site/js/Style.js' defer></script>
            <script src='/src/public_site/js/ElementDisplay.js' defer></script>
            <script src='/src/api/js/data/Data.js' defer></script>
            <script src='/src/api/js/camera/Camera.js' defer></script>
            <script src='/src/api/js/camera/initialize-camera.js' defer></script>
        </head>
        <section>
            <main id='camera'>
                <video id='camera-view' class='camera-mirror' autoplay playsinline></video>
                <canvas id='camera-sensor' class='camera-mirror'></canvas>
                <img src='' alt='' id='camera-output' class='camera-mirror' style='display: none;'>
                <button id='camera-trigger'><img src='/src/public_site/media/icons/camera-light.svg'></button>
                <button id='camera-flip'><img src='/src/public_site/media/icons/camera-flip.svg'></button>
                <div class='top'>
                    <a class='btn round onclick' id='close-camera'>
                        <i class='fa-solid fa-chevron-left'></i>
                    </a>
                </div>
                <div class='bottom' id='image-options' style='display: none;'>
                    <a class='btn onclick' id='reject-image'>
                        <i class='fa-solid fa-xmark'></i>
                    </a>
                    <a class='btn onclick' id='accept-image'>
                        <i class='fa-solid fa-check'></i>
                    </a>
                </div>
            </main>
        </section>
        ";
    }
}