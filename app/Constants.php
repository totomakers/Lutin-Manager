<?php

namespace App;

abstract class Constants
{
    const MSG_ERROR_CODE=0;
    const MSG_WARNING_CODE=1;
    const MSG_OK_CODE=2;

    const DEFAULT_USER_ID = 0;

    const ORDER_WAITING = 0;
    const ORDER_IN_PROGRESS = 1;
    const ORDER_VALIDATE = 2;
}