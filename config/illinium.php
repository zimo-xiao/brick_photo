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
                'title' => 'Hello Photographer! | Welcome to Illinium Photography',
                'description' => 'Congratulation! Our team would like to welcome you to the Illinium Photography community. Your Illinium account now has permission to upload your photography work. If you are logged in, please logout and login again to make it effective.\n\n\nWe are looking forward to seeing your beautiful photos on our platform. If you have any questions, feel free to reach out to our team (email: zimox2@illinois.edu).'
            ]
        ]
    ],
    'imageController' => [
        'visitorViewTag' => "Editor's Pick",
    ],
    'validationCodeController' => [
        'mustEndWith' => '@illinium.edu',
        'validationCodeEmail' => [
            'title' => 'Your Account Activation Code | Welcome to Illinium Photography',
            'description' => "Your account activation code is : **[code]** \n\n We have received your request for an Illinium account. We are delighted to invite you to create your account and explore the vast collections that our photographer community offers. Please visit our website and click register to create your account. \n\n ### About Us \n\n Illinium is the largest non-profit photography media library at UIUC, open to all students, alumni, and faculties. Our mission is to inspire academic work, community projects, and student activities with images of our beautiful campus, donated by an amazing community of campus photographers. Sign up for free! Our Illinium License provides free, non-profit-usage-only access for all members of UIUC. \n\n We are looking forward to your arrival. If you have any questions, feel free to reach out to our team (email: zimox2@illinois.edu)."
        ]
    ],
    'main' => [
        'color' => '#e04e39',
        'secondaryColor' => '#13294b',
        'title' => 'Illinium - photography media library for Illinois',
        'pls_login' => 'Please login before download. Request account if you don\'t have an access',
        'register_form' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/register.jpg',
        'social_media' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/follow.jpg',
        'js' => [
            'request' => [
                'mustEndWith' => '@illinois.edu',
                'downloadAlertContent' => 'I understand and agree with the <a target="_blank" href="https://docs.google.com/document/d/1E0vid7jMlINZ2n3bxVX3cLUp5aBKG-vzOtD4yoWBk74/edit#">Illinium Licence</a>, and will only use this photography work in nonprofit usage.'
            ]
        ]
    ],
    'login' => [
        'usin' => 'NetID'
    ],
    'register' => [
        'email' => '@illinois Email (Request Account If Using Non-Illinois Address)',
        'usin' => 'NetID',
        'contract' => 'I understand and agree with the <a target="_blank" href="https://docs.google.com/document/d/1E0vid7jMlINZ2n3bxVX3cLUp5aBKG-vzOtD4yoWBk74/edit#">Illinium Licence</a>'
    ],
    'download_box' => [
        'alert' => 'Remember to credit the author! 😉',
    ],
    'header' => [
        'logo' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/logo.png',
        'logoWidth' => '120',
        'bg_img' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/bg.jpg',
        'title' => 'Blue and Orange Never Fade',
        'requestAccountForm' => 'https://forms.gle/2A5xHPiKVeCQgRbXA',
        'tagline' => 'Illinois\' largest photography media library. Proudly hosting [images] images，and sharing them with [users] Illinois student and faculties',
        'custom_menu_items' => [
            [
                'name' => 'Illinium License',
                'url' => 'https://docs.google.com/document/d/1E0vid7jMlINZ2n3bxVX3cLUp5aBKG-vzOtD4yoWBk74/edit#'
            ],
            [
                'name' => 'Become A Photographer',
                'url' => 'https://forms.gle/ZQuoFHoEZieeCFjB9'
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
                ],
                [
                    'name' => 'Become A Photographer',
                    'url' => 'https://forms.gle/ZQuoFHoEZieeCFjB9'
                ]
            ]
        ],
        'image' => [
            'alert' => 'Show appreciation with a simple credit: Photo by [author] on Illinium'
        ]
    ],
    'find_password' => [
        'usin' => 'NetID'
    ],
    'change_permission' => [
        'usin' => 'NetID'
    ]
];
