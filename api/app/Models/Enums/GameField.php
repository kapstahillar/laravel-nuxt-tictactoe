<?php

namespace App\Models\Enums;

enum GameField: string
{
    case PLAYER = "x";
    case AI = "o";
    case EMPTY_CELL = " ";
}