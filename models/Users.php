<?php
//
//namespace app\models;
//
//use yii\base\BaseObject;
//use yii\db\ActiveRecord;
//use yii\web\IdentityInterface;
//
///**
// * This is the model class for table "users".
// *
// * @property int $id
// * @property string $name
// * @property string|null $email
// * @property string $password
// * @property int|null $is_admin
// * @property string|null $photo
// *
// * @property Comments[] $comments
// */
//class Users extends ActiveRecord implements IdentityInterface
//{
//    /**
//     * {@inheritdoc}
//     */
//    public static function tableName()
//    {
//        return 'users';
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function rules()
//    {
//        return [
//            [['name', 'password'], 'required'],
//            [['is_admin'], 'integer'],
//            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
//        ];
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'name' => 'Name',
//            'email' => 'Email',
//            'password' => 'Password',
//            'is_admin' => 'Is Admin',
//            'photo' => 'Photo',
//        ];
//    }
//
//    /**
//     * Gets query for [[Comments]].
//     *
//     * @return \yii\db\ActiveQuery
//     */
//    public function getComments()
//    {
//        return $this->hasMany(Comments::class, ['user_id' => 'id']);
//    }
//
//    public static function findIdentity($id)
//    {
//        return Users::findOne($id);
//    }
//
//    public static function findIdentityByAccessToken($token, $type = null)
//    {
//        // TODO: Implement findIdentityByAccessToken() method.
//    }
//
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    public function getAuthKey()
//    {
//        // TODO: Implement getAuthKey() method.
//    }
//
//    public function validateAuthKey($authKey)
//    {
//        // TODO: Implement validateAuthKey() method.
//    }
//
//    public function validatePassword($password)
//    {
//        return $this->password === $password;
//    }
//
//    public static function findUserByName($username)
//    {
////        var_dump(Users::find()->where(['name'=>$username])->one());die();
//        return Users::find()->where(['name'=>$username])->one();
//    }
//
//    public function validateThisPassword($password)
//    {
//        return $this->password === $password;
//    }
//}
