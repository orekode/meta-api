<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\PageContents;

class PageContentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $navigations = [
        //     [
        //         'link' => '/',
        //         'link_label' => 'Home',
        //     ],
            
        //     [
        //         'link' => '/about',
        //         'link_label' => 'Who We Are',
        //     ],

        //     [
        //         'link' => '/programs',
        //         'link_label' => 'Programs',
        //     ],

        //     [
        //         'link' => '/contact',
        //         'link_label' => 'Contact Us',
        //     ],

        //     [
        //         'link' => '/gallery',
        //         'link_label' => 'Gallery',
        //     ],
        // ];


        // foreach( $navigations as $navigation ) {
        //     PageContents::create([...$navigation, 'position' => 'Navigation']);
        // }

        $homepage = [
            // [
            //     'image'      => 'header.jpeg',
            //     'title'      => 'Educating and Empowering the Nigerian Youth',
            //     'content'    => 'To care for our kids and young ones, indeed the future of the Nigerian youth through education and empowerment programs and outreach',
            //     'link'       => '/programs',
            //     'link_label' => 'Ongoing Programs',
            //     'position'   => 'home_header',
            // ],
            [
                'link_label' => 'Make a donation',
                'position'   => 'donation_btn',
            ],
        ];

        foreach( $homepage as $content ) {
            PageContents::create($content);
        }

    }
}
