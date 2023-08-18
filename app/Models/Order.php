<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const PROCESSING_ID = '0';
    const COMPLETED_ID = '1';

    const PROCESSING_STRING = 'Processing';
    const COMPLETED_STRING = 'Completed';
}
