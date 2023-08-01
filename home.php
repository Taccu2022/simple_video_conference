<!DOCTYPE html>
<html lang='en'>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta conent-type="application/javascript" charset="utf-8">
    <title>Video Conferencing Chat</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href='./images/logo.png' type="image/x-icon">
    <style>
        body {
            background-image: url('images/login.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .container {
            margin-top: 50px;
            background-color: #ffffffdd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: -3px -3px 9px #aaa9a9a2, 3px 3px 7px rgba(147, 149, 151, 0.5);
        }

        video {
            width: 100%;
            max-width: 320px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
            transform: scaleX(-1); /* Mirror effect */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Video Conferencing Chat</h1>
        <div id="chatBox"></div>
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button id="sendButton">Send</button>

        <h1 class="mt-5">Welcome to Video Conference</h1>
        <button onclick="startConference()" class="btn btn-primary mt-3">Start Conference</button>
        <div id="videoContainer" class="d-flex flex-wrap"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="./scripts/chat.js"></script>
    <script src="./scripts/conference.js"></script>
</body>

</html>
