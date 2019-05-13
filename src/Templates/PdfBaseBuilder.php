<?php

namespace RebelWalls\PdfLibHelper\Templates;

use Pdf\PdfLibAdapter;
use RebelWalls\PdfLibHelper\Helpers\PdfPosition;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawCell;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawGraphic;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawImage;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawKeyValueTable;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawLine;
use RebelWalls\PdfLibHelper\Templates\Concerns\CanDrawTable;

/**
 * @property PdfLibAdapter adapter
 */
abstract class PdfBaseBuilder
{
    protected $pdf;
    protected $pos;
    protected $text;
    protected $color;
    protected $fontList;
    protected $defaultFont;
    protected $defaultFontSize;
    protected $additionalFonts;

    use CanDrawCell;
    use CanDrawGraphic;
    use CanDrawImage;
    use CanDrawKeyValueTable;
    use CanDrawLine;
    use CanDrawTable;

    /**
     * PdfBaseTemplate constructor.
     *
     * @param array $options
     */
    public function __construct()
    {
        $this->adapter = new PdfLibAdapter;

        $this->pos = new PdfPosition();
    }
}
