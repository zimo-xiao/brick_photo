<?php
return [
    'cn' => [
        'email' => [
            'siteName' => '红砖图库',
            'siteColor' => '#13294b',
            'default' => [
                'hello' => '你好',
                'title' => '来自红砖图库的一封信',
                'btn' => '点击进入红砖',
                'thanks' => '感谢'
            ]
        ],
        'authController' => [
            'validationCodeError' => '激活码错误',
            'usinExists' => '该学号已被注册',
            'validationError' => '验证错误',
            'passOrUsinError' => '用户名或密码错误',
            'userNotExists' => '该用户不存在',
            'permissionDenied' => '没有权限进行操作',
            'allUserInfo' => '所有用户信息',
            'email' => [
                'welcome' => [
                    'title' => '欢迎！摄影师！',
                    'description' => '恭喜你成为红砖摄影师，现在传图权限已经为你开启啦！\n\n\n请退出账号重新登陆,传图等功能已为您开启，如遇到任何问题请及时联系我们。期待你可以把自己满意的作品传到红砖，为附中增添一份宝藏！\n\n\n如果在传图的过程中遇到问题，或者你有大量传图的需求，欢迎联系我们（微信：lrh20021108），我们会第一时间给予支持！'
                ],
                'resetPass' => [
                    'title' => '找回密码邮件',
                    'description' => '请点击以下链接找回密码（50分钟内有效）：[url]'
                ]
            ]
        ],
        'downloadController' => [
            'imgNotExits' => '图片不存在',
            'imgProcessNotComplete' => '水印还在生成中，请过10分钟后再来下载',
            'expiredDownloadSession' => '下载过期',
            'permissionDenied' => '你没有权限',
            'downloadActivity' => '下载动态信息'
        ],
        'imageController' => [
            'permissionDenied' => '你没有权限',
            'visitorViewTag' => '编辑推荐',
            'imgNotExits' => '图片不存在'
        ],
        'validationCodeController' => [
            'permissionDenied' => '你没有权限',
            'excelFormatError' => 'Excel格式错误',
            'uploadSuccess' => '上传成功',
            'validationCodeEmail' => [
                'title' => '发送激活码，邀请附中人加入',
                'description' => "您的激活码是：**[code]**\n\n我们是红砖社团，很高兴向您发送这封邮件。我们将在以下介绍「红砖图库」，并向您发放注册激活码。如果您已熟知「红砖图库」，可以依照邮件末尾处的指示完成注册。\n\n\n### 一、「红砖图库」是什么？\n\n「红砖图库」(以下正文简称\"红砖\")是当前北京大学附属中学最大的图片库，面向全校同学和附中校友免费开放，并已有数十位摄影师入驻。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。\n\n\n### 二、「红砖图库」能带来什么？\n\n红砖保存上千张优质的附中照片。学校可以将这些照片用于校友活动；校内的社团和书院可以使用这些照片作为宣传用途；附中的普通同学也可以将这些图片设置成手机和电脑的壁纸。红砖使校内的学生团体宣传找图变得更加容易。\n\n\n### 三、「红砖图库」的注册流程\n\n「红砖图库」采用个人激活码注册，您的激活码是：**[code]**\n\n请访问[「红砖图库」](https://hong.zuggr.com)并于页面右上角完成注册。\n\n你可以点击右侧链接按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用「红砖图库」。\n\n如有任何疑问，请联系微信：lrh20021108"
            ],
            'exportExcelTitle' => '未激活的激活码'
        ],
        'main' => [
            'color' => '#13294b',
            'title' => '红砖图库 - 附中的宝藏',
            'pls_login' => '请在右上角登录；未注册请扫描右方 二维码 获取红砖账号',
            'js' => [
                'request' => [
                    'resetPass' => '密码重置成功！请输入新密码重新登录',
                    'noEmpty' => '请不要留空',
                    'findPass' => '验证邮箱已发到该学号所绑定的邮箱中，请查收',
                    'addTags' => '添加成功，请刷新查看',
                    'permissionDenied' => '权限不正确',
                    'addDescription' => '添加成功，请刷新查看',
                    'samePass' => '重复输入密码要和原密码一致哦',
                    'selectImg' => '请选择图片',
                    'uploadedTitle' => '上传完成',
                    'uploadedContent' => '成功上传[counter]张图片，请进入图库查看',
                    'uploadBtn' => '已选择[counter]张图片',
                    'downloadAlertTitle' => '知情同意',
                    'downloadAlertContent' => '在下载图片时，本人同意将遵守「红砖平台使用协议」：用图署名作者，不在除声明用图场景外用图',
                    'downloadAlertBtn' => '同意并下载图片',
                    'downloadRequireUsage' => '请填写下载用途',
                    'admin' => [
                        'deleteSuccess' => '删除成功，请刷新查看',
                        'wantToDelete' => '请问你是否要删除这些图片？',
                        'deleteBtn' => '删除',
                        'deleteSuccess' => '删除成功，请刷新查看',
                        'changePermissionSuccess' => '更改成功，请让用户退出登录再登录'
                    ]
                ]
            ],
            'dns' => [
                'jquery' => 'https://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js',
                'axios' => 'https://unpkg.com/axios@0.18.0/dist/axios.min.js',
                'vue' => 'https://unpkg.com/vue@2.6.10/dist/vue.min.js'
            ]
        ],
        'login' => [
            'title' => '登录',
            'usin' => '学号',
            'pass' => '密码',
            'btn' => '登录'
        ],
        'register' => [
            'title' => '注册',
            'usin' => '学号',
            'code' => '激活码',
            'pass' => '密码',
            'reenter_pass' => '请重新输入密码',
            'contract' => '我阅读、理解并同意',
            'btn' => '注册'
        ],
        'download_box' => [
            'alert' => '如要下载去水印图片，请微信联系：YangynAcpovaurox',
            'usage' => '请简单描述一下图片用途',
            'btn' => '下载图片'
        ],
        'header' => [
            'logo' => 'https://hong.zuggr.com/image/logo.png',
            'bg_img' => 'https://hong.zuggr.com/image/background.gif',
            'title' => '不倒的记忆，附中的宝藏',
            'tagline' => '北大附中最大的图库，目前共藏[images]张摄影作品，共[users]位附中校友在红砖',
            'admin_dropdown' => [
                'name' => '管理员操作',
                'upload_code' => '上传激活码',
                'change_user_permission' => '修改用户权限',
                'delete_image_batch' => '批量删除图片',
                'download_non_activated_codes' => '下载未激活码',
                'all_user_info' => '所有用户信息',
                'image_download_activities' => '图片下载动态'
            ],
            'logout' => '退出登录',
            'register' => '注册',
            'login' => '登录',
            'find_password' => '找回密码',
            'index' => '首页',
            'upload' => '上传图片',
            'custom_menu_items' => [
                [
                    'name' => '协议',
                    'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                ]
            ]
        ],
        'index' => [
            'left_menu_bar' => [
                'all' => '全部',
                'tags' => '标签',
                'photographers' => '摄影师/组织',
                'admins' => '管理员'
            ],
            'order' => [
                'update_desc' => '最新动态',
                'created_desc' => '最新发布',
                'created_asc' => '最旧发布'
            ],
            'about' => [
                'title' => '关于我们',
                'description' => '红砖是目前北大附中最大的图片库，面向全校同学和附中校友免费开放。我们',
                'custom_menu_items' => [
                    [
                        'name' => '协议',
                        'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                    ]
                ]
            ],
            'image' => [
                'author' => '作者',
                'download' => '下载',
                'add_tags' => '添加标签',
                'add_description' => '添加介绍',
                'no_description' => '暂时没有作品简介哦',
                'delete' => '删除',
                'alert' => '侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者[author]」'
            ]
        ],
        'reset_password' => [
            'title' => '找回密码',
            'pass' => '密码',
            'reenter_pass' => '请重复输入密码',
            'btn' => '更新密码'
        ],
        'upload' => [
            'instruction' => '将图片拖拽到此处，或点击选择文件，一次最多可上传40张图片',
            'btn' => '上传中请稍后，请不要关闭离开页面...',
            'selected' => '已选择[img_count]张图片'
        ],
        'admin_upload_validation_code' => [
            'instruction' => '将Excel文件拖拽到此处，或点击选择文件，不可多选',
            'btn' => '上传'
        ],
        'find_password' => [
            'title' => '找回密码',
            'usin' => '学号',
            'btn' => '向学号所绑定的邮箱发送邮件'
        ],
        'tags_box' => [
            'btn' => '添加标签'
        ],
        'description_box' => [
            'enter' => '请输入图片简介',
            'btn' => '添加介绍'
        ],
        'change_permission' => [
            'usin' => '学号',
            'permission' => '权限 (1读者，2摄影师，3管理员)',
            'btn' => '更改权限'
        ],
        'delete_image' => [
            'start' => '开始编号（删除时包括此图，要小于结束）',
            'end' => '结束编号（删除时包括此图）',
            'btn' => '删除图片'
        ],
        'delete_box' => [
            'title' => '请谨慎删除',
            'reason' => '请简单描述删除原因',
            'btn' => '删除'
        ]
    ],
    // en
    'en' => [
        'email' => [
            'siteName' => 'Illinium',
            'siteColor' => '#13294b',
            'default' => [
                'hello' => 'Hello',
                'title' => 'A letter from the Illinium team',
                'btn' => 'click to enter Illinium',
                'thanks' => 'thank you'
            ]
        ],
        'authController' => [
            'validationCodeError' => 'validation code not match',
            'usinExists' => 'user ID exists',
            'validationError' => 'validation error',
            'passOrUsinError' => 'password or username not match',
            'userNotExists' => 'user not exists',
            'permissionDenied' => 'permission denied',
            'allUserInfo' => 'all user information',
            'email' => [
                'welcome' => [
                    'title' => 'Welcome! Photographer!',
                    'description' => '恭喜你成为红砖摄影师，现在传图权限已经为你开启啦！\n\n\n请退出账号重新登陆,传图等功能已为您开启，如遇到任何问题请及时联系我们。期待你可以把自己满意的作品传到红砖，为附中增添一份宝藏！\n\n\n如果在传图的过程中遇到问题，或者你有大量传图的需求，欢迎联系我们（微信：lrh20021108），我们会第一时间给予支持！'
                ],
                'resetPass' => [
                    'title' => '找回密码邮件',
                    'description' => '请点击以下链接找回密码（50分钟内有效）：[url]'
                ]
            ]
        ],
        'downloadController' => [
            'imgNotExits' => '图片不存在',
            'imgProcessNotComplete' => '水印还在生成中，请过10分钟后再来下载',
            'expiredDownloadSession' => '下载过期',
            'permissionDenied' => '你没有权限',
            'downloadActivity' => '下载动态信息'
        ],
        'imageController' => [
            'permissionDenied' => '你没有权限',
            'visitorViewTag' => '编辑推荐',
            'imgNotExits' => '图片不存在'
        ],
        'validationCodeController' => [
            'permissionDenied' => '你没有权限',
            'excelFormatError' => 'Excel格式错误',
            'uploadSuccess' => '上传成功',
            'validationCodeEmail' => [
                'title' => '发送激活码，邀请附中人加入',
                'description' => "您的激活码是：**[code]**\n\n我们是红砖社团，很高兴向您发送这封邮件。我们将在以下介绍「红砖图库」，并向您发放注册激活码。如果您已熟知「红砖图库」，可以依照邮件末尾处的指示完成注册。\n\n\n### 一、「红砖图库」是什么？\n\n「红砖图库」(以下正文简称\"红砖\")是当前北京大学附属中学最大的图片库，面向全校同学和附中校友免费开放，并已有数十位摄影师入驻。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。\n\n\n### 二、「红砖图库」能带来什么？\n\n红砖保存上千张优质的附中照片。学校可以将这些照片用于校友活动；校内的社团和书院可以使用这些照片作为宣传用途；附中的普通同学也可以将这些图片设置成手机和电脑的壁纸。红砖使校内的学生团体宣传找图变得更加容易。\n\n\n### 三、「红砖图库」的注册流程\n\n「红砖图库」采用个人激活码注册，您的激活码是：**[code]**\n\n请访问[「红砖图库」](https://hong.zuggr.com)并于页面右上角完成注册。\n\n你可以点击右侧链接按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用「红砖图库」。\n\n如有任何疑问，请联系微信：lrh20021108"
            ],
            'exportExcelTitle' => '未激活的激活码'
        ],
        'main' => [
            'color' => '#13294b',
            'title' => '红砖图库 - 附中的宝藏',
            'pls_login' => '请在右上角登录；未注册请扫描右方 二维码 获取红砖账号',
            'js' => [
                'request' => [
                    'resetPass' => '密码重置成功！请输入新密码重新登录',
                    'noEmpty' => '请不要留空',
                    'findPass' => '验证邮箱已发到该学号所绑定的邮箱中，请查收',
                    'addTags' => '添加成功，请刷新查看',
                    'permissionDenied' => '权限不正确',
                    'addDescription' => '添加成功，请刷新查看',
                    'samePass' => '重复输入密码要和原密码一致哦',
                    'selectImg' => '请选择图片',
                    'uploadedTitle' => '上传完成',
                    'uploadedContent' => '成功上传[counter]张图片，请进入图库查看',
                    'uploadBtn' => '已选择[counter]张图片',
                    'downloadAlertTitle' => '知情同意',
                    'downloadAlertContent' => '在下载图片时，本人同意将遵守「红砖平台使用协议」：用图署名作者，不在除声明用图场景外用图',
                    'downloadAlertBtn' => '同意并下载图片',
                    'downloadRequireUsage' => '请填写下载用途',
                    'admin' => [
                        'deleteSuccess' => '删除成功，请刷新查看',
                        'wantToDelete' => '请问你是否要删除这些图片？',
                        'deleteBtn' => '删除',
                        'deleteSuccess' => '删除成功，请刷新查看',
                        'changePermissionSuccess' => '更改成功，请让用户退出登录再登录'
                    ]
                ]
            ],
            'dns' => [
                'jquery' => 'https://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js',
                'axios' => 'https://unpkg.com/axios@0.18.0/dist/axios.min.js',
                'vue' => 'https://unpkg.com/vue@2.6.10/dist/vue.min.js'
            ]
        ],
        'login' => [
            'title' => '登录',
            'usin' => '学号',
            'pass' => '密码',
            'btn' => '登录'
        ],
        'register' => [
            'title' => '注册',
            'usin' => '学号',
            'code' => '激活码',
            'pass' => '密码',
            'reenter_pass' => '请重新输入密码',
            'contract' => '我阅读、理解并同意',
            'btn' => '注册'
        ],
        'download_box' => [
            'alert' => '如要下载去水印图片，请微信联系：YangynAcpovaurox',
            'usage' => '请简单描述一下图片用途',
            'btn' => '下载图片'
        ],
        'header' => [
            'logo' => 'https://hong.zuggr.com/image/logo.png',
            'bg_img' => 'https://hong.zuggr.com/image/background.gif',
            'title' => '不倒的记忆，附中的宝藏',
            'tagline' => '北大附中最大的图库，目前共藏[images]张摄影作品，共[users]位附中校友在红砖',
            'admin_dropdown' => [
                'name' => '管理员操作',
                'upload_code' => '上传激活码',
                'change_user_permission' => '修改用户权限',
                'delete_image_batch' => '批量删除图片',
                'download_non_activated_codes' => '下载未激活码',
                'all_user_info' => '所有用户信息',
                'image_download_activities' => '图片下载动态'
            ],
            'logout' => '退出登录',
            'register' => '注册',
            'login' => '登录',
            'find_password' => '找回密码',
            'index' => '首页',
            'upload' => '上传图片',
            'custom_menu_items' => [
                [
                    'name' => '协议',
                    'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                ]
            ]
        ],
        'index' => [
            'left_menu_bar' => [
                'all' => '全部',
                'tags' => '标签',
                'photographers' => '摄影师/组织',
                'admins' => '管理员'
            ],
            'order' => [
                'update_desc' => '最新动态',
                'created_desc' => '最新发布',
                'created_asc' => '最旧发布'
            ],
            'about' => [
                'title' => '关于我们',
                'description' => '红砖是目前北大附中最大的图片库，面向全校同学和附中校友免费开放。我们',
                'custom_menu_items' => [
                    [
                        'name' => '协议',
                        'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                    ]
                ]
            ],
            'image' => [
                'author' => '作者',
                'download' => '下载',
                'add_tags' => '添加标签',
                'add_description' => '添加介绍',
                'no_description' => '暂时没有作品简介哦',
                'delete' => '删除',
                'alert' => '侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者[author]」'
            ]
        ],
        'reset_password' => [
            'title' => '找回密码',
            'pass' => '密码',
            'reenter_pass' => '请重复输入密码',
            'btn' => '更新密码'
        ],
        'upload' => [
            'instruction' => '将图片拖拽到此处，或点击选择文件，一次最多可上传40张图片',
            'btn' => '上传中请稍后，请不要关闭离开页面...',
            'selected' => '已选择[img_count]张图片'
        ],
        'admin_upload_validation_code' => [
            'instruction' => '将Excel文件拖拽到此处，或点击选择文件，不可多选',
            'btn' => '上传'
        ],
        'find_password' => [
            'title' => '找回密码',
            'usin' => '学号',
            'btn' => '向学号所绑定的邮箱发送邮件'
        ],
        'tags_box' => [
            'btn' => '添加标签'
        ],
        'description_box' => [
            'enter' => '请输入图片简介',
            'btn' => '添加介绍'
        ],
        'change_permission' => [
            'usin' => '学号',
            'permission' => '权限 (1读者，2摄影师，3管理员)',
            'btn' => '更改权限'
        ],
        'delete_image' => [
            'start' => '开始编号（删除时包括此图，要小于结束）',
            'end' => '结束编号（删除时包括此图）',
            'btn' => '删除图片'
        ],
        'delete_box' => [
            'title' => '请谨慎删除',
            'reason' => '请简单描述删除原因',
            'btn' => '删除'
        ]
    ]
];
