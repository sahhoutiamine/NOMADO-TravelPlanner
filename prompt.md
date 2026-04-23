You are working on NOMADO, a Laravel 11 travel planner app. I need you to implement a major feature upgrade to the trip results page and booking flow. Here is the full context and requirements:

PROJECT CONTEXT
Stack: Laravel 11, Blade, Tailwind CSS, vanilla JS (no Alpine, no Vue, no React)

Key Models & DB Schema:

countries — id, name, description, image, cardinals (cardinals = "lat,lng" string e.g. "48.8566,2.3522")

cities — id, country_id, name, trip_type, description, image

hotels — id, city_id, name, price_per_night, description, image, type, localisation, contact_number, email

places — id, city_id, name, description, image, localisation, min_price (min_price = minimum cost in € to visit this place)

bookings — id, user_id, city_id, hotel_id, departure_city_id, trip_type, budget_total, duration, passengers, flight_budget, hotel_budget, activities_budget, misc_budget, total_price, status
 
payments — id, user_id, booking_id, start_date, departure_country, departure_city, is_flight_paid, is_hotel_paid, airline, flight_departure, flight_arrival, flight_duration

Relations: Country → hasMany Cities → hasMany Hotels, hasMany Places

Current flow: User fills form (trip_type, budget, duration, passengers, departure_city_id) → TripGeneratorController@generate returns results.blade.php with 3 trip options → User confirms → booking saved → payment page.

FEATURE 1 — Dynamic Results Page (results.blade.php)
Transform the static results page into a fully interactive trip builder. For each of the 3 trip options:

1A — Hotel Selection (Optional)
Add a toggle switch "Include Hotel?" (default: ON)

When ON: show a hotel selector — a horizontal scrollable list of ALL hotels in that city (not just the one auto-selected). Each hotel card shows: name, image, type badge, price_per_night. The currently selected hotel is highlighted.

When the user clicks a different hotel, it becomes selected and the budget recalculates instantly.

When OFF: hotel cost = 0, hotel_budget = 0, the accommodation progress bar disappears.

1B — Places Selection (Dynamic)
Below the hotel section, show all places belonging to that city.

Each place card shows: image, name, description snippet, min_price badge (e.g. "From €25").

Places are checkboxes — user can select/deselect any combination.

The sum of selected min_price values is added to the activities_budget line.

If total selected places cost exceeds the activities budget, show a warning: "⚠️ Places cost exceeds your activities budget by €X".

1C — Live Budget Bar
The right sidebar budget panel must update in real-time (no page reload) whenever:

Hotel is toggled on/off

A different hotel is selected

Places are checked/unchecked

The budget breakdown recalculates as:

hotel_cost = (selected_hotel.price_per_night × duration × passengers) if hotel included, else 0
places_cost = sum of selected places min_price × passengers
remaining = budget_total - hotel_cost
flight_budget = remaining × 0.30
activities_budget = (remaining × 0.50) — but display places_cost separately as "Selected Places"
misc_budget = remaining × 0.20
total_displayed = hotel_cost + places_cost + flight_budget + misc_budget

Copy
Animate the number changes (count-up animation, same style as existing code).
Animate the progress bar widths with CSS transitions.

1D — Confirm Form
The hidden form inputs must be updated dynamically before submission to reflect the user's current selections (selected hotel_id, whether hotel is included, selected place IDs as a comma-separated string, and all recalculated budget values).

FEATURE 2 — Trip Plan Generator
2A — New Route & Controller Method
Add a route: GET /bookings/{id}/plan → BookingController@plan (or a new TripPlanController)

2B — Flight Duration Calculation
Calculate flight duration using the Haversine formula based on:

Departure: departure_city → city → country → cardinals (lat,lng string, parse it)

Destination: booking → city → country → cardinals

function haversineDistance(string $from, string $to): float {
    [$lat1, $lng1] = array_map('floatval', explode(',', $from));
    [$lat2, $lng2] = array_map('floatval', explode(',', $to));
    $R = 6371; // Earth radius km
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat/2)**2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) \* sin($dLng/2)**2;
return $R * 2 * atan2(sqrt($a), sqrt(1-$a));
}
// Average commercial flight speed: 900 km/h
$flightHours = $distanceKm / 900;

Copy
Format as: "Xh Ym" (e.g. "2h 15m")

2C — Plan Generation Logic
Given a booking with duration days and the city's places (ordered by min_price ASC):

Day 1: ✈️ Flight from [departure_city] to [destination_city] — [duration] (e.g. "2h 30m")
Day 2: 🏨 Check-in at [hotel_name] — Rest & settle in
Days 3 to (duration-1): Distribute places evenly (1-2 places per day)
→ Each day entry: "📍 [Place Name] — [place.description snippet, max 100 chars] — From €[min_price]"
→ If no places left, fill with: "🗺️ Free exploration day in [city_name]"
Last day: ✈️ Return flight to [departure_city] — [same flight duration]

Copy
If duration <= 2, show only flight days.

2D — Plan View (bookings/plan.blade.php)
Create a beautiful Blade view matching the existing design system (glass-card, text-gradient, same Tailwind classes). The plan is displayed as a vertical timeline:

Each day is a timeline node with: day number circle, icon, title, description

Day 1 and last day use a blue/indigo flight color scheme

Hotel check-in day uses an amber color scheme

Place visit days use emerald/green color scheme

Free days use slate color scheme

Add a "Print / Save as PDF" button that calls window.print().

Add a back button to bookings.show.

Also add a "View Trip Plan" button on bookings/show.blade.php (visible for both pending and paid bookings, placed near the existing action buttons).

FEATURE 3 — DB & Model Updates
3A — Booking model
Add selected_place_ids (nullable text, comma-separated) and include_hotel (boolean, default true) to the bookings table via a new migration. Update the Booking model $fillable.

3B — Seeder update
Ensure countries.cardinals is populated for all seeded countries in CountrySeeder using real approximate coordinates (e.g. France: "46.2276,2.2137", Morocco: "31.7917,-7.0926").

CONSTRAINTS
No external JS libraries (no jQuery, no Alpine, no Vue) — use vanilla JS only

Keep the existing design language: glass-card, text-gradient, animate-slide-right/left, budget-progress CSS classes

All JS for the dynamic budget must be inline in the Blade file (same pattern as existing code)

The plan generation is pure PHP — no AI API calls

Reuse existing Blade components (x-input-error, etc.)

Follow existing controller patterns (Auth check via where('user_id', auth()->id()))

The TripGeneratorController@confirm must be updated to also save selected_place_ids and include_hotel

DELIVERABLES (in order)
Migration: add_plan_fields_to_bookings_table

Updated Booking model

Updated TripGeneratorController@confirm

Updated results.blade.php (full file) with all dynamic JS

New TripPlanController (or method in existing controller) with Haversine logic

New route in web.php

New bookings/plan.blade.php (full file)

Updated bookings/show.blade.php — add "View Trip Plan" button only

Updated CountrySeeder with cardinals
