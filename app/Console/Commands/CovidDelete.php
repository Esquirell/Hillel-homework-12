<?php

namespace App\Console\Commands;




use App\services\StatServiceInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CovidDelete extends Command
{
    protected $signature = 'covid:delete';
    protected $description = 'Удалить статистику';

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
            $this->covidStatService->delete($countryData->id);
            $output->writeln('Data deleted');
        } catch (\InvalidArgumentException $exception) {
            $output->writeln('ERROR ' . $exception->getMessage());
        }
        return 0;
    }
}
