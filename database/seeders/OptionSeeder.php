<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->preliminaryData() as $key => $option) {
            if ( Option::whereTag($option['tag'])->first() ) continue;

            Option::create($option);
        }
    }

    protected function preliminaryData() {
        return [
            [
                'tag'=> 'front_theme',
                'type'=> 'hidden',
                'is_translatable'=> false,
                'plain_data'=> '2023',
            ],
            [
                'tag'=> 'panel_theme',
                'type'=> 'hidden',
                'is_translatable'=> false,
                'plain_data'=> 'ZedAdmin',
            ],
            [
                'tag'=> 'site_short_name',
                'type'=> 'text',
                'en'=> [
                    'name'=> 'Website short name',
                    'data'=> 'ZagreusCMS',
                    'default'=> null,
                ],
                'fa'=> [
                    'name'=> 'نام کوتاه وبسایت',
                    'data'=> 'ZagreusCMS',
                    'default'=> null,
                ]
            ],
            [
                'tag'=> 'site_tag_line',
                'type'=> 'text',
                'en'=> [
                    'name'=> 'Website tag line',
                    'data'=> 'Modular Laravel CMS',
                    'default'=> null
                ],
                'fa'=> [
                    'name'=> 'معرفی کوتاه',
                    'data'=> 'سامانه مدیریت محتوای زاگرس',
                    'default'=> null
                ]
            ],
            [
                'tag'=> 'site_description',
                'type'=> 'textarea',
                'en'=> [
                    'name'=> 'Site description',
                    'data'=> 'Put small description up to 160 chars for this field.',
                    'default'=> null
                ],
                'fa'=> [
                    'name'=> 'توضیحات سایت',
                    'data'=> 'یک توضیح کوتاه تا 160 کلمه در اینجا قرار دهید',
                    'default'=> null
                ]
            ],
            [
                'tag'=> 'site_keywords',
                'type'=> 'textarea',
                'en'=> [
                    'name'=> 'Your website main keywords',
                    'data'=> 'Laravel CMS, Laravel 8 CMS, PHP CMS, Zagreus CMS, Laravel Zagureus',
                    'default'=> null,
                ],
    
                'fa'=> [
                    'name'=> 'کلمات کلیدی وب سایت',
                    'data'=> 'لاراول, CMS لاراول, Laravel CMS, Laravel 8 CMS, Zagreus CMS',
                    'default'=> null,
                ]
            ],
            [
                'tag'=> 'allow_register',
                'type'=> 'select',
                'en'=> [
                    'name'=> 'Allow anyone to register',
                    'data'=> '0',
                    'default'=> ["values"=> ["1"=> "Allow", "0"=> "Deny"] ],
                ],
                'fa'=> [
                    'name'=> 'اجازه ثبت نام',
                    'data'=> '0',
                    'default'=> ["values"=> ["1"=> "مجاز", "0"=> "غیرمجاز"] ]
                ]
            ],
            [
                'tag'=> 'guest_can_comment',
                'type'=> 'select',
                'en'=> [
                    'name'=> 'Allow commenting for guest users',
                    'data'=> '1',
                    'default'=> ["values"=> ["1"=> "Allow", "0"=> "Deny"] ]
                ],
                'fa'=> [
                    'name'=> 'اجازه ثبت نظر توسط کاربر مهمان',
                    'data'=> '1',
                    'default'=> ["values"=> ["1"=> "مجاز", "0"=> "غیرمجاز"] ]
                ]
            ],
            [
                'tag'=> 'straight_publish_comments',
                'type'=> 'select',
                'en'=> [
                    'name'=> 'Publish comments without admin check',
                    'data'=> '1',
                    'default'=> ["values"=> ["1"=> "Allow", "0"=> "Deny"] ]
                ],
                'fa'=> [
                    'name'=> 'انتظار نظرات بدون برسی مدیریت',
                    'data'=> '1',
                    'default'=> ["values"=> ["1"=> "مجاز", "0"=> "غیرمجاز"] ]
                ]
            ],
            [
                'tag'=> 'cache_id',
                'type'=> 'number',
                'en'=> [ 
                    'name'=> 'Cache ID',
                    'data'=> '1',
                    'default'=> null,
                ],
                'fa'=> [
                    'name'=> 'شناسه کش',
                    'data'=> '1',
                    'default'=> null,
                ]
            ],
            [
                'tag'=> 'head_extra',
                'type'=> 'textarea',
                'en'=> [
                    'name'=> 'Extra codes to put in head tag',
                    'data'=> '',
                    'default'=> null,
                ],
                'fa'=> [
                    'name'=> 'کد های اضافی در <head> سایت',
                    'data'=> '',
                    'default'=> null
                ]
            ],
            [
                'tag'=> 'footer_extra',
                'type'=> 'textarea',
                'en'=> [
                    'name'=> 'Extra codes to put in footer tag',
                    'data'=> '',
                    'default'=> null
                ],
                'fa'=> [
                    'name'=> 'کد های اضافی در <footer> سایت',
                    'data'=> '',
                    'default'=> null
                ]
            ],
        ];
    }
}