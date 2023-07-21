<?php


    namespace App;


    use App\model\Post;

    class Form{


        private $post;

        private $postName;

        private $postContent;
        private $errors;

        private $data;




        public function __construct($data, ?array $err)
        {
            $this->data = $data;
            $this->errors = $err;
        }

        public function input (string $name, string $label): string
        {
            $value = $this->getValue($name);
            $inputClass = "form-control";
            $invalidFeedback ='';
            if(isset($this->errors[$name])){
                $inputClass .= " is-invalid";
                $invalidFeedback = "<div class='invalid-feedback'>" . implode('<br>', $this->errors[$name]) . "</div>";
            }

            return <<<HTML
            <label for="{$name}">$label</label>
            <input class="$inputClass" 
                id="{$name}" 
                type="text" 
                name="{$name}" 
                value="$value">
                $invalidFeedback
            HTML;
        }

        public function textarea(string $name, string $label): string
        {
            $value = $this->getValue($name);
            $inputClass = $this->getInputClass($name);
            $invalidFeedback = $this->getErrorFeedback($name);

            return <<<HTML
                 <label for="{$name}">$label :</label>
                 <textarea class="$inputClass" name="{$name}" id={$name} cols="30" rows="10" >$value
                 </textarea>
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