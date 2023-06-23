<?php

namespace App\Sdkpayment\Itau\Models;

class Response extends DefaultModel
{
    /**
     *@var int code HTTP
     */
    public $code;

    /**
     *@var int errorCode
     */
    public $errorCode;

    /**
     *@var string status
     */

    public $status;

    /**
     *@var string messages
     */
    public $messages;

    /**
     *@var string type
     */
    public $type;

    /**
     *@var string title
     */
    public $title;

    /**
     *@var string violacoes
     */
    public $violacoes;

    /**
     *@var array detail
     */
    public $detail;

    /**
     *@var array messages
     */
    public $errors;
}