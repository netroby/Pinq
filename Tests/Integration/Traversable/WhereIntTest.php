<?php

namespace Pinq\Tests\Integration\Traversable;

class WhereIntTest extends TraversableTest
{
    protected function _testReturnsNewInstanceOfSameTypeWithSameScheme(\Pinq\ITraversable $traversable)
    {
        return $traversable->whereIn([]);
    }

    /**
     * @dataProvider everything
     */
    public function testThatWhereInWithSelfReturnsAllValues(\Pinq\ITraversable $traversable, array $data)
    {
        $values = $traversable->whereIn($traversable);

        $this->assertMatches($values, $data);
    }

    /**
     * @dataProvider everything
     */
    public function testThatWhereInWithEmptyReturnsEmpty(\Pinq\ITraversable $traversable, array $data)
    {
        $values = $traversable->whereIn([]);

        $this->assertMatches($values, []);
    }

    /**
     * @dataProvider oneToTen
     */
    public function testThatWhereInWithDuplicateValuesPreservesTheOriginalKeys(\Pinq\ITraversable $traversable, array $data)
    {
        $otherData = ['test' => 1, 'anotherkey' => 3, 1000 => 5];
        $values = $traversable->whereIn($otherData);

        $this->assertMatches($values, array_intersect($data, $otherData));
    }

    /**
     * @dataProvider oneToTen
     */
    public function testThatWhereInUsesStrictEquality(\Pinq\ITraversable $traversable, array $data)
    {
        $insection = $traversable->intersect(['1', '2', '3', '4', '5']);

        $this->assertMatches($insection, []);
    }
}
