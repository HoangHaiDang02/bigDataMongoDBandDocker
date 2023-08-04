<?php

namespace App\MongoDb\MongoRepositorisService;

use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Code\Throwable;

class InfrastructureService
{
    /**
     * @var string
     */
    public string $table = '';

    /**
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getAllValue(): array
    {
        return DB::table($this->table)->get()->toArray();
    }

    /**
     * @param $values
     * @return void
     */
    public function insertValuesToCollection($values): void
    {
        DB::table($this->table)->insert($values);
    }
}
