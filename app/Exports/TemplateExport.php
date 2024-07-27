<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateExport implements WithHeadings
{
    protected $headings;

    public function __construct(array $headings)
    {
        $this->headings = $headings;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
