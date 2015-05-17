<?php
namespace console\controllers;

use common\models\User;
use Yii;

/**
 * Application initialization
 *
 * @author jonas jonas_php@163.com
 *        
 */
class InitController extends \yii\console\Controller
{

    /**
     * Create init user
     */
    public function actionUser()
    {
        echo "Create init user ...\n"; // 提示当前操作
        $username = $this->prompt('User Name:'); // 接收用户名
        $email = $this->prompt('Email:'); // 接收Email
        $password = $this->prompt('Password:'); // 接收密码
        $model = new User(); // 创建一个新用户
        $model->username = $username; // 完成赋值
        $model->email = $email;
        $model->password = $password;
        if (! $model->save()) // 保存新的用户
{
            foreach ($model->getErrors() as $error) // 如果保存失败，说明有错误，那就输出错误信息。
{
                foreach ($error as $e) {
                    echo "$e\n";
                }
            }
            return 1; // 命令行返回1表示有异常
        }
        return 0; // 返回0表示一切OK
    }

    /**
     * Send test mail
     */
    public function actionMail()
    {
        $mail = Yii::$app->mailer->compose();
        $mail->setFrom('jonas_lab@163.com');
        $mail->setTo('924454486@qq.com');
        $mail->setSubject('test');
        $mail->setTextBody('test222');
        $mail->setHtmlBody('test333');
        if ($mail->send())
            echo "success";
        else
            echo "failse";
    }
}