<?php

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;
use App\Models\FeesInfo;


class CountryAndCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $it = new Country();
        $it->country_name = "Italia";
        $it->language_name = "Italiano";
        $it->iso_code = "IT";
        $it->phone_prefix = "+39";
        $it->save();

        $city = new City();
        $city->city_name = "Roma";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Milano";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Napoli";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Torino";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Palermo";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Genova";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Bologna";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Firenze";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Bari";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Catania";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Venezia";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Verona";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Messina";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Padova";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Trieste";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Taranto";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Parma";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Brescia";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Prato";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Modena";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Reggio Calabria";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Reggio nell'Emilia";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Perugia";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Ravenna";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Livorno";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Cagliari";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Foggia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Rimini";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Salerno";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Ferrara";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Sassari";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Latina";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Giugliano in Campania";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Monza";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Siracusa";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Bergamo";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Pescara";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Trento";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Forlì";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Vicenza";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Terni";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Bolzano";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Novara";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Piacenza";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Ancona";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Andria";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Udine";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Arezzo";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Cesena";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Lecce";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Pesaro";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Barletta";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Alessandria";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "La Spezia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Pistoia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Pisa";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Catanzaro";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Lucca";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Brindisi";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Torre del Greco";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Treviso";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Busto Arsizio";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Como";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Marsala";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Grosseto";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Sesto San Giovanni";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Pozzuoli";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Varese";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Fiumicino";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Casoria";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Corigliano-Rossano";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Asti";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Cinisello Balsamo";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Caserta";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Gela";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Aprilia";
        $city->country_id = $it->id;
        $city->save();




        $city = new City();
        $city->city_name = "Ragusa";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Pavia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Cremona";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Carpi";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Quartu Sant'Elena";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Lamezia Terme";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Altamura";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Imola";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "L'Aquila";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Massa";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Trapani";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Viterbo";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Cosenza";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Potenza";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Castellammare di Stabia";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Afragola";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Vittoria";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Crotone";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Pomezia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Vigevano";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Carrara";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Caltanissetta";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Viareggio";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Fano";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Savona";
        $city->country_id = $it->id;
        $city->save();



        $city = new City();
        $city->city_name = "Matera";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Olbia";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Legnano";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Acerra";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Marano di Napoli";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Benevento";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Molfetta";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Agrigento";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Faenza";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Cerignola";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Moncalieri";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Foligno";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Manfredonia";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Tivoli";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Cuneo";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Trani";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Bisceglie";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Bitonto";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Bagheria";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Anzio";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Portici";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Modica";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Sanremo";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Avellino";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Teramo";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Montesilvano";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Siena";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Gallarate";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Velletri";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Cava de' Tirreni";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "San Severo";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Aversa";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Ercolano";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Civitavecchia";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Acireale";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Mazara del Vallo";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Rovigo";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Pordenone";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Battipaglia";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Rho";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Chieti";
        $city->country_id = $it->id;
        $city->save();


        $city = new City();
        $city->city_name = "Scafati";
        $city->country_id = $it->id;
        $city->save();

        $city = new City();
        $city->city_name = "Scandicci";
        $city->country_id = $it->id;
        $city->save();

    }
}
