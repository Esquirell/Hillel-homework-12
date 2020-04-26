<?php


namespace App\repositories;


use App\Models\Country;
use App\Models\CovidStat;

interface StatRepositoryInterface
{
    public function getAllCountries();
    public function findCountryByName(string $name);
    public function addNewStat(array $data, Country $country, CovidStat $stat = null);
    public function getStatByCountry(int $id);
    public function findExistCountry(int $id);
    public function statList();
}
