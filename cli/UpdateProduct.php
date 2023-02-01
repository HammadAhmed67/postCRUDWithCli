<?php 
declare(strict_types=1);


namespace App\cli\UpdateProduct;

use App\src\Storage\Reader;
use App\src\Storage\Writer;
use App\cli\Product\Product;
class UpdateProduct
{
    private $storageReader;
    private $storageWriter;

    public function __construct(Reader $storageReader, Writer $storageWriter)
    {
        $this->storageReader = $storageReader;
        $this->storageWriter = $storageWriter;
    }

    public function update($id,$name): void
    {
     
     
        $this->storageWriter->update($id,$name);
        print("Product updated: " . $id . "\n");
      
        
    }
}
