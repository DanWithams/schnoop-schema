<?php

namespace MilesAsylum\SchnoopSchema\MySQL\DataType;

class TinyIntType extends AbstractIntType
{
    const MIN_SIGNED = -128;
    const MAX_SIGNED = 127;
    const MIN_UNSIGNED = 0;
    const MAX_UNSIGNED = 255;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return self::TYPE_TINYINT;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinRange()
    {
        return $this->isSigned() ? self::MIN_SIGNED : self::MIN_UNSIGNED;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxRange()
    {
        return $this->isSigned() ? self::MAX_SIGNED : self::MAX_UNSIGNED;
    }
}
