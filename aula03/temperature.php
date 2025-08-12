<?php
class ConvertorTemperatura{
    public static function celsiusToFahrenheit($celsius){
        return ($celsius * 9/5) + 32;
    }

    public static function fahrenheitToCelsius($fahrenheit){
        return ($fahrenheit - 32) * 5/9;
    }
}
echo "25°C em Fahrenheit: " . ConvertorTemperatura::celsiusToFahrenheit(25) . "°F<br>";
echo "77°F em Celsius: " . ConvertorTemperatura::fahrenheitToCelsius(77) . "°C";

?>