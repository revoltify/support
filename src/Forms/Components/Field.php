<?php

declare(strict_types=1);

namespace Revoltify\Support\Forms\Components;

use Closure;
use Revoltify\Support\Forms\Contracts\FormComponent;

class Field implements FormComponent
{
    // Core properties
    private string $key;

    private string $label;

    private string $type = 'text';

    private mixed $value = '';

    private mixed $default = null;

    // UI properties
    private ?string $placeholder = null;

    private ?string $helpertext = null;

    private ?string $tooltip = null;

    private ?string $hint = null;

    private ?string $hintIcon = null;

    private ?string $hintColor = null;

    private ?string $hintActionLabel = null;

    private ?string $hintActionUrl = null;

    private ?string $hintActionIcon = null;

    private bool $hintActionOpenInNewTab = false;

    // State properties
    private bool $required = false;

    private bool $disabled = false;

    private bool $readOnly = false;

    private bool $live = false;

    private bool $columnSpanFull = false;

    // Validation properties
    /** @var list<string>|null */
    private ?array $rules = null;

    // Visibility properties
    private ?Closure $visible = null;

    private ?string $visibleWhen = null;

    private mixed $visibleWhenValue = null;

    private ?string $dependent = null;

    // Select/Radio/Tags properties
    /** @var array<array-key, string>|null */
    private ?array $options = null;

    private bool $multiple = false;

    private bool $searchable = false;

    private bool $preload = false;

    // Text field properties
    private ?int $maxLength = null;

    private ?int $minLength = null;

    private ?string $prefix = null;

    private ?string $suffix = null;

    private bool $suffixCopy = false;

    private ?Closure $suffixAction = null;

    private bool $url = false;

    // Number field properties
    private ?int $minValue = null;

    private ?int $maxValue = null;

    private ?string $step = null;

    // Textarea properties
    private ?int $rows = null;

    // File upload properties
    /** @var list<string>|null */
    private ?array $acceptedFileTypes = null;

    private ?int $maxSize = null;

    private bool $image = false;

    // Password properties
    private bool $revealable = false;

    // Code editor properties
    private ?string $language = null;

    private ?int $height = null;

    /**
     * Create a new field instance
     */
    public static function make(string $key): self
    {
        $instance = new self;
        $instance->key = $key;
        $instance->label = ucfirst(str_replace('_', ' ', $key));

        return $instance;
    }

    // ===========================================
    // Field Type Methods
    // ===========================================

    public function text(string $value = ''): self
    {
        $this->type = 'text';
        $this->value = $value;

        return $this;
    }

    public function password(string $value = ''): self
    {
        $this->type = 'password';
        $this->value = $value;

        return $this;
    }

    public function email(string $value = ''): self
    {
        $this->type = 'email';
        $this->value = $value;

        return $this;
    }

    public function number(int|string $value = ''): self
    {
        $this->type = 'number';
        $this->value = $value;

        return $this;
    }

    public function textarea(string $value = '', int $rows = 3): self
    {
        $this->type = 'textarea';
        $this->value = $value;
        $this->rows = $rows;
        $this->columnSpanFull = true;

        return $this;
    }

    public function markdown(string $value = ''): self
    {
        $this->type = 'markdown';
        $this->value = $value;
        $this->columnSpanFull = true;

        return $this;
    }

    /**
     * @param  array<array-key, string>  $options
     */
    public function select(array $options = [], string $value = ''): self
    {
        $this->type = 'options';
        $this->options = $options;
        if ($value !== '' && $value !== '0') {
            $this->value = $value;
        }

        return $this;
    }

    /**
     * @param  array<array-key, string>  $options
     */
    public function radio(array $options = []): self
    {
        $this->type = 'radio';
        $this->options = $options;

        return $this;
    }

    public function checkbox(bool $value = false): self
    {
        $this->type = 'checkbox';
        $this->value = $value;

        return $this;
    }

    public function file(): self
    {
        $this->type = 'file';

        return $this;
    }

    public function color(string $value = ''): self
    {
        $this->type = 'color';
        $this->value = $value;

        return $this;
    }

    /**
     * @param  list<string>  $value
     */
    public function tags(array $value = []): self
    {
        $this->type = 'tags';
        $this->value = $value;

        return $this;
    }

    public function codeEditor(string $value = ''): self
    {
        $this->type = 'codeeditor';
        $this->value = $value;
        $this->columnSpanFull = true;

        return $this;
    }

