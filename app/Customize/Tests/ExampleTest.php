<?php

namespace Customize\Tests;

use PHPUnit\Framework\TestCase;

/**
 * サンプルのユニットテスト。
 *
 * app/Customize/ 配下のコードは `Customize\` 名前空間で autoload されるため、
 * テスト対象クラスをそのまま use して検証できる（例: use Customize\Service\Foo;）。
 *
 * 純粋なユニットテストは Eccube のカーネル/DB を起動しないので高速。
 * DB やサービスコンテナが必要な統合テストを書く場合は
 * Eccube\Tests\EccubeTestCase を継承し、テスト用 DB を用意する（README 参照）。
 */
class ExampleTest extends TestCase
{
    public function testAddition(): void
    {
        $this->assertSame(2, 1 + 1);
    }

    public function testStringHelper(): void
    {
        $this->assertStringContainsString('CUBE', 'EC-CUBE');
    }
}
