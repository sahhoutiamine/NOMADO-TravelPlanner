<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('countries')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        $countries = [
            // Adventure (8 countries)
            ['name' => 'Morocco', 'trip_type' => 'adventure', 'description' => 'Discover the Sahara desert, Atlas mountains, and vibrant medinas.', 'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70'],
            ['name' => 'Nepal', 'trip_type' => 'adventure', 'description' => 'Trek the majestic Himalayas and discover ancient temples.', 'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa'],
            ['name' => 'Peru', 'trip_type' => 'adventure', 'description' => 'Hike the Inca Trail to Machu Picchu and explore the breathtaking Andes.', 'image' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377'],
            ['name' => 'Iceland', 'trip_type' => 'adventure', 'description' => 'Dramatic landscapes with volcanoes, geysers, hot springs, and lava fields.', 'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae'],
            ['name' => 'Jordan', 'trip_type' => 'adventure', 'description' => 'Explore the ancient wonder of Petra and the vast beauty of Wadi Rum.', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada'],
            ['name' => 'Tanzania', 'trip_type' => 'adventure', 'description' => 'Witness the Great Migration in the Serengeti and climb Mount Kilimanjaro.', 'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801'],
            ['name' => 'Chile', 'trip_type' => 'adventure', 'description' => 'From the Atacama Desert down to the stunning fjords of Patagonia.', 'image' => 'https://images.unsplash.com/photo-1518182170546-076616fdcbbe'],
            ['name' => 'New Zealand', 'trip_type' => 'adventure', 'description' => 'Majestic fjords, expansive glaciers, and cinematic natural landscapes.', 'image' => 'https://images.unsplash.com/photo-1469521669194-babbdf9aa987'],
            
            // Culture (8 countries)
            ['name' => 'Italy', 'trip_type' => 'culture', 'description' => 'Immerse yourself in Renaissance art, ancient Roman history, and stunning architecture.', 'image' => 'https://images.unsplash.com/photo-1498503182468-3b51fbb6cb1b'],
            ['name' => 'Spain', 'trip_type' => 'culture', 'description' => 'Antoni Gaudí\'s architecture, passionate flamenco, and historic cities.', 'image' => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325'],
            ['name' => 'Egypt', 'trip_type' => 'culture', 'description' => 'Uncover the mysteries of the Pyramids and cruise the magnificent Nile.', 'image' => 'https://images.unsplash.com/photo-1539650116574-8b8ac76b0d91'],
            ['name' => 'Japan', 'trip_type' => 'culture', 'description' => 'A perfect blend of ancient traditions, historic temples, and modern innovation.', 'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e'],
            ['name' => 'India', 'trip_type' => 'culture', 'description' => 'Journey through vibrant cities, witness the Taj Mahal, and deep spirituality.', 'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da'],
            ['name' => 'Turkey', 'trip_type' => 'culture', 'description' => 'A captivating bridge between Europe and Asia with stunning history.', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200'],
            ['name' => 'Greece', 'trip_type' => 'culture', 'description' => 'The cradle of Western civilization with awe-inspiring ancient ruins and mythology.', 'image' => 'https://images.unsplash.com/photo-1503152394-c571994fd383'],
            ['name' => 'China', 'trip_type' => 'culture', 'description' => 'Walk the Great Wall and explore forbidden cities of ancient dynasties.', 'image' => 'https://images.unsplash.com/photo-1508804185872-416beea60432'],
            
            // Beach (8 countries)
            ['name' => 'Maldives', 'trip_type' => 'beach', 'description' => 'Relax on pristine white-sand beaches surrounded by crystal-clear waters.', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8'],
            ['name' => 'Thailand', 'trip_type' => 'beach', 'description' => 'Discover tropical islands, limestone cliffs, and a lively coastal culture.', 'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a'],
            ['name' => 'Indonesia', 'trip_type' => 'beach', 'description' => 'Explore the lush paradise of Bali and thousands of other sun-drenched islands.', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4'],
            ['name' => 'Philippines', 'trip_type' => 'beach', 'description' => 'Crystal waters, hidden lagoons, and thousands of tropical islands.', 'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86'],
            ['name' => 'Seychelles', 'trip_type' => 'beach', 'description' => 'An archipelago of timeless beauty with iconic granite boulders.', 'image' => 'https://images.unsplash.com/photo-1588722741133-c2111d4d38ff'],
            ['name' => 'Fiji', 'trip_type' => 'beach', 'description' => 'Warm hospitality and incredibly clear waters perfect for diving and relaxing.', 'image' => 'https://images.unsplash.com/photo-1557088497-767838584742'],
            ['name' => 'Mauritius', 'trip_type' => 'beach', 'description' => 'A sparkling Indian Ocean island known for its spectacular beaches and lagoons.', 'image' => 'https://images.unsplash.com/photo-1569085871261-26786aebbb24'],
            ['name' => 'Bahamas', 'trip_type' => 'beach', 'description' => 'Endless sunshine, swimming pigs, and spectacular coral reefs.', 'image' => 'https://images.unsplash.com/photo-1542289947-0e6d548fbac2'],
            
            // Romantic (8 countries)
            ['name' => 'France', 'trip_type' => 'romantic', 'description' => 'The ultimate destination for romance, from the lights of Paris to the vineyards of Bordeaux.', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34'],
            ['name' => 'Switzerland', 'trip_type' => 'romantic', 'description' => 'Cozy up in alpine chalets and view stunning snow-capped peaks.', 'image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99'],
            ['name' => 'Portugal', 'trip_type' => 'romantic', 'description' => 'Stroll hand-in-hand through Lisbon\'s alleys and taste sweet Port wine.', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b'],
            ['name' => 'Austria', 'trip_type' => 'romantic', 'description' => 'Experience the imperial charm of Vienna and its musical romance.', 'image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af'],
            ['name' => 'Czech Republic', 'trip_type' => 'romantic', 'description' => 'Wander through the utterly romantic, cobblestoned streets of Prague.', 'image' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439'],
            ['name' => 'Croatia', 'trip_type' => 'romantic', 'description' => 'Watch the sunset over the deep blue Adriatic from medieval stone walls.', 'image' => 'https://images.unsplash.com/photo-1517904018873-1383cd89e3ec'],
            ['name' => 'Saint Lucia', 'trip_type' => 'romantic', 'description' => 'A remarkably romantic Caribbean escape framing the majestic Piton mountains.', 'image' => 'https://images.unsplash.com/photo-1517700683050-25275e54d3cd'],
            ['name' => 'Ireland', 'trip_type' => 'romantic', 'description' => 'Romantic, lush rolling hills, cozy pubs, and the dramatic Cliffs of Moher.', 'image' => 'https://images.unsplash.com/photo-1515091943-9def6d5ea258'],
            
            // Shopping (4 countries)
            ['name' => 'UAE', 'trip_type' => 'shopping', 'description' => 'Shop till you drop in the ultra-modern, gigantic luxury malls of Dubai.', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c'],
            ['name' => 'USA', 'trip_type' => 'shopping', 'description' => 'From the boutiques of New York to expansive outlets across the nation.', 'image' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b'],
            ['name' => 'Singapore', 'trip_type' => 'shopping', 'description' => 'Premium retail therapy along Orchard Road and futuristic shopping centers.', 'image' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd'],
            ['name' => 'South Korea', 'trip_type' => 'shopping', 'description' => 'Trendy boutiques of Seoul, cutting-edge cosmetics, and night markets.', 'image' => 'https://images.unsplash.com/photo-1517154421773-0529f29ea451'],
            
            // Nature (4 countries)
            ['name' => 'Canada', 'trip_type' => 'nature', 'description' => 'Experience the vast wilderness of the Rockies, emerald lakes, and lush forests.', 'image' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce'],
            ['name' => 'Norway', 'trip_type' => 'nature', 'description' => 'Spectacular deep fjords, scenic trails, and the mystical Northern Lights.', 'image' => 'https://images.unsplash.com/photo-1520681280062-8e390234ea6a'],
            ['name' => 'Costa Rica', 'trip_type' => 'nature', 'description' => 'Rich biodiversity, tropical rainforests, and incredible wildlife.', 'image' => 'https://images.unsplash.com/photo-1519069507908-1cc68bc3eef0'],
            ['name' => 'Australia', 'trip_type' => 'nature', 'description' => 'The Great Barrier Reef, the vast Outback, and unique incredible wildlife.', 'image' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be'],
        ];

        $insertData = [];
        foreach ($countries as $country) {
            $insertData[] = [
                'name'        => $country['name'],
                'description' => $country['description'],
                'image'       => $country['image'] . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }

        DB::table('countries')->insert($insertData);
    }
}