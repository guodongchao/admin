<?php
$config = array (
    //应用ID,您的APPID。
    'app_id' => "2016091900549952",

    //商户私钥
    'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCDk0yRNlF/xvf8F/gZzJpnbpelCPlRM3Mo5WA36dS2Me6H4Pyb3UjhRyhUChrIAzanrYQdGC6i+BlmzO3NY3Oa3tA7V112CtIIsu9I8/FQwMlttq0ukwIcctaDfTCU6zhd0feJr81ecEx8fBCXnG04Lx8TAjksM7PRzIgCrTnkkVh964lxeRCgGhjFjqvFMADGITit8w1p6N2Hd214+8rvQurO7xl/rzj6m8Cm5z2V4jUhJRjKxT3Wh+tlXNlMuScJ04UC4eBkPQlmUHEugeRjn30p6JApmb1ocs87Vr0CqAo/2pawX3Q9todK9bk5ddQbC8GtgX9zIMcxVdV5ldBZAgMBAAECggEAXcoV/jz2A1tVUgHT/K/4MFqJBj9LWTKPmEtJNxIbanRVT850wrYOSWdru9woEwMXZpctYX/nXovzr2/M42dM9Mx3KpWwLYCxDzpdj2c0URfbfbWF5XktPBIwDzKh+sVhPJ97EE6c2gC6xNG7EheTU0VjpS0ki/me6KIfIalRZzecYM4GAiVsnXoJ+eWzVSsk+KnzWr006+RFMuM2hYa1ypSU1GQLooazWMvlTCZLfA9mnHEVCnB7DtANqgDNwbEjSaqTWVHn1JuXyJs9mUNsxGjyQQTgRPOqjcljSd8Jt95lylYhL3XJiSaUM/r2Bq8IwZWunOl8YjlYoFviHS4LMQKBgQDQGJ9KmhK9clQ6Hwj4qXJf9lJQ9ZiqdOxzS5QbMcGdqtkW262E/dyzuK7zlqAETJVX8EtIf/dHe2rfQBNNKoyEPHeNHMh7G1v0AFTF1SDFC4k5MKpwQqMRcweyJKHNNmZzdJYORfdnFK2y+r+j8MHOBei8GhdXPs552SNAPm+ZxwKBgQCh3TUPmoKK1sJX+e2uDRW2LzsDUDAKIeSVEdJkRS6VxfIbGJ/bRY1lwv4Et6i/F9VoteIRuZ9D48QBz2oT2LSkaKwDc3lrYvHk0sEAC0Yg0Ej+t/LeBgYr8JMRO/UeqwwYjfVzA2lW1pJvB8Vy5NpuHCjfjYonFouKbOMREkpE3wKBgQDBBfXLhzrWy1PhTaROsy5KYPtd6VGg2y/wiixpRS/pBe60SzSa5bdwZWCyxgbLthXZKiVKrJg8j/hD+PVuYIdSqZvjIs27k1cp75yynMz2uYqhp8iQtN75co+y6FPFPC6v7Xa66p9f2Eh+eiSE9u9uIQEOac04uiNf1s/h6YgvRQKBgBoB0t648rSgIQXFsHzAuXZWTGMR5UYbgAC7plRaEUwbS/UylazDlh59oBbd840QpUd3weUbMA3WcM3hp6ecsBmif9DmIuIwObGMc1owdYocLT5QDAPEcAVrWBXyzkWpMf5YANIEAE7llw2j8AOv5bC/cYnJ0iLJqo4JRMqfZ7N9AoGAUUypOmhHOcSDDLPOubWLutVrssp4N7YI+GOP+M1+ITktoFeQFThvIqf2VrAztJmmab4S8yOx7if3tDZNJc67jKBzyHG3vf0/rpGIeo/FXVnBG6I7dFBoRTOlVK0fr7yPZxryr9J9wulLnCOzkQVfoCO3OZE9jNe4En/FmY4nz4I=",

    //异步通知地址
    'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",

    //同步跳转
    'return_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/return_url.php",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3199zVjgpNCVMHBJFtbZcx++Q49j3QRLiv30EAC/PLqR6NMnvXklQvnXyAQF3hZoZ10Xcy9KZEEPL2LtyBlOlfPmyR1bDUJZhYAzdE1nuboxh6ohApmsmojU6Ck8vpgiK+tNhxPOdE7xOSLTLA3PvQRqb/WghODwaGrRA3Ck9Bg2Wb4zFZs6OE40785jccQWqn8WEAqS6kFdSRqNCUpcHd7DJG7Pb0Vy60i/3liUdBkJN5Usj26njYWgfZxSpwcrk1+Rcjco2TybLyTgmdM+qKqsScDX5TBSg36oP1XQZVUEdvZ7ZCY81+Qpj/eba7HAHK6B42bLTjpSLPUmN+gR3QIDAQAB",
);
return $config;