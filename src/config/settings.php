<?php
/*
【設定方法】
テストサーバにUPする際は、UP先のディレクリ名を第二引数に指定して下さい

//例1）define( '_ROOT_DIRECTORY_' , '/test');
//※上記の場合は、「http://ドメイン/test」にUPする際の設定です。

//例2）define( '_ROOT_DIRECTORY_' , '/ui/ma_0831');
//※上記の場合は、「http://ドメイン/ui/ma_0831'」にUPする際の設定です。

//本番環境にUPする際は、第二引数を「''」の状態にしてください
*/

define('_ROOT_DIRECTORY_', '/hiyama_hinoki/dist');
define('_FORM_SEND_MAIL_', 'ui-developers@u-active.jp'); //フォーム送信先の設定「,」カンマ区切りで複数設定可能
define('_FORM_SEND_MAIL_BCC_', ''); //フォームBcc送信先の設定「,」カンマ区切りで複数設定可能
define('_DEVELOP_MODE_', true);
