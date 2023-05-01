<?php

namespace App\Libs\Excel;

use App\Libs\Excel\Constants\ExcelBorderConstants;
use App\Libs\Excel\Constants\ExcelFillType;

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
    private $fontProps = [];

    /**
     * Example:
     * [
     *     ExcelBorderConstants::POSITION_ALL => [
     *         'borderStyle' => ExcelBorderConstants::LINE_STYLE_THIN,
     *         'color' => ['rgb' => '000000'],
     *     ],
     * ]
     */
    private $borderProps = [];

    /**
     * Example:
     * [
     *     'horizontal' => ExcelTextAlignmentType::HORIZONTAL_GENERAL,
     *     'vertical' => ExcelTextAlignmentType::VERTICAL_CENTER,
     *     'wrapText' => true,
     *     'indent' => 1,
     * ]
     */
    private $alignmentProps = [];

    /**
     * Example:
     * [
     *     'fillType' => ExcelFillType::SOLID,
     *     'color' => ['rgb' => '000000']
     * ]
     */
    private $fillProps = [];

    /**
     * Example:
     * [
     *     'formatCode' => any string or ExcelNumberFormatCode::GENERAL
     * ]
     */
    private $numberFormatProps = [];

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

    public function setFontBold(bool $bold = true)
    {
        $this->fontProps['bold'] = $bold;
        return $this;
    }

    public function setFontItalic(bool $italic = true)
    {
        $this->fontProps['italic'] = $italic;
        return $this;
    }

    public function setFontUnderline(bool $underline = true)
    {
        $this->fontProps['underline'] = $underline;
        return $this;
    }

    public function setFontStrikethrough(bool $strikethrough = true)
    {
        $this->fontProps['strikethrough'] = $strikethrough;
        return $this;
    }

    public function getBorderProps()
    {
        return $this->borderProps;
    }

    /**
     * Set the border properties
     *
     * @param string $position see ExcelBorderConstants::POSITION_*
     * @param string $borderLineStyle see ExcelBorderConstants::LINE_STYLE_*
     * @param string $hexColor Color of the border (hex code)
     *
     * @return $this
     */
    public function setBorder(
        string $position = ExcelBorderConstants::POSITION_ALL,
        string $borderLineStyle = ExcelBorderConstants::LINE_STYLE_THIN,
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

    /**
     * Set the horizontal align
     *
     * @param string $align see ExcelTextAlignmentType::HORIZONTAL_*
     *
     * @return $this
     */
    public function setHorizontalAlign(string $align)
    {
        $this->alignmentProps['horizontal'] = $align;
        return $this;
    }

    /**
     * Set the vertical align
     *
     * @param string $align see ExcelTextAlignmentType::VERTICAL_*
     *
     * @return $this
     */
    public function setVerticalAlign(string $align)
    {
        $this->alignmentProps['vertical'] = $align;
        return $this;
    }

    public function setTextWrap(bool $wrap = true)
    {
        $this->alignmentProps['wrapText'] = $wrap;
        return $this;
    }

    public function setIndent(int $indent)
    {
        $this->alignmentProps['indent'] = $indent;
        return $this;
    }

    /**
     * Set the fill color (background color)
     *
     * @param string $hexColor Color of the fill (hex code)
     * @param string $fillType see ExcelFillType::*
     */
    public function setFillProps(string $hexColor, string $fillType = ExcelFillType::SOLID)
    {
        $this->fillProps = [
            'color' => [
                'rgb' => $hexColor,
            ],
            'fillType' => $fillType,
        ];
        return $this;
    }

    public function getFillProps()
    {
        return $this->fillProps;
    }

    /**
     * Set number format.
     *
     * @param string $formatCode Can be a custom string or a value in ExcelNumberFormatType::*
     *
     * @return $this
     */
    public function setNumberFormat(string $formatCode)
    {
        $this->numberFormatProps = [
            'formatCode' => $formatCode,
        ];
        return $this;
    }

    public function getNumberFormatProps()
    {
        return $this->numberFormatProps;
    }
}
