<?php 

namespace utilities\Weather\interfaces;

interface WeatherInterface{

    public function getCurrentTemperature(string $city):string;

}