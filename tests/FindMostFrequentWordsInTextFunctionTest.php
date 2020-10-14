<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use function TestTask\findMostFrequentWordsInText;

/**
 * Class FindMostFrequentWordsInTextFunctionTest
 */
class FindMostFrequentWordsInTextFunctionTest extends TestCase
{
    /**
     * Checks that result array has the same keys, values and order
     *
     * @param string $string
     * @param int $topCount
     * @param array $result
     *
     * @dataProvider getSuccessData
     */
    public function testSuccess(string $string, int $topCount, array $result)
    {
        $res = findMostFrequentWordsInText($string, $topCount);

        $this->assertEquals($res, $result);
        $this->assertEquals(array_keys($res), array_keys($result));
    }

    /**
     * @return array[]
     */
    public function getSuccessData()
    {
        return [
            [
                '',
                2,
                []
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Пути я выбираю сам.',
                2,
                [
                    'пути' => 3,
                    'я' => 2,
                ]
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Путь я выбираю сам.',
                2,
                [
                    'я' => 2,
                    'пути' => 2,
                ]
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Путь я выбираю сам. И только я!',
                2,
                [
                    'я' => 3,
                    'пути' => 2,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b) a.',
                2,
                [
                    'a' => 5,
                    'b' => 3,
                ]
            ],
            [
                'a,A b c a: d B! a? c (b) a.',
                2,
                [
                    'a' => 5,
                    'b' => 3,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, Aa, aa)',
                3,
                [
                    'a' => 5,
                    'b' => 3,
                    'aa' => 3,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'a' => 5,
                    'aa' => 4,
                    'b' => 3,
                    'c' => 2,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'aa' => 5,
                    'a' => 4,
                    'b' => 3,
                    'c' => 2,
                ]
            ],
            [
                'aa,a b d a: c d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'aa' => 5,
                    'a' => 4,
                    'b' => 3,
                    'd' => 2,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (AA, aa, aa) Aa?',
                5,
                [
                    'aa' => 5,
                    'a' => 4,
                    'b' => 3,
                    'c' => 2,
                    'd' => 2,
                ]
            ],
        ];
    }

    /**
     * Checks that result array has not the same order
     *
     * @param string $string
     * @param int $topCount
     * @param array $result
     *
     * @dataProvider getCloseToFailData
     */
    public function testCloseToFail(string $string, int $topCount, array $result)
    {
        $res = findMostFrequentWordsInText($string, $topCount);

        $this->assertEquals($res, $result);
        $this->assertNotEquals(array_keys($res), array_keys($result));
    }

    /**
     * @return array[]
     */
    public function getCloseToFailData()
    {
        return [
            [
                'a,a b c a: d b! a? c (b) a.',
                2,
                [
                    'b' => 3,
                    'a' => 5,
                ]
            ],
            [
                'a,A b c a: d B! a? c (b) a.',
                2,
                [
                    'b' => 3,
                    'a' => 5,
                ]
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Путь я выбираю сам. И только я!',
                2,
                [
                    'пути' => 2,
                    'я' => 3,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, Aa, aa)',
                3,
                [
                    'b' => 3,
                    'a' => 5,
                    'aa' => 3,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'a' => 5,
                    'b' => 3,
                    'aa' => 4,
                    'c' => 2,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'a' => 4,
                    'b' => 3,
                    'c' => 2,
                    'aa' => 5,
                ]
            ],
            [
                'aa,a b d a: c d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'aa' => 5,
                    'b' => 3,
                    'a' => 4,
                    'd' => 2,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (AA, aa, aa) Aa?',
                5,
                [
                    'c' => 2,
                    'aa' => 5,
                    'a' => 4,
                    'b' => 3,
                    'd' => 2,
                ]
            ],
        ];
    }

    /**
     * Checks that result array not the same
     *
     * @param string $string
     * @param int $topCount
     * @param array $result
     *
     * @dataProvider getFailData
     */
    public function testFail(string $string, int $topCount, array $result)
    {
        $res = findMostFrequentWordsInText($string, $topCount);

        $this->assertNotEquals($res, $result);
    }

    /**
     * @return array[]
     */
    public function getFailData()
    {
        return [
            [
                'a,a b c a: d b! a? c (b) a.',
                2,
                [
                    'b' => 3,
                    'a' => 4,
                ]
            ],
            [
                'a,A b c a: d B! a? c (b) a.',
                2,
                [
                    'a' => 4,
                    'b' => 3,
                ]
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Путь я выбираю сам. И только я!',
                2,
                [
                    'пути' => 1,
                    'я' => 3,
                ]
            ],
            [
                'Я иду по верному пути, с этого пути сворачивать не планирую. Путь я выбираю сам. И только я!',
                2,
                [
                    'я' => 2,
                    'пути' => 2,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, Aa, aa)',
                3,
                [
                    'b' => 3,
                    'a' => 5,
                ]
            ],
            [
                'a,a b c a: d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'a' => 5,
                    'b' => 3,
                    'aa' => 4,
                    'c' => 1,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'a' => 0,
                    'b' => 3,
                    'c' => 2,
                    'aa' => 5,
                ]
            ],
            [
                'aa,a b d a: c d b! a? c (b, a), (aa, aa, aa) aa?',
                4,
                [
                    'aa' => 5,
                    'b' => 3,
                    'a' => 4,
                    'd' => 1,
                ]
            ],
            [
                'aa,a b c a: d d b! a? c (b, a), (AA, aa, aa) Aa?',
                5,
                [
                    'c' => 2,
                    'aa' => 5,
                    'a' => 3,
                    'b' => 3,
                    'd' => 2,
                ]
            ],
        ];
    }
}
