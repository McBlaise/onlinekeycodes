<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user' => 'annkaje',
            'password' => app('hash')->make('annkaje'),
            'locksmith_id' => 0
        ]);
        
        DB::table('users')->insert([
            'user' => 'master',
            'password' => app('hash')->make('master'),
            'locksmith_id' => 0
        
        ]);

        DB::table('applications')->insert([
            'settings' => 'charge',
            'status' => '0'
        ]);

        DB::table('applications')->insert([
            'settings' => 'maintenance',
            'status' => '0'
        ]);

        DB::table('charges')->insert([
            'amount' => '40',
            'type' => 'signup',
            'is_active' => 'false'
        ]);
        
        DB::insert(
            'INSERT INTO cars (id, make, level, price, filename, year, `time`, docs, remarks, created_at, updated_at) VALUES
        (1, "Acura", "1", 25, "acura.jpg", "1990+", NULL, NULL, NULL, NULL, NULL),
        (2, "Honda", "1", 22, "honda.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (3, "5 digit BCM", "1", 0, "bcm.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (4, "Mazda Incode/Outcode", "1", 5, "mazda.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (5, "20 digit BCM", "1", 5, "bcm1.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (6, "Hyundai", "1", 10, "hyundai.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (7, "Kia", "1", 10, "kia.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (8, "Nissan", "1", 10, "nissan.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (9, "Infiniti", "1", 10, "infiniti.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (10, "Chrysler", "1", 35, "chrysler.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (11, "Dodge", "1", 35, "dodge.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (12, "Jeep", "1", 35, "jeep.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (13, "Ford", "1", 40, "ford.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (14, "Lincoln", "1", 45, "lincoln.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (15, "Mercury", "1", 45, "mercury.jpg", NULL, NULL, NULL, NULL, NULL, NULL),
        (16, "Suzuki", "1", 20, "suzuki.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (17, "Mazda Incode/outcode 213", "2", 15, "mazda.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (18, "Acura", "2", 20, "acura.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (19, "Audi", "2", 40, "audi.png", "1997-2005", NULL, NULL, "will take up to 2hrs process", NULL, NULL),
        (20, "Buick", "2", 55, "buick.png", "1988+", "From Monday- Saturday 10:00 Am - 5:00Pm CST", "Owners Name, Owners Drivers License, - Plate Number, Car Registration (Have to Match with The Drivers license name), Mileage, Car Color", "(will take up to 35mins-1hr to process)", NULL, NULL),
        (21, "BMW", "2", 50, "bmw.png", "Year: From 90-94 (Available From Monday- Friday 8:00 AM - 5:00 PM (EST) Take up 1hr-2hr to process", NULL, NULL, NULL, NULL, NULL),
        (22, "Cadilac", "2", 55, "cadillac.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (23, "Chevrolet", "2", 55, "chevrolet.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (24, "Chrysler", "2", 35, "chrysler.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (25, "Dodge", "2", 35, "dodge.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (26, "Eagle", "2", 35, "eagle.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (27, "Ford", "2", 35, "ford.png", "Year: 1996 +", NULL, NULL, NULL, NULL, NULL),
        (28, "Ford Pin Code", "2", 20, "ford.png", "Year: 2013+", NULL, NULL, NULL, NULL, NULL),
        (29, "GEO", "2", 55, "geo.jpg", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (30, "GM", "2", 55, "gm.jpg", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (31, "Honda", "2", 22, "honda.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (32, "Hyundai", "2", 10, "hyundai.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (33, "Infiniti", "2", 10, "infiniti.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (34, "Isuzu", "2", 40, "isuzu.png", "Year: 1990+ (FOR ISUZU PLEASE SEND: PICTURE OF REGISTRATION OR TITLE +PICTURE OF DRIVING LICENSE - NAMES HAVE TOMATCH - MONDAY - FRIDAY 10AM-5PM EST - UP TO 24 HOURS)", NULL, NULL, NULL, NULL, NULL),
        (35, "Jaguar", "2", 40, "jaguar.jpg", "Year: 1983 + (Monday- Friday 10 AM - 5 PM EST)", NULL, NULL, NULL, NULL, NULL),
        (36, "Jeep", "2", 35, "jeep.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (37, "Kia", "2", 10, "kia.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (38, "Land Rover", "2", 50, "landrover.jpg", "Year: 2000+ (Discovery Only) monday-friday ( EST) ( 8:00 am to 5pm it will atke up to 1hr-2hr to process", NULL, NULL, NULL, NULL, NULL),
        (39, "Lexus", "2", 10, "lexus.png", "Year: 1990", NULL, NULL, NULL, NULL, NULL),
        (40, "Lincoln", "2", 35, "lincoln.png", "Year: 1996+", NULL, NULL, NULL, NULL, NULL),
        (41, "Mazda", "2", 15, "mazda.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (42, "Mazda Serial to Pin", "2", 5, "mazda.png", "All Year", NULL, NULL, NULL, NULL, NULL),
        (43, "Mercury", "2", 35, "mercury.jpg", "Year: 1990", NULL, NULL, NULL, NULL, NULL),
        (44, "Mitsubishi", "2", 10, "mitsubishi.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (45, "Nissan", "2", 10, "nissan.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (46, "Nissan", "2", 10, "nissan.png", "2013+", NULL, NULL, NULL, NULL, NULL),
        (47, "Oldsmobile", "2", 55, "oldsmobile.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (48, "Plymouth", "2", 35, "plymouth.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (49, "Scion", "2", 10, "scion.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (50, "Saturn", "2", 55, "saturn.jpg", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (51, "Subaru", "2", 15, "subaru.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (52, "Saab", "2", 55, "saab.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (53, "Suzuki", "2", 25, "suzuki.png", "Year: 1995+", NULL, NULL, NULL, NULL, NULL),
        (54, "Toyota", "2", 10, "toyota.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (55, "Volvo Car", "2", 15, "volvo.png", "Year: 1997+", NULL, NULL, NULL, NULL, NULL),
        (56, "Vw", "2", 40, "vw.jpg", "Year: 1999-2008 up to 5-24 hrs to process", NULL, NULL, NULL, NULL, NULL),
        (57, "Trucks", "2", 50, "trucks.jpg", "(Monday- Friday 10 AM - 5 PM EST, take up to 24hrs to process)", NULL, NULL, NULL, NULL, NULL),
        (58, "Mazda Incode/outcode 213", "3", 15, "mazda.png", NULL, NULL, NULL, NULL, NULL, NULL),
        (59, "Acura", "3", 20, "acura.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (60, "Audi", "3", 40, "audi.png", "Year: 1997-2005 (will take up to 2hrs process)", NULL, NULL, NULL, NULL, NULL),
        (61, "Buick", "3", 55, "buick.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (62, "BMW", "3", 50, "bmw.png", "Year: From 90-94 (Available From Monday- Friday 8:00 AM - 5:00 PM (EST) Take up 1hr-2hr to process", NULL, NULL, NULL, NULL, NULL),
        (63, "Cadilac", "3", 55, "cadillac.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (64, "Chevrolet", "3", 55, "chevrolet.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (65, "Chrysler", "3", 35, "chrysler.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (66, "Dodge", "3", 35, "dodge.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (67, "Eagle", "3", 35, "eagle.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (68, "Ford", "3", 35, "ford.png", "Year: 1996 +", NULL, NULL, NULL, NULL, NULL),
        (69, "Ford Pin Code", "3", 20, "ford.png", "Year: 2013+", NULL, NULL, NULL, NULL, NULL),
        (70, "GEO", "3", 55, "geo.jpg", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (71, "GM", "3", 55, "gm.jpg", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (72, "Honda", "3", 22, "honda.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (73, "Hyundai", "3", 10, "hyundai.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (74, "Infiniti", "3", 10, "infiniti.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (75, "Isuzu", "3", 40, "isuzu.png", "Year: 1990+ (FOR ISUZU PLEASE SEND: PICTURE OF REGISTRATION OR TITLE +PICTURE OF DRIVING LICENSE - NAMES HAVE TOMATCH - MONDAY - FRIDAY 10AM-5PM EST - UP TO 24 HOURS)", NULL, NULL, NULL, NULL, NULL),
        (76, "Jaguar", "3", 40, "jaguar.jpg", "Year: 1983 + (Monday- Friday 10 AM - 5 PM EST)", NULL, NULL, NULL, NULL, NULL),
        (77, "Jeep", "3", 35, "jeep.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (78, "Kia", "3", 10, "kia.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (79, "Land Rover", "3", 50, "landrover.jpg", "Year: 2000+ (Discovery Only) monday-friday ( EST) ( 8:00 am to 5pm it will atke up to 1hr-2hr to process", NULL, NULL, NULL, NULL, NULL),
        (80, "Lexus", "3", 10, "lexus.png", "Year: 1990", NULL, NULL, NULL, NULL, NULL),
        (81, "Lincoln", "3", 35, "lincoln.png", "Year: 1996+", NULL, NULL, NULL, NULL, NULL),
        (82, "Mazda", "3", 15, "mazda.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (83, "Mazda Serial to Pin", "3", 5, "mazda.png", "All Year", NULL, NULL, NULL, NULL, NULL),
        (84, "Mercury", "3", 35, "mercury.jpg", "Year: 1990", NULL, NULL, NULL, NULL, NULL),
        (85, "Mitsubishi", "3", 10, "mitsubishi.jpg", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (86, "Subaru", "3", 15, "subaru.jpg", "Year: 1998+", NULL, NULL, NULL, NULL, NULL),
        (87, "Saab", "3", 55, "saab.png", "Year: 1988+ From Monday- Saturday 10:00 Am - 5:00Pm CST (will take up to 35mins-1hr to process)", NULL, NULL, NULL, NULL, NULL),
        (88, "Suzuki", "3", 25, "suzuki.png", "Year: 1995+", NULL, NULL, NULL, NULL, NULL),
        (89, "Toyota", "3", 10, "toyota.png", "Year: 1990+", NULL, NULL, NULL, NULL, NULL),
        (90, "Volvo Car", "3", 15, "volvo.png", "Year: 1997+", NULL, NULL, NULL, NULL, NULL),
        (91, "Vw", "3", 40, "vw.jpg", "Year: 1999-2008 up to 5-24 hrs to process", NULL, NULL, NULL, NULL, NULL),
        (92, "Trucks", "3", 50, "trucks.jpg", "(Monday- Friday 10 AM - 5 PM EST, take up to 24hrs to process)", NULL, NULL, NULL, NULL, NULL)'

        );

    }
}
