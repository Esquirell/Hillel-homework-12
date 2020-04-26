<?php


namespace App\repositories;



use App\Models\Country;
use App\Models\CovidStat;

class StatRepository implements StatRepositoryInterface
{

    private $modelCountry;
    private $modelCovidStat;

    public function __construct()
    {
        $this->modelCountry = app()->make(Country::class);
        $this->modelCovidStat = app()->make(CovidStat::class);
    }

    public function getAllCountries()
    {
        return $this->modelCountry->all('name')->pluck('name')->toArray();
    }

    public function findCountryByName(string $name)
    {
        return $this->modelCountry->where('name', '=', $name)->first();
    }

    public function getStatByCountry(int $id)
    {
        return $stat = $this->modelCountry->find($id)->stats()->first();
    }


    public function addNewStat(array $data, $country, $stat)
    {
        if($stat == null) {
            $stat = new CovidStat();
        }
        $stat->ill = $data['ill'];
        $stat->death = $data['death'];
        $stat->good = $data['good'];
        $stat->country()->associate($country);
        $stat->save();
    }


    public function findExistCountry(int $id)
    {
        return $this->modelCovidStat->find($id)->country()->first();
    }

    public function statList()
    {
        return $this->modelCovidStat->all();
    }


}
