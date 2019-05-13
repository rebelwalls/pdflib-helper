<?php

namespace RebelWalls\PdfLibHelper\Templates\Concerns;

use RebelWalls\PdfLibHelper\Elements\PdfCell;
use RebelWalls\PdfLibHelper\Elements\PdfLine;
use RebelWalls\PdfLibHelper\Elements\PdfTable;
use RebelWalls\PdfLibHelper\Helpers\PdfColor;
use Illuminate\Support\Collection;

trait CanDrawTable
{
    /**
     * @param PdfTable $table
     * @param null $maxWidth
     */
    public function drawTable(PdfTable $table, $maxWidth = null): void
    {
        $startX = $this->pos->x;

        if (! $maxWidth) {
            $maxWidth = $this->pos->max_x - $this->pos->x;
        }

        $firstRow = $table->rows->first();

        /** @var Collection $columnWidths */
        $columnWidths = $firstRow->pluck('width');

        $totalSetWidth = $columnWidths->sum();
        $countSetWidth = $columnWidths->filter()->count();
        $totalColumnCount = $firstRow->count();
        $totalUnsetWidth = $maxWidth - $totalSetWidth;
        $countUnsetWidth = $totalColumnCount - $countSetWidth;

        if ($countUnsetWidth) {
            $defaultColumnWidth = $totalUnsetWidth / $countUnsetWidth;
        } else {
            $defaultColumnWidth = 0;
        }

        if ($table->titles) {
            $columnAlignments = $firstRow->pluck('align')->transform(function ($align) {
                    return $align ?? 'left';
                });

            $columnWidths = $columnWidths->transform(function ($width) use ($defaultColumnWidth) {
                return $width ?? $defaultColumnWidth;
            });

            $table->titles
                ->each(function ($title, $index) use ($table, $columnAlignments, $columnWidths) {
                    $this->drawCell(
                        PdfCell::make($title)
                            ->style('I')
                            ->size($table->size)
                            ->width($columnWidths[$index])
                            ->align($columnAlignments[$index])
                    );

                    $this->pos->addX($columnWidths[$index]);
                });

            $this->pos->addY(1);

            $this->drawLine(
                PdfLine::make()
                    ->fromPos($this->pos->min_x, $this->pos->y)
                    ->toPos($this->pos->max_x, $this->pos->y)
                    ->lineWidth(.2)
                    ->stroke((new PdfColor())->gray(.9))
            );

            $this->pos->setX($startX);
            $this->pos->addY($table->size + 1);
        }

        $table->rows
            ->each(function($tableRow) use ($table, $defaultColumnWidth, $startX) {
                $tableRow = collect($tableRow);

                collect($tableRow)
                    ->each(function (PdfCell $cell) use ($table, $defaultColumnWidth) {
                        if (! $cell->width) {
                            $cell->width = $defaultColumnWidth;
                        }

                        if (! $cell->size) {
                            $cell->size($table->size);
                        }

                        $this->drawCell($cell);

                        $this->pos->addX($cell->width);
                    });

                $this->pos->setX($startX);
                $this->pos->addY($table->size + 2);
            });
    }
}