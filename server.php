<?php
// server.php

require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\WsServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $conferences = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "WebSocket server started." . PHP_EOL;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "New connection: {$conn->resourceId}" . PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg) {
      $data = json_decode($msg, true);
      
      switch ($data['type']) {
          case 'startConference':
              $this->startConference($from, $data['username']);
              break;
          case 'joinConference':
              $this->joinConference($from, $data['conferenceId'], $data['username']);
              break;
          // Handle other message types as needed
      }
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
        echo "Message from {$from->resourceId}: {$msg}" . PHP_EOL;
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "Connection closed: {$conn->resourceId}" . PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error occurred: {$e->getMessage()}" . PHP_EOL;
        $conn->close();
    }

    protected function startConference(ConnectionInterface $host, $hostUsername) {
        $conferenceId = uniqid(); // Generate a unique conference ID

        // Store the conference details
        $this->conferences[$conferenceId] = [
            'host' => $host,
            'hostUsername' => $hostUsername,
            'participants' => [],
        ];

        $host->send(json_encode([
            'type' => 'conferenceStarted',
            'conferenceId' => $conferenceId,
        ]));
    }

    protected function joinConference(ConnectionInterface $participant, $conferenceId, $participantUsername) {
        if (isset($this->conferences[$conferenceId])) {
            $this->conferences[$conferenceId]['participants'][] = $participant;

            $participant->send(json_encode([
                'type' => 'conferenceJoined',
                'conferenceId' => $conferenceId,
            ]));

            // Notify the host about the new participant
            $host = $this->conferences[$conferenceId]['host'];
            $host->send(json_encode([
                'type' => 'participantJoined',
                'participantUsername' => $participantUsername,
            ]));
        }
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    3060
);

echo "WebSocket server listening on port 3060." . PHP_EOL;
$server->run();
?>
