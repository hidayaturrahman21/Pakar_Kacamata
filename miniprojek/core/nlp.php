<?php

function prosesNLP($text)
{
    $text = strtolower($text);

    $kamus = [

        // ======================
        // KELUHAN
        // ======================

        'VIS01' => [
            'kabur jauh',
            'rabun jauh',
            'blur jauh'
        ],

        'VIS02' => [
            'sulit baca',
            'tidak jelas dekat',
            'susah membaca'
        ],

        'VIS03' => [
            'mata lelah',
            'mata capek',
            'mata perih',
            'mata berat',
            'pegal mata'
        ],

        'VIS04' => [
            'mata merah',
            'iritasi'
        ],

        'VIS05' => [
            'silau malam',
            'silau lampu'
        ],

        'VIS06' => [
            'sensitif cahaya',
            'silau matahari'
        ],

        'VIS07' => [
            'mata kering',
            'kering',
            'pedih'
        ],

        // ======================
        // AKTIVITAS
        // ======================

        'ACT01' => [
            'depan layar',
            'main laptop',
            'komputer',
            'gadget',
            'main hp',
            'editing',
            'gaming',
            'ngoding'
        ],

        'ACT02' => [
            'menyetir malam',
            'driver malam'
        ],

        'ACT03' => [
            'outdoor',
            'lapangan',
            'luar ruangan'
        ],

        'ACT04' => [
            'olahraga',
            'futsal',
            'badminton'
        ],

        'ACT05' => [
            'ruangan ac',
            'kantor ac'
        ],

        // ======================
        // SCREEN TIME
        // ======================

        'SCR01' => [
            'seharian laptop',
            'lama depan layar',
            'main gadget terus',
            'screen time',
            'lebih dari 5 jam'
        ],

        // ======================
        // USIA
        // ======================

        'AGE01' => [
            'anak-anak',
            'anak sekolah'
        ],

        'AGE02' => [
            'dewasa'
        ],

        'AGE03' => [
            'usia 40',
            'umur 40'
        ],

        // ======================
        // REFRAKSI
        // ======================

        'REF01' => [
            'minus'
        ],

        'REF02' => [
            'plus'
        ],

        'REF03' => [
            'silinder',
            'cylinder'
        ]
    ];

    $hasil = [];

    foreach ($kamus as $kode => $keywords) {

        foreach ($keywords as $keyword) {

            if (strpos($text, $keyword) !== false) {

                $hasil[] = $kode;
                break;
            }
        }
    }

    return array_unique($hasil);
}