<?php

namespace MilesAsylum\SchnoopSchema\MySQL\Constraint;

abstract class AbstractConstraint implements ConstraintInterface
{
    /**
     * @var null
     */
    protected $name;

    protected $constraintType;

    /**
     * @var string
     */
    protected $tableName;

    public function __construct($name, $constraintType)
    {
        $this->name = $name;
        $this->constraintType = $constraintType;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getConstraintType()
    {
        return $this->constraintType;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * Identify if the index has been attached to a table.
     * @return bool True if the index has been attached to a table.
     */
    public function hasTableName()
    {
        return isset($this->tableName);
    }
}
