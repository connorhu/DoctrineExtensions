<?php

namespace DoctrineExtensions\Query\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

/**
 * AgeFunction ::= "AGE" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
 */
class Age extends FunctionNode
{
    private $arithmeticPrimary1 = null;

    private $arithmeticPrimary2 = null;

    public function getSql(SqlWalker $sqlWalker)
    {
        return 'AGE(' . $this->arithmeticPrimary1->dispatch($sqlWalker) . ', ' . $this->arithmeticPrimary2->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->arithmeticPrimary1 = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->arithmeticPrimary2 = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
