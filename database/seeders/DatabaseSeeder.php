<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Donation;
use App\Models\Project;
use File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public $json;
    public $data_all = [];
    public $password;

    public function __construct()
    {
        $this->json = File::get("database/data/data_all.json");
        $da = json_decode($this->json, true);
        $this->data_all = array_reverse($da);
        $this->password = Hash::make('password');
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $initdate = "2024-01-01 09:30:00";
        $unique_email = [];
        $data_users = [];
        $data_kategories = [];
        $data_projects = [];
        $data_comments = [];
        $data_donations = [];
        foreach ($this->data_all as $key => $value) {
            $d = $key + 3;
            $initdate = explode(" ", str_replace(",", "", $value["tgl_mulai"]));
            $tgla = date("Y-m-d H:i:s", strtotime("$initdate[1]-$initdate[0]-$initdate[2] 08:12:43"));
            $tglb = date("Y-m-d H:i:s", strtotime($tgla . " + 5 years"));
            $kat = $value["kategori"]["name"];
            if (!in_array($kat, $data_kategories)) {
                array_push($data_kategories, $value["kategori"]["name"]);
            }
            array_push($data_projects, [
                'judul' => $value['judul'],
                'gambar' => $value['img'],
                'lokasi' => $value['lokasi'],
                'deskripsi' => $value['deskripsi'],
                'target_dana' => (int)$value['target_dana'],
                // 'tgl_mulai' => fake()->dateTimeInInterval('-1 years', '+1 week'),
                // 'tgl_selesai' => fake()->dateTimeInInterval('-1 years', '+1 week'),
                'tgl_mulai' => $tgla,
                'tgl_selesai' => $tglb,
                'kategori' => $value["kategori"]["name"],
            ]);
            if (!isset(($value['komen']))) {
                continue;
            }
            foreach ($value['komen'] as $k => $v) {
                $d2 = $k % 30 + 1;
                // echo "$d2 ";
                $created_at_raw = strtotime($tgla . " + $d2 days");
                $now = strtotime(date("Y-m-d H:i:s"));
                if ($created_at_raw > $now) {
                    $created_at_raw = $now + $d2;
                }
                $created_at = date("Y-m-d H:i:s", $created_at_raw);
                array_push($data_comments, [
                    'user' => $v['email'],
                    'judul' => $value['judul'],
                    'isi_komentar' => $v['isi'],
                    'anonim' => $v['anonim'],
                    'amin' => 0,
                    'created_at' => $created_at
                ]);
                array_push($data_donations, [
                    'user' => $v['email'],
                    'judul' => $value['judul'],
                    'jumlah' => (int)$v['donation'],
                    'anonim' => $v['anonim'],
                    'created_at' => $created_at
                ]);
                if (in_array($v["email"], $unique_email)) {
                    continue;
                }
                array_push($unique_email, $v["email"]);
                array_push($data_users, [
                    'nama' => $v['username'],
                    'email' => $v['email'],
                    'email_verified_at' => now()->toDateTimeString(),
                    'password' => $this->password,
                    'nomor_telepon' => $v['telp'],
                    'alamat' => $v['alamat'],
                    'remember_token' => Str::random(10),
                ]);
            }
        }
        // INSERT DATA
        foreach ($data_users as $k => $v) {
            User::create($v);
        }
        foreach ($data_kategories as $k => $v) {
            Category::create([
                'nama_kategori' => $v,
                'slug' => Str::slug($v)
            ]);
        }
        foreach ($data_projects as $k => $value) {
            $katid = Category::where("nama_kategori", $value["kategori"])->first();
            Project::create([
                'judul' => $value['judul'],
                'slug' => Str::slug($value['judul']),
                'gambar' => $value['gambar'],
                'lokasi' => $value['lokasi'],
                'deskripsi' => $value['deskripsi'],
                'target_dana' => $value['target_dana'],
                'tgl_mulai' => $value['tgl_mulai'],
                'tgl_selesai' => $value['tgl_selesai'],
                'category_id' => $katid["id"]
            ]);
        }
        foreach ($data_comments as $k => $v) {
            $userid = User::where("email", $v["user"])->first();
            $projid = Project::where("slug", Str::slug($v['judul']))->first();
            Comment::create([
                'project_id' => $projid['id'],
                'user_id' => $userid['id'],
                'isi_komentar' => $v['isi_komentar'],
                'anonim' => $v['anonim'],
                'amin' => $v['amin'],
                'created_at' => $v['created_at']
            ]);
        }
        foreach ($data_donations as $k => $v) {
            $userid = User::where("email", $v["user"])->first();
            $projid = Project::where("slug", Str::slug($v['judul']))->first();
            Donation::create([
                'project_id' => $projid['id'],
                'user_id' => $userid['id'],
                'jumlah' => $v['jumlah'],
                'anonim' => $v['anonim'],
                'created_at' => $v['created_at']
            ]);
        }
    }
}
