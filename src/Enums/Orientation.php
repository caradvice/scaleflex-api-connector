<?php

namespace Drive\ScaleflexApiConnector\Enums;

enum Orientation: string
{
    case PA = 'PA'; // Panorama image
    case PO = 'PO'; // Portrait image
    case SQ = 'SQ'; // Square image
    case LD = 'LD'; // Landscape image
}
