<?php


namespace App\Models;


class CellForTableResultDepartmentBelbinTest
{
    private $value;
    private $colorCell;

    public function __construct($value, $numberColumn)
    {
        $this->value = $value;
        $this->colorCell = $this->setColorCell($value, $numberColumn);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getColorCell()
    {
        return $this->colorCell;
    }

    // Numbers color:
    // 0 - red
    // 1 - without color
    // 2 - green
    // 3 - darkgreen
    private function setColorCell($value, $numberColumn):int
    {
        $limits = [ 0 => ['bebinMiddle' => 7, 'beginHigh' => 12, 'beginVeryHigh' => 17],
                    1 => ['bebinMiddle' => 7, 'beginHigh' => 11, 'beginVeryHigh' => 14],
                    2 => ['bebinMiddle' => 9, 'beginHigh' => 14, 'beginVeryHigh' => 18],
                    3 => ['bebinMiddle' => 5, 'beginHigh' => 9, 'beginVeryHigh' => 13],
                    4 => ['bebinMiddle' => 7, 'beginHigh' => 10, 'beginVeryHigh' => 12],
                    5 => ['bebinMiddle' => 6, 'beginHigh' => 10, 'beginVeryHigh' => 13],
                    6 => ['bebinMiddle' => 9, 'beginHigh' => 13, 'beginVeryHigh' => 17],
                    7 => ['bebinMiddle' => 4, 'beginHigh' => 7, 'beginVeryHigh' => 10]
                    ];
        if ($value < $limits[$numberColumn]['bebinMiddle']) {
            return 0;
        }
        if ($value < $limits[$numberColumn]['beginHigh']) {
            return 1;
        }
        if ($value < $limits[$numberColumn]['beginVeryHigh']) {
            return 2;
        }
        return 3;
    }
}
