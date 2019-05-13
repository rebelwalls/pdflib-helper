<?php

namespace RebelWalls\PdfLibHelper\Elements;

use RebelWalls\PdfLibHelper\Helpers\PdfColor;

class PdfCell extends BaseGenerator
{
    public $align;
    public $caps;
    public $color;
    public $content;
    public $currency;
    public $font;
    public $line_height;
    public $size;
    public $style;
    public $weight;
    public $width;

    /**
     * PdfCell constructor.
     *
     * @param $contentString
     */
    public function __construct($contentString)
    {
        $this->setContent($contentString);
    }

    private function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function align(string $align)
    {
        $this->align = $align;

        return $this;
    }

    public function caps(bool $caps = true)
    {
        $this->caps = $caps;

        return $this;
    }

    public function color(PdfColor $color)
    {
        $this->color = $color;

        return $this;
    }

    public function currency(string $currency = 'sek')
    {
        $this->currency = $currency;

        return $this;
    }

    public function font(string $font)
    {
        $this->font = $font;

        return $this;
    }

    public function style(string $style)
    {
        $this->style = $style;

        return $this;
    }

    public function isWeight()
    {
        $this->weight = true;

        return $this;
    }

    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    public function lineHeight($lineHeight)
    {
        $this->line_height = $lineHeight;

        return $this;
    }

    public function width($width)
    {
        $this->width = $width;

        return $this;
    }
}
