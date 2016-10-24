<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
require('../../loader_config.php');
require('./UploadHandler.php');

$upload_handler = new UploadHandler(array(
    'upload_dir' => get_config('ADMIN_UPLOAD_PATH') . 'medium/',
    'upload_url' => get_config('ADMIN_UPLOAD_URL') . 'medium/'
));

//die(get_config('ADMIN_UPLOAD_URL') . 'medium/');