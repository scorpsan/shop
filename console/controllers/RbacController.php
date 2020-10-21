<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');
        $user = $auth->createRole('user');

        // запишем их в БД
        $auth->add($admin);
        $auth->add($manager);
        $auth->add($user);

        // Создаем разрешения.
        $profilePanel = $auth->createPermission('profilePanel');
        $profilePanel->description = 'Access to Profile Panel';

        $adminPanel = $auth->createPermission('adminPanel');
        $adminPanel->description = 'Access to Admin Panel';

        $viewPages = $auth->createPermission('viewPages');
        $viewPages->description = 'View Other Page Panel';
        $editPages = $auth->createPermission('editPages');
        $editPages->description = 'Edit Other Page Panel';
        $deletePages = $auth->createPermission('deletePages');
        $deletePages->description = 'Delete Other Page Panel';

        $viewSettings = $auth->createPermission('viewSettings');
        $viewSettings->description = 'View Settings Panel';
        $editSettings = $auth->createPermission('editSettings');
        $editSettings->description = 'Edit Settings Panel';
        $deleteSettings = $auth->createPermission('deleteSettings');
        $deleteSettings->description = 'Delete Settings Panel';

        // Запишем эти разрешения в БД
        $auth->add($profilePanel);
        $auth->add($adminPanel);
        $auth->add($viewPages);
        $auth->add($editPages);
        $auth->add($deletePages);
        $auth->add($viewSettings);
        $auth->add($editSettings);
        $auth->add($deleteSettings);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Ролям присваиваем разрешения
        $auth->addChild($user, $profilePanel);

        $auth->addChild($manager, $adminPanel);
        $auth->addChild($manager, $viewPages);
        $auth->addChild($manager, $editPages);
        $auth->addChild($manager, $deletePages);
        $auth->addChild($manager, $viewSettings);

        $auth->addChild($admin, $editSettings);
        $auth->addChild($admin, $deleteSettings);

        // админ наследует все роли. Он же админ, должен уметь всё! :D
        $auth->addChild($manager, $user);
        $auth->addChild($admin, $manager);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль editor пользователю с ID 2
        //$auth->assign($manager, 2);
    }
}