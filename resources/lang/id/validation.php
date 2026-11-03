<?php

return [
    'accepted' => ':Attribute harus diterima.',
    'required' => ':Attribute wajib diisi.',
    'email' => ':Attribute harus berupa alamat surel yang valid.',
    'unique' => ':Attribute sudah ada sebelumnya.',
    'min' => [
        'string' => ':Attribute minimal berisi :min karakter.',
    ],
    'max' => [
        'string' => ':Attribute maksimal berisi :max karakter.',
        'file' => ':Attribute maksimal berukuran :max kilobita.',
    ],
    'attributes' => [
        'title' => 'Judul laporan',
        'description' => 'Deskripsi laporan',
        'address' => 'Alamat lokasi',
        'region_id' => 'Kecamatan',
        'report_category_id' => 'Kategori laporan',
        'tracking_code' => 'Kode pelacakan',
        'phone' => 'Nomor HP/WhatsApp',
    ],
];
