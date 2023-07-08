<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Cell\DataType;

class ExcelDataType
{
    const STRING = DataType::TYPE_STRING;
    const FORMULA = DataType::TYPE_FORMULA;
    const NUMERIC = DataType::TYPE_NUMERIC;
    const BOOL = DataType::TYPE_BOOL;
    const NULL = DataType::TYPE_NULL;
    const INLINE = DataType::TYPE_INLINE;
    const ERROR = DataType::TYPE_ERROR;
    const ISO_DATE = DataType::TYPE_ISO_DATE;
}
