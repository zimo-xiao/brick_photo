<?php
return [
    'lang' => 'cn',
    'email' => [
        'siteName' => '红砖图库',
        'siteColor' => '#ea5662',
        'default' => [
            'title' => '来自红砖图库的一封信',
            'btn' => '点击进入红砖'
        ]
    ],
    'sendDeleteEmails' => [
        'contentTitle' => '有[count]张图片被管理员删除，如有疑问请联系：微信号lrh20021108'
    ],
    'authController' => [
        'usinExists' => '该学号已被注册',
        'passOrUsinError' => '用户名或密码错误',
        'email' => [
            'welcome' => [
                'title' => '欢迎！摄影师！',
                'description' => "恭喜你成为红砖摄影师，现在传图权限已经为你开启啦！\n\n\n请退出账号重新登陆,传图等功能已为您开启，如遇到任何问题请及时联系我们。期待你可以把自己满意的作品传到红砖，为附中增添一份宝藏！\n\n\n如果在传图的过程中遇到问题，或者你有大量传图的需求，欢迎联系我们（微信：lrh20021108），我们会第一时间给予支持！"
            ]
        ]
    ],
    'imageController' => [
        'visitorViewTag' => "编辑推荐",
    ],
    'validationCodeController' => [
        'mustEndWith' => '@i.pkuschool.edu.cn',
        'validationCodeEmail' => [
            'title' => '发送激活码，邀请附中人加入',
            'description' => "您的激活码是：**[code]**\n\n我们是红砖社团，很高兴向您发送这封邮件。我们将在以下介绍「红砖图库」，并向您发放注册激活码。如果您已熟知「红砖图库」，可以依照邮件末尾处的指示完成注册。\n\n\n### 一、「红砖图库」是什么？\n\n「红砖图库」(以下正文简称\"红砖\")是当前北京大学附属中学最大的图片库，面向全校同学和附中校友免费开放，并已有数十位摄影师入驻。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。\n\n\n### 二、「红砖图库」能带来什么？\n\n红砖保存上千张优质的附中照片。学校可以将这些照片用于校友活动；校内的社团和书院可以使用这些照片作为宣传用途；附中的普通同学也可以将这些图片设置成手机和电脑的壁纸。红砖使校内的学生团体宣传找图变得更加容易。\n\n\n### 三、「红砖图库」的注册流程\n\n「红砖图库」采用个人激活码注册，您的激活码是：**[code]**\n\n请访问[「红砖图库」](https://hong.zuggr.com)并于页面右上角完成注册。\n\n你可以点击右侧链接按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用「红砖图库」。\n\n如有任何疑问，请联系微信：lrh20021108"
        ]
    ],
    'main' => [
        'color' => '#ea5662',
        'secondaryColor' => '#13294b',
        'title' => '红砖图库 - 附中的宝藏',
        'pls_login' => '请在右上角登录；未注册请扫描右方 二维码 获取红砖账号',
        'register_form' => 'https://brick-1255766843.cos.ap-beijing.myqcloud.com/asset/code_qr.png',
        'social_media' => 'https://brick-1255766843.cos.ap-beijing.myqcloud.com/asset/wx_qr.jpg',
        'js' => [
            'request' => [
                'mustEndWith' => '@i.pkuschool.edu.cn',
                'downloadAlertContent' => '在下载图片时，本人同意将遵守「红砖平台使用协议」，用图署名作者，不在除声明用图场景外用图'
            ]
        ]
    ],
    'login' => [
        'usin' => '学号/工号'
    ],
    'register' => [
        'email' => '@i.pkuschool.edu.cn 邮箱（如果非此邮箱请选择「申请账号」）',
        'usin' => '学号/工号',
        'contract' => '我阅读、理解并同意<a target="_blank" href="https://shimo.im/docs/bmH8eGUP7OEKRP1e">「红砖平台使用协议」</a>'
    ],
    'download_box' => [
        'alert' => '如要下载去水印图片，请微信联系：YangynAcpovaurox',
    ],
    'header' => [
        'logo' => 'https://brick-1255766843.cos.ap-beijing.myqcloud.com/asset/logo.png',
        'logoWidth' => '100',
        'bg_img' => 'https://brick-1255766843.cos.ap-beijing.myqcloud.com/asset/background.gif',
        'title' => '不倒的记忆，附中的宝藏',
        'requestAccountForm' => 'https://shimo.im/forms/jhzlDpMETj88SNT4/fill',
        'tagline' => '北大附中最大的图库，目前共藏[images]张摄影作品，共[users]位附中校友在红砖',
        'custom_menu_items' => [
            [
                'name' => '协议',
                'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
            ]
        ]
    ],
    'index' => [
        'about' => [
            'title' => '关于我们',
            'description' => '红砖是目前北大附中最大的图片库，面向全校同学和附中校友免费开放。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。<br><br>联系/成为摄影师：微信号lrh20021108',
            'custom_menu_items' => [
                [
                    'name' => '协议',
                    'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                ]
            ]
        ],
        'image' => [
            'alert' => '侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者[author]」'
        ]
    ],
    'find_password' => [
        'usin' => '学号'
    ],
    'change_permission' => [
        'usin' => '学号'
    ]
];
