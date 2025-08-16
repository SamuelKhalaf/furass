<?php

namespace Database\Seeders;

use App\Models\Ckeditor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variables_en = [
            'section1_title' => "We bridge <br> education and <br> careers to guide <br> students toward <br> success in both <br> school and life",
            'section1_img' => '<img src="' . asset('assets/imgs/template/test.jpg') . '" alt="About Image">',
        ];

        $variables_ar = [
            'section1_title' =>  "نحن نربط بين <br> التعليم والمهن <br> لإرشاد الطلاب نحو <br> النجاح في كلٍ من <br> المدرسة والحياة",
            'section1_img' => '<img src="' . asset('assets/imgs/template/test.jpg') . '" alt="About Image">',
        ];

        $record = Ckeditor::where('page', 'about')->first();

        if ($record) {
            $record->update([
                'variables_en' => $variables_en,
                'variables_ar' => $variables_ar,
            ]);
        } else {
            Ckeditor::create([
                'page' => 'about',
                'variables_en' => $variables_en,
                'variables_ar' => $variables_ar,
            ]);
        }
    }
}
