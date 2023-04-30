<?php

namespace App\Libs\Excel;

use App\Libs\Excel\Constants\ExcelBorderLineStyle;

class ExcelCellStyle
{
    /**
     * Sets the font of the cell style
     *
     * Example:
     * [
     *     'name' => 'Arial',
     *     'size' => 10,
     *     'color' => ['rgb' => '000000'],
     *     'bold' => true,
     *     'italic' => true,
     *     'underline' => true,
     *     'strikethrough' => true,
     * ]
     */
    private $fontProps;

    /**
     * Example:
     * [
     *     ExcelBorderPosition::ALL => [
     *         'borderStyle' => ExcelBorderLineStyle::THIN,
     *         'color' => ['rgb' => '000000'],
     *     ],
     * ]
     */
    private $borderProps;

    /**
     * Example:
     * [
     *     'horizontal' => ExcelTextAlignmentType::HORIZONTAL_GENERAL,
     *     'vertical' => ExcelTextAlignmentType::VERTICAL_CENTER,
     *     'wrapText' => true,
     *     'indent' => 1,
     * ]
     */
    private $alignmentProps;

    public function __construct()
    {
    }

    public function getFontProps()
    {
        return $this->fontProps;
    }

    public function setFontName(string $fontName)
    {
        $this->fontProps['name'] = $fontName;
        return $this;
    }

    public function setFontSize(int $fontSize)
    {
        $this->fontProps['size'] = $fontSize;
        return $this;
    }

    public function setFontColor(string $hexColor)
    {
        $this->fontProps['color'] = [
            'rgb' => $hexColor,
        ];
        return $this;
    }

    public function setFontBold(bool $bold)
    {
        $this->fontProps['bold'] = $bold;
        return $this;
    }

    public function setFontItalic(bool $italic)
    {
        $this->fontProps['italic'] = $italic;
        return $this;
    }

    public function setFontUnderline(bool $underline)
    {
        $this->fontProps['underline'] = $underline;
        return $this;
    }

    public function setFontStrikethrough(bool $strikethrough)
    {
        $this->fontProps['strikethrough'] = $strikethrough;
        return $this;
    }

    public function getBorderProps()
    {
        return $this->borderProps;
    }

    public function setBorderProp(
        string $position,
        string $borderLineStyle = ExcelBorderLineStyle::THIN,
        string $hexColor = '000000'
    ) {
        $this->borderProps[$position] = [
            'borderStyle' => $borderLineStyle,
            'color' => [
                'rgb' => $hexColor,
            ]
        ];
        return $this;
    }

    public function getAlignmentProps()
    {
        return $this->alignmentProps;
    }

    public function setHorizontalAlign(string $align)
    {
        $this->alignmentProps['horizontal'] = $align;
        return $this;
    }

    public function setVerticalAlign(string $align)
    {
        $this->alignmentProps['vertical'] = $align;
        return $this;
    }

    public function setTextWrap(bool $wrap)
    {
        $this->alignmentProps['wrapText'] = $wrap;
        return $this;
    }

    public function setIndent(int $indent)
    {
        $this->alignmentProps['indent'] = $indent;
        return $this;
    }
}
