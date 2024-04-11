<?php

namespace Drive\ScaleflexApiConnector\Enums;

enum SortField: string
{
    case NAME = 'name';
    case UPLOADED_AT = 'uploaded_at';
    case CREATED_AT = 'created_at';
    case MODIFIED_AT = 'modified_at';
    case SIZE = 'size';
}
