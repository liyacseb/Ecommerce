<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contact::create([
            'website_logo'=>'20220616060262aabd0a164e3.png',
            'website_name'=>'Ecommerce',
            'adrs_line_1'=>'Indeevaram Building',
            'adrs_line_2'=>'Koratty',
            'pincode'=>'625888',
            'district'=>'Trissur',
            'state'=>'Kerala',
            'country'=>'India',
            'gmail_link'=>'https://accounts.google.com/signin/v2/identifier?continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&service=mail&flowName=GlifWebSignIn&flowEntry=ServiceLogin'
        ]);
    }
}
