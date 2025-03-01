<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GenericExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $columns;
    protected $columnFormats;

    protected $formatters = [
        'date' => [self::class, 'formatDate'],
        'uppercase' => [self::class, 'formatUppercase'],
    ];

    public function __construct($data, $columns, $columnFormats = [])
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->columnFormats = $columnFormats;
    }

    public function formatDate($value)
    {
        return $value instanceof \Carbon\Carbon ? $value->format('Y-m-d') : $value;
    }

    public function formatUppercase($value)
    {
        return strtoupper($value);
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return collect($this->columns)->mapWithKeys(function ($column) use ($item) {
                $value = $item->$column;
                if (isset($this->columnFormats[$column]) && isset($this->formatters[$this->columnFormats[$column]])) {
                    $value = call_user_func($this->formatters[$this->columnFormats[$column]], $value);
                }
                return [$column => $value];
            })->all();
        });
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
