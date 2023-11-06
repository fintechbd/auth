<?php

namespace Fintech\Auth\Seeders;

use Fintech\Auth\Facades\Auth;
use Illuminate\Database\Seeder;

class IdDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = $this->data();

        foreach (array_chunk($data, 200) as $block) {
            set_time_limit(2100);
            foreach ($block as $entry) {
                Auth::idDocType()->create($entry);
            }
        }
    }

    private function data()
    {
        return array (
            0 =>
                array (
                    'id' => 1,
                    'country_id' => 1,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            1 =>
                array (
                    'id' => 2,
                    'country_id' => 11,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            2 =>
                array (
                    'id' => 3,
                    'country_id' => 11,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            3 =>
                array (
                    'id' => 4,
                    'country_id' => 15,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            4 =>
                array (
                    'id' => 5,
                    'country_id' => 15,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            5 =>
                array (
                    'id' => 6,
                    'country_id' => 15,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            6 =>
                array (
                    'id' => 7,
                    'country_id' => 17,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            7 =>
                array (
                    'id' => 8,
                    'country_id' => 17,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            8 =>
                array (
                    'id' => 9,
                    'country_id' => 18,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            9 =>
                array (
                    'id' => 10,
                    'country_id' => 18,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            10 =>
                array (
                    'id' => 11,
                    'country_id' => 18,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            11 =>
                array (
                    'id' => 12,
                    'country_id' => 25,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            12 =>
                array (
                    'id' => 13,
                    'country_id' => 32,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            13 =>
                array (
                    'id' => 14,
                    'country_id' => 32,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            14 =>
                array (
                    'id' => 15,
                    'country_id' => 32,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            15 =>
                array (
                    'id' => 16,
                    'country_id' => 36,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            16 =>
                array (
                    'id' => 17,
                    'country_id' => 44,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            17 =>
                array (
                    'id' => 18,
                    'country_id' => 44,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            18 =>
                array (
                    'id' => 19,
                    'country_id' => 44,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            19 =>
                array (
                    'id' => 20,
                    'country_id' => 56,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            20 =>
                array (
                    'id' => 21,
                    'country_id' => 56,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            21 =>
                array (
                    'id' => 22,
                    'country_id' => 56,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            22 =>
                array (
                    'id' => 23,
                    'country_id' => 56,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            23 =>
                array (
                    'id' => 24,
                    'country_id' => 79,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            24 =>
                array (
                    'id' => 25,
                    'country_id' => 79,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            25 =>
                array (
                    'id' => 26,
                    'country_id' => 79,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            26 =>
                array (
                    'id' => 27,
                    'country_id' => 96,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            27 =>
                array (
                    'id' => 28,
                    'country_id' => 96,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            28 =>
                array (
                    'id' => 29,
                    'country_id' => 96,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            29 =>
                array (
                    'id' => 30,
                    'country_id' => 99,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            30 =>
                array (
                    'id' => 31,
                    'country_id' => 99,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            31 =>
                array (
                    'id' => 32,
                    'country_id' => 99,
                    'name' => 'Voter Id',
                    'code' => 'voter_id',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'VI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'voter_id',
                        ),
                    'enabled' => true,
                ),
            32 =>
                array (
                    'id' => 33,
                    'country_id' => 99,
                    'name' => 'Tax Id',
                    'code' => 'tax_id',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => NULL,
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'tax_id',
                        ),
                    'enabled' => true,
                ),
            33 =>
                array (
                    'id' => 34,
                    'country_id' => 100,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            34 =>
                array (
                    'id' => 35,
                    'country_id' => 100,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            35 =>
                array (
                    'id' => 36,
                    'country_id' => 100,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            36 =>
                array (
                    'id' => 37,
                    'country_id' => 109,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            37 =>
                array (
                    'id' => 38,
                    'country_id' => 101,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            38 =>
                array (
                    'id' => 39,
                    'country_id' => 102,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            39 =>
                array (
                    'id' => 40,
                    'country_id' => 104,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            40 =>
                array (
                    'id' => 41,
                    'country_id' => 104,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            41 =>
                array (
                    'id' => 42,
                    'country_id' => 107,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            42 =>
                array (
                    'id' => 43,
                    'country_id' => 107,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            43 =>
                array (
                    'id' => 44,
                    'country_id' => 107,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            44 =>
                array (
                    'id' => 45,
                    'country_id' => 107,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            45 =>
                array (
                    'id' => 46,
                    'country_id' => 107,
                    'name' => 'Social Security Card',
                    'code' => 'social_security_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'SS',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'social_security_card',
                        ),
                    'enabled' => true,
                ),
            46 =>
                array (
                    'id' => 47,
                    'country_id' => 107,
                    'name' => 'Postal Identity Card',
                    'code' => 'postal_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PO',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'postal_identity_card',
                        ),
                    'enabled' => true,
                ),
            47 =>
                array (
                    'id' => 48,
                    'country_id' => 108,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            48 =>
                array (
                    'id' => 49,
                    'country_id' => 108,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            49 =>
                array (
                    'id' => 50,
                    'country_id' => 108,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            50 =>
                array (
                    'id' => 51,
                    'country_id' => 112,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            51 =>
                array (
                    'id' => 52,
                    'country_id' => 113,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            52 =>
                array (
                    'id' => 53,
                    'country_id' => 113,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            53 =>
                array (
                    'id' => 54,
                    'country_id' => 113,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            54 =>
                array (
                    'id' => 55,
                    'country_id' => 114,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            55 =>
                array (
                    'id' => 56,
                    'country_id' => 114,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            56 =>
                array (
                    'id' => 57,
                    'country_id' => 114,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            57 =>
                array (
                    'id' => 58,
                    'country_id' => 115,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            58 =>
                array (
                    'id' => 59,
                    'country_id' => 116,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            59 =>
                array (
                    'id' => 60,
                    'country_id' => 118,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            60 =>
                array (
                    'id' => 61,
                    'country_id' => 129,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            61 =>
                array (
                    'id' => 62,
                    'country_id' => 129,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            62 =>
                array (
                    'id' => 63,
                    'country_id' => 129,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            63 =>
                array (
                    'id' => 64,
                    'country_id' => 129,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            64 =>
                array (
                    'id' => 65,
                    'country_id' => 146,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            65 =>
                array (
                    'id' => 66,
                    'country_id' => 130,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            66 =>
                array (
                    'id' => 67,
                    'country_id' => 142,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            67 =>
                array (
                    'id' => 68,
                    'country_id' => 142,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            68 =>
                array (
                    'id' => 69,
                    'country_id' => 149,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            69 =>
                array (
                    'id' => 70,
                    'country_id' => 161,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            70 =>
                array (
                    'id' => 71,
                    'country_id' => 161,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            71 =>
                array (
                    'id' => 72,
                    'country_id' => 161,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            72 =>
                array (
                    'id' => 73,
                    'country_id' => 161,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            73 =>
                array (
                    'id' => 74,
                    'country_id' => 162,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            74 =>
                array (
                    'id' => 75,
                    'country_id' => 162,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            75 =>
                array (
                    'id' => 76,
                    'country_id' => 162,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            76 =>
                array (
                    'id' => 77,
                    'country_id' => 164,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            77 =>
                array (
                    'id' => 78,
                    'country_id' => 169,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            78 =>
                array (
                    'id' => 79,
                    'country_id' => 169,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            79 =>
                array (
                    'id' => 80,
                    'country_id' => 169,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            80 =>
                array (
                    'id' => 81,
                    'country_id' => 169,
                    'name' => 'Postal Identity Card',
                    'code' => 'postal_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PO',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'postal_identity_card',
                        ),
                    'enabled' => true,
                ),
            81 =>
                array (
                    'id' => 82,
                    'country_id' => 169,
                    'name' => 'Professional Qualification Card',
                    'code' => 'professional_qualification_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => NULL,
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'professional_qualification_card',
                        ),
                    'enabled' => true,
                ),
            82 =>
                array (
                    'id' => 83,
                    'country_id' => 169,
                    'name' => 'Social Security Card',
                    'code' => 'social_security_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'SS',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'social_security_card',
                        ),
                    'enabled' => true,
                ),
            83 =>
                array (
                    'id' => 84,
                    'country_id' => 169,
                    'name' => 'Voter Id',
                    'code' => 'voter_id',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'VI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'voter_id',
                        ),
                    'enabled' => true,
                ),
            84 =>
                array (
                    'id' => 85,
                    'country_id' => 174,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            85 =>
                array (
                    'id' => 86,
                    'country_id' => 174,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            86 =>
                array (
                    'id' => 87,
                    'country_id' => 174,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            87 =>
                array (
                    'id' => 88,
                    'country_id' => 174,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            88 =>
                array (
                    'id' => 89,
                    'country_id' => 187,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            89 =>
                array (
                    'id' => 90,
                    'country_id' => 187,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            90 =>
                array (
                    'id' => 91,
                    'country_id' => 187,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            91 =>
                array (
                    'id' => 92,
                    'country_id' => 192,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            92 =>
                array (
                    'id' => 93,
                    'country_id' => 192,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            93 =>
                array (
                    'id' => 94,
                    'country_id' => 192,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            94 =>
                array (
                    'id' => 95,
                    'country_id' => 192,
                    'name' => 'Work Permit',
                    'code' => 'work_permit',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'WP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'work_permit',
                        ),
                    'enabled' => true,
                ),
            95 =>
                array (
                    'id' => 96,
                    'country_id' => 200,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            96 =>
                array (
                    'id' => 97,
                    'country_id' => 200,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            97 =>
                array (
                    'id' => 98,
                    'country_id' => 207,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            98 =>
                array (
                    'id' => 99,
                    'country_id' => 208,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            99 =>
                array (
                    'id' => 100,
                    'country_id' => 208,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            100 =>
                array (
                    'id' => 101,
                    'country_id' => 208,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            101 =>
                array (
                    'id' => 102,
                    'country_id' => 208,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            102 =>
                array (
                    'id' => 103,
                    'country_id' => 209,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            103 =>
                array (
                    'id' => 104,
                    'country_id' => 211,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            104 =>
                array (
                    'id' => 105,
                    'country_id' => 211,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            105 =>
                array (
                    'id' => 106,
                    'country_id' => 211,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            106 =>
                array (
                    'id' => 107,
                    'country_id' => 212,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            107 =>
                array (
                    'id' => 108,
                    'country_id' => 219,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            108 =>
                array (
                    'id' => 109,
                    'country_id' => 224,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            109 =>
                array (
                    'id' => 110,
                    'country_id' => 224,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            110 =>
                array (
                    'id' => 111,
                    'country_id' => 224,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            111 =>
                array (
                    'id' => 112,
                    'country_id' => 224,
                    'name' => 'Residence Permit',
                    'code' => 'residence_permit',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'RP',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'residence_permit',
                        ),
                    'enabled' => true,
                ),
            112 =>
                array (
                    'id' => 113,
                    'country_id' => 229,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            113 =>
                array (
                    'id' => 114,
                    'country_id' => 232,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            114 =>
                array (
                    'id' => 115,
                    'country_id' => 232,
                    'name' => 'National Identity Card',
                    'code' => 'national_identity_card',
                    'sides' => '2',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'NI',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'national_identity_card',
                        ),
                    'enabled' => true,
                ),
            115 =>
                array (
                    'id' => 116,
                    'country_id' => 232,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            116 =>
                array (
                    'id' => 117,
                    'country_id' => 237,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            117 =>
                array (
                    'id' => 118,
                    'country_id' => 237,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
            118 =>
                array (
                    'id' => 119,
                    'country_id' => 164,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            119 =>
                array (
                    'id' => 120,
                    'country_id' => 130,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            120 =>
                array (
                    'id' => 121,
                    'country_id' => 142,
                    'name' => 'Passport',
                    'code' => 'passport',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'PA',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'passport',
                        ),
                    'enabled' => true,
                ),
            121 =>
                array (
                    'id' => 122,
                    'country_id' => 142,
                    'name' => 'Driving Licence',
                    'code' => 'driving_licence',
                    'sides' => '1',
                    'id_doc_type_data' =>
                        array (
                            'trans_fast_sender_id_type_id' => 'DL',
                            'trans_fast_receiver_id_type_id' => NULL,
                            'onfido_document_type' => 'driving_licence',
                        ),
                    'enabled' => true,
                ),
        );
    }
}
