<?php

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientAddress;
use App\Models\PatientFamily;
use App\Models\PatientProfile;

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
                    'name' => 'Cong',
                    'email' => 'microbiologist@gmail.com',
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
        }
        if (!DB::table('patient_profiles')->count()) {
            PatientProfile::create(
                [   
                    'patient_id' => 1,
                    'first_name' => 'Cong',
                    'middle_name' => 'Cong',
                    'last_name' => 'Cong',
                    'home_contact' => 'Cong',
                    'cell_contact' => 'Cong',
                    'gender' => 'Cong',
                    'age' => 1,
                    'birthdate' => 'Cong',
                    'citizenship' => 'Cong',
                    'height' => 1,
                    'weight' => 1,
                    'bmi' => 1,
                    'bmi_category' => 'Cong',
                    'blood_type' => 'Cong',
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
