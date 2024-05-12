<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Posisi;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Jadwal';
        $data['breadcumb'] = 'Jadwal';
        // Implementasi GeneticAlgorithmScheduler
        $scheduler = new GeneticAlgorithmScheduler();
        $bestSchedule = $scheduler->schedule();
        dd($bestSchedule);

        $data['jadwal'] = $bestSchedule;
        return view('jadwal.index', $data);
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
                $position = $this->getPositionFromCode($posisi);
                $weekSchedule = [];
                for ($week = 1; $week <= 4; $week++) {
                    $weekSchedule[$week] = $position;
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
        $selectedKaryawans = $this->selectRandomKaryawans();
        
        for ($i = 0; $i < $this->populationSize; $i += 2) {
            $parent1 = $parents[$i];
            $parent2 = $parents[$i + 1];
            
            $child1 = [];
            $child2 = [];
            
            foreach ($this->data['user'] as $karyawan => $posisi) {
                $child1[$karyawan] = [];
                $child2[$karyawan] = [];
                
                $weekSchedule1 = $parent1['schedule'][$karyawan];
                $weekSchedule2 = $parent2['schedule'][$karyawan];
                
                for ($week = 1; $week <= 4; $week++) {
                    $position1 = $weekSchedule1[$week];
                    $position2 = $weekSchedule2[$week];
                    
                    if (in_array($karyawan, $selectedKaryawans)) {
                        // Lakukan crossover pada posisi karyawan
                        if (rand(0, 1) === 0) {
                            $child1[$karyawan][$week] = $position1;
                            $child2[$karyawan][$week] = $position2;
                        } else {
                            $child1[$karyawan][$week] = $position2;
                            $child2[$karyawan][$week] = $position1;
                        }
                    } else {
                        // Pindahkan jadwal dari parent tanpa modifikasi karena karyawan tidak dipilih
                        $child1[$karyawan][$week] = $position1;
                        $child2[$karyawan][$week] = $position2;
                    }
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

    private function selectRandomKaryawans()
    {
        $userKeys = $this->data['user']->keys()->toArray();
        shuffle($userKeys);
        return array_slice($userKeys, 0, 13);
    }
  
    private function getPositionFromCode($code)
    {
        $posisi = Posisi::where('id', $code)->value('posisi');
        return $posisi ?? 'X'; // Mengembalikan 'X' jika posisi tidak ditemukan
    }

    private function getBestSchedule($population)
    {
        usort($population, function ($a, $b) {
            return $b['fitness'] - $a['fitness'];
        });
        return $population[0];
    }
}
