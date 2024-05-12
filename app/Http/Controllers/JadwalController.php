<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Posisi;
use App\Models\Scheduler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
 
    public function index()
    {
        $data['page_title'] = 'Jadwal';
        $data['breadcumb'] = 'Jadwal';
        $data['jadwal'] = Scheduler::orderBy('id','asc')->get();
        if (Auth::user()->type == 2) {
            $sisa1 = Scheduler::where('id_karyawan',Auth::user()->id)->where('off_1',null)->first();
            $sisa2 = Scheduler::where('id_karyawan',Auth::user()->id)->where('off_2',null)->first();
            $data['sisa'] = ($sisa1 != null ? 1 : 0) + ($sisa2 != null ? 1 : 0);

        }

        $data['karyawan'] = User::where('type','2')->whereNotIn('id',[Auth::user()->id])->get();
        // dd($data);
        return view('jadwal.index', $data);
    }

    public function generateAlgortma(){
        // Implementasi GeneticAlgorithmScheduler
        $scheduler = new GeneticAlgorithmScheduler();
        $bestSchedule = $scheduler->schedule();
        
        $jadwal = Scheduler::orderBy('id','asc')->get();

        if (count($jadwal) > 0 ) {
            foreach ($jadwal as $value) {
                $delete = Scheduler::find($value->id);
                $delete->delete();
            }

            foreach ($bestSchedule['schedule'] as $karyawan => $weekSchedule) {
                $idKaryawan = User::where('name', $karyawan)->value('id');
                $posisi_w1 = $weekSchedule[1];
                $posisi_w2 = $weekSchedule[2];
                $posisi_w3 = $weekSchedule[3];
                $posisi_w4 = $weekSchedule[4];
                
                $schedulerData = [
                    'id_karyawan' => $idKaryawan,
                    'posisi_w1' => $posisi_w1,
                    'posisi_w2' => $posisi_w2,
                    'posisi_w3' => $posisi_w3,
                    'posisi_w4' => $posisi_w4,
                    'off_1' => null,
                    'off_2' => null,
                    'id_karyawan_change_off_1' => null,
                    'id_karyawan_change_off_2' => null,
                ];
    
                Scheduler::create($schedulerData);
            }

        }else{
            foreach ($bestSchedule['schedule'] as $karyawan => $weekSchedule) {
                $idKaryawan = User::where('name', $karyawan)->value('id');
                $posisi_w1 = $weekSchedule[1];
                $posisi_w2 = $weekSchedule[2];
                $posisi_w3 = $weekSchedule[3];
                $posisi_w4 = $weekSchedule[4];
                
                $schedulerData = [
                    'id_karyawan' => $idKaryawan,
                    'posisi_w1' => $posisi_w1,
                    'posisi_w2' => $posisi_w2,
                    'posisi_w3' => $posisi_w3,
                    'posisi_w4' => $posisi_w4,
                    'off_1' => null,
                    'off_2' => null,
                    'id_karyawan_change_off_1' => null,
                    'id_karyawan_change_off_2' => null,
                ];
    
                Scheduler::create($schedulerData);
            }

        }

        return redirect()->back()->with(['success' => 'Generate Jadwal successfully!']);

    }

    public function getPosisionWeek(Request $request){
        $id_karyawan = $request->id_karyawan;
        $week = $request->week;
        $jadwal = Scheduler::where('id_karyawan',$id_karyawan)->first();
        if ($week == 1) {
            $posisi = $jadwal->posisi_w1;
        }elseif ($week == 2) {
            $posisi = $jadwal->posisi_w2;
        }elseif ($week == 3) {
            $posisi = $jadwal->posisi_w3;
        }elseif ($week == 4) {
            $posisi = $jadwal->posisi_w4;
        }
        if ($jadwal != null) {
            return response()->json([
                'msg' => 'berhasil',
                'posisi' => $posisi,
            ]);
        }else{
            return response()->json([
                'msg' => 'gagal',
            ]);
        }
    }
    public function getKaryawanByPosisi(Request $request){
        $id_karyawan = $request->id_karyawan;
        $week = $request->week;
        $posisi = $request->posisi;
        $getIdKaryawan = Scheduler::where('id','!=',$id_karyawan)->where('posisi_w'.$week,'!=',$posisi)->get()->pluck('id_karyawan');

        $karyawan = User::whereIn('id', $getIdKaryawan)->pluck('id','name');

        if ($karyawan != []) {
            return response()->json([
                'msg' => 'berhasil',
                'karyawan' => $karyawan,
            ]);
        }else{
            return response()->json([
                'msg' => 'gagal',
            ]);
        }

    }

    public function listRequestOff(Request $request){

        $data['page_title'] = 'Request Off Karyawan';
        $data['breadcumb'] = 'Request Off Karyawan';

        if (Auth::user()->type == 2) {
            $karyawan1 = Scheduler::where('off_1','pending')->where('id_karyawan',Auth::user()->id)->get();
            $karyawan2 = Scheduler::where('off_2','pending')->where('id_karyawan',Auth::user()->id)->get();
        } else {
            $karyawan1 = Scheduler::where('off_1','pending')->get();
            $karyawan2 = Scheduler::where('off_2','pending')->get();
        }
        

        $data['karyawan'] = $karyawan1->merge($karyawan2);
        return view('jadwal.request-off', $data);

    }

    public function requestOfF(Request $request){

        try {
            $id_karyawan = Auth::user()->id;
            $week = $request->week;
            $posisi = $request->posisi;
            $karyawan_pengganti = $request->karyawan_pengganti;
    
            $getDataKaryawan = Scheduler::where('id_karyawan',$id_karyawan)->first();
            if($getDataKaryawan->off_1 == ''  || $getDataKaryawan->off_1 == 'Pending'){
                $getDataKaryawan->off_1 = 'Pending';
                $getDataKaryawan->posisi_before_off_1 = $week.'_'.$posisi;
                $getDataKaryawan->id_karyawan_change_off_1 = $karyawan_pengganti;
                $getDataKaryawan->status_off_1 = 1;
            }elseif ($getDataKaryawan->off_2 == '' || $getDataKaryawan->off_2 == 'Pending'){
                $getDataKaryawan->off_2 = 'Pending';
                $getDataKaryawan->posisi_before_off_2 = $week.'_'.$posisi;
                $getDataKaryawan->id_karyawan_change_off_2 = $karyawan_pengganti;
                $getDataKaryawan->status_off_2 = 1;
            }
            $getDataKaryawan->save();
    
            return redirect()->back()->with(['success' => 'Request Off Successfully!']);
        } catch (\Throwable $th) {
            return redirect()->back();
        }

    }

    public function approveOff($id,$week,$posisi){
        $DataKaryawan = Scheduler::find($id);
        $sisa1 = Scheduler::where('id_karyawan',$DataKaryawan->id_karyawan)->where('off_1','Pending')->first();

        if ($sisa1 != null) {
            $DataKaryawan->off_1 = 'Approve';
            if ($week == 1) {
                $DataKaryawan->posisi_w1 = null;
            }elseif ($week == 2) {
                $DataKaryawan->posisi_w2 = null;
            }elseif ($week == 3) {
                $DataKaryawan->posisi_w3 = null;
            }elseif ($week == 4) {
                $DataKaryawan->posisi_w4 = null;
            }
            $DataKaryawan->save();

            // BERIKAN KE KARYAWAN PENGGANTI 
            $DataKaryawanPengganti = Scheduler::where('id_karyawan',$DataKaryawan->id_karyawan_change_off_1)->first();
            if ($week == 1) {
                $getPosisi = $DataKaryawanPengganti->posisi_w1;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w1 = $final_posisi;
            }elseif ($week == 2) {
                $getPosisi = $DataKaryawanPengganti->posisi_w2;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w2 = $final_posisi;
            }elseif ($week == 3) {
                $getPosisi = $DataKaryawanPengganti->posisi_w3;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w3 = $final_posisi;
            }elseif ($week == 4) {
                $getPosisi = $DataKaryawanPengganti->posisi_w4;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w4 = $final_posisi;
            }
            $DataKaryawanPengganti->save();
            return redirect()->back()->with(['success' => 'Approve Successfully!']);

        }else{
            $DataKaryawan = Scheduler::find($id);
            $DataKaryawan->off_2 = 'Approve';
            if ($week == 1) {
                $DataKaryawan->posisi_w1 = null;
            }elseif ($week == 2) {
                $DataKaryawan->posisi_w2 = null;
            }elseif ($week == 3) {
                $DataKaryawan->posisi_w3 = null;
            }elseif ($week == 4) {
                $DataKaryawan->posisi_w4 = null;
            }
            $DataKaryawan->save();

            // BERIKAN KE KARYAWAN PENGGANTI 
            $DataKaryawanPengganti = Scheduler::where('id_karyawan',$DataKaryawan->id_karyawan_change_off_2)->first();
            if ($week == 1) {
                $getPosisi = $DataKaryawanPengganti->posisi_w1;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w1 = $final_posisi;
            }elseif ($week == 2) {
                $getPosisi = $DataKaryawanPengganti->posisi_w2;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w2 = $final_posisi;
            }elseif ($week == 3) {
                $getPosisi = $DataKaryawanPengganti->posisi_w3;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w3 = $final_posisi;
            }elseif ($week == 4) {
                $getPosisi = $DataKaryawanPengganti->posisi_w4;
                $final_posisi = $getPosisi.'_'. $posisi;
                $DataKaryawanPengganti->posisi_w4 = $final_posisi;
            }
            $DataKaryawanPengganti->save();
            return redirect()->back()->with(['success' => 'Approve Successfully!']);

        }

    }

    public function notApproveOff($id,$week,$posisi){
        $DataKaryawan = Scheduler::find($id);
        $sisa1 = Scheduler::where('id_karyawan',$DataKaryawan->id_karyawan)->where('off_1','Pending')->first();

        if ($sisa1 != null) {
            $DataKaryawan->off_1 = null;
            $DataKaryawan->id_karyawan_change_off_1 = null;
            $DataKaryawan->status_off_1 = null;
            $DataKaryawan->posisi_before_off_1 = null;
            $DataKaryawan->save();

            return redirect()->back()->with(['success' => 'Not Approve Successfully!']);

        }else{
            $DataKaryawan = Scheduler::find($id);
            $DataKaryawan->off_2 = null;
            $DataKaryawan->id_karyawan_change_off_2 = null;
            $DataKaryawan->status_off_2 = null;
            $DataKaryawan->posisi_before_off_2 = null;
            $DataKaryawan->save();

           
            return redirect()->back()->with(['success' => 'Not Approve Successfully!']);

        }

    }

}

