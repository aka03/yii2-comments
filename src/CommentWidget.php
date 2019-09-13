<?php

namespace aka03\comments;

use Yii;
use yii\base\Widget;
use aka03\comments\models\Comment;

class CommentWidget extends Widget
{
    /**
     * @var bool If user is not logged in, he can't leave comments.
     * This option have no effect if $showCommentsForGuests sets to false.
     */
    public $guestCanLeaveComment = true;

    /**
     * @var bool Show comments for guest users.
     */
    public $showCommentsForGuests = true;

    /**
     * @var bool Show time as relative. False means datetime will be shown.
     */
    public $showRelativeTime = true;

    /**
     * @var string User avatar field in database.
     * If not found, default avatar will be used.
     */
    public $avatarField = 'avatar';

    /**
     * @var mixed Page for comments. Set this option for separate comments for each page.
     */
    public $page;

    /**
     * @var mixed Page id for comments. Set this option for separate comments for each id of page.
     */
    public $page_id;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    /**
     * Translations file for widget
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['comment*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@aka03/comments/messages',
            'fileMap' => [
                'comment' => 'comment.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('comment/' . $category, $message, $params, $language);
    }

    /**
     * Get avatar path of current user. If $avatarField is not set, default avatar will be used.
     * @param $comment
     * @param $defaultAvatar
     * @return string
     */
    public function getAvatar($comment, $defaultAvatar)
    {
        $avatarField = $this->avatarField;
        $userAvatar = (!isset($comment->user) && !Yii::$app->user->isGuest && isset($comment->$avatarField))
            ? $comment->$avatarField
            : null;
        return ($userAvatar) ? $userAvatar : $defaultAvatar;
    }

    /**
     * Get default avatar path.
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getDefaultAvatar()
    {
        $bundle = $this->view->getAssetManager()->getBundle('aka03\comments\assets\CommentAsset');
        return $bundle->baseUrl . '/images/default-avatar.png';
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $model = new Comment();
        $post = Yii::$app->request->post();

        if (!Yii::$app->user->isGuest && isset($post['action']) && $post['action'] == 'delete') {
            $postId = Yii::$app->request->post()['id'];
            $model = $this->findModel($postId);
            if ($model->user_id == Yii::$app->user->identity->getId()) {
                $this->deleteComment($postId);
            }
            $model = new Comment();
        }

        if ($model->load($post)) {
            if ($model->id && !Yii::$app->user->isGuest) {
                $data = $this->findModel($model->id);
                if ($data->user_id == Yii::$app->user->identity->id) {
                    $data->message = $model->message;
                    if ($data->save()) {
                        $model = new Comment();
                    }
                }
            } else {
                $model->page = $this->page;
                $model->page_id = $this->page_id;
                if (!Yii::$app->user->isGuest) {
                    $model->user_id = Yii::$app->user->identity->id;
                }
                if ($model->save()) {
                    $model = new Comment();
                }
            }
        }

        $comments = Comment::find()
            ->joinWith('user')
            ->where(['page' => $this->page, 'page_id' => $this->page_id])
            ->all();

        $commentsCount = count($comments);

        $defaultAvatar = $this->getDefaultAvatar();

        $userAvatar = $this->getAvatar(Yii::$app->user->identity, $defaultAvatar);

        return $this->render('index', [
            'model' => $model,
            'comments' => $comments,
            'commentsCount' => $commentsCount,
            'defaultAvatar' => $defaultAvatar,
            'userAvatar' => $userAvatar
        ]);
    }

    /**
     * Deletes an existing Comments model.
     * @param integer $id
     * @return mixed
     */
    public function deleteComment($id)
    {
        $this->findModel($id)->delete();
    }

    /**
     * Find comment by id.
     * @param integer $id
     * @return Comment the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Comment::findOne($id)) !== null) {
            return $model;
        }
    }
}
