<?php

namespace Pinq\Tests\Integration\Traversable;

class UnionTest extends TraversableTest
{
    protected function _testReturnsNewInstance(\Pinq\ITraversable $traversable)
    {
        return $traversable->union([]);
    }

    /**
     * @dataProvider Everything
     */
    public function testThatUnionWithSelfReturnsUniqueReindexedValues(\Pinq\ITraversable $traversable, array $data)
    {
        $unioned = $traversable->union($traversable);

        $this->assertMatches($unioned, array_values(array_unique($data)));
    }

    /**
     * @dataProvider Everything
     */
    public function testThatUnionWithEmptyReturnsUniqueReindexedValues(\Pinq\ITraversable $traversable, array $data)
    {
        $unioned = $traversable->union(new \Pinq\Traversable());

        $this->assertMatches($unioned, array_values(array_unique($data)));
    }

    /**
     * @dataProvider OneToTenTwice
     */
    public function testThatUnionRemovesDuplicateValues(\Pinq\ITraversable $traversable, array $data)
    {
        $unioned = $traversable->union(new \Pinq\Traversable());

        $this->assertMatches($unioned, array_values(array_unique($data)));
    }

    /**
     * @dataProvider OneToTen
     */
    public function testThatUnionUsesStrictEquality(\Pinq\ITraversable $traversable, array $data)
    {
        $otherData = [100 => '1', 101 => '2', 102 => '3'];
        $unioned = $traversable->union($otherData);

        $this->assertMatches($unioned, array_merge($data, $otherData));
    }
}
