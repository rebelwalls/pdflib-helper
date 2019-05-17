<?php

namespace RebelWalls\PdfLibHelper\Helpers;

class PdfPosition
{
    public $orientation;

    public $x;
    public $y;

    public $width;
    public $height;

    public $margin_top;
    public $margin_right;
    public $margin_bottom;
    public $margin_left;

    public $min_y;
    public $max_x;
    public $max_y;
    public $min_x;

    public $line_height;
    private $default_line_height;

    /**
     * PdfPosition constructor.
     *
     * @param $orientation
     */
    public function __construct($orientation = null)
    {
        if (! $orientation) {
            $orientation = config('pdf.orientation');
        }

        $this->orientation = $orientation;

        $this->x = 0;
        $this->y = 0;

        $this->setProps();
    }

    /**
     * @return $this
     */
    private function setProps()
    {
        if ($this->orientation === 'P') {
            $this->width = 210;
            $this->height = 297;
        } else {
            $this->width = 297;
            $this->height = 210;
        }

        $this->margin_top = config('pdf.margin.top');
        $this->margin_right = config('pdf.margin.right');
        $this->margin_bottom = config('pdf.margin.bottom');
        $this->margin_left = config('pdf.margin.left');

        $this->default_line_height = config('pdf.line-height');
        $this->line_height = $this->default_line_height;

        // Computed
        $this->min_y = $this->margin_top;
        $this->max_x = $this->width - $this->margin_right;
        $this->max_y = $this->height - $this->margin_bottom;
        $this->min_x = $this->margin_left;

        return $this;
    }

    /**
     * @param $defaultLineHeight
     *
     * @return $this
     */
    public function setDefaultLineHeight($defaultLineHeight)
    {
        $this->default_line_height = $defaultLineHeight;
        $this->line_height = $defaultLineHeight;

        return $this;
    }

    /**
     * @return $this
     */
    public function reset()
    {
        $this->x = $this->min_x;
        $this->y = $this->min_y;
        $this->resetLineHeight();

        return $this;
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return $this
     */
    public function setXY(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;

        return $this;
    }

    /**
     * @param int $x
     *
     * @return $this
     */
    public function setX(int $x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * @param int $y
     *
     * @return $this
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * @param int $addedX
     *
     * @return $this
     */
    public function addX($addedX)
    {
        $this->x = $this->x + $addedX;

        return $this;
    }

    /**
     * @param int $addedY
     *
     * @return $this
     */
    public function addY($addedY)
    {
        $this->y += $addedY;

        return $this;
    }

    /**
     * @param int $subbedX
     *
     * @return $this
     */
    public function subX($subbedX)
    {
        $this->x -= $subbedX;

        return $this;
    }

    /**
     * @param int $subbedY
     *
     * @return $this
     */
    public function subY($subbedY)
    {
        $this->y -= $subbedY;

        return $this;
    }

    /**
     * @param int|null $count
     *
     * @return $this
     */
    public function lineBreak(int $count = 1)
    {
        $this->y += $this->line_height * $count;

        return $this;
    }

    /**
     * @param int $minY
     *
     * @return $this
     */
    public function setMinY(int $minY)
    {
        $this->min_y = $minY;

        return $this;
    }

    /**
     * @param int $maxY
     *
     * @return $this
     */
    public function setMaxY(int $maxY)
    {
        $this->max_y = $maxY;

        return $this;
    }

    /**
     * @return int
     */
    public function getUsableX(): int
    {
        return $this->width - $this->margin_right - $this->margin_left;
    }

    /**
     * @return int
     */
    public function getUsableY(): int
    {
        return $this->height - $this->margin_top - $this->margin_bottom;
    }

    /**
     * @return $this
     */
    public function setSmallLineHeight(bool $bool = true)
    {
        if ($bool) {
            $this->line_height = config('fpdf.line-height') - 1;
        } else {
            $this->resetLineHeight();
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function resetLineHeight()
    {
        $this->line_height = $this->default_line_height;

        return $this;
    }

    /**
     * @return $this
     */
    public function moveToFarLeft()
    {
        $this->x = $this->margin_left;

        return $this;
    }

    /**
     * @return $this
     */
    public function moveToFarRight()
    {
        $this->x = $this->width - $this->margin_right;

        return $this;
    }

    /**
     * @return $this
     */
    public function moveToTop()
    {
        $this->y = $this->margin_top;

        return $this;
    }

    /**
     * @return $this
     */
    public function moveToBottom()
    {
        $this->y = $this->height - $this->margin_bottom;

        return $this;
    }
}
