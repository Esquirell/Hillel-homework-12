<?php


namespace App\Http\services;


interface StatServiceInterface
{
    public function add(array $data);
    public function list();
    public function delete(int $id);

    public function getCountries();

    public function getExistCountry(int $id);

    public function getStatByCountry(int $id);


}
