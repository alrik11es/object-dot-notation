<?php
use Alr\ObjectDotNotation\Data;

class DataTest extends PHPUnit_Framework_TestCase
{

    public function dataProvider()
    {
        return [
            [['two'=>['three'=>'value']], 'two.three', 'value'],
            [['books'=>['alien'=>'no','pan'=>'value']], 'books.alien', 'no'],
            [(object) ['books'=> ['alien'=>'no','pan'=>'value']], 'books.alien', 'no']
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetter($data, $request, $result)
    {
        echo json_encode($data);
        $d = Data::load($data);
        $this->assertEquals($result, $d->get($request));

    }

}
