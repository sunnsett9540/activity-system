<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Field;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            'วิศวกรรมคอมพิวเตอร์',
            'วิศวกรรมไฟฟ้า',
            'วิศวกรรมโยธา',
            'วิศวกรรมเครื่องกล',
            'วิศวกรรมอุตสาหการ',
            'วิศวกรรมโลจิสติกส์'
        ];

        foreach ($fields as $field) {
            Field::create([
                'field_name' => $field
            ]);
        }
    }
}