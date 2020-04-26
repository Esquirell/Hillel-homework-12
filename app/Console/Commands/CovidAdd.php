<?php


namespace App\Console\Commands;


use App\services\StatServiceInterface;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CovidAdd extends Command
{
    protected $signature = 'covid:add {ill} {death} {good}';
    protected $description = 'Добавить или обновить статистику';

    private $covidStatService;

    public function __construct(StatServiceInterface $statService)
    {
        $this->covidStatService = $statService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Получаем список стран
        $countriesList = $this->covidStatService->getCountries();
        $country = $this->choice('Country name', $countriesList);
        //Записываем данные
        $ill = $input->getArgument('ill');
        $death = $input->getArgument('death');
        $good = $input->getArgument('good');
        //Записываем данные
        $data = compact('ill', 'death', 'good');
        $data['country_name'] = $country;
        try {
            $this->covidStatService->add($data);
            $output->writeln('Data saved');
        } catch (\InvalidArgumentException $exception) {
            $output->writeln('ERROR ' . $exception->getMessage());
        }
        return 0;
    }

}
