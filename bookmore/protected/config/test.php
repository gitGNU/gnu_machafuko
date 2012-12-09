<?php

return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
        'components'=>array(
            'fixture'=>array(
                'class'=>'system.test.CDbFixtureManager',
            ),
            'db'=>array(
                'connectionString'=>'mysql:host=localhost;dbname=bookmore_test',
                'emulatePrepare' => true,
                'username' => 'roman',
                'password' => 'roman',
                'charset' => 'utf8',
            ),
        ),
    )
);
