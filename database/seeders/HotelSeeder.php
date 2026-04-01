<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Country;
use Faker\Factory as Faker;
use Carbon\Carbon;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('hotels')->truncate();
        Schema::enableForeignKeyConstraints();

        $faker = Faker::create();
        $countries = Country::all();
        $now = Carbon::now();

        // Location mappings: 3 distinct cities/regions for the 102 seeded countries
        $locationsMap = [
            'Morocco' => ['Marrakech', 'Casablanca', 'Fes'],
            'Nepal' => ['Kathmandu', 'Pokhara', 'Lalitpur'],
            'Peru' => ['Cusco', 'Lima', 'Arequipa'],
            'Iceland' => ['Reykjavik', 'Akureyri', 'Vik'],
            'Jordan' => ['Amman', 'Aqaba', 'Petra'],
            'Tanzania' => ['Dar es Salaam', 'Arusha', 'Zanzibar City'],
            'Kenya' => ['Nairobi', 'Mombasa', 'Kisumu'],
            'Chile' => ['Santiago', 'Valparaiso', 'Punta Arenas'],
            'Argentina' => ['Buenos Aires', 'Cordoba', 'Mendoza'],
            'Bolivia' => ['La Paz', 'Sucre', 'Santa Cruz'],
            'Mongolia' => ['Ulaanbaatar', 'Erdenet', 'Darkhan'],
            'Namibia' => ['Windhoek', 'Swakopmund', 'Walvis Bay'],
            'Madagascar' => ['Antananarivo', 'Toamasina', 'Antsirabe'],
            'Bhutan' => ['Thimphu', 'Paro', 'Punakha'],
            'Ecuador' => ['Quito', 'Guayaquil', 'Cuenca'],
            'Zambia' => ['Lusaka', 'Livingstone', 'Ndola'],
            'Zimbabwe' => ['Harare', 'Bulawayo', 'Victoria Falls'],
            'Italy' => ['Rome', 'Milan', 'Venice'],
            'Spain' => ['Madrid', 'Barcelona', 'Seville'],
            'Egypt' => ['Cairo', 'Alexandria', 'Luxor'],
            'Japan' => ['Tokyo', 'Kyoto', 'Osaka'],
            'India' => ['New Delhi', 'Mumbai', 'Jaipur'],
            'Turkey' => ['Istanbul', 'Ankara', 'Izmir'],
            'Cambodia' => ['Phnom Penh', 'Siem Reap', 'Battambang'],
            'Mexico' => ['Mexico City', 'Cancun', 'Guadalajara'],
            'China' => ['Beijing', 'Shanghai', 'Xi\'an'],
            'United Kingdom' => ['London', 'Edinburgh', 'Manchester'],
            'Iran' => ['Tehran', 'Isfahan', 'Shiraz'],
            'Uzbekistan' => ['Tashkent', 'Samarkand', 'Bukhara'],
            'Israel' => ['Jerusalem', 'Tel Aviv', 'Haifa'],
            'Germany' => ['Berlin', 'Munich', 'Hamburg'],
            'Russia' => ['Moscow', 'Saint Petersburg', 'Kazan'],
            'Poland' => ['Warsaw', 'Krakow', 'Gdansk'],
            'Greece' => ['Athens', 'Thessaloniki', 'Heraklion'],
            'Maldives' => ['Male', 'Maafushi', 'Hulhumale'],
            'Thailand' => ['Bangkok', 'Phuket', 'Pattaya'],
            'Indonesia' => ['Jakarta', 'Bali', 'Surabaya'],
            'Philippines' => ['Manila', 'Cebu', 'Boracay'],
            'Bahamas' => ['Nassau', 'Freeport', 'West End'],
            'Seychelles' => ['Victoria', 'Praslin', 'La Digue'],
            'Fiji' => ['Suva', 'Nadi', 'Lautoka'],
            'Mauritius' => ['Port Louis', 'Grand Baie', 'Flic en Flac'],
            'Dominican Republic' => ['Santo Domingo', 'Punta Cana', 'Puerto Plata'],
            'Jamaica' => ['Kingston', 'Montego Bay', 'Ocho Rios'],
            'Barbados' => ['Bridgetown', 'Speightstown', 'Holetown'],
            'Cuba' => ['Havana', 'Santiago de Cuba', 'Varadero'],
            'Sri Lanka' => ['Colombo', 'Kandy', 'Galle'],
            'Vietnam' => ['Ho Chi Minh City', 'Hanoi', 'Da Nang'],
            'Belize' => ['Belize City', 'San Pedro', 'Belmopan'],
            'Honduras' => ['Tegucigalpa', 'San Pedro Sula', 'Roatan'],
            'Antigua and Barbuda' => ['St. John\'s', 'All Saints', 'Liberta'],
            'France' => ['Paris', 'Nice', 'Lyon'],
            'Switzerland' => ['Zurich', 'Geneva', 'Lucerne'],
            'Portugal' => ['Lisbon', 'Porto', 'Sintra'],
            'Austria' => ['Vienna', 'Salzburg', 'Innsbruck'],
            'Czech Republic' => ['Prague', 'Brno', 'Karlovy Vary'],
            'Monaco' => ['Monte Carlo', 'La Condamine', 'Fontvieille'],
            'Saint Lucia' => ['Castries', 'Soufriere', 'Gros Islet'],
            'French Polynesia' => ['Papeete', 'Bora Bora', 'Moorea'],
            'Croatia' => ['Zagreb', 'Dubrovnik', 'Split'],
            'Belgium' => ['Brussels', 'Bruges', 'Antwerp'],
            'Malta' => ['Valletta', 'Sliema', 'Mdina'],
            'Cyprus' => ['Nicosia', 'Limassol', 'Paphos'],
            'San Marino' => ['City of San Marino', 'Serravalle', 'Borgo Maggiore'],
            'Andorra' => ['Andorra la Vella', 'Escaldes-Engordany', 'Encamp'],
            'Luxembourg' => ['Luxembourg City', 'Esch-sur-Alzette', 'Echternach'],
            'Hungary' => ['Budapest', 'Debrecen', 'Szeged'],
            'Ireland' => ['Dublin', 'Galway', 'Cork'],
            'Canada' => ['Toronto', 'Vancouver', 'Montreal'],
            'New Zealand' => ['Auckland', 'Wellington', 'Queenstown'],
            'Norway' => ['Oslo', 'Bergen', 'Tromso'],
            'Costa Rica' => ['San Jose', 'Liberia', 'Tamarindo'],
            'South Africa' => ['Cape Town', 'Johannesburg', 'Durban'],
            'Australia' => ['Sydney', 'Melbourne', 'Brisbane'],
            'Brazil' => ['Rio de Janeiro', 'Sao Paulo', 'Salvador'],
            'Colombia' => ['Bogota', 'Medellin', 'Cartagena'],
            'Uganda' => ['Kampala', 'Entebbe', 'Jinja'],
            'Rwanda' => ['Kigali', 'Musanze', 'Gisenyi'],
            'Finland' => ['Helsinki', 'Rovaniemi', 'Turku'],
            'Sweden' => ['Stockholm', 'Gothenburg', 'Malmo'],
            'Slovenia' => ['Ljubljana', 'Bled', 'Maribor'],
            'Slovakia' => ['Bratislava', 'Kosice', 'Poprad'],
            'Romania' => ['Bucharest', 'Cluj-Napoca', 'Brasov'],
            'Bulgaria' => ['Sofia', 'Plovdiv', 'Varna'],
            'Serbia' => ['Belgrade', 'Novi Sad', 'Nis'],
            'UAE' => ['Dubai', 'Abu Dhabi', 'Sharjah'],
            'USA' => ['New York', 'Los Angeles', 'Chicago'],
            'South Korea' => ['Seoul', 'Busan', 'Jeju'],
            'Singapore' => ['Marina Bay', 'Orchard', 'Sentosa'],
            'Malaysia' => ['Kuala Lumpur', 'Penang', 'Langkawi'],
            'Hong Kong' => ['Central', 'Kowloon', 'Causeway Bay'],
            'Qatar' => ['Doha', 'Al Wakrah', 'Al Khor'],
            'Kuwait' => ['Kuwait City', 'Salmiya', 'Hawalli'],
            'Bahrain' => ['Manama', 'Riffa', 'Muharraq'],
            'Taiwan' => ['Taipei', 'Kaohsiung', 'Taichung'],
            'Macau' => ['Cotai', 'Taipa', 'Coloane'],
            'Panama' => ['Panama City', 'David', 'Colon'],
            'Saudi Arabia' => ['Riyadh', 'Jeddah', 'Mecca'],
            'Lebanon' => ['Beirut', 'Byblos', 'Tripoli'],
            'Oman' => ['Muscat', 'Salalah', 'Nizwa'],
            'Brunei' => ['Bandar Seri Begawan', 'Kuala Belait', 'Seria'],
            'Netherlands' => ['Amsterdam', 'Rotterdam', 'The Hague']
        ];

        $hotelImages = [
            'https://images.unsplash.com/photo-1566073771259-6a8506099945',
            'https://images.unsplash.com/photo-1551882547-ff40c0d125fa',
            'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9',
            'https://images.unsplash.com/photo-1542314831-c6a4d27ce6a2',
            'https://images.unsplash.com/photo-1582719508461-905c673771fd',
            'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4',
            'https://images.unsplash.com/photo-1517840901100-8179e982acb7',
            'https://images.unsplash.com/photo-1555854877-bab0e564b8d5',
            'https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd',
            'https://images.unsplash.com/photo-1611892440504-42a792e24d32',
            'https://images.unsplash.com/photo-1596436889106-be35e843f974',
            'https://images.unsplash.com/photo-1564501049412-61c2a3083791',
            'https://images.unsplash.com/photo-1522798514-97ceb8c4f1c8',
        ];

        // Specific naming formats avoiding "Garbage names"
        $namingStructures = [
            'budget' => ['value' => ['Backpackers', 'Hostel', 'Guesthouse', 'Lodge', 'Budget Inn', 'Stay', 'Rooms'], 'format' => '[Location] [Value]'],
            'mid' => ['value' => ['Oasis', 'Retreat', 'Boutique Hotel', 'Resort', 'Suites', 'Villa'], 'format' => '[Value] [Location]'],
            'luxury' => ['value' => ['Grand Hotel', 'Imperial Stay', 'Palace', 'Luxury Resort', 'Ritz', 'Four Seasons', 'Waldorf'], 'format' => '[Value] [Location]']
        ];

        $insertData = [];

        foreach ($countries as $country) {
            $cities = $locationsMap[$country->name] ?? [$faker->city, $faker->city, $faker->city];
            
            // EXACTLY 3 Hotels representing 3 Tiers (Budget, Mid, Luxury)
            $tiers = [
                ['type' => 'budget', 'price' => rand(20, 60)],
                ['type' => 'mid', 'price' => rand(61, 120)],
                ['type' => 'luxury', 'price' => rand(121, 400)]
            ];

            foreach ($tiers as $index => $tier) {
                $location = $cities[$index]; // Ensuring different city for each of the 3 hotels

                $format = $namingStructures[$tier['type']]['format'];
                $word = $faker->randomElement($namingStructures[$tier['type']]['value']);
                
                // Construct the highly realistic name based on the tier's format blueprint
                $name = str_replace(['[Location]', '[Value]'], [$location, $word], $format);

                $image = $faker->randomElement($hotelImages) . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                
                $adjectives = ['beautiful', 'stunning', 'vibrant', 'peaceful', 'magnificent', 'charming'];
                $adj = $faker->randomElement($adjectives);

                $insertData[] = [
                    'country_id' => $country->id,
                    'name' => $name,
                    'location' => $location,
                    'price_per_night' => $tier['price'],
                    'description' => "Experience a {$adj} stay at {$name}, located in the heart of {$location}. " . $faker->sentence(10),
                    'image' => $image,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Chunking insertions to prevent PDO prepared statement limitations limit
        $chunks = array_chunk($insertData, 100);
        foreach ($chunks as $chunk) {
            DB::table('hotels')->insert($chunk);
        }
    }
}
