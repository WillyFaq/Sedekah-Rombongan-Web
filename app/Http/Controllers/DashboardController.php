<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            "sumcards" => $this->gensumcard(),
            "chart_donation" => $this->genchartdonation()
        ];
        return view('dashboard', $data);
    }
    //
    private function gensumcard()
    {
        $jml_user = User::where("status", ">", "0")->count();
        $project = Project::with(["donations"])->where("status", ">", "0");
        $jml_project = $project->count();
        $donasi_terkumpul = Donation::where('status', '>', '0')->sum('jumlah');
        // dd($project->donations);
        // $donasi_terkumpul = $project->donations->sum('jumlah');
        // dd($donasi_terkumpul);
        // $donasi_terkumpul = $project->donations->sum('jumlah');
        $kebutuhan_dana = $project->sum('target_dana');
        $project_done = DB::table('projects')
            ->select('projects.target_dana', DB::raw("SUM(donations.jumlah) as jumlah"))
            ->join('donations', 'projects.id', '=', 'donations.project_id')
            ->groupBy('donations.project_id')
            ->havingRaw("SUM(donations.jumlah) >= projects.target_dana")->count();
        $data_sumcard = [
            [
                "title" => "Jumlah Proyek Terpenuhi",
                "color" => "primary",
                "value" => number_format($project_done) . " / " . number_format($jml_project),
                "icon" => "fas fa-calendar"
            ],
            [
                "title" => "Donasi Terkumpul",
                "color" => "success",
                "value" => "Rp. " . number_format($donasi_terkumpul),
                "icon" => "fas fa-donate"
            ],
            [
                "title" => "Kebutuhan Dana",
                "color" => "danger",
                "value" => "Rp. " . number_format($kebutuhan_dana),
                "icon" => "fas fa-search-dollar"
            ],
            [
                "title" => "Jumlah Pengguna",
                "color" => "warning",
                "value" => number_format($jml_user),
                "icon" => "fas fa-users"
            ],
        ];
        return $data_sumcard;
    }

    private function genchartdonation()
    {
        $donations = Donation::selectRaw('SUM(jumlah) as jumlah, created_at')
            ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
            ->where('status', '>', '0')
            ->oldest()
            ->get();
        // dd($donations);
        $jml = [];
        $bln = [];
        foreach ($donations as $donation) {
            array_push($bln, date("M y", strtotime($donation->created_at)));
            array_push($jml, $donation->jumlah);
        }
        return ["label" => "'" . join("','", $bln) . "'", "data" => join(",", $jml)];
        // return ["label" => $bln, "data" => join(",", $jml)];
    }
}
