<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements FromArray, WithHeadings
{
    protected $data;
    protected $headings;

    public function __construct(array $data, array $headings = [])
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        if (!empty($this->headings)) {
            // Use provided headings if available
            return $this->headings;
        }

        if (!empty($this->data)) {
            // Extract headings from the keys of the first row of data if no headings are provided
            return array_keys($this->data[0]);
        }

        return [];
    }
}
