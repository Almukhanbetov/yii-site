<?
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class SomeWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'SomeWidget';
        }
    }

    public function run()
    {
        return Html::encode($this->message);
    }
}