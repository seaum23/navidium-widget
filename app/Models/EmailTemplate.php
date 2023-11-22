<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailTemplate extends Model
{
    use HasFactory;

    const TEMPLATES = [
        'reorder' => [
            'automation' => [
                'merchant' => 3,
                'customer' => 4,
            ],
            'manual' => [
                'merchant' => 11,
                'customer' => 12,
            ]
        ],
        'refund' => [
            'automation' => [
                'merchant' => 1,
                'customer' => 2,
            ],
            'manual' => [
                'merchant' => 9,
                'customer' => 10,
            ]
        ],
        'deny' => [
            'automation' => [
                'merchant' => 5,
                'customer' => 6,
            ],
            'manual' => [
                'merchant' => 13,
                'customer' => 14,
            ]
        ],
        'claim_review' => [
            'merchant' => 7,
            'customer' => 8,
        ]
    ];

    protected $table = "nvd_email_templates";
    protected $guarded = [];
}
