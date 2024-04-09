<?php

namespace Drive\ScaleflexApiConnector\Enums;

enum ImageMimeTypes: string
{
    case JPEG = 'image/jpeg';
    case PNG = 'image/png';
    case GIF = 'image/gif';
    case WEBP = 'image/webp';
    case AVIF = 'image/avif';
    case SVG = 'image/svg';
    case BMP = 'image/bmp';
}
