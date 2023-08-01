
const socket = new WebSocket('ws://localhost:3060');

socket.onopen = () => {
    console.log('WebSocket connection established.');
};

socket.onmessage = (event) => {
    const message = JSON.parse(event.data);
    const chatBox = document.getElementById('chatBox');
    const messageElement = document.createElement('div');
    messageElement.textContent = message.text;
    chatBox.appendChild(messageElement);
};

socket.onclose = (event) => {
    console.log(`WebSocket connection closed with code ${event.code}.`);
};

const sendMessage = () => {
    const input = document.getElementById('messageInput');
    const message = input.value;
    if (message.trim() !== '') {
        const messageObject = {
            type: 'chat',
            text: message,
        };
        socket.send(JSON.stringify(messageObject));
        input.value = '';
    }
};

document.getElementById('sendButton').addEventListener('click', sendMessage);
document.getElementById('messageInput').addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        sendMessage();
    }
});
