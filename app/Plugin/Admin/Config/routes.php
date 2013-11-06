<?php


Router::connect('/admin', array('plugin' => 'admin', 'controller' => 'dashboard', 'action' => 'index'));
Router::parseExtensions('json');