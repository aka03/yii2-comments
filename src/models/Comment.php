<?php

namespace aka03\comments\models;

use Yii;
use yii\db\ActiveRecord;
use aka03\comments\CommentWidget;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $page
 * @property int $page_id
 * @property int $user_id
 * @property string $guest_name
 * @property string $message
 * @property int $created_at
 * @property int $updated_at
 */
class Comment extends ActiveRecord
{
    public $avatar;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['guest_name'], 'required', 'when' => function ($model) {
                return Yii::$app->user->isGuest;
            }],
            [['id', 'page_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['page', 'message'], 'string'],
            [['guest_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * Relation user.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        $user = Yii::$app->user->identityClass;
        return $this->hasOne($user::className(), ['id' => 'user_id']);
    }

    /**
     * Get username for current user.
     * @return string
     */
    public function getUsername()
    {
        return ($this->user_id) ? $this->user->username : $this->guest_name;
    }

    /**
     * Check is current user is an author.
     * @return bool
     */
    public function isAuthor()
    {
        if (!is_null($this->user_id) && !Yii::$app->user->isGuest && Yii::$app->user->identity->id == $this->user_id) {
            return true;
        }
        return false;
    }

    /**
     * Get time for current comment.
     * @return string
     */
    public function getTime()
    {
        $widget = new CommentWidget();
        $showRelativeTime = $widget->showRelativeTime;
        $showTimeAs = (!$showRelativeTime) ? 'asDateTime' : 'asRelativeTime';

        if ($this->created_at == $this->updated_at) {
            return Yii::$app->formatter->$showTimeAs($this->created_at);
        } else {
            return Yii::t('comment', 'Updated') . ' ' . Yii::$app->formatter->$showTimeAs($this->updated_at);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'guest_name' => Yii::t('comment', 'Name'),
            'message' => Yii::t('comment', 'Message'),
        ];
    }
}
