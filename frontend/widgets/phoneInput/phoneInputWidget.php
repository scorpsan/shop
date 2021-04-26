<?php
namespace frontend\widgets\phoneInput;

use common\models\Country;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\InputWidget;
use yii\helpers\Html;

class phoneInputWidget extends InputWidget
{
	public $selectOn = true;
	public $preferred = [];
	public $disabled = false;
	public $buttonClass = '';
	public $bsVersion = 4;
	public $hint = null;

	public function run()
	{
		parent::run();

		if (empty($this->options['label'])) {
			$this->options['label'] = null;
		}

		if (!empty($this->options['class'])) {
			$this->options['class'] = 'form-control phone-input ' . $this->options['class'];
		}

		if ($this->disabled) {
			$this->options['disabled'] = $this->disabled;
		}

		$this->registerAssets();

		if ($this->hasModel()) {
			$content = Html::activeInput("tel", $this->model, $this->attribute, $this->options);
		} else {
			$content = Html::input("tel", $this->name, "", $this->options);
		}

		if ($this->selectOn) {
			$button = Html::button('<span class="iti__flag iti__by"></span>', ['class' => 'list-country-button btn btn-outline-secondary dropdown-toggle ' . $this->buttonClass, 'data-toggle' => 'dropdown', 'aria-haspopup' => true, 'aria-expanded' => false, 'disabled' => $this->disabled]);

			$countries = Country::find()->where(['>', 'phonecode', 0])->orderBy(['nicename' => SORT_ASC])->all();
			$preferredList = '';
			$allList = '';
			foreach ($countries as $country) {
				if (ArrayHelper::isIn($country->iso, $this->preferred))
					$preferredList .= '<li class="selectCountry iti__country iti__preferred" id="iti__' . $country->iso . '" data-dial-code="' . $country->phonecode . '" aria-selected="false"><div class="iti__flag-box"><span class="iti__flag iti__' . $country->iso . '"></span></div><span class="iti__country-name">' . $country->nicename . '</span><span class="iti__dial-code">+' . $country->phonecode . '</span></li>';
				else
					$allList .= '<li class="selectCountry iti__country iti__standard" id="iti__' . $country->iso . '" data-dial-code="' . $country->phonecode . '" aria-selected="false"><div class="iti__flag-box"><span class="iti__flag iti__' . $country->iso . '"></span></div><span class="iti__country-name">' . $country->nicename . '</span><span class="iti__dial-code">+' . $country->phonecode . '</span></li>';
			}
			$button .= Html::tag("ul", (($preferredList != '') ? $preferredList . '<li role="separator" class="dropdown-divider divider"></li>' . $allList : $allList), ['class' => 'dropdown-menu list-country-codes']);

			if ($this->bsVersion == 3)
				$button = Html::tag("div", $button, ['class' => 'input-group-btn']);

			$content = Html::tag("div", $button . $content, ['class' => 'input-group']);
			if ($this->hint)
				$content .= Html::tag("div", $this->hint, ['class' => 'hint']);
		}

		return $content;
	}

	protected function registerAssets()
	{
		$view = $this->getView();
		phoneInputAsset::register($view);

		$message = Yii::t('frontend', 'Wrong format, enter phone number in international format.');

		$js = <<<JS
var phoneInput = $(".phone-input"),
	countryBtn = $(".list-country-button"),
	countryUl = $(".list-country-codes"),
	maskOpts = {
		inputmask: {
			definitions: {
				'#': {
					validator: "[0-9]",
					cardinality: 1
				}
			},
			showMaskOnHover: false,
			autoUnmask: true,
			clearMaskOnLostFocus: false
		},
		match: /[0-9]/,
		replace: '#',
		list: $.masksSort(phoneCodes, ['#'], /[0-9]|#/, "mask"),
		listKey: "mask",
		onMaskChange: function(maskObj, determined) {
			if (determined) {
				countryUl.find(".iti__active").removeClass("iti__highlight iti__active").attr("aria-selected", false);
				countryUl.find("#iti__" + maskObj.cc).addClass("iti__highlight iti__active").attr("aria-selected", true);
				countryBtn.find(".iti__flag").removeClass().addClass("iti__flag iti__" + maskObj.cc);
			}
		}
	};
phoneInput.inputmasks(maskOpts);

$(document).on("click", ".selectCountry", function () {
    countryUl.find(".iti__active").removeClass("iti__highlight iti__active").attr("aria-selected", false);
    $(this).addClass("iti__highlight iti__active").attr("aria-selected", true);
    countryBtn.find(".iti__flag").removeClass().addClass("iti__flag " + $(this).attr("id"));
    phoneInput.val($(this).attr("data-dial-code"));
});

phoneInput.parents("form:first").on("beforeValidate", function (e) {
    $(this).yiiActiveForm('find', phoneInput.attr("id")).validate = function (attribute, value, messages, deferred, form) {
		if (!phoneInput.inputmasks("isCompleted")) {
		    phoneInput.closest(".field").addClass("has-error");
			messages.push("${message}");
			e.preventDefault();
			return false;
		}
		phoneInput.closest(".field").removeClass("has-error");
		return true;
	}
});
JS;

		$view->registerJs($js, View::POS_READY);
	}
}