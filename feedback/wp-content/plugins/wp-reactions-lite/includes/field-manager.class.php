<?php
namespace WP_Reactions\Lite\FieldManager;
use WP_Reactions\Lite\Helper;

class Text {
	public $id = '';
	private $label = '';
	private $value;
	public $checkboxes = array();
	public $classes = '';
	public $disabled = false;
	public $type = 'text';
	private $placeholder = '';

	public function setId( $id ) {
		$this->id = $id;
		return $this;
	}

	public function setLabel( $label ) {
		$this->label = $label;
		return $this;
	}

	public function setValue( $value ) {
		$this->value = $value;
		return $this;
	}

	public function addClasses( $classes ) {
		$this->classes = $classes;
		return $this;
	}

	public function setDisabled( $disabled ) {
		$this->disabled = $disabled;
		return $this;
	}

	public function setType( $type ) {
		$this->type = $type;
		return $this;
	}

	public function setPlaceholder( $placeholder ) {
		$this->placeholder = $placeholder;
		return $this;
	}

	function build() {
		$type = $this->type;
		$is_disabled = '';
		if ( $this->disabled ) {
			$is_disabled = 'disabled';
		}
		$color_chooser_cls = '';
		if ( $this->type == 'color-chooser') {
			$color_chooser_cls = 'color-chooser';
			$type = 'text';
		}
		$out = '';
		if ( $this->type != 'hidden' and $this->label != '') {
			$out .= "<label for='{$this->id}'>{$this->label}</label>";
		}
		$out .= "<input type='{$type}' name='{$this->id}' id='{$this->id}' placeholder='{$this->placeholder}' class='form-control {$color_chooser_cls}' value=\"{$this->value}\" {$is_disabled}>";
		echo "<div class='{$this->classes}'>{$out}</div>";
	}

}

class Radio {

	public $name;
	public $radios = array();
	public $checked = '';
	public $disabled = false;
	public $label_type = 'text';
	public $classes = '';

	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	public function setChecked( $checked ) {
		$this->checked = $checked;
		return $this;
	}

	public function setLabelType( $label_type ) {
		$this->label_type = $label_type;
		return $this;
	}

	public function setDisabled( $disabled ) {
		$this->disabled = $disabled;
		return $this;
	}

	public function addRadio($id, $value, $label, $elem_after = '', $tooltip = '') {
		$this->radios[] = array(
			'id' => $id,
			'value' => $value,
			'label' => $label,
			'elemAfter' => $elem_after,
			'tooltip' => $tooltip,
		);
		return $this;
	}

	public function addClasses( $classes ) {
		$this->classes = $classes;
		return $this;
	}

	function build() {

		$is_disabled = '';
		if ( $this->disabled ) {
			$is_disabled = 'disabled';
		}

		foreach ( $this->radios as $radio ) {
			if ( $this->checked == $radio['value'] ) {
				$is_checked = 'checked';
			} else {
				$is_checked = '';
			}
			if ( $this->label_type == 'image' ) {
				$label = "<img src='{$radio['label']}' />";
			} else {
				$label = $radio['label'];
			}
			echo "<div class='circle-radio {$this->classes}'>";
			echo "<input type='radio' name='{$this->name}' id='{$radio["id"]}' value='{$radio["value"]}' {$is_checked} {$is_disabled}>";
			echo "<label for='{$radio["id"]}'><span>{$label}</span></label>";
			if (!empty($radio['elemAfter'])) {
				echo $radio['elemAfter'];
			}
			if (!empty($radio['tooltip'])) {
				Helper::tooltip($radio['tooltip']);
			}
			echo "</div>";
		}
	}

}

class Select {
	public $id;
	public $label;
	public $values;
	public $selected;
	public $classes = '';
	public $disabled;

	public function setId( $id ) {
		$this->id = $id;
		return $this;
	}

	public function setLabel( $label ) {
		$this->label = $label;
		return $this;
	}

	public function setValues( $values ) {
		$this->values = $values;
		return $this;
	}

	public function setDefault( $selected ) {
		$this->selected = $selected;
		return $this;
	}

	public function setDisabled( $disabled ) {
		$this->disabled = $disabled;
		return $this;
	}

	public function addClasses( $classes ) {
		$this->classes = $classes;
		return $this;
	}

	public function build() {
		$is_disabled = '';
		if ( $this->disabled ) {
			$is_disabled = 'disabled';
		}
		echo "<div class='{$this->classes}'>";
		if ( $this->label != '' ) {
			echo "<label for='{$this->id}'>{$this->label}</label>";
		}
		echo "<select name='$this->id' id='{$this->id}' class='wpra-custom-select form-control' {$is_disabled}>";
		foreach ( $this->values as $key => $value ) {
			if ( $this->selected == $key ) {
				$is_selected = 'selected';
			} else {
				$is_selected = '';
			}
			echo "<option value='{$key}' {$is_selected}>{$value}</option>";
		}
		echo "</select></div>";
	}
}

