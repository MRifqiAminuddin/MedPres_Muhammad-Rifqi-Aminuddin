<?php

return [

    'required' => ':attribute wajib diisi.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'string' => ':attribute harus berupa teks.',
    'max' => [
        'string' => ':attribute maksimal :max karakter.',
    ],
    'min' => [
        'string' => ':attribute minimal :min karakter.',
    ],
    'unique' => ':attribute sudah digunakan.',
    'in' => ':attribute tidak valid.',

    'attributes' => [
        'name'       => 'Nama',
        'gender'     => 'Jenis kelamin',
        'email'      => 'Email',
        'strNumber'  => 'Nomor STR',
        'sipNumber'  => 'Nomor SIP',
        'station'    => 'Poli',
    ],
];
