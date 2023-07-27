<?php


    namespace App;


    class Form{
        private $errors;

        private $data;




        public function __construct($data, ?array $err)
        {
            $this->data = $data;
            $this->errors = $err;
        }

        public function input (string $name, string $label, string $placeholder = null): string
        {
            $p = '';
            $inputClass = "form-control";
            $invalidFeedback ='';
            if($placeholder !== null){
                $p = "placeholder='$placeholder' ";
            }else{
                $value = $this->getValue($name);
                $p = "value ='{$value}'";
            }
            if(isset($this->errors[$name])){
                $inputClass .= " is-invalid";
                $invalidFeedback = "<div class='invalid-feedback'>" . implode('<br>', $this->errors[$name]) . "</div>";
            }

            return <<<HTML
            <label for="{$name}">$label</label>
            <input class="$inputClass" id="{$name}" type="text" name="{$name}" $p>
                $invalidFeedback
            HTML;
        }

        public function textarea(string $name, string $label, string $placeholder = null): string
        {
            $p = '';
            $v = '';
            $inputClass = $this->getInputClass($name);
            $invalidFeedback = $this->getErrorFeedback($name);
             if($placeholder !== null){
                $p = "placeholder='$placeholder'";
            }else{
                $value = $this->getValue($name);
                $v = "$value";
            }

            return <<<HTML
                 <label for="{$name}">$label :</label>
                 <textarea class="$inputClass" name="{$name}" id={$name} cols="30" rows="10" $p>$v</textarea>
                 $invalidFeedback
             HTML;
        }

        public function select(string $key, string $label, array $option):string
        {
            $class = '';
            $options = $option;
            $optionsHTML = [];
            $value = $this->getValue($key);
            foreach($options as $k => $v){
                $selected = in_array($k, $value) ? " selected" : '';
                $optionsHTML[] = "<option  value=$k $selected>$v</option>";
            }
            $optionsHTML = implode('', $optionsHTML);
            $inputClass = $this->getInputClass($key);
            $invalidFeedback = $this->getErrorFeedback($key);
            return <<<HTML
            <label for="{$key}">$label :</label>
            
            <select class="$inputClass" id="{$key}" type="text" name="{$key}[]" multiple>
                $optionsHTML;
            </select>
              $invalidFeedback  
            HTML;
        }


        private function getValue(string $key)
        {
            if(is_array($this->data)){
                return $this->data[$key] ?? null;
            }

            $method = "get". str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
            $value = $this->data->$method();
            if($value instanceof \DateTimeInterface){
               return $value->format(('Y-m-d H:i:s'));
            }
            return $value;
        }

        private function getInputClass(string $key) : string
        {
            $inputClass = "form-control";
             if(isset($this->errors[$key])){
                $inputClass .= " is-invalid";
            }
            return  $inputClass;
        }
        private function getErrorFeedback(string $key) : string
        {
             if(isset($this->errors[$key])){
                return "<div class='invalid-feedback'>" . implode('<br>', $this->errors[$key]) . "</div>";
            }
            return '';
            
        }

        

        

    }