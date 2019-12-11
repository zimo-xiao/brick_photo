<?php
return [
    'lang' => 'en',
    'email' => [
        'siteName' => 'Illinium',
        'siteColor' => '#e04e39',
        'default' => [
            'title' => 'A letter from the Illinium team',
            'btn' => 'Enter Illinium'
        ]
    ],
    'authController' => [
        'usinExists' => 'NetID exists',
        'passOrUsinError' => 'NetID or password error',
        'email' => [
            'welcome' => [
                'title' => 'Welcome, photographer!',
                'description' => 'Hello'
            ]
        ]
    ],
    'imageController' => [
        'visitorViewTag' => "Editor's pick",
    ],
    'validationCodeController' => [
        'validationCodeEmail' => [
            'title' => 'Account Activation Code | Welcome to Illinium',
            'description' => "Hello"
        ]
    ],
    'main' => [
        'color' => '#e04e39',
        'secondaryColor' => '#13294b',
        'title' => 'Illinium - photography media library for Illinois',
        'pls_login' => 'Please login before download. 未注册请扫描右方 二维码 获取红砖账号',
        'register_form' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/register.jpg',
        'social_media' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/follow.jpg',
        'js' => [
            'request' => [
                'downloadAlertContent' => '在下载图片时，本人同意将遵守「红砖平台使用协议」：用图署名作者，不在除声明用图场景外用图'
            ]
        ]
    ],
    'login' => [
        'usin' => 'NetID'
    ],
    'register' => [
        'usin' => 'NetID',
        'contract' => 'I understand and agree to the'
    ],
    'download_box' => [
        'alert' => 'Remember to credit the author! 😉',
    ],
    'header' => [
        'logo' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/logo.png',
        'logoWidth' => '120',
        'bg_img' => 'https://hong.zuggr.com/image/background.gif',
        'title' => 'Blue and Orange Never Fade',
        'requestAccountForm' => 'https://forms.gle/2A5xHPiKVeCQgRbXA',
        'tagline' => 'Illinois\' largest photography media library. Proudly hosting [images] images，and sharing them with [users] Illinois student and faculties',
        'custom_menu_items' => [
            [
                'name' => 'Agreement',
                'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
            ],
            [
                'name' => 'Agreement',
                'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
            ]
        ]
    ],
    'index' => [
        'about' => [
            'title' => 'About Us',
            'description' => 'Illinium is the largest non-profit photography media library at UIUC, open to all students, alumni, and faculties. Our mission is to inspire academic work, community projects, and student activities with images of our beautiful campus, donated by an amazing community of campus photographers. Sign up for free! Our Illinium License provides free, non-profit-usage-only access for all members of UIUC.',
            'custom_menu_items' => [
                [
                    'name' => 'Illinium License',
                    'url' => 'https://docs.google.com/document/d/1E0vid7jMlINZ2n3bxVX3cLUp5aBKG-vzOtD4yoWBk74/edit?usp=sharing'
                ]
            ]
        ],
        'image' => [
            'alert' => '侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者[author]」'
        ]
    ],
    'find_password' => [
        'usin' => 'NetID'
    ],
    'change_permission' => [
        'usin' => 'NetID'
    ]
];
