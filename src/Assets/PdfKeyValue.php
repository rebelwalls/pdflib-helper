<?php

namespace RebelWalls\PdfLibHelper\Assets;

/**
 * Class PdfKeyValue
 *
 * @package App\Services\Pdf\Generators
 */

class PdfKeyValue extends BaseAsset
{
    public $items = [];

    public function addItem($key, $value)
    {
        $this->items[] = [$key, $value];

        return $this;
    }
}
