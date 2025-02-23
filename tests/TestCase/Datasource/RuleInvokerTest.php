<?php

namespace Cake\Test\TestCase\Datasource;

use Cake\Datasource\RuleInvoker;
use Cake\ORM\Entity;
use Cake\ORM\Rule\ValidCount;
use PHPUnit\Framework\TestCase;

class RuleInvokerTest extends TestCase
{
    public function test__invoke(): void
    {
        $entity = new Entity([
            'players' => 1,
        ]);

        $rule = new ValidCount('players');
        $rulesInvoker = new RuleInvoker(
            $rule,
            'countPlayers',
            [
                'count' => 2,
                'errorField' => 'player_id',
                'message' => function ($entity, $options) {
                    return 'Player count should be ' . $options['count'] . ' not ' . $entity->get('players');
                },
            ]
        );
        $rulesInvoker->__invoke($entity, []);
        $this->assertEquals(
            ['countPlayers' => 'Player count should be 2 not 1'],
            $entity->getError('player_id')
        );
    }
}
