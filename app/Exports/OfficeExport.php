<?php

namespace App\Exports;

use App\Models\Master\Office;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OfficeExport implements FromView, WithProperties, WithEvents, WithColumnFormatting, ShouldAutoSize
{
    use Exportable, RegistersEventListeners;

    public function properties(): array
    {
        return [
            'creator'        => 'IDFACE',
            'lastModifiedBy' => 'IDFACE',
            'title'          => 'User Export',
            'description'    => 'User Export',
            'subject'        => 'User Export',
            'keywords'       => 'user,idface,data',
            'category'       => 'Data',
            'manager'        => 'IDFACE',
            'company'        => 'IDFACE',
        ];
    }

    public function view(): View
    {
        return view('excel.office', [
            'data' => Office::all()
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        $headerRange = "A1:F1";
        $event->sheet->getDelegate()->getStyle($headerRange)->getFont()->getColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $event->sheet->getDelegate()->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('00267c');
        $event->sheet->setAutoFilter($headerRange);

    }
}
