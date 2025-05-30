<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $random_building_links = [
            'https://images.squarespace-cdn.com/content/v1/62dfa656a2986f7b76f75c92/1658824441045-RYTWQQGICIUX6WN1TCXZ/Carib+Dev.jpg',
            'https://images.squarespace-cdn.com/content/v1/62dfa656a2986f7b76f75c92/1658824441038-V9M9HUR52ETGN4U7Z3HT/real-estate-marketing.jpg',
            'https://media-cdn.tripadvisor.com/media/daodao/photo-s/05/47/34/f7/resort-day-view2.jpg',
            'https://media-cdn.tripadvisor.com/media/daodao/photo-s/05/47/34/f7/resort-day-view2.jpg',
            'https://timberhut.com/wp-content/uploads/2024/05/resort-building-1024x680.jpg',
            'https://www.shutterstock.com/image-photo/luxury-pool-sunset-600nw-2322035441.jpg',
            'https://media.istockphoto.com/id/903417402/photo/luxury-construction-hotel-with-swimming-pool-at-sunset.jpg?s=612x612&w=0&k=20&c=NyPC_c-wE3W_CImA4t57FpyGy6f428CYROd80jxVC4A=',
            'https://thumbs.dreamstime.com/z/luxury-resort-building-facade-tropical-garden-turquoise-canal-modern-architecture-leisure-hospitality-tourism-296174597.jpg',
            'https://www.agritecture.com/hs-fs/hubfs/Imported_Blog_Media/Phillipines%20Agritecture-Sep-11-2023-02-59-02-4274-PM.jpeg?width=962&height=655&name=Phillipines%20Agritecture-Sep-11-2023-02-59-02-4274-PM.jpeg',
            'https://www.bworldonline.com/wp-content/uploads/2024/01/ADVT_Banyan-Tree-New-Clark-City-Main-Building-OL.jpg',
            'https://snoopy.archdaily.com/images/archdaily/media/images/622c/e8cf/b9fa/780e/7d2e/f21c/slideshow/sanya-horizons-by-ole-scheeren-c-buro-os-12-green-horizons.jpg?1647110405&format=webp&width=640&height=580',
            'https://snoopy.archdaily.com/images/archdaily/media/images/622c/e8cf/b9fa/780e/7d2e/f21c/slideshow/sanya-horizons-by-ole-scheeren-c-buro-os-12-green-horizons.jpg?1647110405&format=webp&width=640&height=580',
            'https://i0.wp.com/fulgararchitects.com/wp-content/uploads/2020/06/fulgar-architects-h-resort-puerto-princesa-city-palawan-philippines-10.jpg?resize=1920%2C1200&ssl=1',
            'https://5.imimg.com/data5/SELLER/Default/2024/1/374384991/UK/CQ/RT/80296815/resort-construction-services.jpg',
            'https://www.watg.com/wp-content/uploads/2017/07/123066_N174_website.jpg',
            'https://media.istockphoto.com/id/119926339/photo/resort-swimming-pool.jpg?s=612x612&w=0&k=20&c=9QtwJC2boq3GFHaeDsKytF4-CavYKQuy1jBD2IRfYKc=',
            'https://media.architecturaldigest.com/photos/57e42de0fe422b3e29b7e78f/16:9/w_2560%2Cc_limit/JW_LosCabos_2015_MainExterior.jpg',
            'https://lirp.cdn-website.com/c4b57344/dms3rep/multi/opt/Hue+Siargao_Exterior-633d7eb5-640w.jpg',
            'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2e/9a/97/b3/hotel-building.jpg?w=900&h=500&s=1',
            'https://imkarchitects.com/images/hotels-banner.jpg',
        ];

        return [
            'name' => $this->faker->company . ' Building',
            'image' => $random_building_links[$this->faker->numberBetween(0, count($random_building_links) - 1)],
            'floor_count' => $this->faker->numberBetween(2, 4),
            'room_per_floor' => $this->faker->numberBetween(4, 7),
        ];
    }
}
