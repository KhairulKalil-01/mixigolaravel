<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Patient;

class ClientAndPatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            ['id' => 1, 'name' => 'Pn Aida Aziza Mohd Jamaludin', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0123937853', 'email' => 'aidaaziza@yahoo.com', 'address' => 'Pangsapuri Daisy Blok 8 No 112 Subang Perdana 40150 Shah Alam Selangor', 'city' => 'Subang Perdana', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 2, 'name' => 'En Ahmad Hezril Zulkifli', 'ic_num' => null, 'sex' => 'Male', 'mobileno' => '0162157871', 'email' => 'ahezril@gmail.com', 'address' => 'No 4 Jalan seri putra 2/3,Bandar seri putra, Kajang, Selangor', 'city' => 'Kajang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 3, 'name' => 'Pn Huzaidah Husin Mohamed', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0107668446', 'email' => 'huzaidah@gmail.com', 'address' => 'No 6 Jln 4, Taman Selayang PKNS 1, Batu Caves, Selangor', 'city' => 'Batu Caves', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 4, 'name' => 'En Nelson', 'ic_num' => null, 'sex' => 'Male', 'mobileno' => '0192759071', 'email' => null, 'address' => '2/1A,Jalan Dagang,Bandar Sri Damansara,Kuala Lumpur', 'city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur', 'remarks' => null],
            ['id' => 5, 'name' => 'Pn Ruzianah Shariff', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0178812920', 'email' => null, 'address' => '12 Jln 12/16 Seksyen 12 Petaling Jaya', 'city' => 'Petaling Jaya', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 6, 'name' => 'Pn Siti Marlina', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0126925800', 'email' => null, 'address' => '2A Jln Diamond B1/3, Diamond Residence, 43500 Semenyih', 'city' => 'Semenyih', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 7, 'name' => 'Pn Thevaletchume', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0122043256', 'email' => null, 'address' => 'No A38, Lorong BP11/6, Bandar Bukit Puchong 2, 47120, Selangor', 'city' => 'Puchong', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 8, 'name' => 'En Zuhairi', 'ic_num' => null, 'sex' => 'Male', 'mobileno' => '0175607995', 'email' => null, 'address' => '19,Jalan Desa Pinggiran Putra 4A/7,Taman Desa Pinggiran Putra, Sg Merab,43000, Kajang, Selangor', 'city' => 'Kajang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 9, 'name' => 'Pn Leela', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0123020053', 'email' => null, 'address' => '93 Jalan SS 5/1,Kelana Jaya,47301 Petaling Jaya', 'city' => 'Petaling Jaya', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 10, 'name' => 'Pn Jaime', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0162254271', 'email' => null, 'address' => 'No 70, Jalan SG10/2, Taman Sri Gombak, 68100 Batu Caves, Selangor ', 'city' => 'Batu Caves', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 11, 'name' => 'Pn Norhayati Mohd Yusoff ', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0124318844', 'email' => null, 'address' => '1, Jalan Andaman 6, Taman Andaman Ukay, 68000, Ampang', 'city' => 'Ampang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 12, 'name' => 'Pn May', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0129301797', 'email' => null, 'address' => '338, Jalan Pelanduk,Taman Suntex, 43200 Cheras,Selangor.', 'city' => 'Cheras', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 13, 'name' => 'Pn Wan Hanira', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0192832624', 'email' => null, 'address' => 'No.76 Jalan Impian Jaya 5, Saujana Impian, 43000, Kajang, Selangor', 'city' => 'Kajang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 14, 'name' => 'Pn Fadwa', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0163233054', 'email' => null, 'address' => '2, Jalan 3/5 B, Bandar Baru Bangi, Selangor', 'city' => 'Bangi', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 15, 'name' => 'Schinkels Sdn Bhd', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '01126190168', 'email' => null, 'address' => 'Pangsapuri Daisy, Blok 8, No 112, Subang Perdana, 40150, Shah Alam, Selangor', 'city' => 'Shah Alam', 'state' => 'Selangor', 'remarks' => 'Employer of Pn Aida Aziza Mohd Jamaludin. Same patient'],
            ['id' => 16, 'name' => 'Pn Aida', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0192368627', 'email' => null, 'address' => '197, Jalan 3, Taman Sekamat, 43000, Kajang, Selangor', 'city' => 'Kajang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 17, 'name' => 'Pn Theresa', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '61412863063', 'email' => null, 'address' => 'C2-2-2, Jalan Putra Permai 2, Taman Equine, Seri Kembangan, Selangor', 'city' => 'Seri Kembangan', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 18, 'name' => 'Pn Jayanthi', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0123713075', 'email' => null, 'address' => 'No 2A,Jalan SS5A/17A,47301 Kelana Jaya', 'city' => 'Kelana Jaya', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 19, 'name' => 'Lim Teck Foo & Leong Wing Yan', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0102029145', 'email' => null, 'address' => 'A-10-09, Residensi M Vertica, No.555, Jln Cheras, 56000, Kuala Lumpur, WP Kuala Lumpur.', 'city' => 'Kuala Lumpur', 'state' => 'Wilaya Persekutuan Kuala Lumpur', 'remarks' => null],
            ['id' => 20, 'name' => 'Pn Sharifah Junainah', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0122148769', 'email' => null, 'address' => '44, Jalan Terasek 4, Bangsar Baru, 59100, Kuala Lumpur', 'city' => 'Kuala Lumpur', 'state' => 'Wilayah Persekutuan Kuala Lumpur', 'remarks' => null],
            ['id' => 21, 'name' => 'Pn Rose', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0102011786', 'email' => null, 'address' => 'No.118, Villa Laman Tasik, Jalan Bandar Sri Pemaisuri, Cheras, Kuala Lumpur', 'city' => 'Kuala Lumur', 'state' => 'Wilayah Persekutuan Kuala Lumpur', 'remarks' => null],
            ['id' => 22, 'name' => 'Pn Nur Afiqah Binti Abd Manan', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0199295446', 'email' => null, 'address' => 'No.25, Jalan Pinggiran Putra 5/10, Desa Pinggiran Putra, 43000, Kajang, Selangor', 'city' => 'Kajang', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 23, 'name' => 'Pn Sakinah', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '0176299869', 'email' => null, 'address' => '42, Jalan Aman Bayan 5, Bandar Tropicana Aman, Selangor', 'city' => 'Bandar Tropica Aman', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 24, 'name' => 'Encik Ramli Hashim', 'ic_num' => null, 'sex' => 'Male', 'mobileno' => '01157759061', 'email' => null, 'address' => 'No 6, Jalan Nuri 7/17a, Kota Damansara, 47810, Petaling Jaya, Selangor', 'city' => 'Petaling Jaya', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 25, 'name' => 'Puan Aiman Atikah', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '966 53 750 2347', 'email' => null, 'address' => '7 Teratai Villas, Jalan Merah Saga Empat, U9/5D  Kayangan Heights, 40150,  Shah Alam', 'city' => 'Shah Alam', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 26, 'name' => 'Encik Amar', 'ic_num' => null, 'sex' => 'Male', 'mobileno' => '0135357334', 'email' => null, 'address' => '57, Jalan P11 C/8, Presint 11, 62000, Putrajaya', 'city' => 'Putrajaya', 'state' => 'Selangor', 'remarks' => null],
            ['id' => 27, 'name' => 'Pn Dayana@Pn. Razlin', 'ic_num' => null, 'sex' => 'Female', 'mobileno' => '01159909506', 'email' => null, 'address' => 'No 6, Jalan Nuri 7/17a, Kota Damansara, 47810 Petaling Jaya', 'city' => 'Petaling Jaya', 'state' => 'Selangor', 'remarks' => null],

        ];

        $patients = [
            ['id' => 1, 'branch_id' => 1, 'name' => 'Suzana binti Hassan', 'ic_num' => null, 'age' => null, 'sex' => 'Female', 'weight' => 70, 'condition_description' => 'Post Surgery. Requires daily assist, grooming', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 2, 'branch_id' => 1, 'name' => 'Zulkifli', 'ic_num' => null, 'age' => null, 'sex' => 'Male', 'weight' => 70, 'condition_description' => 'Parkinson with tubing', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 3, 'branch_id' => 1, 'name' => 'Husin Mohamed', 'ic_num' => null, 'age' => 50, 'sex' => 'Male', 'weight' => 50, 'condition_description' => '', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 4, 'branch_id' => 1, 'name' => 'Mary', 'ic_num' => null, 'age' => 94, 'sex' => 'Female', 'weight' => 52, 'condition_description' => 'Diabetic', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 5, 'branch_id' => 1, 'name' => 'Rusiah Abdullah', 'ic_num' => null, 'age' => 98, 'sex' => 'Female', 'weight' => 50, 'condition_description' => 'Sakit tua.Ada darah tinggi.Ada bullous pemphigoid.', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 6, 'branch_id' => 1, 'name' => 'M Ishan Hj Bakar', 'ic_num' => null, 'age' => 69, 'sex' => 'Male', 'weight' => 85, 'condition_description' => 'Post Bypass', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 7, 'branch_id' => 1, 'name' => 'Esheensai', 'ic_num' => null, 'age' => 12, 'sex' => 'Male', 'weight' => 50, 'condition_description' => 'Autism,hyper', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 8, 'branch_id' => 1, 'name' => 'Normazian binti Ahmad', 'ic_num' => null, 'age' => null, 'sex' => 'Female', 'weight' => null, 'condition_description' => 'PSP(Progressive Supranuclear Palsy)', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 9, 'branch_id' => 1, 'name' => 'Irene', 'ic_num' => null, 'age' => 90, 'sex' => 'Female', 'weight' => null, 'condition_description' => 'Parkinson', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 10, 'branch_id' => 1, 'name' => 'Rachikatas Arulanthu', 'ic_num' => null, 'age' => 77, 'sex' => 'Male', 'weight' => 67, 'condition_description' => 'Sakit tua, asthma', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 11, 'branch_id' => 1, 'name' => 'Narziha Ahmad Zahudi', 'ic_num' => null, 'age' => null, 'sex' => 'Female', 'weight' => 70, 'condition_description' => 'Vertigo', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 12, 'branch_id' => 1, 'name' => 'Yan Chee', 'ic_num' => null, 'age' => null, 'sex' => 'Male', 'weight' => null, 'condition_description' => 'Bedridden', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 13, 'branch_id' => 1, 'name' => 'Wan Mat bin Wan Daud', 'ic_num' => null, 'age' => 76, 'sex' => 'Male', 'weight' => 55, 'condition_description' => 'Vascular Dimentia', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 14, 'branch_id' => 1, 'name' => 'Ali Hj Ahmad', 'ic_num' => null, 'age' => 71, 'sex' => 'Male', 'weight' => 70, 'condition_description' => 'Dementia', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 15, 'branch_id' => 1, 'name' => 'Omar bin Abd Razak', 'ic_num' => null, 'age' => 96, 'sex' => 'Male', 'weight' => 47, 'condition_description' => 'Sakit tua', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 16, 'branch_id' => 1, 'name' => 'Kong Sung Thai', 'ic_num' => null, 'age' => null, 'sex' => 'Male', 'weight' => 90, 'condition_description' => 'Bedridden', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 17, 'branch_id' => 1, 'name' => 'Vijayan Krishnan', 'ic_num' => null, 'age' => null, 'sex' => 'Male', 'weight' => 65, 'condition_description' => 'Bypass', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 18, 'branch_id' => 1, 'name' => 'Michael Lim', 'ic_num' => null, 'age' => 45, 'sex' => 'Male', 'weight' => 80, 'condition_description' => 'Stroke', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 19, 'branch_id' => 1, 'name' => 'Syed Aziz', 'ic_num' => null, 'age' => null, 'sex' => 'Male', 'weight' => null, 'condition_description' => 'Parkinson', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 20, 'branch_id' => 1, 'name' => 'Neza', 'ic_num' => null, 'age' => 40, 'sex' => 'Female', 'weight' => 140, 'condition_description' => 'Stroke', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 21, 'branch_id' => 1, 'name' => 'Abd Manan Bin Mohd Taib', 'ic_num' => null, 'age' => 75, 'sex' => 'Male', 'weight' => 70, 'condition_description' => 'Parkinson,retak tulang pinggul,lutut ada lari sikit akibat jatuh.Baru keluar hospital,tak boleh berdiri,pakai pampers dan perlukan bantuan utk angkat ke kerusi roda,luka bedsore', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 22, 'branch_id' => 1, 'name' => 'Jamil Ali', 'ic_num' => null, 'age' => 66, 'sex' => 'Male', 'weight' => 60, 'condition_description' => 'Recovered from suspected meningitis', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 23, 'branch_id' => 1, 'name' => 'Ramli Hashim', 'ic_num' => null, 'age' => 60, 'sex' => 'Male', 'weight' => 80, 'condition_description' => 'Bilateral Cerebellar Hemorrhagic Stroke', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 24, 'branch_id' => 1, 'name' => 'Puan Tik', 'ic_num' => null, 'age' => 94, 'sex' => 'Female', 'weight' => 40, 'condition_description' => 'Diagnosis pesakit: CHF. Basics screening (vitals, glucose, and recommendation)', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 25, 'branch_id' => 1, 'name' => 'Pn. Natrah', 'ic_num' => null, 'age' => 70, 'sex' => 'Female', 'weight' => 65, 'condition_description' => 'Brain tumor / diamentia/ bedridden', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
            ['id' => 26, 'branch_id' => 1, 'name' => 'En. Ramli Hashim', 'ic_num' => null, 'age' => 60, 'sex' => 'Male', 'weight' => 80, 'condition_description' => 'Bilateral Cerebellar Hemorrhagic Stroke', 'mobileno' => null, 'address' => null, 'city' => null, 'state' => null, 'remarks' => null],
        ];

        // Insert Clients
        foreach ($clients as $client) {
            Client::updateOrCreate(['id' => $client['id']], $client);
        }

        // Insert Patients
        foreach ($patients as $patient) {
            Patient::updateOrCreate(['id' => $patient['id']], $patient);
        }

        // Define relationships (many-to-many)
        $relations = [
            // patient_id => [client_id1, client_id2, ...]
            1 => [1, 15],       // Suzana binti Hassan is related to Pn Aida Aziza Mohd Jamaludin and Schinkels Sdn Bhd
            2 => [2],           // Patient Zulkifli is related to En Ahmad Hezril Zulkifli
            3 => [3],           // Patient Husin Mohamed is related to Pn Huzaidah Husin Mohamed
            4 => [4],           // Patient Mary is related to En Nelson
            5 => [5],           // Patient Rusiah Abdullah is related to Pn Ruzianah Shariff
            6 => [6],           // Patient M Ishan Hj Bakar is related to Pn Siti Marlina

            7 => [7],           // Patient Esheensai is related to Pn Thevaletchume
            8 => [8],           // Patient Normazian binti Ahmad is related to En Zuhairi
            9  => [9],          // Patient Irene is related to Pn Leela
            10 => [10],         // Patient M Ishan Hj 
            11 => [11],         // Patient Narziha Ahmad Zahudi is related to Pn Norhayati Mohd Yusoff
            12 => [12],         // Patient Yan Chee is related to Pn May
            13 => [13],         //patient Wan Mat bin Wan Daud is related to Pn Wan Hanira
            14 => [14],         // Patient Ali Hj Ahmad is related to Pn Fadwa
            15 => [16],         // Patient Omar bin Abd Razak is related to Pn Aida
            16 => [17],     // Patient Kong Sung Thai is related to Pn Theresa
            17 => [18],     // Patient Vijayan Krishnan is related to Pn Jayanthi
            18 => [19],     // Patient Michael Lim is related to Lim Teck Foo & Leong Wing Yan
            19 => [20],     // Patient Syed Aziz is related to Pn Sharifah Junainah
            20 => [21],     // Patient Neza is related to Pn Rose
            21 => [22],     // Patient Abd Manan is related to Pn Nur Afiqah Binti Abd Manan
            22 => [23],     // Patient Jamil Ali is related to Pn Sakinah
            23 => [24],     // Patient Ramli Hashim is related to Encik Ramli Hashim
            24 => [25],     // Patient Puan Tik is related to Puan Aiman Atikah
            25 => [26],     // Patient Pn. Natrah is related to Encik Amar
            26 => [27],     // Patient En. Ramli Hashim is related to Pn Dayana@Pn. Razllin
        ];

        foreach ($relations as $patientId => $clientIds) {
            $patient = Patient::find($patientId);
            if ($patient) {
                $patient->clients()->syncWithoutDetaching($clientIds);
            }
        }
    }
}
