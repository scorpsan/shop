<?php
/**
 * Events For All App
 */

use common\models\ShopOrders;
use yii\base\Event;
use common\models\User;
use common\models\Profile;
use Da\User\Event\UserEvent;
use Da\User\Event\FormEvent;
use Da\User\Event\ProfileEvent;
use Da\User\Controller\RegistrationController;
use Da\User\Controller\SecurityController;
use Da\User\Controller\SettingsController;
/**
// This will happen at the controller's level
Event::on(AdminController::class, UserEvent::EVENT_BEFORE_CREATE, function (UserEvent $event) {
$user = $event->getUser();

// ... your logic here
});

// This will happen at the model's level
Event::on(User::class, UserEvent::EVENT_BEFORE_CREATE, function (UserEvent $event) {

$user = $event->getUser();

// ... your logic here
});
 */
Event::on(User::class, UserEvent::EVENT_AFTER_CREATE, function (UserEvent $event) {
//    $user = $event->getUser();
});

Event::on(RegistrationController::class, FormEvent::EVENT_AFTER_REGISTER, function (FormEvent $event) {
//    $form = $event->form;
//    $user = User::find()->where(['email' => $form->email])->one();
});

Event::on(User::class, UserEvent::EVENT_AFTER_CONFIRMATION, function (UserEvent $event) {
    $user = $event->getUser();
    if ($user->username != $user->email) {
        $user->username = $user->email;
        $user->save();
    }
    $profile = Profile::find()->where(['user_id' => $user->id])->one();
    if ($profile->public_email != $user->email) {
        $profile->public_email = $user->email;
        $profile->save();
    }
});

Event::on(SecurityController::class, FormEvent::EVENT_AFTER_LOGIN, function (FormEvent $event) {
    $user = $event->getForm()->user;
    ShopOrders::updateAll(['user_id' => $user->id], ['customer_email' => $user->email, 'user_id' => null]);
});

Event::on( SettingsController::class, UserEvent::EVENT_AFTER_ACCOUNT_UPDATE, function (UserEvent $event) {
//    $user = $event->getUser();
});

Event::on( SettingsController::class, UserEvent::EVENT_AFTER_PROFILE_UPDATE, function (ProfileEvent $event) {
//    $profile = $event->getProfile();
//    $user = $profile->user;
});

Event::on(ShopOrders::class, ShopOrders::EVENT_AFTER_INSERT, function ($event) {
    $order = $event->sender;

});