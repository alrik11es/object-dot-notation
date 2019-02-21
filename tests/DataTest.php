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
        $this->assertEquals($d->$request, $res);
    }

    public function arrayCaseDataProvider()
    {
        $element = new stdClass();

        $a = new stdClass();
        $a->name = 'bob';
        $b = (new stdClass());
        $b->name = 'perkins';
        $element->people = [
            $a,
            $b
        ];

        return [
            [$element, 'people[0].name', 'bob'],
            [$element, 'people[name=bob].name', 'bob'],
        ];
    }

    /**
     * @dataProvider arrayCaseDataProvider
     */
    public function testArrayCase($data, $request, $result)
    {
        $d = Alr\ObjectDotNotation\Data::load($data);
        $res = $d->get($request);
        $this->assertEquals($result, $res);
    }

}
