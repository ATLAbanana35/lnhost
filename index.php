<?php
include("backend/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
    body {
        background: rgb(27, 0, 36);

        margin: 0;
    }

    .bento {
        font-family: Arial, Helvetica, sans-serif;
        top: 50%;
        left: 50%;
        width: 75%;
        height: 75%;
        transform: translate(-50%, -50%);
        position: absolute;
        padding: 50px;
        display: grid;
        border-radius: 20px;
        grid-template-areas:
            "head nav apps"
            "overview nav apps"
            "overview footer footer"
            "settings settings settings";
        gap: 20px;
        overflow: hidden;
    }

    .bento_child {
        transition: 0.5s;

        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 5px 1px;
        background: rgba(177, 42, 255, 0.381);
        color: #fff;
    }

    .bento_child:hover {
        transform: translateY(-10px) scale(1.01);
    }

    header {
        grid-area: head;
        text-align: center;
    }

    nav {
        grid-area: nav;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 0;
        text-align: center;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    li a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    li a:hover {
        color: #dbc8ff;
    }

    #overview,
    #apps,
    #settings {
        grid-area: overview;
    }

    h2 {
        color: #fff;
        border-bottom: 2px solid #fff;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .online {
        color: #00ff00;
        font-weight: bold;
    }

    .offline {
        color: #ff0000;
        font-weight: bold;
    }

    .pending {
        color: #ffc400;
        font-weight: bold;
    }

    ul {
        padding-left: 20px;
    }

    ul li {
        margin-bottom: 8px;
    }

    footer {
        grid-area: footer;
        text-align: center;
        font-size: 14px;
    }

    header {
        grid-area: head;
    }

    nav {
        grid-area: nav;
    }

    #overview {
        grid-area: overview;
    }

    #apps {
        grid-area: apps;
    }

    #settings {
        grid-area: settings;
    }

    footer {
        grid-area: footer;
    }

    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(to left, #2bc0e4, #eaecc6);
    }

    .menu-checkbox {
        display: none;
    }

    .menu {
        position: relative;
    }

    .menu-dots {
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        box-shadow: 0 0 0 0.3rem #161e3f;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transform: rotate(90deg);
        transition: 0.3s;
        cursor: pointer;
    }

    .menu-dots:hover {
        box-shadow: 0 0 0 0.3rem #161e3f, 0 0 0 1rem rgba(22, 30, 63, 0.16);
        transform: scale(1.2) rotate(90deg);
    }

    .menu-dot {
        width: 0.45rem;
        height: 0.45rem;
        background-color: #161e3f;
        border-radius: 50%;
    }

    .menu-dot+.menu-dot {
        margin-top: 0.3rem;
    }

    .menu-items {
        position: absolute;
        top: -2.3rem;
        left: -2.2rem;
        width: 9.4rem;
        height: 11rem;
        color: #fff;
        pointer-events: none;
        display: grid;
        grid-template-columns: 1fr 1fr;
        opacity: 0;
        transition: 0.3s;
    }

    .menu-item {
        transform: scale(0.5);
        filter: blur(10px);
        transition: 0.3s;
    }

    .menu-item:nth-child(odd) {
        text-align: right;
    }

    .menu-item:nth-child(even) {
        text-align: left;
    }

    .menu-item:first-child,
    .menu-item:last-child {
        grid-column: span 2;
        text-align: center;
    }

    .menu-checkbox:checked+.menu>.menu-dots {
        transform: none;
        box-shadow: 0 0 0 3.4rem #161e3f;
    }

    .menu-checkbox:checked+.menu>.menu-items {
        opacity: 1;
        pointer-events: auto;
    }

    .menu-closer-overlay {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: transparent;
        border-radius: 50%;
        z-index: 2;
        pointer-events: none;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item {
        opacity: 1;
        transform: none;
        transform: translateX(-30px);
        filter: none;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(1) {
        transition-delay: 0.05s;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(2) {
        transition-delay: 0.1s;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(3) {
        transition-delay: 0.15s;
        transform: translateY(10px);
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(4) {
        transition-delay: 0.2s;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(5) {
        transition-delay: 0.25s;
    }

    .menu-checkbox:checked+.menu>.menu-items>.menu-item:nth-child(6) {
        transition-delay: 0.3s;
    }

    .menu-checkbox:checked+.menu>.menu-closer-overlay {
        pointer-events: auto;
        cursor: pointer;
    }
    </style>
    <title>Server Dashboard</title>
</head>

<body>
    <div class="bento">
        <header class="bento_child">
            <h1>LNHost Server Dashboard</h1>
        </header>
        <nav class="bento_child">
            <input class="menu-checkbox" id="menu" type="checkbox" name="menu" />
            <nav class="menu">
                <label class="menu-dots" for="menu">
                    <span class="menu-dot"></span>
                    <span class="menu-dot"></span>
                    <span class="menu-dot"></span>
                </label>
                <ul class="menu-items">
                    <li class="menu-item" onclick="location.href = 'apps.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-app-indicator" viewBox="0 0 16 16">
                            <path
                                d="M5.5 2A3.5 3.5 0 0 0 2 5.5v5A3.5 3.5 0 0 0 5.5 14h5a3.5 3.5 0 0 0 3.5-3.5V8a.5.5 0 0 1 1 0v2.5a4.5 4.5 0 0 1-4.5 4.5h-5A4.5 4.5 0 0 1 1 10.5v-5A4.5 4.5 0 0 1 5.5 1H8a.5.5 0 0 1 0 1z" />
                            <path d="M16 3a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        </svg>
                    </li>
                    <li class="menu-item" onclick="location.href = 'index.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-speedometer2" viewBox="0 0 16 16">
                            <path
                                d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4M3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                            <path fill-rule="evenodd"
                                d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A8 8 0 0 1 0 10m8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3" />
                        </svg>
                    </li>
                    <li class="menu-item" onclick="location.href = 'settings.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-gear" viewBox="0 0 16 16">
                            <path
                                d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                            <path
                                d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                        </svg>
                    </li>
                </ul>
                <label for="menu" class="menu-closer-overlay"></label>
            </nav>
        </nav>
        <section class="bento_child" id="overview">
            <h2>Overview</h2>
            <p>
                Server Status:
                <span class="IOContain"><span class="pending">Pending</span></span>
            </p>
            <!-- Add more server overview information as needed -->
        </section>
        <section class="bento_child" id="apps">
            <h2>Installed Apps</h2>
            <ul>
                <!-- Add more app entries as needed -->
            </ul>
        </section>
        <section class="bento_child" id="settings">
            <h2>Server Settings</h2>
            <p>Server Name: <span class="SName">[OFFLINE]</span></p>
            <p>IP Address: <span class="SAddr">[OFFLINE]</span></p>
            <!-- Add more server settings as needed -->
        </section>
        <footer class="bento_child">&copy; 2024 Server Dashboard</footer>
    </div>
    <script>
    const XML = new XMLHttpRequest();
    XML.open("GET", "api/getStatus.php");
    XML.onload = function name(params) {
        document.querySelector(".IOContain").innerHTML = XML.responseText;
    };
    XML.send();
    const XML2 = new XMLHttpRequest();
    XML2.open("GET", "api/getServerInfos.php");
    XML2.responseType = "json";
    XML2.onload = function name(params) {
        const infos = XML2.response;
        document.querySelector(".SAddr").textContent = infos["server_address"];
        document.querySelector(".SName").textContent = infos["name"];
        infos["apps"].forEach((element) => {
            document.querySelector("#apps ul").innerHTML += `
          <li>${element}</li>
          `;
        });
    };
    XML2.send();
    </script>
</body>

</html>