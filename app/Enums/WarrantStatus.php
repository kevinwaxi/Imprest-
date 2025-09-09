<?php

namespace App\Enums;

enum WarrantStatus: string {
case DRAFT    = 'draft';
case CHECKED  = 'checked';
case APPROVED = 'approved';
case PAID     = 'paid';
}
