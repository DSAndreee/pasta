<?php
require_once '../Lib/Neo/Boot.php';
Neo\boot();

Neo\id(new Neo\Neo())
->map('index', 'PastaC')
->map('paste', 'PastaC', 'paste')
->map(array('hash' => '[0-9a-fA-F]{40}'), 'PastaC', 'readbox')
->map(array('raw' => '[0-9a-fA-F]{40}'), 'PastaC', 'raw')
->map(array('fork' => '[0-9a-fA-F]{40}'), 'PastaC', 'fork')
->run();
