<?php
Namespace Adianti\Widget\Form;

use Adianti\Widget\Form\AdiantiWidgetInterface;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Form\TField;

/**
 * Slider Widget
 *
 * @version    2.0
 * @package    widget
 * @subpackage form
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006-2014 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class TSlider extends TField implements AdiantiWidgetInterface
{
    protected $id;
    private $min;
    private $max;
    private $step;
    
    /**
     * Class Constructor
     * @param $name Name of the widget
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->id   = 'tslider_'.uniqid();
    }
    
    /**
     * Define the field's range
     * @param $min Minimal value
     * @param $max Maximal value
     * @param $step Step value
     */
    public function setRange($min, $max, $step)
    {
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->value = $min;
    }
    
    /**
     * Enable the field
     * @param $form_name Form name
     * @param $field Field name
     */
    public static function enableField($form_name, $field)
    {
        TScript::create( " tslider_enable_field('{$form_name}', '{$field}'); " );
    }
    
    /**
     * Disable the field
     * @param $form_name Form name
     * @param $field Field name
     */
    public static function disableField($form_name, $field)
    {
        TScript::create( " tslider_disable_field('{$form_name}', '{$field}'); " );
    }
    
    /**
     * Shows the widget at the screen
     */
    public function show()
    {
        // define the tag properties
        $this->tag-> name  = $this->name;    // TAG name
        $this->tag-> value = $this->value;   // TAG value
        $this->tag-> type  = 'text';         // input type
        $this->tag-> style = "width:{$this->size}px";  // size
        
        if ($this->id)
        {
            $this->tag->{'id'} = $this->id;
        }
        
        // verify if the widget is editable
        if (parent::getEditable())
        {
            $this->tag-> readonly = "1";
            $this->tag-> style = "width:40px;-moz-user-select:none;border:0;text-align:center";
            
            $div = new TElement('div');
            $div-> id = $this->id.'_div';
            $div-> style = "width:{$this->size}px";
            
            $main_div = new TElement('div');
            $main_div-> style="text-align:center;width:{$this->size}px";
            
            TScript::create(" tslider_start( '#{$this->id}', {$this->value}, {$this->min}, {$this->max}, {$this->step}); ");
            
            $main_div->add($this->tag);
            $main_div->add($div);
            $main_div->show();
        }
        else
        {
            $this->tag-> readonly = "1";
            $this->tag->{'class'} = 'tfield_disabled'; // CSS
            $this->tag-> style = "width:40px;-moz-user-select:none;";
            $this->tag-> onmouseover = "style.cursor='default'";
            $this->tag->show();
        }
    }
    
    /**
     * Set the value
     */
    public function setValue($value)
    {
        parent::setValue( (int) $value);
    }
}
