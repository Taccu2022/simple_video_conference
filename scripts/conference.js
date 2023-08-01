
let localStream; // Local video stream
let peerConnection; // Peer connection object
const signalingServer = 'ws://localhost:3060'; // WebSocket server address

async function startConference() {
    try {
        // Get the user media (video and audio)
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        localStream = stream;
        const videoContainer = document.getElementById('videoContainer');
        const localVideo = createVideoElement(stream, 'Local User');
        videoContainer.appendChild(localVideo);

        // Connect to the signaling server
        const ws = new WebSocket(signalingServer);
        ws.onopen = () => {
            console.log('Connected to signaling server.');
            ws.send(JSON.stringify({ type: 'startConference', username: 'Host User' }));
        };

        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            handleSignalingMessage(data);
        };
    } catch (error) {
        console.error('Error accessing media devices:', error);
    }
}

function createVideoElement(stream, username) {
    const video = document.createElement('video');
    video.srcObject = stream;
    video.autoplay = true;
    video.muted = true; // Mute local video to avoid echo
    video.addEventListener('loadedmetadata', () => {
        console.log(`Video element created for ${username}`);
    });
    return video;
}

function handleSignalingMessage(message) {
    switch (message.type) {
        case 'conferenceStarted':
            joinConference(message.conferenceId, 'Participant User');
            break;
        case 'participantJoined':
            console.log(`${message.participantUsername} has joined the conference.`);
            break;
        // Handle other signaling messages as needed
    }
}

async function joinConference(conferenceId, username) {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        const remoteVideo = createVideoElement(stream, username);
        const videoContainer = document.getElementById('videoContainer');
        videoContainer.appendChild(remoteVideo);

        // Create and set up the peer connection
        peerConnection = new RTCPeerConnection();
        peerConnection.addStream(localStream);
        stream.getTracks().forEach(track => peerConnection.addTrack(track, stream));
        peerConnection.onicecandidate = handleIceCandidate;
        peerConnection.onaddstream = handleRemoteStream;

        // Send offer to the host
        const offer = await peerConnection.createOffer();
        await peerConnection.setLocalDescription(offer);
        sendSignalingMessage({ type: 'offer', conferenceId, sdp: peerConnection.localDescription });
    } catch (error) {
        console.error('Error joining conference:', error);
    }
}

function sendSignalingMessage(message) {
    // Send the signaling message to the server
    const ws = new WebSocket(signalingServer);
    ws.onopen = () => {
        ws.send(JSON.stringify(message));
        ws.close(); // Close the connection after sending the message
    };
}

function handleIceCandidate(event) {
    if (event.candidate) {
        sendSignalingMessage({ type: 'candidate', candidate: event.candidate });
    }
}

function handleRemoteStream(event) {
    // Add the remote stream to a remote video element
    const remoteVideo = createVideoElement(event.stream, 'Remote User');
    const videoContainer = document.getElementById('videoContainer');
    videoContainer.appendChild(remoteVideo);

    // Set the remote stream as the source for the peer connection
    peerConnection.setRemoteDescription(new RTCSessionDescription({ type: 'offer', sdp: offer }));
}
