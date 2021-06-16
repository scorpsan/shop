<?php
namespace common\bootstrap;

use yii\base\BootstrapInterface;
use common\models\Language;
use common\models\SiteSettings;

class SetUp implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
	public function bootstrap($app)
    {
        /** Set Default Language in system */
        $app->params['defaultLanguage'] = Language::getLanguageDefault()->url;
        /** Get Currency Code and Region */
        $siteSettings = SiteSettings::find()->joinWith('translate')->limit(1)->one();
        $app->formatter->currencyCode = $siteSettings->currency_code;
        $app->formatter->defaultTimeZone = $app->params['userTimeZone'];
        $app->setTimeZone($app->params['userTimeZone']);
        $app->name = $siteSettings->title;
        $app->params['comingSoon'] = $siteSettings->coming_soon;
        $app->params['searchOnSite'] = $siteSettings->search_on_site;
        $app->params['shopOnSite'] = $siteSettings->shop_on_site;
        $app->params['adminEmail'] = $siteSettings->admin_email;
        $app->params['supportEmail'] = $siteSettings->support_email;
        $app->params['senderEmail'] = $siteSettings->sender_email;
        $app->params['senderName'] = $siteSettings->title;

        $app->params['title'] = $siteSettings->title;
        $app->params['seotitle'] = $siteSettings->seotitle;
        $app->params['keywords'] = $siteSettings->keywords;
        $app->params['description'] = $siteSettings->description;

        $app->params['siteSettings'] = $siteSettings;

        $app->params['components']['mailer']['messageConfig'] = [
            'from' => [$app->params['senderEmail'] => $app->params['senderName']],
        ];
    }

}