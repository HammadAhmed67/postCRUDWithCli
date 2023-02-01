<?php declare(strict_types=1);

namespace App\cli\EventProcessor;
use App\src\Storage\Reader;
use App\src\Storage\Writer;
use App\cli\EventQueue\EventQueue;

class EventProcessor
{
     private const EVENT_PRODUCT_CREATED = 'product_created';
    private const EVENT_PRODUCT_UPDATED = 'product_updated';
    private const EVENT_PRODUCT_DELETED = 'product_deleted';

    private $eventQueue;
    private $reader;
    private $writer;

    public function __construct(EventQueue $eventQueue, Reader $reader, Writer $writer)
    {
        $this->eventQueue = $eventQueue;
        $this->reader = $reader;
        $this->writer = $writer;
    }

    public function processEvents() : void
    {
        while (($event = $this->eventQueue->popEvent()) !== null) {
            switch ($event['type']) {
                case self::EVENT_PRODUCT_CREATED:
                    $this->processProductCreated($event);
                    break;
                case self::EVENT_PRODUCT_UPDATED:
                    $this->processProductUpdated($event);
                    break;
                case self::EVENT_PRODUCT_DELETED:
                    $this->processProductDeleted($event);
                    break;
                default:
                    throw new \RuntimeException('Unknown event type: ' . $event['type']);
            }
        }
    }

    private function processProductCreated( $event) : void
    {
        $productId = $event->getProductId();
        $productData = $event->getData();
        
        $this->writer->create($productId, $productData);
    }

    private function processProductUpdated( $event) : void
    {
        $productId = $event->getProductId();
        $productData = $event->getData();

        $this->writer->update($productId, $productData);
    }

    private function processProductDeleted( $event) : void
    {
        $productId = $event->getProductId();

        $this->writer->delete($productId);
    }
}
