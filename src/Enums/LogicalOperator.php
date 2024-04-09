<?php

namespace Drive\ScaleflexApiConnector\Enums;

enum LogicalOperator: string
{
    case AND = 'AND';
    case OR = 'OR';
    case NOT = 'NOT';
}
