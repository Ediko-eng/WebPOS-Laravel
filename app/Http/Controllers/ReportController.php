<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BeliHead;
use App\Models\JualHead;
use FPDF;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ReportController extends Controller
{
    public function rJual(Request $request)
    {
        $tgl1 = $request->query('tgl1', date('Y-m-d'));
        $tgl2 = $request->query('tgl2', date('Y-m-d'));

        $penjualan = JualHead::whereBetween('tgl_jual', [$tgl1, $tgl2])
            ->orderBy('no_jual')
            ->get();

        return view('report.jual', compact('penjualan', 'tgl1', 'tgl2'));
    }

    public function rBeli(Request $request)
    {
        $tgl1 = $request->query('tgl1', date('Y-m-d'));
        $tgl2 = $request->query('tgl2', date('Y-m-d'));

        $pembelian = BeliHead::whereBetween('tgl_beli', [$tgl1, $tgl2])
            ->orderBy('no_beli')
            ->get();

        return view('report.beli', compact('pembelian', 'tgl1', 'tgl2'));
    }

    public function rStock()
    {
        $stocks = Barang::orderBy('id_barang')->get();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Relatoriu Stock Sasan', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Kodigu Sasan', 1, 0, 'C');
        $pdf->Cell(60, 8, 'Naran Sasan', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Total Stock', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Unidade', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($stocks as $s) {
            $pdf->Cell(15, 7, $no++, 1, 0, 'C');
            $pdf->Cell(40, 7, $s->id_barang, 1, 0);
            $pdf->Cell(60, 7, $s->nama_barang, 1, 0);
            $pdf->Cell(35, 7, $s->stock, 1, 0, 'C');
            $pdf->Cell(40, 7, $s->satuan, 1, 1, 'C');
        }

        $content = $pdf->Output('S', 'relatoriu-stock.pdf');

        return response($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="relatoriu-stock.pdf"',
        ]);
    }

    public function rBarcode(Request $request)
    {
        $jmlCetak = (int) $request->query('jmlCetak', 1);
        $barcode = $request->query('barcode', '');

        $generator = new BarcodeGeneratorPNG();
        $barcodes = [];

        for ($i = 0; $i < $jmlCetak; $i++) {
            try {
                $barcodes[] = base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128));
            } catch (\Exception $e) {
                $barcodes[] = '';
            }
        }

        return view('report.barcode', compact('barcodes', 'barcode', 'jmlCetak'));
    }
}
