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
            [(object) ['books'=> ['alien'=>'no','pan'=>'value']], 'notexisting', null],
            [(object) ['books'=> ['alien'=>'no','pan'=>'value']], 'books.notexisting', null],
            [null, 'books.notexisting', null],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetter($data, $request, $result)
    {
        $d = Alr\ObjectDotNotation\Data::load($data);
        $res = $d->get($request);
        $this->assertEquals($result, $res);
        $this->assertNull(null, $d->get('fake'));
    }

}
