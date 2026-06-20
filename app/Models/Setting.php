<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'footer_menu_title_1', 'footer_menu_title_2', 'footer_menu_title_3',
        'footer_menu_title_4', 'footer_menu_title_5', 'footer_menu_title_6',
        'footer_menu_title_7', 'footer_menu_title_8', 'footer_menu_title_9',
        'footer_menu_title_10', 'footer_menu_title_11', 'footer_menu_title_12',
        'copyright', 'telegram', 'instagram', 'twitter', 'whatsapp'
    ];

}
