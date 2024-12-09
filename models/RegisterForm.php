<?php

namespace app\models;

use Yii;
use yii\base\Model;
/** @var TYPE_NAME $user */

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;





    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            [['name','email', 'password'], 'required'],
            [['name', 'email', 'password'], 'trim'],
            [['name', 'email', 'password'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => 'email'],
            // password is validated by validatePassword()
            ['password', 'validateRepPassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateRepPassword()
    {
        return $this->password === $this->password_repeat;
    }

    public function register()
    {
        if($this->validate())
        {
            $user = new User();
            $user->attributes = $this->attributes;
            return $user->createUser();
        }
        return false;
    }




}
