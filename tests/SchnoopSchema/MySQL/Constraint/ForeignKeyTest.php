<?php

namespace MilesAsylum\SchnoopSchema\Tests\SchnoopSchema\MySQL\Constraint;

use MilesAsylum\SchnoopSchema\MySQL\Constraint\ConstraintInterface;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKey;
use MilesAsylum\SchnoopSchema\MySQL\Constraint\ForeignKeyColumn;
use MilesAsylum\SchnoopSchema\PHPUnit\Framework\ConstraintTestCase;

class ForeignKeyTest extends ConstraintTestCase
{
    protected $constraintName = 'schnoop_idx';

    /**
     * @var ForeignKey
     */
    protected $foreignKey;

    public function setUp()
    {
        parent::setUp();

        $this->foreignKey = new ForeignKey($this->constraintName);
    }

    /**
     * @return ConstraintInterface
     */
    protected function getConstraint()
    {
        return $this->foreignKey;
    }

    protected function getConstraintName()
    {
        return $this->constraintName;
    }

    protected function getConstraintType()
    {
        return ConstraintInterface::CONSTRAINT_FOREIGN_KEY;
    }

    public function testInitialProperties()
    {
        parent::testInitialProperties();

        $this->assertSame(ForeignKey::REFERENCE_ACTION_RESTRICT, $this->foreignKey->getOnDeleteAction());
        $this->assertSame(ForeignKey::REFERENCE_ACTION_RESTRICT, $this->foreignKey->getOnUpdateAction());

        $this->assertFalse($this->foreignKey->hasReferenceTableName());
        $this->assertNull($this->foreignKey->getReferenceTableName());

        $this->assertFalse($this->foreignKey->hasForeignKeyColumns());
        $this->assertSame([], $this->foreignKey->getForeignKeyColumns());

        $this->assertSame([], $this->foreignKey->getColumnNames());
        $this->assertSame([], $this->foreignKey->getReferenceColumnNames());
    }

    public function testSetOnDeleteAction()
    {
        $this->foreignKey->setOnDeleteAction(ForeignKey::REFERENCE_ACTION_CASCADE);
        $this->assertSame(ForeignKey::REFERENCE_ACTION_CASCADE, $this->foreignKey->getOnDeleteAction());
    }

    public function testSetOnUpdateAction()
    {
        $this->foreignKey->setOnUpdateAction(ForeignKey::REFERENCE_ACTION_CASCADE);
        $this->assertSame(ForeignKey::REFERENCE_ACTION_CASCADE, $this->foreignKey->getOnUpdateAction());
    }

    public function testSetReferenceTableName()
    {
        $referenceTableName = 'ref_tbl';
        $this->foreignKey->setReferenceTableName($referenceTableName);

        $this->assertSame($referenceTableName, $this->foreignKey->getReferenceTableName());
    }

    public function testSetForeignKeyColumns()
    {
        $fkColumnA = $this->createMock(ForeignKeyColumn::class);
        $fkColumnA->method('getColumnName')->willReturn('col_a');
        $fkColumnA->method('getReferenceColumnName')->willReturn('ref_col_a');
        $fkColumnB = $this->createMock(ForeignKeyColumn::class);
        $fkColumnB->method('getColumnName')->willReturn('col_b');
        $fkColumnB->method('getReferenceColumnName')->willReturn('ref_col_b');

        $foreignKeyColumns = [
            $fkColumnA,
            $fkColumnB
        ];

        $this->foreignKey->setForeignKeyColumns($foreignKeyColumns);

        $this->assertSame($foreignKeyColumns, $this->foreignKey->getForeignKeyColumns());
        $this->assertSame(['col_a','col_b'], $this->foreignKey->getColumnNames());
        $this->assertSame(['ref_col_a','ref_col_b'], $this->foreignKey->getReferenceColumnNames());
    }

    public function testDDL()
    {
        $expectedDDL = <<<SQL
CONSTRAINT `{$this->constraintName}` FOREIGN KEY (`col_a`,`col_b`) REFERENCES `ref_tbl` (`ref_col_a`,`ref_col_b`) ON DELETE RESTRICT ON UPDATE RESTRICT
SQL;
        $fkColumnA = $this->createMock(ForeignKeyColumn::class);
        $fkColumnA->method('getColumnName')->willReturn('col_a');
        $fkColumnA->method('getReferenceColumnName')->willReturn('ref_col_a');
        $fkColumnB = $this->createMock(ForeignKeyColumn::class);
        $fkColumnB->method('getColumnName')->willReturn('col_b');
        $fkColumnB->method('getReferenceColumnName')->willReturn('ref_col_b');

        $foreignKeyColumns = [
            $fkColumnA,
            $fkColumnB
        ];
        $this->foreignKey->setForeignKeyColumns($foreignKeyColumns);

        $this->foreignKey->setReferenceTableName('ref_tbl');

        $this->assertSame($expectedDDL, (string)$this->foreignKey);
    }
}
