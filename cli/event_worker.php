<?php declare(strict_types=1);

namespace App\cli\product_manager;


#!/usr/bin/env php
require_once __DIR__ . '/../src/Storage/Reader.php';
require_once __DIR__ . '/../src/Storage/Writer.php';
require_once __DIR__ . '/EventQueue.php';
require_once __DIR__ . '/EventProcessor.php';
require_once __DIR__ . '/CreateProduct.php';
require_once __DIR__ . '/UpdateProduct.php';
require_once __DIR__ . '/DeleteProduct.php';

require __DIR__ . '/../vendor/autoload.php';

use App\src\Storage\Reader;
use App\cli\EventQueue\EventQueue;
use App\cli\EventProcessor\EventProcessor;
use App\cli\CreateProduct\CreateProduct;
use App\cli\UpdateProduct\UpdateProduct;
use App\cli\DeleteProduct\DeleteProduct;
use App\src\Storage\Writer;


$reader = new Reader();
$writer = new Writer();
$eventQueue = new EventQueue();
$eventProcessor = new EventProcessor($eventQueue,$reader, $writer);

$createProduct = new CreateProduct($writer);
$updateProduct = new UpdateProduct($reader, $writer);
$deleteProduct = new DeleteProduct($reader, $writer);

while (true) {
    echo 'Enter Command: ';

    $input = trim(fgets(STDIN));
    $input = explode(' ', $input);
    $command = $input[0];
    $parameters = array_slice($input, 1);

    switch ($command) {
        case 'create':
            $productId = $parameters[0];
            $productName = $parameters[1];

            $createProduct->create($productId, $productName);
            break;
        case 'update':
            $productId = $parameters[0];
            $productName = $parameters[1];

            $updateProduct->update($productId, $productName);
            break;
        case 'delete':
            $productId = $parameters[0];

            $deleteProduct->delete($productId);
            break;
        case 'process':
            $eventProcessor->processEvents();
            break;
        case 'exit':
            echo "Exiting...\n";
            exit(0);
        default:
            echo "Invalid command.\n";
            break;
    }
}