class GeneticAlgorithmScheduler
{
    public function __construct()
    {
        $this->data['posisi'] = Posisi::get()->pluck('id', 'posisi');
        $this->data['user'] = User::where('type', '2')->get()->pluck('id_posisi', 'name');
    }

    private $populationSize = 50;
    private $generations = 100;

    public function schedule()
    {
        $population = $this->initializePopulation();

        for ($gen = 0; $gen < $this->generations; $gen++) {
            $this->evaluateFitness($population);
            $parents = $this->selectParents($population);
            $children = $this->crossoverAndMutate($parents);
            $population = $children;
        }

        return $this->getBestSchedule($population);
    }

    private function initializePopulation()
    {
        $population = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $schedule = [];
            foreach ($this->data['user'] as $karyawan => $posisi) {
                $weekSchedule = [];
                for ($week = 1; $week <= 4; $week++) {
                    $availablePositions = ['X', 'Y', 'Z'];
                    $randomPosition = array_rand($availablePositions);
                    $weekSchedule[$week] = $availablePositions[$randomPosition];
                }
                $schedule[$karyawan] = $weekSchedule;
            }
            $population[] = [
                'schedule' => $schedule,
                'fitness' => 0, // Tambahkan fitness dengan nilai awal 0 ke setiap individu dalam populasi
            ];
        }
        return $population;
    }

