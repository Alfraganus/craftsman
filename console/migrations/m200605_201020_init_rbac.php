<?php
use yii\db\Migration;

/**
 * Class m200605_201020_init_rbac
 */
class m200605_201020_init_rbac extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add "viewSettings" permission
        $viewSettings = $auth->createPermission('viewSettings');
        $viewSettings->description = 'View the settings page';
        $auth->add($viewSettings);

        // add "createContent" permission
        $createContent = $auth->createPermission('createContent');
        $createContent->description = 'Create the content';
        $auth->add($createContent);

        // add "updateContent" permission
        $updateContent = $auth->createPermission('updateContent');
        $updateContent->description = 'Update the content';
        $auth->add($updateContent);

        // add "deleteContent" permission
        $deleteContent = $auth->createPermission('deleteContent');
        $deleteContent->description = 'Delete the content';
        $auth->add($deleteContent);

        // add "createUser" permission
        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Create the user';
        $auth->add($createUser);

        // add "updateUser" permission
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = 'Update the user';
        $auth->add($updateUser);

        // add "deleteUser" permission
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete the user';
        $auth->add($deleteUser);

        // add "isDeveloper" permission
        $isDeveloper = $auth->createPermission('isDeveloper');
        $isDeveloper->description = 'Developer is user';
        $auth->add($isDeveloper);

        // add "buyer" role
        $buyer = $auth->createRole('buyer');
        $buyer->description = 'Buyer';
        $auth->add($buyer);

        // add "seller" role
        $seller = $auth->createRole('seller');
        $seller->description = 'Seller';
        $auth->add($seller);

        // add "admin" role and give this role the "backendView" permission
        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);

        $auth->addChild($admin, $viewSettings);
        $auth->addChild($admin, $createContent);
        $auth->addChild($admin, $updateContent);
        $auth->addChild($admin, $deleteContent);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $isDeveloper);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($admin, 1);
        $auth->assign($seller, 2);
        $auth->assign($buyer, 3);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
