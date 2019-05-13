<?php

namespace RebelWalls\PdfLibHelper\Elements;

/**
 * Class PdfKeyValue
 *
 * @package App\Services\Pdf\Generators
 */

class PdfKeyValue extends BaseGenerator
{
    public $items = [];

    public function addItem($key, $value)
    {
        $this->items[] = [$key, $value];

        return $this;
    }
}
