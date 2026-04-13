<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Place;
use Illuminate\Database\Seeder;
use Faker\Factory;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        
        $realPlaces = [
            'Morocco' => [
                ['name' => 'Jemaa el-Fnaa', 'city' => 'Marrakech', 'image' => 'https://images.unsplash.com/photo-1582200858546-24ebf4ffb626', 'description' => 'A vibrant public square and market place in Marrakech\'s medina quarter.'],
                ['name' => 'Chefchaouen', 'city' => 'Chefchaouen', 'image' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3', 'description' => 'The famous blue city nestled in the Rif Mountains, known for its striking blue-washed buildings.'],
            ],
            'Nepal' => [
                ['name' => 'Mount Everest Base Camp', 'city' => 'Solukhumbu', 'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa', 'description' => 'The legendary starting point for climbing the world\'s highest mountain.'],
                ['name' => 'Pashupatinath Temple', 'city' => 'Kathmandu', 'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa', 'description' => 'A sacred Hindu temple complex on the banks of the Bagmati River.'],
            ],
            'Peru' => [
                ['name' => 'Machu Picchu', 'city' => 'Cusco', 'image' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377', 'description' => 'The iconic 15th-century Inca citadel set high in the Andes Mountains.'],
                ['name' => 'Rainbow Mountain', 'city' => 'Cusco', 'image' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377', 'description' => 'A stunning mountain with vibrant striped colors caused by mineral deposits.'],
            ],
            'Iceland' => [
                ['name' => 'Blue Lagoon', 'city' => 'Grindavik', 'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae', 'description' => 'A geothermal spa with milky blue waters surrounded by lava fields.'],
                ['name' => 'Golden Circle', 'city' => 'Reykjavik', 'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae', 'description' => 'A famous route featuring Gullfoss waterfall, Geysir, and Thingvellir National Park.'],
            ],
            'Jordan' => [
                ['name' => 'Petra', 'city' => 'Wadi Musa', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada', 'description' => 'The ancient Nabatean city carved into rose-red rock faces.'],
                ['name' => 'Wadi Rum', 'city' => 'Wadi Rum', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada', 'description' => 'A dramatic desert valley with towering sandstone mountains.'],
            ],
            'Tanzania' => [
                ['name' => 'Serengeti National Park', 'city' => 'Serengeti', 'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801', 'description' => 'Famous for the annual Great Migration of wildebeest and zebra.'],
                ['name' => 'Mount Kilimanjaro', 'city' => 'Moshi', 'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801', 'description' => 'Africa\'s highest peak and a iconic climbing destination.'],
            ],
            'Chile' => [
                ['name' => 'Torres del Paine', 'city' => 'Patagonia', 'image' => 'https://images.unsplash.com/photo-1518182170546-076616fdcbbe', 'description' => 'A stunning national park with granite peaks, glaciers, and turquoise lakes.'],
                ['name' => 'Atacama Desert', 'city' => 'San Pedro', 'image' => 'https://images.unsplash.com/photo-1518182170546-076616fdcbbe', 'description' => 'The driest non-polar desert in the world with surreal landscapes.'],
            ],
            'New Zealand' => [
                ['name' => 'Milford Sound', 'city' => 'Fiordland', 'image' => 'https://images.unsplash.com/photo-1469521669194-babbdf9aa987', 'description' => 'A breathtaking fjord with dramatic cliffs and cascading waterfalls.'],
                ['name' => 'Hobbiton', 'city' => 'Matamata', 'image' => 'https://images.unsplash.com/photo-1469521669194-babbdf9aa987', 'description' => 'The movie set from The Lord of the Rings and The Hobbit films.'],
            ],
            'Italy' => [
                ['name' => 'Colosseum', 'city' => 'Rome', 'image' => 'https://images.unsplash.com/photo-1552832230-c0197ef3116d', 'description' => 'An ancient gladiatorial arena and one of the greatest works of Roman architecture.'],
                ['name' => 'Venice Canals', 'city' => 'Venice', 'image' => 'https://images.unsplash.com/photo-1514890547357-a9ee288728e0', 'description' => 'A network of picturesque waterways navigated by iconic gondolas.'],
            ],
            'Spain' => [
                ['name' => 'Sagrada Familia', 'city' => 'Barcelona', 'image' => 'https://images.unsplash.com/photo-1583778175782-d1d494957d77', 'description' => 'Gaudi\'s unfinished masterpiece blending Gothic and Art Nouveau styles.'],
                ['name' => 'Alhambra', 'city' => 'Granada', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b', 'description' => 'A stunning palace and fortress complex of Islamic architecture.'],
            ],
            'Egypt' => [
                ['name' => 'Giza Pyramids', 'city' => 'Giza', 'image' => 'https://images.unsplash.com/photo-1539650116574-8b8ac76b0d91', 'description' => 'The last remaining wonder of the ancient world.'],
                ['name' => 'Karnak Temple', 'city' => 'Luxor', 'image' => 'https://images.unsplash.com/photo-1539650116574-8b8ac76b0d91', 'description' => 'An enormous ancient temple complex from the 18th Dynasty.'],
            ],
            'Japan' => [
                ['name' => 'Mount Fuji', 'city' => 'Shizuoka', 'image' => 'https://images.unsplash.com/photo-1490806843957-31f4c9a91c65', 'description' => 'Japan\'s highest mountain with a perfectly symmetrical cone.'],
                ['name' => 'Fushimi Inari Shrine', 'city' => 'Kyoto', 'image' => 'https://images.unsplash.com/photo-1478436127897-769e1b3f0f36', 'description' => 'Famous for thousands of vermilion torii gates.'],
            ],
            'India' => [
                ['name' => 'Taj Mahal', 'city' => 'Agra', 'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da', 'description' => 'A stunning white marble mausoleum and one of the Seven Wonders of the World.'],
                ['name' => 'Jaipur City Palace', 'city' => 'Jaipur', 'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da', 'description' => 'A magnificent palace complex blending Rajasthani and Mughal architecture.'],
            ],
            'Turkey' => [
                ['name' => 'Hagia Sophia', 'city' => 'Istanbul', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200', 'description' => 'A breathtaking architectural marvel that has served as cathedral, mosque, and museum.'],
                ['name' => 'Cappadocia', 'city' => 'Nevsehir', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200', 'description' => 'A surreal landscape of fairy chimneys and hot air balloon rides.'],
            ],
            'Greece' => [
                ['name' => 'Acropolis', 'city' => 'Athens', 'image' => 'https://images.unsplash.com/photo-1503152394-c571994fd383', 'description' => 'An ancient citadel containing the Parthenon overlooking Athens.'],
                ['name' => 'Santorini Caldera', 'city' => 'Oia', 'image' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff', 'description' => 'Breathtaking views of whitewashed houses overlooking the Aegean sea.'],
            ],
            'China' => [
                ['name' => 'Great Wall of China', 'city' => 'Beijing', 'image' => 'https://images.unsplash.com/photo-1508804185872-416beea60432', 'description' => 'One of the Seven Wonders stretching thousands of miles across China.'],
                ['name' => 'Forbidden City', 'city' => 'Beijing', 'image' => 'https://images.unsplash.com/photo-1508804185872-416beea60432', 'description' => 'The magnificent imperial palace complex of Chinese emperors.'],
            ],
            'Maldives' => [
                ['name' => 'Male Island', 'city' => 'Male', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8', 'description' => 'The bustling capital island with colorful buildings and local markets.'],
                ['name' => 'Banana Reef', 'city' => 'North Male Atoll', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8', 'description' => 'A famous diving spot with vibrant coral and diverse marine life.'],
            ],
            'Thailand' => [
                ['name' => 'Grand Palace', 'city' => 'Bangkok', 'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a', 'description' => 'A complex of dazzling buildings, the official residence of the Kings of Siam.'],
                ['name' => 'Phi Phi Islands', 'city' => 'Krabi', 'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592', 'description' => 'Paradise islands known for emerald waters and white sandy beaches.'],
            ],
            'Indonesia' => [
                ['name' => 'Borobudur Temple', 'city' => 'Magelang', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4', 'description' => 'The world\'s largest Buddhist temple with intricate relief panels.'],
                ['name' => 'Pura Tanah Lot', 'city' => 'Bali', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4', 'description' => 'A stunning sea temple perched on a rocky outcrop.'],
            ],
            'Philippines' => [
                ['name' => 'Puerto Princesa', 'city' => 'Palawan', 'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86', 'description' => 'An underground river and UNESCO World Heritage site.'],
                ['name' => 'Chocolate Hills', 'city' => 'Bohol', 'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86', 'description' => 'Over 1,200 symmetrical hills that turn brown in dry season.'],
            ],
            'Seychelles' => [
                ['name' => 'Anse Source d\'Argent', 'city' => 'La Digue', 'image' => 'https://images.unsplash.com/photo-1588722741133-c2111d4d38ff', 'description' => 'Famous beach with giant granite boulders and turquoise water.'],
                ['name' => 'Vallee de Mai', 'city' => 'Praslin', 'image' => 'https://images.unsplash.com/photo-1588722741133-c2111d4d38ff', 'description' => 'A prehistoric forest home to the rare coco de mer palm.'],
            ],
            'Fiji' => [
                ['name' => 'Natadola Beach', 'city' => 'Viti Levu', 'image' => 'https://images.unsplash.com/photo-1557088497-767838584742', 'description' => 'One of Fiji\'s most beautiful white sand beaches.'],
                ['name' => 'Sawa-i-Lau Caves', 'city' => 'Yasawa Islands', 'image' => 'https://images.unsplash.com/photo-1557088497-767838584742', 'description' => 'Sacred limestone caves featured in the movie Blue Lagoon.'],
            ],
            'Mauritius' => [
                ['name' => 'Le Morne Brabant', 'city' => 'Le Morne', 'image' => 'https://images.unsplash.com/photo-1569085871261-26786aebbb24', 'description' => 'A stunning mountain peninsula and UNESCO World Heritage site.'],
                ['name' => 'Chamarel Waterfall', 'city' => 'Chamarel', 'image' => 'https://images.unsplash.com/photo-1569085871261-26786aebbb24', 'description' => 'The tallest waterfall in Mauritius with scenic views.'],
            ],
            'Bahamas' => [
                ['name' => 'Pig Beach', 'city' => 'Exuma', 'image' => 'https://images.unsplash.com/photo-1542289947-0e6d548fbac2', 'description' => 'Famous beach where friendly pigs swim in crystal clear waters.'],
                ['name' => 'Atlantis Paradise Island', 'city' => 'Nassau', 'image' => 'https://images.unsplash.com/photo-1542289947-0e6d548fbac2', 'description' => 'A legendary resort with water park and marine habitat.'],
            ],
            'France' => [
                ['name' => 'Eiffel Tower', 'city' => 'Paris', 'image' => 'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f', 'description' => 'The iconic wrought-iron lattice tower, a global symbol of France.'],
                ['name' => 'Mont Saint-Michel', 'city' => 'Normandy', 'image' => 'https://images.unsplash.com/photo-1521990176414-b4bf01ddf0df', 'description' => 'A breathtaking island commune topped by a medieval monastery.'],
            ],
            'Switzerland' => [
                ['name' => 'Matterhorn', 'city' => 'Zermatt', 'image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99', 'description' => 'One of the most famous mountains in the Alps with a iconic pyramid shape.'],
                ['name' => 'Lake Geneva', 'city' => 'Geneva', 'image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99', 'description' => 'A stunning crescent-shaped lake surrounded by Alps.'],
            ],
            'Portugal' => [
                ['name' => 'Belém Tower', 'city' => 'Lisbon', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b', 'description' => 'A fortified tower and UNESCO World Heritage site on the Tagus River.'],
                ['name' => 'Pena Palace', 'city' => 'Sintra', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b', 'description' => 'A colorful Romanticist palace perched on a hilltop.'],
            ],
            'Austria' => [
                ['name' => 'Schönbrunn Palace', 'city' => 'Vienna', 'image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af', 'description' => 'The former summer residence of the Habsburg monarchs.'],
                ['name' => 'Hallstatt', 'city' => 'Hallstatt', 'image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af', 'description' => 'A picturesque village on Lake Hallstatt with mountain views.'],
            ],
            'Czech Republic' => [
                ['name' => 'Prague Castle', 'city' => 'Prague', 'image' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439', 'description' => 'The largest ancient castle complex in the world.'],
                ['name' => 'Charles Bridge', 'city' => 'Prague', 'image' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439', 'description' => 'A historic bridge adorned with baroque statues.'],
            ],
            'Croatia' => [
                ['name' => 'Plitvice Lakes', 'city' => 'Plitvice', 'image' => 'https://images.unsplash.com/photo-1517904018873-1383cd89e3ec', 'description' => 'A national park with cascading turquoise lakes and waterfalls.'],
                ['name' => 'Dubrovnik Old Town', 'city' => 'Dubrovnik', 'image' => 'https://images.unsplash.com/photo-1517904018873-1383cd89e3ec', 'description' => 'The "Pearl of the Adriatic" with medieval walls.'],
            ],
            'Saint Lucia' => [
                ['name' => 'Pitons', 'city' => 'Soufrière', 'image' => 'https://images.unsplash.com/photo-1517700683050-25275e54d3cd', 'description' => 'Two iconic volcanic plugs rising from the sea.'],
                ['name' => 'Sulphur Springs', 'city' => 'Soufrière', 'image' => 'https://images.unsplash.com/photo-1517700683050-25275e54d3cd', 'description' => 'The Caribbean\'s only drive-in volcano.'],
            ],
            'Ireland' => [
                ['name' => 'Cliffs of Moher', 'city' => 'County Clare', 'image' => 'https://images.unsplash.com/photo-1515091943-9def6d5ea258', 'description' => 'Dramatic sea cliffs rising over 700 feet above the Atlantic.'],
                ['name' => 'Ring of Kerry', 'city' => 'County Kerry', 'image' => 'https://images.unsplash.com/photo-1515091943-9def6d5ea258', 'description' => 'A scenic drive with mountains, lakes, and coastal views.'],
            ],
            'UAE' => [
                ['name' => 'Burj Khalifa', 'city' => 'Dubai', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c', 'description' => 'The tallest building in the world.'],
                ['name' => 'Sheikh Zayed Grand Mosque', 'city' => 'Abu Dhabi', 'image' => 'https://images.unsplash.com/photo-1549468057-5b7fa1a41d0a', 'description' => 'A masterpiece of modern Islamic architecture.'],
            ],
            'USA' => [
                ['name' => 'Grand Canyon', 'city' => 'Arizona', 'image' => 'https://images.unsplash.com/photo-1474044159687-1ee9f3a51722', 'description' => 'A colossal natural wonder carved by the Colorado River.'],
                ['name' => 'Statue of Liberty', 'city' => 'New York City', 'image' => 'https://images.unsplash.com/photo-1605130284535-11dd9eedc58a', 'description' => 'An iconic symbol of freedom in New York Harbor.'],
            ],
            'Singapore' => [
                ['name' => 'Marina Bay Sands', 'city' => 'Singapore', 'image' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd', 'description' => 'An iconic resort with a rooftop infinity pool.'],
                ['name' => 'Gardens by the Bay', 'city' => 'Singapore', 'image' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd', 'description' => 'A futuristic nature park with Supertree structures.'],
            ],
            'South Korea' => [
                ['name' => 'Gyeongbokgung Palace', 'city' => 'Seoul', 'image' => 'https://images.unsplash.com/photo-1517154421773-0529f29ea451', 'description' => 'The largest of the Five Grand Palaces built by the Joseon dynasty.'],
                ['name' => 'Jeju Island', 'city' => 'Jeju', 'image' => 'https://images.unsplash.com/photo-1517154421773-0529f29ea451', 'description' => 'A volcanic island with natural wonders and beaches.'],
            ],
            'Canada' => [
                ['name' => 'Banff National Park', 'city' => 'Alberta', 'image' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce', 'description' => 'Canada\'s first national park with turquoise lakes and mountains.'],
                ['name' => 'Niagara Falls', 'city' => 'Ontario', 'image' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce', 'description' => 'Massive waterfalls known for their thunderous power.'],
            ],
            'Norway' => [
                ['name' => 'Geirangerfjord', 'city' => 'Møre og Romsdal', 'image' => 'https://images.unsplash.com/photo-1520681280062-8e390234ea6a', 'description' => 'A stunning fjord with dramatic cliffs and waterfalls.'],
                ['name' => 'Northern Lights', 'city' => 'Tromsø', 'image' => 'https://images.unsplash.com/photo-1520681280062-8e390234ea6a', 'description' => 'One of the best places to witness the Aurora Borealis.'],
            ],
            'Costa Rica' => [
                ['name' => 'Arenal Volcano', 'city' => 'La Fortuna', 'image' => 'https://images.unsplash.com/photo-1519069507908-1cc68bc3eef0', 'description' => 'An active volcano with perfect conical shape.'],
                ['name' => 'Manuel Antonio Park', 'city' => 'Quepos', 'image' => 'https://images.unsplash.com/photo-1519069507908-1cc68bc3eef0', 'description' => 'A national park with beaches, rainforests, and wildlife.'],
            ],
            'Australia' => [
                ['name' => 'Great Barrier Reef', 'city' => 'Queensland', 'image' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be', 'description' => 'The world\'s largest coral reef system.'],
                ['name' => 'Sydney Opera House', 'city' => 'Sydney', 'image' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be', 'description' => 'A world-famous performing arts centre with distinctive sail-like design.'],
            ],
        ];

        $countries = Country::all();
        $allPlaces = [];
        $now = now();
        $unsplashParams = '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';

        foreach ($countries as $country) {
            if (isset($realPlaces[$country->name])) {
                foreach ($realPlaces[$country->name] as $place) {
                    $allPlaces[] = [
                        'country_id' => $country->id,
                        'name' => $place['name'],
                        'city' => $place['city'],
                        'description' => $place['description'],
                        'image' => $place['image'] . $unsplashParams,
                        'rating' => $faker->randomFloat(1, 4.2, 5.0),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        Place::insert($allPlaces);
    }
}