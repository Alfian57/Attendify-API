<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case ALPHA = 'alpha';
    case SICK = 'sick';
    case PRESENT = 'present';
    case LEAVE = 'leave';
}
