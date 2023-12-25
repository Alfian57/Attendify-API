<?php

namespace App\Enums;

enum Config: string
{
    case QR_CODE = 'qr_code';
    case ATTENDANCE_TIME_START = 'attendance_time_start';
    case ATTENDANCE_TIME_END = 'attendance_time_end';
}
