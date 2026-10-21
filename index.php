<?php

/*
|--------------------------------------------------------------------------
| Root Front Controller
|--------------------------------------------------------------------------
|
| Used when the application is served from a sub-directory, e.g.
| http://localhost/WebPOS-Laravel/ instead of a dedicated virtual host.
|
| Keeping the entry point at the project root means SCRIPT_NAME is
| "/WebPOS-Laravel/index.php", which allows Symfony to resolve the base
| path and generate clean URLs without the "/public" segment.
|
| The real front controller stays in public/index.php.
|
*/

require __DIR__.'/public/index.php';
