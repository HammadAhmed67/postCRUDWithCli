<?php

//declare(strict_types=1);

namespace App\cli\CreateProduct;
use App\cli\Product\Product;
use App\src\Storage\Writer;

class CreateProduct
{
    private $storageWriter;

    public function __construct(Writer $storageWriter)
    {
        $this->storageWriter = $storageWriter;
    }

    public function create($id,$name): void
    {
        $this->storageWriter->create($id,$name);
        print("Product created: " .$id . " " . $name . "\n");
    }
}

