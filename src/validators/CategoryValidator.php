<?php


    namespace App\validators;

use App\table\CategoryTable;

    class CategoryValidator extends AbstractValidator{
        
        public function __construct(array $data, CategoryTable $table, ?int $id = null )
        {
            parent::__construct($data);
            $this->validator->rule('required', ['name'])
            ->rule('lengthBetween', 'name', 3, 255)
            ->rule(function ($field, $value) use ($table, $id){
                    return !$table->exists($field, $value, $id);
            }, ['name','slug'], ' est déjà utilisé');  
        }
    }