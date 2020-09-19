<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CollectionImport implements ToCollection, WithHeadingRow
{

    /**
    * @param Collection $collection
    *
    * @return Collection|null
    */
    public function collection(Collection $collection)
    {
        return $collection;
    }
}
