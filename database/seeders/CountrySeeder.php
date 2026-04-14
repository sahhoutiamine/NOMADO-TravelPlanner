<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('countries')->truncate();
        Schema::enableForeignKeyConstraints();

        $countries = [
            [
                'name' => 'Japan',
                'description' => 'Japan is a fascinating country that seamlessly blends ancient traditions with futuristic technology. From the neon-lit streets of Tokyo to the serene temples of Kyoto, visitors can experience a unique culture that has evolved over thousands of years. The country is known for its exquisite cuisine, including sushi, ramen, and tempura, as well as its beautiful cherry blossoms in spring. Japan offers stunning natural landscapes, from the Japanese Alps to tropical beaches in Okinawa. The Japanese people are known for their politeness, hospitality, and dedication to craftsmanship. Whether you\'re interested in history, technology, nature, or food, Japan offers an unforgettable travel experience that will leave you wanting to return again and again.',
                'image' => 'https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Italy',
                'description' => 'Italy is a country that needs no introduction, famous for its rich history, art, architecture, and cuisine that has influenced the world. From the ancient ruins of Rome, including the Colosseum and Roman Forum, to the Renaissance masterpieces in Florence, Italy is an open-air museum. The romantic canals of Venice, the stunning Amalfi Coast, and the beautiful lakes of northern Italy offer breathtaking scenery. Italian cuisine varies by region, from pizza in Naples to pasta in Bologna and gelato everywhere. The country is also home to the smallest country in the world, Vatican City, with St. Peter\'s Basilica and the Sistine Chapel. With its warm climate, friendly people, and dolce vita lifestyle, Italy captures the hearts of millions of visitors each year.',
                'image' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thailand',
                'description' => 'Thailand, known as the "Land of Smiles," is a Southeast Asian gem that offers incredible value for travelers. The country is famous for its golden temples, royal palaces, and vibrant street food culture. Bangkok, the capital, is a bustling metropolis with floating markets, ornate shrines, and a legendary nightlife. In the north, Chiang Mai offers a more relaxed atmosphere with ancient temples, elephant sanctuaries, and lush jungles perfect for trekking. The southern islands, including Phuket, Koh Samui, and Krabi, boast some of the world\'s most beautiful beaches with crystal-clear waters and limestone cliffs. Thai cuisine is world-renowned for its balance of sweet, sour, salty, and spicy flavors. With its affordable prices, friendly locals, and diverse landscapes, Thailand remains one of the most visited countries in the world.',
                'image' => 'https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'France',
                'description' => 'France is synonymous with romance, culture, gastronomy, and art de vivre. Paris, the City of Light, captivates visitors with the Eiffel Tower, Louvre Museum, Notre-Dame Cathedral, and charming cafes along the Seine. Beyond Paris, the country offers diverse landscapes: the lavender fields of Provence, the glamorous French Riviera, the wine regions of Bordeaux and Burgundy, the stunning castles of the Loire Valley, and the majestic peaks of the French Alps. French cuisine is UNESCO-recognized, from croissants and baguettes to escargots and coq au vin, complemented by world-class wines and cheeses. France is also a shopper\'s paradise with high fashion houses, luxury boutiques, and quaint village markets. With its rich history, artistic heritage, and sophisticated culture, France continues to be the world\'s top tourist destination.',
                'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Australia',
                'description' => 'Australia is a vast continent-country known for its unique wildlife, stunning natural landscapes, and laid-back lifestyle. From the iconic Sydney Opera House and Harbour Bridge to the ancient rainforests of Queensland, Australia offers incredible diversity. The Great Barrier Reef, the world\'s largest coral reef system, is a paradise for divers and snorkelers. The Outback, with its red deserts, Uluru (Ayers Rock), and Aboriginal rock art, offers a spiritual journey into the world\'s oldest living culture. Coastal cities like Melbourne, known for its coffee culture and street art, and Perth, with its pristine beaches, offer urban adventures. Australia is home to unique animals found nowhere else, including kangaroos, koalas, platypuses, and wombats. With its outdoor lifestyle, friendly people, and year-round sunshine, Australia is perfect for adventure seekers and nature lovers.',
                'image' => 'https://images.unsplash.com/photo-1523482580672-f109ba8cb9be?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Brazil',
                'description' => 'Brazil is South America\'s largest country, famous for its vibrant culture, passionate soccer fans, and stunning natural wonders. Rio de Janeiro welcomes visitors with Christ the Redeemer atop Corcovado Mountain, Sugarloaf Mountain, and the iconic beaches of Copacabana and Ipanema. The Amazon Rainforest, often called the "lungs of the Earth," covers much of northern Brazil and offers unparalleled biodiversity and jungle adventures. Iguazu Falls, one of the world\'s most spectacular waterfall systems, straddles the border with Argentina. Salvador and Recife showcase Afro-Brazilian culture, colonial architecture, and capoeira. Brazil is also the birthplace of samba, bossa nova, and the world-famous Carnival celebration in Rio and Salvador. With its warm climate, beautiful people, and contagious energy, Brazil offers an unforgettable South American experience.',
                'image' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'India',
                'description' => 'India is a land of incredible diversity, where ancient traditions coexist with rapid modernization. From the majestic Taj Mahal in Agra to the bustling streets of Mumbai, India overwhelms the senses with its colors, sounds, and aromas. The country offers diverse landscapes: the Himalayan mountains in the north, tropical beaches in Goa and Kerala, the Thar Desert in Rajasthan, and backwaters in the south. India\'s spiritual heritage is evident in its countless temples, mosques, gurdwaras, and churches. The cuisine varies dramatically by region, from fiery curries in the south to Mughlai kebabs in the north. India is also known for its festivals, including Diwali, Holi, and Durga Puja, which showcase the country\'s joyous spirit. With its rich history, warm hospitality, and incredible value, India offers a transformative travel experience.',
                'image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Canada',
                'description' => 'Canada is a vast country known for its stunning natural beauty, friendly people, and multicultural cities. The Canadian Rockies, with Banff and Jasper National Parks, offer breathtaking mountain scenery, turquoise lakes, and abundant wildlife. Vancouver, nestled between mountains and ocean, offers outdoor activities year-round. Toronto, Canada\'s largest city, boasts the iconic CN Tower and diverse neighborhoods. Montreal and Quebec City showcase French-Canadian culture with their European charm, cobblestone streets, and incredible cuisine. The country is also known for its Northern Lights, especially in Yukon and the Northwest Territories. Canada\'s east coast offers picturesque fishing villages, whale watching, and the Cabot Trail in Nova Scotia. With its clean cities, safe environment, and friendly locals, Canada welcomes millions of visitors each year.',
                'image' => 'https://images.unsplash.com/photo-1503614472-8c93d56e92ce?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Morocco',
                'description' => 'Morocco is a North African country that offers a sensory overload of colors, spices, and sounds. From the bustling medinas of Marrakech and Fes to the Sahara Desert\'s golden dunes, Morocco transports visitors to another world. The country\'s architecture is stunning, with intricate Islamic geometric patterns, riads (traditional houses with interior gardens), and beautiful mosques. Moroccan cuisine is world-famous, including tagines, couscous, mint tea, and pastilla. The Atlas Mountains offer trekking opportunities and Berber village visits. Coastal cities like Essaouira and Casablanca offer relaxation by the Atlantic. Morocco\'s souks (markets) are a shopper\'s paradise, selling everything from spices and carpets to lanterns and leather goods. With its warm hospitality, exotic atmosphere, and proximity to Europe, Morocco is a gateway to Africa that never disappoints.',
                'image' => 'https://images.unsplash.com/photo-1489749798305-4fea3ae63d43?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spain',
                'description' => 'Spain is a country of passion, known for its flamenco music and dance, bullfighting, beautiful beaches, and delicious tapas. Barcelona showcases the unique architecture of Antoni Gaudí, including the unfinished Sagrada Família and Park Güell. Madrid, the capital, boasts world-class art museums like the Prado and Reina Sofía, as well as vibrant nightlife. Seville, with its Alcázar palace and Gothic cathedral, embodies Andalusian culture. Granada is home to the Alhambra, a stunning Moorish palace overlooking the city. The Mediterranean coast, including the Costa del Sol and Costa Brava, offers beautiful beaches and resorts. Spain is also famous for its festivals, including La Tomatina (tomato fight) and the Running of the Bulls in Pamplona. Spanish cuisine, from paella to jamón ibérico, is celebrated worldwide. With its warm climate, rich history, and lively culture, Spain captivates all who visit.',
                'image' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Greece',
                'description' => 'Greece is the cradle of Western civilization, famous for its ancient history, stunning islands, and Mediterranean cuisine. Athens, the capital, is home to the Acropolis and Parthenon, as well as the Ancient Agora and Temple of Olympian Zeus. The Greek islands, including Santorini, Mykonos, Crete, and Rhodes, offer white-washed buildings, blue-domed churches, and crystal-clear waters. Greece has over 6,000 islands, each with its own character. The country is also known for its delicious food, including moussaka, souvlaki, Greek salad, and feta cheese, often accompanied by ouzo or local wine. Greek hospitality, or "philoxenia," is legendary. The beaches in Greece are among the most beautiful in the world, with golden sands and turquoise waters. Whether you\'re interested in history, island hopping, or simply relaxing by the sea, Greece offers an idyllic Mediterranean escape.',
                'image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Zealand',
                'description' => 'New Zealand is a country of breathtaking landscapes, from snow-capped mountains and fjords to golden beaches and lush rainforests. The South Island is famous for the Southern Alps, including Aoraki Mount Cook, the highest peak. Queenstown, the adventure capital of the world, offers bungee jumping, skydiving, and jet boating. Milford Sound, with its dramatic cliffs and waterfalls, is often described as the eighth wonder of the world. The North Island features geothermal wonders in Rotorua, the black sand beaches of Auckland\'s west coast, and the glowworm caves of Waitomo. New Zealand is also known for its Maori culture, which adds a unique dimension to the country\'s identity. The country gained international fame as the filming location for The Lord of the Rings and The Hobbit trilogies. With its friendly people, outdoor lifestyle, and stunning scenery, New Zealand is a paradise for nature lovers and adventure seekers.',
                'image' => 'https://images.unsplash.com/photo-1507699622108-4be3abd695ad?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Egypt',
                'description' => 'Egypt is a country that conjures images of ancient pharaohs, mighty pyramids, and the life-giving Nile River. The Pyramids of Giza, the last surviving wonder of the ancient world, continue to amaze visitors with their scale and precision. The Great Sphinx stands guard nearby. Cairo, the bustling capital, is home to the Egyptian Museum, which houses the treasures of Tutankhamun. Luxor, often called the world\'s greatest open-air museum, features the Valley of the Kings, Karnak Temple, and Luxor Temple. A Nile cruise between Luxor and Aswan offers a relaxing way to see ancient temples and rural Egyptian life. The Red Sea resorts of Hurghada and Sharm el-Sheikh offer world-class diving and snorkeling in crystal-clear waters. Egyptian cuisine, including koshari, falafel, and molokhia, reflects the country\'s diverse influences. With its ancient wonders, warm climate, and welcoming people, Egypt offers a journey through time like no other.',
                'image' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mexico',
                'description' => 'Mexico is a country rich in culture, history, and natural beauty, from ancient Mayan and Aztec ruins to beautiful colonial cities and stunning beaches. The Yucatán Peninsula is home to Chichen Itza, one of the New Seven Wonders of the World, as well as Tulum and Uxmal. Cancun and the Riviera Maya offer white-sand beaches, turquoise waters, and world-class resorts. Mexico City, one of the world\'s largest cities, boasts the historic Zócalo, the National Palace with Diego Rivera murals, and the Frida Kahlo Museum. Oaxaca and Puebla are known for their colonial architecture, vibrant markets, and delicious regional cuisines. Mexican cuisine, including tacos, tamales, mole, and tequila, is UNESCO-recognized. The country celebrates vibrant festivals like Day of the Dead (Día de los Muertos) and Cinco de Mayo. With its warm people, rich traditions, and diverse landscapes, Mexico offers an authentic and unforgettable Latin American experience.',
                'image' => 'https://images.unsplash.com/photo-1512813195386-60cf811b74a2?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Germany',
                'description' => 'Germany is a country of contrasts, from historic medieval towns and fairy-tale castles to modern, cutting-edge cities. Berlin, the capital, is a city of history and creativity, with remnants of the Berlin Wall, the Brandenburg Gate, and world-class museums on Museum Island. Munich, in Bavaria, is famous for Oktoberfest, beer gardens, and the beautiful English Garden. The Romantic Road takes visitors through picturesque towns like Rothenburg ob der Tauber and Füssen, home to Neuschwanstein Castle, which inspired Disney\'s Sleeping Beauty Castle. The Black Forest offers hiking trails, cuckoo clocks, and the delicious Black Forest cake. Cologne\'s Gothic cathedral is a masterpiece of medieval architecture. Germany is also known for its automotive heritage, with museums from Mercedes-Benz, BMW, and Porsche. German cuisine, including bratwurst, schnitzel, sauerkraut, and pretzels, is hearty and satisfying, best enjoyed with German beer or Riesling wine. With its efficient infrastructure, rich history, and vibrant culture, Germany is a fantastic European destination.',
                'image' => 'https://images.unsplash.com/photo-1467269204594-9661b134dd2b?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'South Africa',
                'description' => 'South Africa is a country of extraordinary diversity, offering everything from safari adventures to cosmopolitan cities and stunning coastlines. Kruger National Park is one of Africa\'s premier safari destinations, home to the Big Five (lion, leopard, elephant, rhino, and buffalo) and countless other species. Cape Town, with Table Mountain as its backdrop, offers beautiful beaches, the historic Robben Island where Nelson Mandela was imprisoned, and the colorful Bo-Kaap neighborhood. The Garden Route, along the southern coast, features lush forests, lagoons, and picturesque towns like Knysna and Plettenberg Bay. The Winelands around Stellenbosch and Franschhoek produce world-class wines. South Africa also has a complex but inspiring history, from apartheid to the presidency of Nelson Mandela, explored at the Apartheid Museum in Johannesburg. With its diverse landscapes, rich wildlife, and resilient people, South Africa offers an unforgettable journey to the tip of Africa.',
                'image' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United Kingdom',
                'description' => 'The United Kingdom is a country steeped in history, from ancient Roman ruins to medieval castles and modern cultural landmarks. London, the capital, is a global city with iconic sights like Big Ben, the Houses of Parliament, the Tower of London, Buckingham Palace, and the London Eye. The British Museum houses priceless artifacts including the Rosetta Stone and Egyptian mummies. Beyond London, the UK offers diverse landscapes: the Scottish Highlands with their rugged beauty and Loch Ness, the Lake District with its stunning scenery that inspired poets, the Welsh mountains and coastline, and the white cliffs of Dover. Historical cities like Edinburgh, with its castle and Royal Mile, Bath with its Roman baths, Oxford and Cambridge with their prestigious universities, and York with its medieval walls and Viking history offer rich cultural experiences. British cuisine has undergone a renaissance, with traditional dishes like fish and chips, Sunday roast, and afternoon tea alongside innovative modern cooking. With its rich history, cultural institutions, and charming countryside, the United Kingdom continues to fascinate visitors from around the world.',
                'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Turkey',
                'description' => 'Turkey is a transcontinental country bridging Europe and Asia, offering a fascinating blend of cultures, history, and natural beauty. Istanbul, the former capital of the Byzantine and Ottoman Empires, straddles the Bosphorus Strait and boasts iconic landmarks like the Hagia Sophia, Blue Mosque, Topkapi Palace, and Grand Bazaar. Cappadocia, in central Anatolia, is famous for its fairy chimneys, cave dwellings, and hot air balloon rides over otherworldly landscapes. Pamukkale, meaning "cotton castle" in Turkish, features white terraces of thermal springs. The Mediterranean and Aegean coasts offer beautiful beaches, ancient ruins like Ephesus and Troy, and charming towns like Bodrum and Antalya. Turkish cuisine is delicious and diverse, from kebabs and mezes to baklava and Turkish delight, accompanied by strong Turkish coffee or çay (tea). The Turkish people are known for their hospitality. With its rich history, stunning landscapes, and unique position between East and West, Turkey offers a truly unique travel experience.',
                'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indonesia',
                'description' => 'Indonesia is an archipelago of over 17,000 islands, offering incredible diversity in culture, landscapes, and experiences. Bali, the most famous island, is known as the "Island of the Gods" for its beautiful beaches, lush rice terraces, volcanic mountains, and thousands of temples. Jakarta, the capital on Java, is a bustling megacity with a vibrant nightlife, shopping malls, and cultural sites like the National Monument and Istiqlal Mosque. Yogyakarta, also on Java, is the cultural heart of Indonesia, home to the magnificent Buddhist temple Borobudur and the Hindu temple Prambanan, both UNESCO World Heritage sites. Komodo Island is home to the famous Komodo dragons, the world\'s largest lizards. Sumatra offers orangutan trekking in Bukit Lawang and Lake Toba, a massive volcanic lake. Raja Ampat, in West Papua, is one of the world\'s best diving destinations with incredible marine biodiversity. Indonesian cuisine is diverse and flavorful, with dishes like nasi goreng (fried rice), satay, gado-gado, and rendang. With its warm people, beautiful landscapes, and rich culture, Indonesia offers endless possibilities for adventure.',
                'image' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Portugal',
                'description' => 'Portugal is a country with a glorious past, having once built a vast maritime empire. Today, it offers visitors beautiful beaches, historic cities, delicious cuisine, and warm hospitality. Lisbon, the hilly capital, charms visitors with its pastel-colored buildings, historic trams (particularly Tram 28), the Belém Tower, Jerónimos Monastery, and the beautiful views from São Jorge Castle. Porto, in the north, is famous for its port wine cellars across the Douro River, the medieval Ribeira district, and the stunning Livraria Lello bookstore. The Algarve, in the south, attracts sun-seekers with its golden beaches, dramatic sea caves, and golf courses. The country is also known for its fado music, a soulful genre expressing longing and melancholy. Portuguese cuisine features fresh seafood, particularly bacalhau (salted cod), pastéis de nata (custard tarts), and grilled sardines. The country is one of the oldest in Europe, with its borders established in 1139. With its affordable prices, friendly people, and beautiful landscapes, Portugal has become one of Europe\'s most popular destinations.',
                'image' => 'https://images.unsplash.com/photo-1516483638261-f4dbaf036963?w=1200',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        if (!empty($countries)) {
            DB::table('countries')->insert($countries);
        }
    }
}