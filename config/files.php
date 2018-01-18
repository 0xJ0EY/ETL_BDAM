<?php

use ETL\Types\Date;
use ETL\Types\DateTime;
use ETL\Types\Time;
use ETL\Types\Varchar;
use ETL\Types\Interger;
use ETL\Types\MergeDatetime;
use ETL\Types\Device;

return [
    ETL\FileType::LOGBOEK => [
        'rows' => [
            1 => [
                'name' => 'student_number',
                'type' => new Varchar(255)
            ],
            2 => [
                'name' => 'date_watched',
                'type' => new MergeDateTime(),
                'extra_columns' => [
                    'time' => 3
                ]
            ],
            4 => [
                'name' => 'device',
                'type' => new Device()
            ], 
            5 => [
                'name' => 'channel',
                'type' => new Varchar(255)
            ],
            6 => [
                'name' => 'video',
                'type' => new Varchar(255) 
            ],
            7 => [
                'name' => 'time_watched',
                'type' => new Time()
            ],
            8 => [
                'name' => 'rating',
                'type' => new Interger()
            ]
        ],
        'database' => 'logboek'
    ]
];  