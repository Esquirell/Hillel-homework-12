<?php


namespace App\services;

use App\Models\CovidStat;
use App\repositories\StatRepositoryInterface;

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
        $this->statRepository->addNewStat($data, $country, $stat);
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
        return $this->statRepository->statList();
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
