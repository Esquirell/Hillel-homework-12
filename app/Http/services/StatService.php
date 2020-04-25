<?php


namespace App\Http\services;


use App\Http\Models\Country;
use App\Http\Models\CovidStat;
use App\Http\repositories\StatRepositoryInterface;

class StatService implements StatServiceInterface
{
    private $statRepository;

    public function __construct(StatRepositoryInterface $statRepository)
    {
        $this->statRepository = $statRepository;
    }

    //Получаем список всех стран для списка
    public function getCountries()
    {
        return $this->statRepository->getAllCountries();
    }

    //добавление или обновление статистики
    public function add(array $data)
    {
        //получение по имени страны
        $country = $this->getCountryByName($data['country_name']);
        if (!$country) {
            throw new \InvalidArgumentException('Country does not exist');
        }

        //проверка, существует ли запись в БД
        $stat = $this->getStatByCountry($country->id);
        if($stat == null) {
            $this->statRepository->addNewStat($data, $country);
        }
        else {
            $this->statRepository->updateStat($data, $country, $stat);
        }
    }

    //удаление
    public function delete(int $id)
    {
        $stat = $this->getStatByCountry($id);
        $stat->delete();
    }

    //вывод статистики
    public function list()
    {
        return CovidStat::all();
    }

    //получение статистики по стране
    public function getStatByCountry(int $id)
    {
        return $this->statRepository->getStatByCountry($id);
    }

    //получение коллекции по имени страны
    public function getCountryByName(string $name)
    {
        return $this->statRepository->findCountryByName($name);
    }

    //получение существующей страны со статистикой
    public function getExistCountry(int $id)
    {
        return $this->statRepository->findExistCountry($id);
    }

}
