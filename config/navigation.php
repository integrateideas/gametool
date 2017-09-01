<?php
use Cake\Core\Configure;
//If a menu has children, then the link for the menu must always be #
//All links must be in the form of ['controller' => 'ControllerName', 'action' =>'action name' ]
return [ 'Menu' => 
                  [
                      
                   'Admin' =>  [
                            'Challenges' => [
                              'link' => '#',
                              'children' => [
                                    'Challenge List' => [
                                        'link' => [
                                              'controller' => 'Challenges',
                                              'action' => 'index'
                                            ],
                                          ],
                                      'Add Challenge' => [
                                        'link' => [
                                                   'controller' => 'Challenges',
                                                   'action' => 'add'
                                                  ],
                                          ] 
                                  ] 
                            ],
                        ],
                ]
        ];
?>