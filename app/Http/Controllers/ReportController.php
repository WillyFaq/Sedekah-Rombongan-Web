<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "page_title" => "Proyek Donasi",
        ];

        if ($request->ajax()) {
            $tgl_start = $request->tgl_start;
            $tgl_end = $request->tgl_end;
            // return ["OKED", $tgl_start, $tgl_end, $request];
            return $this->get_data($tgl_start, $tgl_end);
        }
        return view("report.index", $data);
    }

    public function get_data($tgl_start, $tgl_end)
    {
        $data_raw = Project::with("donations")
            ->orderBy('tgl_mulai', 'desc')
            ->whereBetween("tgl_mulai", [$tgl_start, $tgl_end])
            ->where("status", ">", "0")
            ->get();
        $data = [];
        $jml_donasi = 0;
        $jml_donatur = 0;
        foreach ($data_raw as $row) {
            $donasi = $row->donations->sum("jumlah");
            $donatur = $row->donations->count();
            $jml_donasi += $donasi;
            $jml_donatur += $donatur;
            $tmp = [
                "id" => $row["id"],
                "judul" => $row["judul"],
                "lokasi" => $row["lokasi"],
                "tgl_mulai" => date('d M Y', strtotime($row["tgl_mulai"])),
                "donasi" => number_format($donasi),
                "donatur" => number_format($donatur),
            ];
            array_push($data, $tmp);
        }
        return ["data" => $data, "total_donasi" => number_format($jml_donasi), "total_donatur" => number_format($jml_donatur)];
    }

    public function pdf(Request $request)
    {
        $tgl_start = $request->tgl_start;
        $tgl_end = $request->tgl_end;
        $data = [
            "page_title" => "Detail Donasi",
            "tgl_start" => $tgl_start,
            "tgl_end" => $tgl_end,
            "report" => Project::with("donations")
                ->orderBy('tgl_mulai', 'desc')
                ->whereBetween("tgl_mulai", [$tgl_start, $tgl_end])
                ->where("status", ">", "0")
                ->get()
        ];
        $pdf = Pdf::loadView('report.pdf', $data)->setPaper('a4', 'landscape');;
        return $pdf->stream('SedekahRombongan_Laporan_' . $tgl_start . '_' . $tgl_end);
        // return $pdf->download('invoice.pdf');
        // return view("report.pdf", $data);
    }
}