class Checkbox {
	public $name = '';
	public $checkboxes = array();
	public $disabled = false;
	public $classes = '';

	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	public function addCheckbox( $id, $value, $label, $checked = '', $lottieAfter = false, $elemAfter = false) {
		$this->checkboxes[] = array(
			'id' => $id,
			'value' => $value,
			'label' => $label,
			'checked' => $checked,
			'lottieAfter' => $lottieAfter,
			'elemAfter' => $elemAfter
		);
		return $this;
	}

	public function addClasses( $classes ) {
		$this->classes = $classes;
		return $this;
	}

	public function setDisabled( $disabled ) {
		$this->disabled = $disabled;
		return $this;
	}

	public function build() {
		$is_disabled = '';
		if ( $this->disabled ) {
			$is_disabled = 'disabled';
		}
		foreach ($this->checkboxes as $checkbox) {
			if ( $checkbox['value'] == $checkbox['checked'] ) {
				$is_checked = 'checked';
			} else {
				$is_checked = '';
			}
			echo "<div class='{$this->classes}'>";
			echo "<div class='rectangle-checkbox'>";
			echo "<input type='checkbox' name='{$this->name}' id='{$checkbox["id"]}' value='{$checkbox["value"]}' {$is_checked} {$is_disabled}>";
			echo "<label for='{$checkbox["id"]}'><span>{$checkbox["label"]}</span></label>";
			if ($checkbox['lottieAfter']) {
				$emoji_name = str_replace('emojis_', '', $checkbox['id']);
				echo "<div class='lottie-element' data-emoji_name='{$emoji_name}'></div>";
			}
			if (is_array($checkbox['elemAfter'])) {
			    $disabled = isset($checkbox["elemAfter"]["disabled"]) ? 'disabled="disabled"' : '';
				echo "<div class='input-text-icon'>";
				$icon_url = Helper::getAsset("images/social/{$checkbox["elemAfter"]["icon"]}");
				echo "<img class='icon_{$checkbox["elemAfter"]["id"]}' src='{$icon_url}' alt='{$checkbox["elemAfter"]["id"]}'>";
				echo "<input type='text' {$disabled} id='{$checkbox["elemAfter"]["id"]}' class='form-control' value='{$checkbox["elemAfter"]["value"]}' placeholder='{$checkbox["elemAfter"]["placeholder"]}'>";
				echo "</div>";
			}
			else if ($checkbox['elemAfter']) {
				echo $checkbox['elemAfter'];
			}
			echo "</div>";
			echo "</div>";
		}
	}
}

class Switcher {
	private $id;
	private $name;
	private $checked;
	private $unchecked;
	private $value;
	private $title = '';
	private $classes = '';
	private $disabled = '';

	public function setId( $id ) {
		$this->id = $id;
		return $this;
	}

	public function setChecked( $checked ) {
		$this->checked = $checked;
		return $this;
	}

	public function setUnchecked($unchecked) {
		$this->unchecked = $unchecked;
		return $this;
	}

	public function setValue( $value) {
		$this->value = $value;
		return $this;
	}

	public function setTitle( $title ) {
		$this->title = $title;
		return $this;
	}

	public function addClasses( $classes ) {
		$this->classes = $classes;
		return $this;
	}

	public function setName( $name ) {
		$this->name = $name;
		return $this;
	}

	public function setDisabled() {
		$this->disabled = 'disabled';
		return $this;
	}

	function build() {
		if ($this->value == $this->checked) {
			$checked = 'checked';
		} else {
			$checked = '';
		}
		echo "<div class='wpe-switch-wrap {$this->classes}'>";
		if ($this->unchecked != '') {
			echo "<input type='hidden' name='{$this->id}' value='$this->unchecked'>";
		}
		if ($this->title != '') {
			echo "<p class='wpe-switch-title'>{$this->title}</p>";
		}
		$name = empty($this->name) ? $this->id : $this->name;

		echo '<label class="wpe-switch">';
		echo "<input id='{$this->id}' name='{$name}' type='checkbox' class='wpe-switch-input' {$checked} {$this->disabled} value='{$this->checked}'>";
		echo '<span class="wpe-switch-label" data-on="On" data-off="Off"></span>';
		echo '<span class="wpe-switch-handle"></span>';
        echo '</label></div>';
	}
}
