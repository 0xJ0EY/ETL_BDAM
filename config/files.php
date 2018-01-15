<?php

use ETL\Types\Varchar;
use ETL\Types\DatetimeMultiple;

return [
    ETL\FileType::LOGBOEK => [
        'format' => [
            7 => function($value) {
                if ($value == 'null') return '00:00';
                return (new DateTime($value))->format('H:i');
            }
        ],
        'rows' => [
            0 => [
                'name' => 'timestamp',
                'type' => new Varchar(255)
            ],
            1 => [
                'name' => 'student_number',
                'type' => new Varchar(255)
            ],
            2 => [
                'name' => 'date_watched',
                'type' => new MergeDatetime(),
                'extra_columns' => [
                    'time_watched' => 3
                ]
            ],
            4 => [
                'name' => 'device',
                'type' => new Varchar(255)
            ], 
        ],
        'database' => 'tabelnaam'
    ]
];