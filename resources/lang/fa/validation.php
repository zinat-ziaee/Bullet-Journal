<?php

return [

    'accepted' => ':attribute باید پذیرفته شود.',
    'active_url' => ':attribute یک آدرس معتبر نیست.',
    'after' => ':attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => ':attribute باید تاریخی بعد از یا مساوی با :date باشد.',
    'alpha' => ':attribute باید فقط شامل حروف باشد.',
    'alpha_dash' => ':attribute باید فقط شامل حروف، اعداد، خط تیره و زیرخط باشد.',
    'alpha_num' => ':attribute باید فقط شامل حروف و اعداد باشد.',
    'array' => ':attribute باید یک آرایه باشد.',
    'before' => ':attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخی قبل از یا مساوی با :date باشد.',
    'between' => [
        'numeric' => ':attribute باید بین :min و :max باشد.',
        'file' => ':attribute باید بین :min و :max کیلوبایت باشد.',
        'string' => ':attribute باید بین :min و :max کاراکتر باشد.',
        'array' => ':attribute باید بین :min و :max آیتم داشته باشد.',
    ],
    'boolean' => 'فیلد :attribute باید صحیح یا غلط باشد.',
    'confirmed' => 'تاییدیه :attribute مطابقت ندارد.',
    'current_password' => 'رمز عبور اشتباه است.',
    'date' => ':attribute یک تاریخ معتبر نیست.',
    'date_equals' => ':attribute باید تاریخی مساوی با :date باشد.',
    'date_format' => ':attribute با فرمت :format مطابقت ندارد.',
    'different' => ':attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید بین :min و :max رقم باشد.',
    'dimensions' => ':attribute ابعاد تصویر نامعتبر دارد.',
    'distinct' => 'فیلد :attribute مقدار تکراری دارد.',
    'email' => ':attribute باید یک آدرس ایمیل معتبر باشد.',
    'ends_with' => ':attribute باید با یکی از مقادیر زیر خاتمه یابد: :values.',
    'exists' => ':attribute انتخاب شده نامعتبر است.',
    'file' => ':attribute باید یک فایل باشد.',
    'filled' => 'فیلد :attribute باید مقدار داشته باشد.',
    'gt' => [
        'numeric' => ':attribute باید بزرگتر از :value باشد.',
        'file' => ':attribute باید بزرگتر از :value کیلوبایت باشد.',
        'string' => ':attribute باید بزرگتر از :value کاراکتر باشد.',
        'array' => ':attribute باید بیشتر از :value آیتم داشته باشد.',
    ],
    'gte' => [
        'numeric' => ':attribute باید بزرگتر یا مساوی :value باشد.',
        'file' => ':attribute باید بزرگتر یا مساوی :value کیلوبایت باشد.',
        'string' => ':attribute باید بزرگتر یا مساوی :value کاراکتر باشد.',
        'array' => ':attribute باید حداقل :value آیتم داشته باشد.',
    ],
    'image' => ':attribute باید یک تصویر باشد.',
    'in' => ':attribute انتخاب شده نامعتبر است.',
    'in_array' => 'فیلد :attribute در :other وجود ندارد.',
    'integer' => ':attribute باید عدد صحیح باشد.',
    'ip' => ':attribute باید یک آدرس IP معتبر باشد.',
    'ipv4' => ':attribute باید یک آدرس IPv4 معتبر باشد.',
    'ipv6' => ':attribute باید یک آدرس IPv6 معتبر باشد.',
    'json' => ':attribute باید یک رشته JSON معتبر باشد.',
    'lt' => [
        'numeric' => ':attribute باید کمتر از :value باشد.',
        'file' => ':attribute باید کمتر از :value کیلوبایت باشد.',
        'string' => ':attribute باید کمتر از :value کاراکتر باشد.',
        'array' => ':attribute باید کمتر از :value آیتم داشته باشد.',
    ],
    'lte' => [
        'numeric' => ':attribute باید کمتر یا مساوی :value باشد.',
        'file' => ':attribute باید کمتر یا مساوی :value کیلوبایت باشد.',
        'string' => ':attribute باید کمتر یا مساوی :value کاراکتر باشد.',
        'array' => ':attribute نباید بیشتر از :value آیتم داشته باشد.',
    ],
    'max' => [
        'numeric' => ':attribute نباید بزرگتر از :max باشد.',
        'file' => ':attribute نباید بزرگتر از :max کیلوبایت باشد.',
        'string' => ':attribute نباید بیشتر از :max کاراکتر باشد.',
        'array' => ':attribute نباید بیشتر از :max آیتم داشته باشد.',
    ],
    'mimes' => ':attribute باید یکی از فرمت‌های :values باشد.',
    'mimetypes' => ':attribute باید یکی از فرمت‌های :values باشد.',
    'min' => [
        'numeric' => ':attribute باید حداقل :min باشد.',
        'file' => ':attribute باید حداقل :min کیلوبایت باشد.',
        'string' => ':attribute باید حداقل :min کاراکتر باشد.',
        'array' => ':attribute باید حداقل :min آیتم داشته باشد.',
    ],
    'multiple_of' => ':attribute باید مضربی از :value باشد.',
    'not_in' => ':attribute انتخاب شده نامعتبر است.',
    'not_regex' => 'فرمت :attribute نامعتبر است.',
    'numeric' => ':attribute باید عدد باشد.',
    'password' => 'رمز عبور اشتباه است.',
    'present' => 'فیلد :attribute باید موجود باشد.',
    'regex' => 'فرمت :attribute نامعتبر است.',
    'required' => 'فیلد :attribute الزامی است.',
    'required_if' => 'فیلد :attribute الزامی است وقتی :other برابر با :value باشد.',
    'required_unless' => 'فیلد :attribute الزامی است مگر اینکه :other در :values باشد.',
    'required_with' => 'فیلد :attribute الزامی است وقتی :values موجود باشد.',
    'required_with_all' => 'فیلد :attribute الزامی است وقتی :values موجود باشد.',
    'required_without' => 'فیلد :attribute الزامی است وقتی :values موجود نباشد.',
    'required_without_all' => 'فیلد :attribute الزامی است وقتی هیچ‌کدام از :values موجود نباشد.',
    'prohibited' => 'فیلد :attribute ممنوع است.',
    'prohibited_if' => 'فیلد :attribute ممنوع است وقتی :other برابر با :value باشد.',
    'prohibited_unless' => 'فیلد :attribute ممنوع است مگر اینکه :other در :values باشد.',
    'same' => ':attribute و :other باید مشابه باشند.',
    'size' => [
        'numeric' => ':attribute باید :size باشد.',
        'file' => ':attribute باید :size کیلوبایت باشد.',
        'string' => ':attribute باید :size کاراکتر باشد.',
        'array' => ':attribute باید :size آیتم داشته باشد.',
    ],
    'starts_with' => ':attribute باید با یکی از موارد زیر شروع شود: :values',
    'string' => ':attribute باید رشته باشد.',
    'timezone' => ':attribute باید یک منطقه زمانی معتبر باشد.',
    'unique' => ':attribute قبلاً استفاده شده است.',
    'uploaded' => 'بارگذاری :attribute ناموفق بود.',
    'url' => 'فرمت :attribute نامعتبر است.',
    'uuid' => ':attribute باید UUID معتبر باشد.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => 'ایمیل',
        'password' => 'رمز عبور',
        'name' => 'نام',
    ],

];
