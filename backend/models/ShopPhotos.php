<?php
namespace backend\models;

use common\models\ShopPhotos as BaseShopPhotos;
use Imagine\Image\ImageInterface;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;

class ShopPhotos extends BaseShopPhotos
{
    /**
     * @var image
     */
    public $attachment;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['product_id', 'url'], 'required'],
            [['product_id', 'sort'], 'integer'],
            [['url'], 'string', 'max' => 255],
            [['sort'], 'default', 'value' => function($model) {
                return self::find()->where(['product_id' => $model->product_id])->count();
            }],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShopProducts::class, 'targetAttribute' => ['product_id' => 'id']],
            [['attachment'], 'safe'],
            [['attachment'], 'image'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'product_id' => Yii::t('backend', 'Product ID'),
            'url' => Yii::t('backend', 'Photo'),
            'sort' => Yii::t('backend', 'Sort'),
        ];
    }

    public static function uploadFile($file = null, $imageSizes = null, $dirRoot)
    {
        if (!empty($file)) {
            if (!file_exists($dirRoot)) {
                FileHelper::createDirectory($dirRoot);
            }
            $filename = strtotime('now') . '_' . Yii::$app->security->generateRandomString(6) . '.' . $file->extension;
            if ($file->saveAs($dirRoot . $filename)) {
                $imagine = Image::getImagine()->open($dirRoot . $filename);
                if (isset($imageSizes['full'])) {
                    if (isset($imageSizes['full'][1])) {
                        Image::thumbnail($imagine, $imageSizes['full'][0], $imageSizes['full'][1], ImageInterface::THUMBNAIL_OUTBOUND)
                            ->save($dirRoot . 'full_' . $filename, ['quality' => 90]);
                    } else {
                        $imagine->resize($imagine->getSize()->widen($imageSizes['full'][0]))
                            ->save($dirRoot . 'full_' . $filename, ['quality' => 90]);
                    }
                }
                if (isset($imageSizes['medium'])) {
                    if (isset($imageSizes['medium'][1])) {
                        Image::thumbnail($imagine, $imageSizes['medium'][0], $imageSizes['medium'][1], ImageInterface::THUMBNAIL_OUTBOUND)
                            ->save($dirRoot . 'medium_' . $filename, ['quality' => 80]);
                    } else {
                        $imagine->resize($imagine->getSize()->widen($imageSizes['medium'][0]))
                            ->save($dirRoot . 'medium_' . $filename, ['quality' => 80]);
                    }
                }
                if (isset($imageSizes['small'])) {
                    if (isset($imageSizes['small'][1])) {
                        Image::thumbnail($imagine, $imageSizes['small'][0], $imageSizes['small'][1], ImageInterface::THUMBNAIL_OUTBOUND)
                            ->save($dirRoot . 'small_' . $filename, ['quality' => 80]);
                    } else {
                        $imagine->resize($imagine->getSize()->widen($imageSizes['small'][0]))
                            ->save($dirRoot . 'small_' . $filename, ['quality' => 80]);
                    }
                }
                /*
                if (isset($imageSizes['medium'])) {
                    $imagine = Image::getImagine()->open($dirRoot . $filename);
                    $imagine = Image::thumbnail($imagine, $imageSizes['medium'][0] *1.2, null, ImageInterface::THUMBNAIL_OUTBOUND);
                    Image::crop($imagine, $imageSizes['medium'][0], $imageSizes['medium'][1], [$imageSizes['medium'][0] *0.1, $imageSizes['medium'][1] *0.2])
                        ->save($dirRoot . 'medium_' . $filename, ['quality' => 80]);
                }
                if (isset($imageSizes['small'])) {
                    $imagine = Image::getImagine()->open($dirRoot . $filename);
                    $imagine = Image::thumbnail($imagine, $imageSizes['small'][0] *2, null, ImageInterface::THUMBNAIL_OUTBOUND);
                    Image::crop($imagine, $imageSizes['small'][0], $imageSizes['small'][1], [$imageSizes['small'][0] /2, $imageSizes['small'][1] /4])
                        ->save($dirRoot . 'small_' . $filename, ['quality' => 80]);
                }
                */
                return $filename;
            }
        }
        return null;
    }

    public function beforeDelete()
    {
        self::updateAllCounters(['sort' => -1], ['and', ['product_id' => $this->product_id], ['>', 'sort', $this->sort]]);
        self::deleteFile($this->url, Yii::getAlias('@filesroot/products/' . $this->product_id . '/'));
        return parent::beforeDelete();
    }

    public static function deleteFile($file = null, $dirRoot)
    {
        if (!empty($file)) {
            if (file_exists($dirRoot . 'full_' . $file)) {
                unlink($dirRoot . 'full_' . $file);
            }
            if (file_exists($dirRoot . 'medium_' . $file)) {
                unlink($dirRoot . 'medium_' . $file);
            }
            if (file_exists($dirRoot . 'small_' . $file)) {
                unlink($dirRoot . 'small_' . $file);
            }
            if (file_exists($dirRoot . $file)) {
                unlink($dirRoot . $file);
            }
        } else {
            return null;
        }
    }

}