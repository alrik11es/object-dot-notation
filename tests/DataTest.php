<?php
use Alr\ObjectDotNotation\Data;

class DataTest extends PHPUnit_Framework_TestCase
{

    public function dataProvider()
    {
        $element = new stdClass();
        $array_case = new stdClass();
        $array_case->collection = [
            $element, $element
        ];

        return [
            [['two'=>['three'=>'value']], 'two.three', 'value'],
            [['books'=>['alien'=>'no','pan'=>'value']], 'books.alien', 'no'],
            [(object) ['books'=> ['alien'=>'no','pan'=>'value']], 'books.alien', 'no'],
            [ $array_case, 'collection', [
                $element, $element
            ]],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetter($data, $request, $result)
    {
        $d = Data::load($data);
        $this->assertEquals($result, $d->get($request));
        var_dump($d->get('something.not.existing'));
        $this->assertNull($d->get('something.not.existing'));
    }

}
