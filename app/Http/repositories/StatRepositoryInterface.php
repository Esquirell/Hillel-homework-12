<?php


namespace App\Http\repositories;


interface StatRepositoryInterface
{
    public function getAllCountries();
    public function findCountryByName(string $name);
    public function addNewStat(array $data, $country);
    public function updateStat(array $data, $country, $stat);
    public function getStatByCountry(int $id);
    public function findExistCountry(int $id);
}
