<?php

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\PatientProfile;
use App\Models\Doctor;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('patients')->count()) {
            Patient::create(
                [   
                    'name' => 'Jerameel',
                    'email' => 'jerameel@gmail.com',
                    'password' => Hash::make('123456')
                ]
            );
            Patient::create(
                [   
                    'name' => 'Test',
                    'email' => 'test@gmail.com',
                    'password' => Hash::make('123456')
                ]
            );
            Doctor::create(
                [   
                    'name' => 'Test',
                    'email' => 'doctor@gmail.com',
                    'password' => Hash::make('123456')
                ]
            );
        }
        if (!DB::table('patient_profiles')->count()) {
            PatientProfile::create(
                [   
                    'patient_id' => 1,
                    'first_name' => 'Jerameel',
                    'middle_name' => 'D',
                    'last_name' => 'Delos Reyes',
                    'home_contact' => '000-0000',
                    'cell_contact' => '0909090909',
                    'gender' => 'Male',
                    'age' => 21,
                    'birthdate' => '10/17/1995',
                    'citizenship' => 'Filipino',
                    'height' => 173,
                    'weight' => 65,
                    'bmi' => 67,
                    'bmi_category' => 'Normal',
                    'blood_type' => 'A',
                ]
            );
        }
        if (!DB::table('patient_addresses')->count()) {
            PatientAddress::create(
                [   
                    'patient_id' => 1,
                    'perma_address' => 'Cong',
                    'perma_city' => 'Cong',
                    'perma_province' => 'Cong',
                    'perma_region' => 'Cong',
                    'perma_postal' => 'Cong',
                    'pres_address' => 'Cong',
                    'pres_city' => 'Cong',
                    'pres_province' => 'Cong',
                    'pres_region' => 'Cong',
                    'pres_postal' => 'Cong',
                ]
            );
        }
        if (!DB::table('patient_families')->count()) {
            PatientFamily::create(
                [   
                    'patient_id' => 1,
                    'first_name' => 'Cong',
                    'middle_name' => 'Cong',
                    'last_name' => 'Cong',
                    'contact' => 'Cong',
                    'citizenship' => 'Cong',
                    'email' => 'Cong',
                    'occupation' => 'Cong',
                    'relationship' => 'Cong'
                ]
            );
            PatientFamily::create(
                [   
                    'patient_id' => 1,
                    'first_name' => 'Test',
                    'middle_name' => 'Test',
                    'last_name' => 'Test',
                    'contact' => 'Test',
                    'citizenship' => 'Test',
                    'email' => 'Test',
                    'occupation' => 'Test',
                    'relationship' => 'Test'
                ]
            );
        }
    }
}
