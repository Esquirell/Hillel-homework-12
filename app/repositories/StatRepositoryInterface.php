<?php


namespace App\repositories;


interface StatRepositoryInterface
{
    public function getAllCountries();
    public function findCountryByName(string $name);
    public function addNewStat(array $data, $country, $stat);
    public function getStatByCountry(int $id);
    public function findExistCountry(int $id);
    public function statList();
}
