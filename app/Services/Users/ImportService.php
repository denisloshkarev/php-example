<?php


namespace App\Services\Users;


use App\Imports\CollectionImport;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ImportService
{

    protected $type;
    protected $importedCount;

    public function importUsers(array $params)
    {

        $this->importedCount = [
            'imported' => 0,
            'failed' => 0
        ];

        $this->type = $params['type'];

        $sheets = Excel::toCollection(new CollectionImport, $params['file']);

        $sheets->each(function(Collection $sheet) {
            $firstRow = $sheet->first();

            if($firstRow->has('fio')) {
                $sheet->each(function(Collection $row) {
                    if(($user = $this->importUser($row)) !== false) {
                        $this->importedCount['imported']++;
                    }
                    else {
                        $this->importedCount['failed']++;
                    }
                });
            }
        });

        return [
            'counts' => $this->importedCount
        ];
    }

    protected function importUser(Collection $row)
    {

        $user = User::updateOrCreate([
            'id' => $row->get('id')
        ], [
            'name' => $row->get('fio'),
            'phone' => $row->get('telefon'),
            'email' => $row->get('e_mail'),
            'password' => $row->get('parol')
        ]);

        return $user ?? false;

    }

}
