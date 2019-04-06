<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => '当前:必须接受属性.',
    'active_url' => '当前:属性不是有效的URL.',
    'after' => '当前:属性必须是之后的日期:日期.',
    'after_or_equal' => '当前:属性必须是晚于或等于的日期:日期.',
    'alpha' => '当前:属性只能包含字母.',
    'alpha_dash' => '当前:属性只能包含字母,数字,短划线和下划线.',
    'alpha_num' => '当前: 属性可能只包含字母和数字.',
    'array' => '当前:属性必须是数组.',
    'before' => '当前:属性必须早于日期:日期.',
    'before_or_equal' => '当前:属性必须是早于或等于的日期:日期.',
    'between' => [
        'numeric' => '当前:属性必须介于:分和:最大值之间.',
        'file'    => '当前:属性必须介于:分和:最大千字节之间.',
        'string'  => '当前:属性必须介于:分和:最大字符之间.',
        'array'   => '当前:属性必须在:分和:最大项之间.',
    ],
    'boolean' => '当前:属性字段必须为 true 真 或 false 假.',
    'confirmed' => '当前:属性确认不匹配.',
    'date' => '当前:属性不是有效日期.',
    'date_equals' => '当前:属性的日期必须等于:日期.',
    'date_format' => '当前:属性与格式不匹配:格式.',
    'different' => '当前:属性和:其他必须不同 .',
    'digits' => '当前:属性必须有: digits 位数字.',
    'digits_between' => '当前:属性必须介于：最小和最大位数之间.',
    'dimensions' => '当前:属性具有无效的图像维度.',
    'distinct' => '当前:属性字段的值重复.',
    'email' => '当前:属性必须是有效的电子邮件地址.',
    'exists' => '所选：属性无效.',
    'file' => '当前:属性必须是文件.',
    'filled' => '当前:"属性"是必需的.',
    'gt' => [
        'numeric' => '当前:属性必须大于值.',
        'file' => '当前:属性必须大于:value 千字节.',
        'string' => '当前:属性必须大于:value 字符.',
        'array' => '当前:属性必须至少具有:value 项目.',
    ],
    'gte' => [
        'numeric' => '当前:属性必须大于或等于:value.',
        'file' => '当前:属性必须大于或等于:value 千字节.',
        'string' => '当前:属性必须大于或等于:value 文字.',
        'array' => '当前:属性必须具有:value 项目或更多.',
    ],
    'image' => '当前:属性必须是图像.',
    'in' => '所选:属性无效.',
    'in_array' => '当前:属性字段不存在于:其他.',
    'integer' => '当前:属性必须是整数.',
    'ip' => '当前:属性必须是有效的IP地址.',
    'ipv4' => '当前:属性必须是有效的IPv4地址.',
    'ipv6' => '当前:属性必须是有效的IPv6地址.',
    'json' => '当前:属性必须是有效的JSON字符串.',
    'lt' => [
        'numeric' => '当前:属性必须小于:value.',
        'file' => '当前:属性必须小于:value 千字节.',
        'string' => '当前:属性必须小于:value 字符.',
        'array' => '当前:属性必须小于:value 项目.',
    ],
    'lte' => [
        'numeric' => '当前:属性必须小于或等于:value.',
        'file' => '当前:属性必须小于或等于:value 千字节.',
        'string' => '当前:属性必须小于或等于:value 文字.',
        'array' => '当前:attribute 不能超过:value 项目.',
    ],
    'max' => [
        'numeric' => '当前:attribute 不能大于:max.',
        'file' => '当前:attribute 不能大于:max 千字节.',
        'string' => ':attribute 最多有:max 个字符.',
        'array' => '当前:attribute 不能超过:max 项目.',
    ],
    'mimes' => '当前:attribute 必须是类型为的文件:values.',
    'mimetypes' => '当前:attribute 必须是类型为的文件:values.',
    'min' => [
        'numeric' => '当前:attribute 必须至少为:min.',
        'file' => '当前:attribute 必须至少为:min 千字节.',
        'string' => ':attribute 最少要有 :min 个字符.',
        'array' => '当前:attribute 必须至少具有:min 项目.',
    ],
    'not_in' => '所选:attribute 无效.',
    'not_regex' => '当前:attribute 格式无效.',
    'numeric' => '当前:attribute 必须是数字形式.',
    'present' => '当前:attribute 字段必须存在.',
    'regex' => '当前:attribute 格式无效.',
    'required' => '必填项 :attribute 为空.',
    'required_if' => '当前:attribute 字段是必需的:条件是:value.',
    'required_unless' => '当前:attribute field is required unless :other is in :values.',
    'required_with' => '当前:attribute field is required when :values is present.',
    'required_with_all' => '当前:attribute field is required when :values are present.',
    'required_without' => '当前:attribute field is required when :values is not present.',
    'required_without_all' => '当前:attribute field is required when none of :values are present.',
    'same' => '当前:attribute and :other must match.',
    'size' => [
        'numeric' => '当前:attribute must be :size.',
        'file' => '当前:attribute must be :size kilobytes.',
        'string' => '当前:attribute must be :size characters.',
        'array' => '当前:attribute must contain :size items.',
    ],
    'starts_with' => '当前:attribute must start with one of the following: :values',
    'string' => '当前:attribute must be a string.',
    'timezone' => '当前:attribute must be a valid zone.',
    'unique' => ':attribute 已被占用,请更换.',
    'uploaded' => '当前:attribute failed to upload.',
    'url' => '当前:attribute format is invalid.',
    'uuid' => '当前:attribute must be a valid UUID.',

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

    'attributes' => [],

];
