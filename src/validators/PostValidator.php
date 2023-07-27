<?php


    namespace App\validators;
    use App\table\PostTable;
    use App\validators\AbstractValidator;


    class PostValidator extends AbstractValidator{


        public function __construct(array $data, PostTable $table, array $categories, ?int $postId = null)
        {
            parent::__construct($data);
            $this->validator->rule('required', ['name', 'content', 'created_at'])
            ->rule('lengthBetween', 'name', 3, 255)
            ->rule('date' , 'created_at', 'Y-m-d H:i:s')
            ->rule('subset', 'categories_ids', array_keys($categories))
            ->rule(function ($field, $value) use ($table, $postId){
                    
                    return !$table->exists($field, $value, $postId);
            }, 'name', ' est déjà utilisé');  
        }

    }