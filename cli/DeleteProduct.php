<?php
declare(strict_types=1);

namespace App\cli\DeleteProduct;

use App\src\Storage\Reader;
use App\src\Storage\Writer;
class DeleteProduct
{
    private $storageReader;
    private $storageWriter;

    public function __construct(Reader $storageReader, Writer $storageWriter)
    {
        $this->storageReader = $storageReader;
        $this->storageWriter = $storageWriter;
    }

    public function delete($id): void
    {
     
            $this->storageWriter->delete($id);
            print("Product deleted: " .$id . "\n");
        
        
    }
}
