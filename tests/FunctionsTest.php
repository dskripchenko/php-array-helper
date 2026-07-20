<?php

declare(strict_types=1);

namespace Dskripchenko\PhpArrayHelper\Tests;

use PHPUnit\Framework\TestCase;

final class FunctionsTest extends TestCase
{
    public function test_array_merge_deep_merges_nested_string_keys(): void
    {
        $a = ['x' => ['a' => 1, 'b' => 2], 'y' => 1];
        $b = ['x' => ['b' => 3, 'c' => 4], 'z' => 2];

        $this->assertSame(
            ['x' => ['a' => 1, 'b' => 3, 'c' => 4], 'y' => 1, 'z' => 2],
            array_merge_deep($a, $b),
        );
    }

    public function test_array_merge_deep_appends_int_keys(): void
    {
        $this->assertSame([1, 2, 3, 4], array_merge_deep([1, 2], [3, 4]));
    }

    public function test_array_merge_deep_is_variadic(): void
    {
        $this->assertSame(
            ['a' => 1, 'b' => 2, 'c' => 3],
            array_merge_deep(['a' => 1], ['b' => 2], ['c' => 3]),
        );
    }

    public function test_array_sort_deep_sorts_keys_recursively(): void
    {
        $out = array_sort_deep(['b' => 2, 'a' => ['y' => 1, 'x' => 2]]);

        $this->assertSame(['a', 'b'], array_keys($out));
        $this->assertSame(['x', 'y'], array_keys($out['a']));
    }

    public function test_array_is_associative(): void
    {
        $this->assertTrue((bool) array_is_associative(['x' => 1]));
        $this->assertFalse((bool) array_is_associative([1, 2, 3]));
    }

    public function test_array_get_signature_is_order_independent_and_secret_sensitive(): void
    {
        $a = array_get_signature(['a' => 1, 'b' => 2]);
        $b = array_get_signature(['b' => 2, 'a' => 1]);

        // Deep-sorted before hashing → key order does not matter.
        $this->assertSame($a, $b);
        // A different secret yields a different signature.
        $this->assertNotSame($a, array_get_signature(['a' => 1, 'b' => 2], 'secret'));
    }
}
