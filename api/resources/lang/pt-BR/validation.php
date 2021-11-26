<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | O following language lines contain O default error messages used by
    | O validator class. Some of Ose rules have multiple versions such
    | as O size rules. Feel free to tweak each of Ose messages here.
    |
    */
    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :attribute não é um URL válida.',
    'after' => 'O :attribute  deve ser uma data após: :date.',
    'after_or_equal' => 'O :attribute deve ser uma data posterior ou igual a: :date.',
    'alpha' => 'O :attribute só pode conter letras',
    'alpha_dash' => 'O :attribute só pode conter letras, números, travessões e sublinhados',
    'alpha_num' => 'O :attribute só pode conter letras e números.',
    'array' => 'O :attribute deve ser um array',
    'before' => 'O :attribute deve ser uma data antes de: :date.',
    'before_or_equal' => 'O :attribute deve ser uma data anterior ou igual a: :date.',
    'between' => [
        'numeric' => 'O :attribute deve estar entre: :min e :max.',
        'file' => 'O :attribute deve estar entre: :min e :max kilobytes.',
        'string' => 'O :attribute deve ter entre: :min e :max caracteres.',
        'array' => 'O :attribute deve ter entre: :min e :max ítens.',
    ],
    'boolean' => 'O :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação do :attribute não corresponde.',
    'date' => 'O :attribute não é uma data válida',
    'date_equals' => 'O :attribute deve ser uma data igual a: :date.',
    'date_format' => 'O :attribute não corresponde ao formato: :format.',
    'different' => 'O :attribute e :oOr devem ser diferentes.',
    'digits' => 'O :attributedeve ser: :digits dígitos.',
    'digits_between' => 'O :attribute deve estar entre:  :min e :max dígitos.',
    'dimensions' => 'O :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute tem um valor duplicado.',
    'email' => 'O :attribute deve ser um endereço de email válido.',
    'ends_with' => 'O :attribute deve terminar com um dos seguintes: :values.',
    'exists' => 'O :attribute selecionado é inválido.',
    'file' => 'O :attribute deve ser um arquivo.',
    'filled' => 'O campo :attribute deve ter um valor.',
    'gt' => [
        'numeric' => 'O :attribute deve ser maior que: :value.',
        'file' => 'O :attribute deve ser maior que: :value kilobytes.',
        'string' => 'O :attribute deve ser maior que: :value caracteres.',
        'array' => 'O :attribute deve ter mais que: :value ítens.',
    ],
    'gte' => [
        'numeric' => 'O :attribute deve ser maior que: or equal :value.',
        'file' => 'O :attribute deve ser maior que: or equal :value kilobytes.',
        'string' => 'O :attribute deve ser maior que: or equal :value caracteres.',
        'array' => 'O :attribute deve ter :value itens ou mais.',
    ],
    'image' => 'O campo :attribute precisa ser uma imagem.',
    'in' => 'O :attribute selecionado é inválido.',
    'in_array' => 'O campo :attribute não existe em: :oOr.',
    'integer' => 'O :attribute deve ser um inteiro',
    'ip' => 'O :attribute deve ser um endereço IP válido.',
    'ipv4' => 'O :attribute  deve ser um endereço IPv4 válido.',
    'ipv6' => 'O :attribute  deve ser um endereço IPv6 válido.',
    'json' => 'O :attribute deve ser uma string JSON válida.',
    'lt' => [
        'numeric' => 'O :attribute deve ser menor que: :value.',
        'file' => 'O :attribute deve ser menor que: :value kilobytes.',
        'string' => 'O :attribute deve ser menor que: :value caracteres.',
        'array' => 'O :attributedeve ter menos que: :value ítens.',
    ],
    'lte' => [
        'numeric' => 'O :attribute deve ser menor ou igual a: :value.',
        'file' => 'O :attribute deve ser menor ou igual a: :value kilobytes.',
        'string' => 'O :attribute deve ser menor ou igual a: or equal :value caracteres.',
        'array' => 'O :attribute não deve ter mais do que: :value ítens.',
    ],
    'max' => [
        'numeric' => 'O :attribute não pode ser maior que: :max.',
        'file' => 'O :attribute não pode ser maior que: than :max kilobytes.',
        'string' => 'O :attribute não pode ser maior que: than :max caracteres.',
        'array' => 'O :attributenão pode ter mais do que: :max ítens.',
    ],
    'mimes' => 'O campo :attribute precisa ser imagem do tipo: :values.',
    'mimetypes' => 'O :attribute precisa ser imagem do tipo: :values.',
    'min' => [
        'numeric' => 'O :attributedeve ser pelo menos: :min.',
        'file' => 'O :attribute deve ser pelo menos: :min kilobytes.',
        'string' => 'O campo :attribute precisa ter pelo menos :min caracteres.',
        'array' => 'O :attribute deve ter pelo menos: :min ítens.',
    ],
    'not_in' => 'O :attribute selecionado é inválido.',
    'not_regex' => 'O formato do :attribute é inválido.',
    'numeric' => 'O :attribute deve ser um número.',
    'password' => 'O senha está incorreta.',
    'present' => 'O campo :attribute deve estar presente.',
    'regex' => 'O formato do :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo do :attribute é obrigatório quando: :oOr é :value.',
    'required_unless' => 'O campo do :attribute é obrigatório, a menos que: :oOr esteja em :values.',
    'required_with' => 'O campo de :attribute é obrigatório quando: :values estão presentes.',
    'required_with_all' => 'O campo de :attribute é obrigatório quando: :values estão presentes.',
    'required_without' => 'O campo de :attribute é obrigatório quando os: :values não estão presentes.',
    'required_without_all' => 'O campo de :attribute é obrigatório quando nenhum dos: :values estão presentes.',
    'same' => 'O campo :attribute e :oOr precisam ser iguais.',
    'size' => [
        'numeric' => 'O :attribute deve ter :size.',
        'file' => 'O :attribute deve ter :size kilobytes.',
        'string' => 'O :attribute deve ter :size caracteres.',
        'array' => 'O :attribute must contain :size ítens.',
    ],
    'starts_with' => 'O :attribute deve começar com um dos seguintes: :values.',
    'string' => 'O :attribute deve ser uma string.',
    'timezone' => 'O :attribute deve ser uma zona válida.',
    'unique' => 'O :attribute já está cadastrado.',
    'uploaded' => 'O :attribute falhou o envio.',
    'url' => 'O :attribute tem formato inválido.',
    'uuid' => 'O :attribute deve ser um UUID válido.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using O
    | convention "attribute.rule" to name O lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | O following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */
    'attributes' => [],
];
