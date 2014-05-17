<?php
require_once '../Lib/Neo/Boot.php';
Neo\boot();

Neo\id(new Neo\Neo())
->map('index', 'PastaC')
->map('paste', 'PastaC', 'paste')
->map(array('hash' => '[0-9a-fA-F]{40}'), 'PastaC', 'readbox')
->run();