    // ===========================================
    // Core Configuration Methods
    // ===========================================

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function value(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function default(mixed $default): self
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @param  array<array-key, string>  $options
     */
    public function options(array $options, string $value = ''): self
    {
        $this->options = $options;
        if ($value !== '' && $value !== '0') {
            $this->value = $value;
        }

        return $this;
    }

    public function toggle(string $value = 'disable'): self
    {
        return $this->select([
            'enable' => 'Enable',
            'disable' => 'Disable',
        ])->default($value);
    }

    // ===========================================
    // UI Configuration Methods
    // ===========================================

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function helperText(string $helpertext): self
    {
        $this->helpertext = $helpertext;

        return $this;
    }

    public function tooltip(string $tooltip): self
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function hint(string $hint): self
    {
        $this->hint = $hint;

        return $this;
    }

    public function hintIcon(string $icon, ?string $tooltip = null): self
    {
        $this->hintIcon = $icon;
        if ($tooltip !== null && $tooltip !== '' && $tooltip !== '0') {
            $this->tooltip = $tooltip;
        }

        return $this;
    }

    public function hintColor(string $color): self
    {
        $this->hintColor = $color;

        return $this;
    }

    public function hintActionUrl(string $label, string $url, ?string $icon = null, bool $openInNewTab = true): self
    {
        $this->hintActionLabel = $label;
        $this->hintActionUrl = $url;
        $this->hintActionIcon = $icon;
        $this->hintActionOpenInNewTab = $openInNewTab;

        return $this;
    }

    // ===========================================
    // State & Behavior Methods
    // ===========================================

    public function required(bool $required = true): self
    {
        $this->required = $required;

        return $this;
    }

    public function disabled(bool $disabled = true): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function readOnly(bool $readOnly = true): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function live(bool $live = true): self
    {
        $this->live = $live;

        return $this;
    }

    public function columnSpanFull(bool $columnSpanFull = true): self
    {
        $this->columnSpanFull = $columnSpanFull;

        return $this;
    }

    // ===========================================
    // Validation Methods
    // ===========================================

    /**
     * @param  list<string>|string  $rules
     */
    public function rules(array|string $rules): self
    {
        $this->rules = is_array($rules) ? $rules : [$rules];

        return $this;
    }

    // ===========================================
    // Visibility Methods
    // ===========================================

    public function visible(Closure $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function visibleWhen(string $field, mixed $value): self
    {
        $this->visibleWhen = $field;
        $this->visibleWhenValue = $value;

        return $this;
    }

    public function dependent(string $dependent): self
    {
        $this->dependent = $dependent;

        return $this;
    }

    // ===========================================
    // Text Field Methods
    // ===========================================

    public function maxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function minLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function rows(int $rows): self
    {
        $this->rows = $rows;

        return $this;
    }

    public function prefix(string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix(string $suffix): self
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function suffixCopy(bool $suffixCopy = true): self
    {
        $this->suffixCopy = $suffixCopy;

        return $this;
    }

    public function suffixAction(Closure $suffixAction): self
    {
        $this->suffixAction = $suffixAction;

        return $this;
    }

    public function url(bool $url = true): self
    {
        $this->url = $url;

        return $this;
    }

    // ===========================================
    // Number Field Methods
    // ===========================================

    public function min(int $minValue): self
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function max(int $maxValue): self
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    public function step(string $step): self
    {
        $this->step = $step;

        return $this;
    }

    // ===========================================
    // File Upload Methods
    // ===========================================

    /**
     * @param  list<string>  $types
     */
    public function acceptedFileTypes(array $types): self
    {
        $this->acceptedFileTypes = $types;

        return $this;
    }

    public function maxSize(int $maxSize): self
    {
        $this->maxSize = $maxSize;

        return $this;
    }

    public function image(bool $image = true): self
    {
        $this->image = $image;

        return $this;
    }

    // ===========================================
    // Select/Dropdown Methods
    // ===========================================

    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;

        return $this;
    }

    public function preload(bool $preload = true): self
    {
        $this->preload = $preload;

        return $this;
    }

    // ===========================================
    // Password Methods
    // ===========================================

    public function revealable(bool $revealable = true): self
    {
        $this->revealable = $revealable;

        return $this;
    }

    // ===========================================
    // Code Editor Methods
    // ===========================================

    public function language(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function height(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    // ===========================================
    // Getter Methods (FormComponent Interface)
    // ===========================================

    public function getKey(): string
    {
        return $this->key;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getDefault(): mixed
    {
        return $this->default ?? $this->value;
    }

    /**
     * @return array<array-key, string>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    // ===========================================
    // Serialization
    // ===========================================

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            // Core
            'type' => $this->type,
            'label' => $this->label,
            'value' => $this->value,
            'default' => $this->default,

            // UI
            'placeholder' => $this->placeholder,
            'helpertext' => $this->helpertext,
            'tooltip' => $this->tooltip,
            'hint' => $this->hint,
            'hintIcon' => $this->hintIcon,
            'hintColor' => $this->hintColor,
            'hintActionLabel' => $this->hintActionLabel,
            'hintActionUrl' => $this->hintActionUrl,
            'hintActionIcon' => $this->hintActionIcon,
            'hintActionOpenInNewTab' => $this->hintActionOpenInNewTab,

            // State
            'required' => $this->required,
            'disabled' => $this->disabled,
            'readOnly' => $this->readOnly,
            'live' => $this->live,
            'columnSpanFull' => $this->columnSpanFull,

            // Validation
            'rules' => $this->rules,

            // Visibility
            'visible' => $this->visible,
            'visibleWhen' => $this->visibleWhen,
            'visibleWhenValue' => $this->visibleWhenValue,
            'dependent' => $this->dependent,

            // Select/Options
            'options' => $this->options,
            'multiple' => $this->multiple,
            'searchable' => $this->searchable,
            'preload' => $this->preload,

            // Text fields
            'maxLength' => $this->maxLength,
            'minLength' => $this->minLength,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'suffixCopy' => $this->suffixCopy,
            'suffixAction' => $this->suffixAction,
            'url' => $this->url,

            // Number fields
            'minValue' => $this->minValue,
            'maxValue' => $this->maxValue,
            'step' => $this->step,

            // Textarea
            'rows' => $this->rows,

            // File upload
            'acceptedFileTypes' => $this->acceptedFileTypes,
            'maxSize' => $this->maxSize,
            'image' => $this->image,

            // Password
            'revealable' => $this->revealable,

            // Code editor
            'language' => $this->language,
            'height' => $this->height,
        ];
    }
}
