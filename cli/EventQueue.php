<?php declare(strict_types=1);


namespace App\cli\EventQueue;

class EventQueue
{
    private const QUEUE_FILE = __DIR__ . 'event_queue.json';

    private $events;

    public function __construct()
    {
        $this->loadEvents();
    }

    public function pushEvent(array $event) : void
    {
        $this->events[] = $event;
        $this->saveEvents();
    }

    public function popEvent() : array
    {
        if (empty($this->events)) {
            throw new \RuntimeException('No events in queue');
        }

        $event = array_shift($this->events);
        $this->saveEvents();

        return $event;
    }

    private function loadEvents() : void
    {
        if (file_exists(self::QUEUE_FILE) === false) {
            $this->events = [];
            return;
        }

        $data = file_get_contents(self::QUEUE_FILE);
        if ($data === false) {
            throw new \RuntimeException('Failed to load events from queue');
        }

        $this->events = json_decode($data, true);
    }

    private function saveEvents() : void
    {
        $data = json_encode($this->events);
        file_put_contents(self::QUEUE_FILE, $data);
    }
}
