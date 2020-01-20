<?php

namespace Dfevrier\LaravelFilter\Test;

use PHPUnit\Framework\TestCase;

use Dfevrier\LaravelFilter\Parser;

class ParserTest extends TestCase
{

    public function testBasic()
    {
        $search = ['column' => 'searched'];
        $args = ['column'];
        $queries = Parser::parse($args, $search);
        $this->assertEquals(1, count($queries));
        $this->assertEquals('searched', $queries[0]->getSearch());
        $this->assertEquals("=", $queries[0]->getOperator());
        $this->assertEquals('column', $queries[0]->getColumn());
    }

    public function testLikeOperator()
    {
        $search = ['column' => 'searched'];
        $args = ['column' => 'like'];
        $queries = Parser::parse($args, $search);
        $this->assertEquals(1, count($queries));
        $this->assertEquals('%searched%', $queries[0]->getSearch());
        $this->assertEquals('like', $queries[0]->getOperator());
        $this->assertEquals('column', $queries[0]->getColumn());
    }

    public function testMultipleArgs()
    {
        $search = [
            'column' => 'test',
            'column2' => 'test2',
            'column3' => 'test3'
        ];
        $args = ['column', 'column2' => ['operator' => 'like'], 'column3' => '>'];
        $queries = Parser::parse($args, $search);
        $this->assertEquals(3, count($queries));
        $this->assertEquals('test', $queries[0]->getSearch());
        $this->assertEquals('=', $queries[0]->getOperator());
        $this->assertEquals('column', $queries[0]->getColumn());
        $this->assertEquals('%test2%', $queries[1]->getSearch());
        $this->assertEquals('like', $queries[1]->getOperator());
        $this->assertEquals('column2', $queries[1]->getColumn());
        $this->assertEquals('test3', $queries[2]->getSearch());
        $this->assertEquals('>', $queries[2]->getOperator());
        $this->assertEquals('column3', $queries[2]->getColumn());
    }

    public function testErrorNotSearched()
    {
        $search = ['other' => 'test'];
        $args = ['column'];
        $queries = Parser::parse($args, $search);
        $this->assertEquals(0, count($queries));
    }

    public function testSearchedIsNull()
    {
        $search = ['column' => ''];
        $args = ['column'];
        $queries = Parser::parse($args, $search);
        $this->assertEquals(1, count($queries));
        $this->assertEquals('', $queries[0]->getSearch());
        $this->assertEquals('=', $queries[0]->getOperator());
        $this->assertEquals('column', $queries[0]->getColumn());
    }
}
