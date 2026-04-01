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
            // Adventure (17)
            ['name' => 'Morocco', 'trip_type' => 'adventure', 'description' => 'Discover the Sahara desert, Atlas mountains, and vibrant medinas.', 'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70'],
            ['name' => 'Nepal', 'trip_type' => 'adventure', 'description' => 'Trek the majestic Himalayas and discover ancient temples.', 'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa'],
            ['name' => 'Peru', 'trip_type' => 'adventure', 'description' => 'Hike the Inca Trail to Machu Picchu and explore the breathtaking Andes.', 'image' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377'],
            ['name' => 'Iceland', 'trip_type' => 'adventure', 'description' => 'Dramatic landscapes with volcanoes, geysers, hot springs, and lava fields.', 'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae'],
            ['name' => 'Jordan', 'trip_type' => 'adventure', 'description' => 'Explore the ancient wonder of Petra and the vast beauty of Wadi Rum.', 'image' => 'https://images.unsplash.com/photo-1548013146-72479768bada'],
            ['name' => 'Tanzania', 'trip_type' => 'adventure', 'description' => 'Witness the Great Migration in the Serengeti and climb Mount Kilimanjaro.', 'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801'],
            ['name' => 'Kenya', 'trip_type' => 'adventure', 'description' => 'Experience thrilling safaris and witness spectacular wildlife in the Maasai Mara.', 'image' => 'https://images.unsplash.com/photo-1483325367123-5eac4cf4817a'],
            ['name' => 'Chile', 'trip_type' => 'adventure', 'description' => 'From the Atacama Desert down to the stunning fjords of Patagonia.', 'image' => 'https://images.unsplash.com/photo-1518182170546-076616fdcbbe'],
            ['name' => 'Argentina', 'trip_type' => 'adventure', 'description' => 'Explore the vast plains of Patagonia, high peaks, and vibrant culture.', 'image' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849'],
            ['name' => 'Bolivia', 'trip_type' => 'adventure', 'description' => 'Walk across the breathtaking Uyuni Salt Flat and explore the high Andes.', 'image' => 'https://images.unsplash.com/photo-1542157155-22485eedee58'],
            ['name' => 'Mongolia', 'trip_type' => 'adventure', 'description' => 'Vast, rugged expanses and nomadic culture in the land of the blue sky.', 'image' => 'https://images.unsplash.com/photo-1550978805-4c6e913aebf9'],
            ['name' => 'Namibia', 'trip_type' => 'adventure', 'description' => 'Towering red dunes of Sossusvlei and spectacular desert landscapes.', 'image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742'],
            ['name' => 'Madagascar', 'trip_type' => 'adventure', 'description' => 'Unique wildlife, baobab alleys, and untouched remote wilderness.', 'image' => 'https://images.unsplash.com/photo-1554316654-be8df1a542b8'],
            ['name' => 'Bhutan', 'trip_type' => 'adventure', 'description' => 'A magical kingdom in the Himalayas with stunning monasteries and trails.', 'image' => 'https://images.unsplash.com/photo-1551061491-9ad4c000fbd2'],
            ['name' => 'Ecuador', 'trip_type' => 'adventure', 'description' => 'Discover the Amazon rainforest, Andean peaks, and the Galapagos Islands.', 'image' => 'https://images.unsplash.com/photo-1594916893699-b1464c2bf6f7'],
            ['name' => 'Zambia', 'trip_type' => 'adventure', 'description' => 'Home to the magnificent Victoria Falls and incredible walking safaris.', 'image' => 'https://images.unsplash.com/photo-1518151820692-a1b948f95c02'],
            ['name' => 'Zimbabwe', 'trip_type' => 'adventure', 'description' => 'Epic wildlife encounters and majestic views of the iconic Victoria Falls.', 'image' => 'https://images.unsplash.com/photo-1579624535316-2ea8472a15da'],

            // Culture (17)
            ['name' => 'Italy', 'trip_type' => 'culture', 'description' => 'Immerse yourself in Renaissance art, ancient Roman history, and stunning architecture.', 'image' => 'https://images.unsplash.com/photo-1498503182468-3b51fbb6cb1b'],
            ['name' => 'Spain', 'trip_type' => 'culture', 'description' => 'Antoni Gaudí’s architecture, passionate flamenco, and historic cities.', 'image' => 'https://images.unsplash.com/photo-1543783207-ec64e4d95325'],
            ['name' => 'Egypt', 'trip_type' => 'culture', 'description' => 'Uncover the mysteries of the Pyramids and cruise the magnificent Nile.', 'image' => 'https://images.unsplash.com/photo-1539650116574-8b8ac76b0d91'],
            ['name' => 'Japan', 'trip_type' => 'culture', 'description' => 'A perfect blend of ancient traditions, historic temples, and modern innovation.', 'image' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e'],
            ['name' => 'India', 'trip_type' => 'culture', 'description' => 'Journey through vibrant cities, witness the Taj Mahal, and deep spirituality.', 'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da'],
            ['name' => 'Turkey', 'trip_type' => 'culture', 'description' => 'A captivating bridge between Europe and Asia with stunning history.', 'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200'],
            ['name' => 'Cambodia', 'trip_type' => 'culture', 'description' => 'Marvel at the ancient, sprawling temple complex of Angkor Wat.', 'image' => 'https://images.unsplash.com/photo-1538681105587-85640961bf8b'],
            ['name' => 'Mexico', 'trip_type' => 'culture', 'description' => 'Rich Mayan history, vibrant festivals, and incredible local cuisine.', 'image' => 'https://images.unsplash.com/photo-1518105779142-d975f22f1b0a'],
            ['name' => 'China', 'trip_type' => 'culture', 'description' => 'Walk the Great Wall and explore forbidden cities of ancient dynasties.', 'image' => 'https://images.unsplash.com/photo-1508804185872-416beea60432'],
            ['name' => 'United Kingdom', 'trip_type' => 'culture', 'description' => 'Explore medieval castles, British monarchy history, and vibrant literature.', 'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad'],
            ['name' => 'Iran', 'trip_type' => 'culture', 'description' => 'Breathtaking Persian architecture, grand mosques, and deep historical roots.', 'image' => 'https://images.unsplash.com/photo-1561003732-fc29b63a6f11'],
            ['name' => 'Uzbekistan', 'trip_type' => 'culture', 'description' => 'The jewel of the Silk Road with stunning blue-tiled mosques and minarets.', 'image' => 'https://images.unsplash.com/photo-1596707323114-c1e0b571ce16'],
            ['name' => 'Israel', 'trip_type' => 'culture', 'description' => 'A deeply historic land with sacred sites across multiple major religions.', 'image' => 'https://images.unsplash.com/photo-1513256038166-4c9df4514ac0'],
            ['name' => 'Germany', 'trip_type' => 'culture', 'description' => 'Experience a wealth of classical music history, fairy-tale castles, and rich traditions.', 'image' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b'],
            ['name' => 'Russia', 'trip_type' => 'culture', 'description' => 'Grand palaces, iconic Red Square, and profound literary history.', 'image' => 'https://images.unsplash.com/photo-1513326738677-b964603b136d'],
            ['name' => 'Poland', 'trip_type' => 'culture', 'description' => 'A complex, resilient history with beautifully restored medieval town centers.', 'image' => 'https://images.unsplash.com/photo-1519213123849-fb9f82662059'],
            ['name' => 'Greece', 'trip_type' => 'culture', 'description' => 'The cradle of Western civilization with awe-inspiring ancient ruins and mythology.', 'image' => 'https://images.unsplash.com/photo-1503152394-c571994fd383'],

            // Beach (17)
            ['name' => 'Maldives', 'trip_type' => 'beach', 'description' => 'Relax on pristine white-sand beaches surrounded by crystal-clear waters.', 'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8'],
            ['name' => 'Thailand', 'trip_type' => 'beach', 'description' => 'Discover tropical islands, limestone cliffs, and a lively coastal culture.', 'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a'],
            ['name' => 'Indonesia', 'trip_type' => 'beach', 'description' => 'Explore the lush paradise of Bali and thousands of other sun-drenched islands.', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4'],
            ['name' => 'Philippines', 'trip_type' => 'beach', 'description' => 'Crystal waters, hidden lagoons, and thousands of tropical islands.', 'image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86'],
            ['name' => 'Bahamas', 'trip_type' => 'beach', 'description' => 'Endless sunshine, swimming pigs, and spectacular coral reefs.', 'image' => 'https://images.unsplash.com/photo-1542289947-0e6d548fbac2'],
            ['name' => 'Seychelles', 'trip_type' => 'beach', 'description' => 'An archipelago of timeless beauty with iconic granite boulders.', 'image' => 'https://images.unsplash.com/photo-1588722741133-c2111d4d38ff'],
            ['name' => 'Fiji', 'trip_type' => 'beach', 'description' => 'Warm hospitality and incredibly clear waters perfect for diving and relaxing.', 'image' => 'https://images.unsplash.com/photo-1557088497-767838584742'],
            ['name' => 'Mauritius', 'trip_type' => 'beach', 'description' => 'A sparkling Indian Ocean island known for its spectacular beaches and lagoons.', 'image' => 'https://images.unsplash.com/photo-1569085871261-26786aebbb24'],
            ['name' => 'Dominican Republic', 'trip_type' => 'beach', 'description' => 'Golden sands, luxurious resorts, and an unbeatable Caribbean vibe.', 'image' => 'https://images.unsplash.com/photo-1586526435334-032f2ecb42c6'],
            ['name' => 'Jamaica', 'trip_type' => 'beach', 'description' => 'Lush topography of mountains, rainforests and vibrant reef-lined beaches.', 'image' => 'https://images.unsplash.com/photo-1589133742211-e40608ed1b99'],
            ['name' => 'Barbados', 'trip_type' => 'beach', 'description' => 'Powdery white-sand beaches meeting the dramatic Atlantic surf.', 'image' => 'https://images.unsplash.com/photo-1590846200236-81cf9063bd70'],
            ['name' => 'Cuba', 'trip_type' => 'beach', 'description' => 'Warm Caribbean waters surrounding a vibrantly cultural and historic island.', 'image' => 'https://images.unsplash.com/photo-1588887955513-41a6b07de0dd'],
            ['name' => 'Sri Lanka', 'trip_type' => 'beach', 'description' => 'Golden palm-fringed beaches along a culturally rich, tropical coastline.', 'image' => 'https://images.unsplash.com/photo-1588721443697-3932e4d07b8b'],
            ['name' => 'Vietnam', 'trip_type' => 'beach', 'description' => 'Explore the dramatic limestone karsts of Ha Long Bay and endless sandy coastlines.', 'image' => 'https://images.unsplash.com/photo-1528127269322-539801943592'],
            ['name' => 'Belize', 'trip_type' => 'beach', 'description' => 'A stunning barrier reef, jungle beaches, and rich marine biodiversity.', 'image' => 'https://images.unsplash.com/photo-1596700874591-180a4b12384a'],
            ['name' => 'Honduras', 'trip_type' => 'beach', 'description' => 'Gorgeous Caribbean diving spots and idyllic sandy bay islands.', 'image' => 'https://images.unsplash.com/photo-1596700767073-674558509c2a'],
            ['name' => 'Antigua and Barbuda', 'trip_type' => 'beach', 'description' => 'Boasting a spectacular 365 beaches with fine white and pink sand.', 'image' => 'https://images.unsplash.com/photo-1591871408133-c215e47852c0'],

            // Romantic (17)
            ['name' => 'France', 'trip_type' => 'romantic', 'description' => 'The ultimate destination for romance, from the lights of Paris to the vineyards of Bordeaux.', 'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34'],
            ['name' => 'Switzerland', 'trip_type' => 'romantic', 'description' => 'Cozy up in alpine chalets and view stunning snow-capped peaks.', 'image' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99'],
            ['name' => 'Portugal', 'trip_type' => 'romantic', 'description' => 'Stroll hand-in-hand through Lisbon’s alleys and taste sweet Port wine.', 'image' => 'https://images.unsplash.com/photo-1555881400-74d7acaacd8b'],
            ['name' => 'Austria', 'trip_type' => 'romantic', 'description' => 'Experience the imperial charm of Vienna and its musical romance.', 'image' => 'https://images.unsplash.com/photo-1516550893923-42d28e5677af'],
            ['name' => 'Czech Republic', 'trip_type' => 'romantic', 'description' => 'Wander through the utterly romantic, cobblestoned streets of Prague.', 'image' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439'],
            ['name' => 'Monaco', 'trip_type' => 'romantic', 'description' => 'Unparalleled luxury and glamorous evenings on the dazzling French Riviera.', 'image' => 'https://images.unsplash.com/photo-1520623297598-c70eebd120e2'],
            ['name' => 'Saint Lucia', 'trip_type' => 'romantic', 'description' => 'A remarkably romantic Caribbean escape framing the majestic Piton mountains.', 'image' => 'https://images.unsplash.com/photo-1517700683050-25275e54d3cd'],
            ['name' => 'French Polynesia', 'trip_type' => 'romantic', 'description' => 'Overwater bungalows, turquoise lagoons, and the iconic romance of Bora Bora.', 'image' => 'https://images.unsplash.com/photo-1506012474130-179cd3638dbf'],
            ['name' => 'Croatia', 'trip_type' => 'romantic', 'description' => 'Watch the sunset over the deep blue Adriatic from medieval stone walls.', 'image' => 'https://images.unsplash.com/photo-1517904018873-1383cd89e3ec'],
            ['name' => 'Belgium', 'trip_type' => 'romantic', 'description' => 'Share incredible chocolate and cruise the incredibly romantic canals of Bruges.', 'image' => 'https://images.unsplash.com/photo-1518335359048-4395ad602058'],
            ['name' => 'Malta', 'trip_type' => 'romantic', 'description' => 'A uniquely romantic archipelago with glowing honey-colored stone architecture.', 'image' => 'https://images.unsplash.com/photo-1515902166946-f94d21eaf7ec'],
            ['name' => 'Cyprus', 'trip_type' => 'romantic', 'description' => 'The legendary birthplace of Aphrodite, featuring romantic coves and ruins.', 'image' => 'https://images.unsplash.com/photo-1555562768-4a572a15c8e2'],
            ['name' => 'San Marino', 'trip_type' => 'romantic', 'description' => 'A tiny, majestic mountaintop microstate offering unparalleled romantic views.', 'image' => 'https://images.unsplash.com/photo-1536643905591-64506f23f4ec'],
            ['name' => 'Andorra', 'trip_type' => 'romantic', 'description' => 'A peaceful mountainous retreat perfect for a cozy, romantic winter getaway.', 'image' => 'https://images.unsplash.com/photo-1563725442563-36ce3b44b822'],
            ['name' => 'Luxembourg', 'trip_type' => 'romantic', 'description' => 'Fairy-tale castles perched on cliffs and beautifully serene green valleys.', 'image' => 'https://images.unsplash.com/photo-1579728445892-0b73fcbee0fb'],
            ['name' => 'Hungary', 'trip_type' => 'romantic', 'description' => 'Evening boat cruises along the majestic Danube river in Budapest.', 'image' => 'https://images.unsplash.com/photo-1517551062060-61b9acc1ea28'],
            ['name' => 'Ireland', 'trip_type' => 'romantic', 'description' => 'Romantic, lush rolling hills, cozy pubs, and the dramatic Cliffs of Moher.', 'image' => 'https://images.unsplash.com/photo-1515091943-9def6d5ea258'],

            // Nature (17)
            ['name' => 'Canada', 'trip_type' => 'nature', 'description' => 'Experience the vast wilderness of the Rockies, emerald lakes, and lush forests.', 'image' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce'],
            ['name' => 'New Zealand', 'trip_type' => 'nature', 'description' => 'Majestic fjords, expansive glaciers, and cinematic natural landscapes.', 'image' => 'https://images.unsplash.com/photo-1469521669194-babbdf9aa987'],
            ['name' => 'Norway', 'trip_type' => 'nature', 'description' => 'Spectacular deep fjords, scenic trails, and the mystical Northern Lights.', 'image' => 'https://images.unsplash.com/photo-1520681280062-8e390234ea6a'],
            ['name' => 'Costa Rica', 'trip_type' => 'nature', 'description' => 'Rich biodiversity, tropical rainforests, and incredible wildlife.', 'image' => 'https://images.unsplash.com/photo-1519069507908-1cc68bc3eef0'],
            ['name' => 'South Africa', 'trip_type' => 'nature', 'description' => 'Stunning coastal drives and unforgettable Big Five safaris.', 'image' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5'],
            ['name' => 'Australia', 'trip_type' => 'nature', 'description' => 'The Great Barrier Reef, the vast Outback, and unique incredible wildlife.', 'image' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be'],
            ['name' => 'Brazil', 'trip_type' => 'nature', 'description' => 'The magnificent Amazon basin and breathtaking Iguazu Falls.', 'image' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325'],
            ['name' => 'Colombia', 'trip_type' => 'nature', 'description' => 'A stunning convergence of Andean peaks, Caribbean beaches, and deep jungles.', 'image' => 'https://images.unsplash.com/photo-1596701198425-c6f376a9c968'],
            ['name' => 'Uganda', 'trip_type' => 'nature', 'description' => 'Encounter magnificent mountain gorillas hidden deep in the misty forests.', 'image' => 'https://images.unsplash.com/photo-1547471080-7b2cc2ae0199'],
            ['name' => 'Rwanda', 'trip_type' => 'nature', 'description' => 'Incredible primate trekking amidst the dramatically rolling lush hills.', 'image' => 'https://images.unsplash.com/photo-1574044158428-1428a5091c6e'],
            ['name' => 'Finland', 'trip_type' => 'nature', 'description' => 'Thousands of tranquil lakes and the pristine beauty of wild Lapland.', 'image' => 'https://images.unsplash.com/photo-1520286082464-cc81315802fb'],
            ['name' => 'Sweden', 'trip_type' => 'nature', 'description' => 'Endless forests, picturesque coastal archipelagos, and the midnight sun.', 'image' => 'https://images.unsplash.com/photo-1508826620593-90d56ee2cbac'],
            ['name' => 'Slovenia', 'trip_type' => 'nature', 'description' => 'A remarkably green nation starring the serene Lake Bled and Julian Alps.', 'image' => 'https://images.unsplash.com/photo-1563177741-2b0ea2a01d67'],
            ['name' => 'Slovakia', 'trip_type' => 'nature', 'description' => 'Rugged alpine peaks of the High Tatras and intricate cave systems.', 'image' => 'https://images.unsplash.com/photo-1558712395-5cbcf22502c3'],
            ['name' => 'Romania', 'trip_type' => 'nature', 'description' => 'The wild Carpathian mountains, dense forests, and the Danube Delta.', 'image' => 'https://images.unsplash.com/photo-1560946059-4fa22d0abf90'],
            ['name' => 'Bulgaria', 'trip_type' => 'nature', 'description' => 'Stunning Balkan mountain ranges and pristine natural lakes.', 'image' => 'https://images.unsplash.com/photo-1564552084428-f60bb116b0a1'],
            ['name' => 'Serbia', 'trip_type' => 'nature', 'description' => 'Untamed rivers, deep gorges, and spectacularly rich national parks.', 'image' => 'https://images.unsplash.com/photo-1540324888924-d2e8251e06c1'],

            // Shopping (17)
            ['name' => 'UAE', 'trip_type' => 'shopping', 'description' => 'Shop till you drop in the ultra-modern, gigantic luxury malls of Dubai.', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c'],
            ['name' => 'USA', 'trip_type' => 'shopping', 'description' => 'From the boutiques of New York to expansive outlets across the nation.', 'image' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b'],
            ['name' => 'South Korea', 'trip_type' => 'shopping', 'description' => 'Trendy boutiques of Seoul, cutting-edge cosmetics, and night markets.', 'image' => 'https://images.unsplash.com/photo-1517154421773-0529f29ea451'],
            ['name' => 'Singapore', 'trip_type' => 'shopping', 'description' => 'Premium retail therapy along Orchard Road and futuristic shopping centers.', 'image' => 'https://images.unsplash.com/photo-1525625293386-3f8f99389edd'],
            ['name' => 'Malaysia', 'trip_type' => 'shopping', 'description' => 'Massive mega-malls and vibrant street markets pulsating with energy.', 'image' => 'https://images.unsplash.com/photo-1520190282873-afebe6bcea6a'],
            ['name' => 'Hong Kong', 'trip_type' => 'shopping', 'description' => 'A dizzying mix of bespoke tailoring, luxury brand flagships, and markets.', 'image' => 'https://images.unsplash.com/photo-1505706240228-568ebba4eb9e'],
            ['name' => 'Qatar', 'trip_type' => 'shopping', 'description' => 'Extravagant shopping experiences blending modern luxury and traditional souqs.', 'image' => 'https://images.unsplash.com/photo-1538356111053-748a31e87396'],
            ['name' => 'Kuwait', 'trip_type' => 'shopping', 'description' => 'Some of the largest and most opulent shopping malls in the entire Middle East.', 'image' => 'https://images.unsplash.com/photo-1513076135-2665e8aeb9be'],
            ['name' => 'Bahrain', 'trip_type' => 'shopping', 'description' => 'Luxurious modern arcades alongside ancient alleys filled with gold.', 'image' => 'https://images.unsplash.com/photo-1582035919429-281b37dd1bd7'],
            ['name' => 'Taiwan', 'trip_type' => 'shopping', 'description' => 'Exhilarating night markets, cutting-edge electronics, and fashion.', 'image' => 'https://images.unsplash.com/photo-1552993873-0aa11af15668'],
            ['name' => 'Macau', 'trip_type' => 'shopping', 'description' => 'Grand casino resort shopping promenades featuring high-end global fashion.', 'image' => 'https://images.unsplash.com/photo-1583210404098-b807aa3c62a8'],
            ['name' => 'Panama', 'trip_type' => 'shopping', 'description' => 'The massive shopping hub of the Americas with duty-free luxury goods.', 'image' => 'https://images.unsplash.com/photo-1522201479-798edec86407'],
            ['name' => 'Saudi Arabia', 'trip_type' => 'shopping', 'description' => 'Gargantuan, extravagant malls reflecting the pinnacle of retail luxury.', 'image' => 'https://images.unsplash.com/photo-1550508007-cc090f4886e4'],
            ['name' => 'Lebanon', 'trip_type' => 'shopping', 'description' => 'The fashion capital of the Middle East, balancing couture and antiquity.', 'image' => 'https://images.unsplash.com/photo-1550978805-4c6e913aebf9'],
            ['name' => 'Oman', 'trip_type' => 'shopping', 'description' => 'Exquisite traditional souqs packed with frankincense, silver, and textiles.', 'image' => 'https://images.unsplash.com/photo-1537824598505-99ee03483384'],
            ['name' => 'Brunei', 'trip_type' => 'shopping', 'description' => 'Opulent commercial centers offering a calm, tax-free retail experience.', 'image' => 'https://images.unsplash.com/photo-1520190282873-afebe6bcea6a'],
            ['name' => 'Netherlands', 'trip_type' => 'shopping', 'description' => 'Quirky boutiques lining Amsterdam’s scenic and iconic nine streets.', 'image' => 'https://images.unsplash.com/photo-1512470876311-b1e0750fb578'],
        ];

        $insertData = [];
        foreach ($countries as $country) {
            $insertData[] = [
                'name' => $country['name'],
                'trip_type' => $country['trip_type'],
                'description' => $country['description'],
                // Apply unsplash parameters for unified high quality placeholders
                'image' => $country['image'] . '?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Chunking the insert to avoid too many prepared statements limit in PHP/PDO 
        $chunks = array_chunk($insertData, 50);
        foreach ($chunks as $chunk) {
            DB::table('countries')->insert($chunk);
        }
    }
}
