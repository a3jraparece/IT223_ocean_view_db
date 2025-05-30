<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Resort;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as FakerFactory;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */




    public function run(): void
    {

        $faker = FakerFactory::create();

        function getRandomAmenities(array $all_amenities): string
        {
            $count = rand(10, 15);
            $selected = (array)array_rand(array_flip($all_amenities), $count);
            return implode(' | ', $selected);
        }

        $all_amenities = [
            'Free WiFi',
            'Air Conditioning',
            'Balcony',
            'Sea View',
            'Room Service',
            'Flat Screen TV',
            'Mini Bar',
            'Coffee Maker',
            'Safe Box',
            'Hair Dryer',
            'Daily Housekeeping',
            'Private Bathroom',
            'Shower',
            'Bathtub',
            'Toiletries',
            'Iron',
            'Desk',
            'Telephone',
            'Wake-up Service',
            'Laundry Service',
            'Complimentary Breakfast',
            'Free Parking',
            'Swimming Pool Access',
            'Gym Access',
            'Spa Access',
            'Airport Shuttle',
            '24-hour Front Desk',
            'Non-smoking Rooms',
            'Beach Access',
            'Pet Friendly',
            'Kitchenette',
            'Refrigerator',
            'Microwave',
            'Electric Kettle',
            'Dining Area',
            'Sofa',
            'Heating',
            'Soundproof Rooms',
            'Blackout Curtains',
            'Cable Channels',
            'Safe Deposit Box',
            'Terrace',
            'Garden View',
            'Daily Newspaper',
            'Valet Parking',
            'Massage Services',
            'Bicycle Rental',
            'Car Rental',
            'Luggage Storage',
            'Currency Exchange',
            'Fitness Center',
            'Children’s Play Area'
        ];

        $random_room_links = [
            'https://www.xotels.com/wp-content/uploads/2022/07/Resort-room-xotels-hotel-management-company.webp',
            'https://cf.bstatic.com/xdata/images/hotel/max1024x768/388663972.jpg?k=5c20cf08ddea443267e7627b43400c10e31519f4057bb96d2cc003893b1aed35&o=&hp=1',
            'https://bythesea.com.ph/images/rooms/328090920181536500383.jpg',
            'https://www.cvent.com/sites/default/files/styles/focus_scale_and_crop_800x450/public/image/2021-10/hotel%20room%20with%20beachfront%20view.jpg?h=662a4f7c&itok=7Laa3LkQ',
            'https://beresortmactan.com/wp-content/uploads/2019/09/roomsBanner.jpg',
            'https://d39miauuw5ic1z.cloudfront.net/images/Home/Rooms/bedroom_with_wooden_design_in_annai_resorts.jpg',
            'https://www.bwplusivywall-panglao.com/wp-content/uploads/2020/01/Family-Room.jpg',
            'https://i0.wp.com/theluxurytravelexpert.com/wp-content/uploads/2014/04/star-sanctuary-jade-mountain-st-lucia.jpg?ssl=1',
            'https://q-xx.bstatic.com/xdata/images/xphoto/608x352/45450084.webp?k=2ae8e4858809ea16a1f25723d8473a56dabd2216cbddc4562d1711431fbe6669&o=',
            'https://www.bohol.ph/pics/large/Room.jpg',
            'https://beachresort.dawal.com.ph/wp-content/uploads/2021/10/SINGLE-UNIT-BEDROOM-OPTION-1-scaled.jpg',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEc_qdUXpceZcvLtjSSktz3609Lb7dgRkbGA&s',
            'https://beresortmactan.com/wp-content/uploads/2019/09/BE-Cool-with-View_little.jpg',
            'https://www.thunderbird-asia.com/wp-content/uploads/2017/11/Rizal-Rizal-Deluxe-Room-COVER-ROOM-DETAIL-rooms-and-villas_preview-min.jpeg',
            'https://cdn1.parksmedia.wdprapps.disney.com/resize/mwImage/1/900/450/75/vision-dam/digital/parks-platform/parks-global-assets/disney-world/resorts/caribbean-beach-resort/room/d8/l/room-d8-00-16x9.jpg?2023-09-29T19:52:34+00:00',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcREP2zosB2Yfzv0poIXRSHREnHLU7DoiQAgoQ&s',
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-nIB1b_wAT6zeG_SwEJ4jef7LXPxCQjgF4A&s',
            'https://www.redrockresort.com/wp-content/uploads/2020/04/RR-King-Bedroom.jpg',
            'https://haspcms-chroma-hospitality.s3.ap-southeast-1.amazonaws.com/JSNY3C5jCYRLJw4CxZbF4qXZwl1lij-metacGljMi53ZWJw-.webp?w=1080&q=100',
            'https://q-xx.bstatic.com/xdata/images/hotel/max500/608424271.jpg?k=626e3329d89e9c947109c238626260adc75002411004bcee76e39b7940186095&o=',
            'https://passport-cdn.kiwicollection.com/blog/drive/uploads/2021/02/104870-33-CC_MalPais1-693x390.jpg',
            'https://www.seacrestmyrtlebeachresort.com/wp-content/uploads/2021/10/ieS2bh9Q-scaled.jpeg',
            'https://media.istockphoto.com/id/1299710067/photo/double-bedroom-with-sea-view.jpg?s=612x612&w=0&k=20&c=LPNC-aqrsOsgxU8eqPcR38ACIOIjqAmh0VSKclIa2gs=',
            'https://media.cnn.com/api/v1/images/stellar/prod/160920113053-beachfront-hotel-20-resort-at-pedregal-2.jpg?q=w_1900,h_1069,x_0,y_0,c_fill',
            'https://tagresorts.com.ph/wp-content/uploads/elementor/thumbs/IMG_3630-r3reaexgqtgbt4tzyffhrr37st4sm6u2s7n0ei7xna.jpg',
            'https://cdn1.parksmedia.wdprapps.disney.com/resize/mwImage/1/900/450/75/vision-dam/digital/parks-platform/parks-global-assets/disney-world/resorts/disneys-contemporary-resort/standard-room/contemporary-resort-cf/room-cf-g00-16x9.jpg?2022-10-12T16:35:02+00:00',
            'https://www.area83.in/ElementImages/5bf8a789-2234-4321-921d-da46e0660d3b_rgallery.jpg',
            'https://media.cntraveler.com/photos/6583229cb5aa398657c3dd59/master/w_1600%2Cc_limit/The%2520retreat%2520costa%2520rica_TRCR_Luxury%2520Loft_4.jpg',
            'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/03/75/0e/bc/camayan-beach-resort.jpg?w=900&h=500&s=1',
            'https://www.disneytouristblog.com/wp-content/uploads/2021/12/under-sea-little-mermaid-hotel-room-caribbean-beach-resort-disney-world-315.jpg'
        ];


        // $buildings = Building::all();
        $buildings = Building::with('resort')->get();
        $room_types = RoomType::all();

        foreach ($buildings as $building) {
            $floor_count = $building['floor_count'];
            $room_per_floor = $building['room_per_floor'];

            for ($i = 1; $i <= $floor_count; $i++) {
                for ($j = 1; $j <= $room_per_floor; $j++) {
                    $random_room_type = $room_types->random();
                    Room::create([
                        'building_id' => $building['id'],
                        'resort_id' => $building['resort']['id'],
                        'room_type_id' => $random_room_type->id,
                        'room_name' => $this->getAcronym($building['name']) . ' ' . $i . '-' . $j,
                        'room_image' => $random_room_links[$faker->numberBetween(0, count($random_room_links) - 1)], // replace with your actual image logic or random URL
                        'description' => 'A cozy room with all modern amenities to ensure a comfortable stay.',
                        'inclusions' => getRandomAmenities($all_amenities),
                        'amenities' => getRandomAmenities($all_amenities),
                        'price_per_night' => $random_room_type->base_price,
                        'is_available' => 0,
                    ]);
                }
            }
        }
    }

    public function getAcronym($string)
    {
        $words = preg_split('/\s+/', trim($string));
        $acronym = "";

        foreach ($words as $word) {
            // if (ctype_alpha($word[0])) { // Ensure it's a letter
            $acronym .= strtoupper($word[0]);
            // }
        }

        return $acronym;
    }
}
