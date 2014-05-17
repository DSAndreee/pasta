<?php
require_once '../Lib/Neo/Boot.php';
Neo\boot();

Neo\id(new Neo\Neo())
->map('index', 'PastaC')
->map(array('hash' => '[0-9a-zA-Z]{16}'), 'PastaC', 'readbox')
->run();
