<?php

namespace Database\Seeders;

use App\Models\Resort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initial_resorts = [
            [
                'name' => 'Punta Verde',
                'location' => 'Lobo - Malabrigo',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495769.14625124517!2d120.91107645306354!3d13.88719842861475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd215ae45c82c7%3A0x4bd2fb540cf7c003!2sPunta%20Verde%20Resort!5e0!3m2!1sen!2sph!4v1743441362225!5m2!1sen!2sph',
                'tax_rate' => '12',
                'status' => 'active'
            ],
            [
                'name' => 'Bruzy Resort',
                'location' => 'New Corella',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253269.64483085732!2d125.54060155066222!3d7.315852589701174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f953a38f5f6273%3A0x99b17e0bee4b0a9a!2sARRS%20Hotel%20%26%20Resort!5e0!3m2!1sen!2sph!4v1743442287773!5m2!1sen!2sph',
                'tax_rate' => '7',
                'status' => 'active'
            ],
            [
                'name' => 'White Sands Paradise',
                'location' => 'Samal Island',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.513843306622!2d126.09051107503095!3d9.974344990129786!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33041074c8ca850f%3A0x815210bb755bada0!2sWhitesands%20Beach%20Resort%20Siargao!5e0!3m2!1sen!2sph!4v1746046298727!5m2!1sen!2sph',
                'tax_rate' => '22',
                'status' => 'active'
            ],
            [
                'name' => 'Blue Waters Resort',
                'location' => 'Oslob, Cebu',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.264621621438!2d125.66199687499818!3d7.095295792907909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f96e8f5be9ad5f%3A0xb2a912cd06aeff81!2sBluewaters%20Village%20and%20Resort!5e0!3m2!1sen!2sph!4v1746362282043!5m2!1sen!2sph',
                'tax_rate' => '5',
                'status' => 'active'
            ],
            [
                'name' => 'Hidden Haven Resort',
                'location' => 'El Nido, Palawan',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4007906.549637331!2d114.40430961249999!3d11.189763700000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33b6531eedfcb3b3%3A0x280e86deb6b6ad9d!2sHidden%20Beach!5e0!3m2!1sen!2sph!4v1746362362841!5m2!1sen!2sph',
                'tax_rate' => '15',
                'status' => 'active'
            ],
            [
                'name' => 'Crystal Shore',
                'location' => 'Bolinao, Pangasinan',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1968663.5706829713!2d118.70785191282954!3d15.481955717421751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33960d49b3f6232f%3A0xa31fef68990591e3!2sCrystal%20Shores%20Beach%20Resort!5e0!3m2!1sen!2sph!4v1746362456181!5m2!1sen!2sph',
                'tax_rate' => '12',
                'status' => 'active'
            ],
            [
                'name' => 'Bayfront Escape',
                'location' => 'Tagbilaran, Bohol',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4019563.865315772!2d119.0150348125!3d10.313420999999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a999ef055afebf%3A0x870e7dec3004f261!2sBayfront%20Hotel%20Cebu%20-%20Capitol%20Site!5e0!3m2!1sen!2sph!4v1746362547062!5m2!1sen!2sph',
                'tax_rate' => '3',
                'status' => 'active'
            ],
            [
                'name' => 'Sunset Cliff Resort',
                'location' => 'Anda, Bohol',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4015170.2143908213!2d119.4268524125!3d10.65208470000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a833bb6ae76d93%3A0x58592b115f268465!2sCasa%20Verde%20Cliff%20Resort%20and%20Spa!5e0!3m2!1sen!2sph!4v1746362625536!5m2!1sen!2sph',
                'tax_rate' => '8',
                'status' => 'active'
            ],
            [
                'name' => 'Palm View Resort',
                'location' => 'Puerto Galera, Mindoro',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4015319.2914426876!2d119.4265310202322!3d10.640768485488895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33abacc6b67a3ab5%3A0xf00bafc57388c532!2sPalm%20View%20Residence!5e0!3m2!1sen!2sph!4v1746362678759!5m2!1sen!2sph',
                'tax_rate' => '14',
                'status' => 'active'
            ],
            [
                'name' => 'Tropical Breeze Inn',
                'location' => 'Moalboal, Cebu',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3869.8611264724354!2d121.13540777509634!3d14.085374086342146!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd6f6537aef71f%3A0x9ec191368641c2dd!2sTropical%20Breeze%20Hotel%20%26%20Resort!5e0!3m2!1sen!2sph!4v1746362840199!5m2!1sen!2sph',
                'tax_rate' => '11',
                'status' => 'active'
            ],
            [
                'name' => 'Blue Lagoon Hideaway',
                'location' => 'Pagudpud, Ilocos Norte',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3868.2979707653594!2d121.19310457432319!3d14.177317987301175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd610003d0a869%3A0xe197fbe118a11447!2sThe%20Vacation%20House%20by%20Hideaway!5e0!3m2!1sen!2sph!4v1746362874670!5m2!1sen!2sph',
                'tax_rate' => '6',
                'status' => 'active'
            ],
            [
                'name' => 'Calaguas Pearl Resort',
                'location' => 'Vinzon, Camarines Norte',
                'location_coordinates' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d247437.1892118743!2d122.7790868773872!3d14.299455592945844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3398cf99e94a066b%3A0x73c7f38b8949c81!2sCalaguas%20Paradise%20Resort!5e0!3m2!1sen!2sph!4v1746362916077!5m2!1sen!2sph',
                'tax_rate' => '18',
                'status' => 'active'
            ]
        ];

        foreach ($initial_resorts as $resort) {
            Resort::create($resort);
        }

        // Resort::factory(20)->create();
    }
}
