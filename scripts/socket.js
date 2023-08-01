const socket = new WebSocket('ws://localhost:3060');

socket.onopen = () => {
    console.log('WebSocket connection established.');
};