private function evaluateFitness(&$population)
{
    foreach ($population as &$schedule) {
        $fitness = 0;
        foreach ($schedule['schedule'] as $karyawan => $weekSchedule) {
            foreach ($weekSchedule as $week => $position) {
                $fitness += $this->data['posisi'][$position];
            }
        }
        $schedule['fitness'] = $fitness;
    }
}

    private function selectParents($population)
    {
        // Metode seleksi turnamen
        $parents = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $tournamentSize = 5;
            $tournamentParticipants = array_rand($population, $tournamentSize);
            $bestParticipant = null;
            foreach ($tournamentParticipants as $participantIndex) {
                $participant = $population[$participantIndex];
                if ($bestParticipant === null || $participant['fitness'] > $population[$bestParticipant]['fitness']) {
                    $bestParticipant = $participantIndex;
                }
            }
            $parents[] = $population[$bestParticipant];
        }
        return $parents;
    }

    private function crossoverAndMutate($parents)
    {
        // One-point crossover dan bitwise mutation
        $children = [];
        for ($i = 0; $i < $this->populationSize; $i += 2) {
            $parent1 = $parents[$i];
            $parent2 = $parents[$i + 1];
            $crossoverPoint = rand(1, count($this->data['user']));
            $child1 = [];
            $child2 = [];

            $j = 0;
            foreach ($this->data['user'] as $karyawan => $posisi) {
                $weekSchedule1 = $parent1['schedule'][$karyawan];
                $weekSchedule2 = $parent2['schedule'][$karyawan];
                $child1[$karyawan] = [];
                $child2[$karyawan] = [];
                for ($week = 1; $week <= 4; $week++) {
                    $position1 = $weekSchedule1[$week];
                    $position2 = $weekSchedule2[$week];
                    if ($j < $crossoverPoint) {
                        $child1[$karyawan][$week] = $position1;
                        $child2[$karyawan][$week] = $position2;
                    } else {
                        $child1[$karyawan][$week] = $position2;
                        $child2[$karyawan][$week] = $position1;
                    }
                    $j++;
                }
            }
            
            // Tambahkan kunci 'fitness' dengan nilai awal 0 ke setiap anak
            $children[] = [
                'schedule' => $child1,
                'fitness' => 0,
            ];
            $children[] = [
                'schedule' => $child2,
                'fitness' => 0,
            ];
        }
        return $children;
    }





    private function getBestSchedule($population)
    {
        usort($population, function ($a, $b) {
            return $b['fitness'] - $a['fitness'];
        });
        return $population[0];
    }
}

