<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case RECEPTIONIST = 'receptionist';
    case PATIENT = 'patient';
}
