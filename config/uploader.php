<?php

return [

    'table_name' => env('UPLOAD_TABLE_NAME', 'files'),

    'disk' => env('UPLOAD_DISK', 'public'),

    'structure' => 'year/month/week',

    'visibility' => 'public', // public | private

    'optimize_images' => true,

    'image_max_width' => 1920,

];
