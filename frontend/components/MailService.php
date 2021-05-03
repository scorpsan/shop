<?php
namespace frontend\components;

use Da\User\Service\MailService as BaseMailService;

/**
 * Change default view path  for template mails on common/mail
 * Class MailService
 * @package frontend\components
 */
class MailService extends BaseMailService
{
    protected $viewPath = '@common/mail';
}