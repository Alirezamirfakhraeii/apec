<?php

namespace Database\Seeders;

use App\Models\PageBlockType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageBlockTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createBlockType([
            'name' => 'بخش کمیته',
            'key' => 'commite',
            'view_path' => 'front.pages.blocks.commite',
            'is_repeatable' => false,
            'sort_order' => 5,
            'fields' => [
                [
                    'label' => 'عنوان',
                    'field_key' => 'title',
                    'field_type' => 'text',
                    'is_required' => true,
                    'sort_order' => 1,
                ],
                [
                    'label' => 'عکس',
                    'field_key' => 'image',
                    'field_type' => 'image',
                    'is_required' => false,
                    'sort_order' => 2,
                ],
                [
                    'label' => 'سمت متن',
                    'field_key' => 'text_side',
                    'field_type' => 'select',
                    'settings' => [
                        'options' => [
                            'right' => 'متن سمت راست / عکس سمت چپ',
                            'left' => 'متن سمت چپ / عکس سمت راست',
                        ],
                    ],
                    'is_required' => true,
                    'sort_order' => 3,
                ],
                [
                    'label' => 'متن',
                    'field_key' => 'body',
                    'field_type' => 'editor',
                    'is_required' => true,
                    'sort_order' => 4,
                ],
            ],
        ]);
    }

    private function createBlockType(array $data): void
    {
        $fields = $data['fields'];
        unset($data['fields']);

        $type = PageBlockType::updateOrCreate(
            ['key' => $data['key']],
            $data + ['status' => 'active']
        );

        foreach ($fields as $field) {
            $type->fields()->updateOrCreate(
                ['field_key' => $field['field_key']],
                $field + ['status' => 'active']
            );
        }
    }
}
