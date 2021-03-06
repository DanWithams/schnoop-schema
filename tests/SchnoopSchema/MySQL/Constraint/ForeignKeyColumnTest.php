<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyColumn;

class ForeignKeyColumnTest extends \PHPUnit_Framework_TestCase
{
    protected $columnName = 'schnoop_col';

    protected $referenceColumnName = 'schnoop_ref_col';

    /**
     * @var ForeignKeyColumn
     */
    protected $foreignKeyColumn;

    public function setUp()
    {
        parent::setUp();

        $this->foreignKeyColumn = new ForeignKeyColumn($this->columnName, $this->referenceColumnName);
    }

    public function testInitialProperties()
    {
        $this->assertSame($this->columnName, $this->foreignKeyColumn->getColumnName());
        $this->assertSame($this->referenceColumnName, $this->foreignKeyColumn->getReferenceColumnName());
    }
}
