<?php


namespace App\Console\Commands;



use App\services\StatServiceInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CovidList extends Command
{
    protected $signature = 'covid:list';
    protected $description = 'Показать статистику';

    private $covidStatService;

    public function __construct(StatServiceInterface $statService)
    {
        $this->covidStatService = $statService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stats = $this->covidStatService->list();
        $data = [];
        foreach ($stats as $stat) {
            $data[] = [
                'country' => $stat->country->name,
                'ill' => $stat->ill,
                'death' => $stat->death,
                'good' => $stat->good,
                'updated_at' => date('H:i:s d.m.Y', strtotime($stat->updated_at))
            ];
        }
        $this->table(
            ['Country name', 'Ill', 'Death', 'Good', 'Updated'],
            $data
        );
        return 0;
    }
}
