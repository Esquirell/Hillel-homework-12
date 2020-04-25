<?php


namespace App\Console\Commands;


use App\Http\services\StatServiceInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CovidGetByCountry extends Command
{
    protected $signature = 'covid:get';
    protected $description = 'Получить статистику страны';

    private $covidStatService;

    public function __construct(StatServiceInterface $statService)
    {
        $this->covidStatService = $statService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $stats = $this->covidStatService->list();
            $countryList = [];
            foreach ($stats as $stat) {
                $countryCollection = $this->covidStatService->getExistCountry($stat->id);
                $countryList [] = $countryCollection->name;
            }
            $country = $this->choice('Country name', $countryList);
            $countryData = $this->covidStatService->getCountryByName($country);
            $stat = $this->covidStatService->getStatByCountry($countryData->id);
            $data [] = [
                'country' => $stat->country->name,
                'ill' => $stat->ill,
                'death' => $stat->death,
                'good' => $stat->good,
                'updated_at' => date('H:i:s d.m.Y', strtotime($stat->updated_at))
            ];
            $this->table(
                ['Country name', 'Ill', 'Death', 'Good', 'Updated'],
                $data
            );
        } catch (\InvalidArgumentException $exception) {
            $output->writeln('ERROR ' . $exception->getMessage());
        }
        return 0;
    }
}
