<?php
return [
    'cn' => [
        'authenticate' => [
            'credential_error' => '用户验证错误'
        ],
        'sendDownloadEmails' => [
            'title' => '下载图片提醒',
            'contentTitle' => '今天一共有[count]次图片下载',
            'contentItem' => "\n\n[name]下载了你编号为**[id]**的图片，使用原因为：**[usage]**"
        ],
        'sendDeleteEmails' => [
            'title' => '图片删除通知',
            'contentTitle' => '有[count]张图片被管理员删除，如有疑问请联系：微信号lrh20021108',
            'contentItem' => "\n\n编号为**[id]**的图片被管理员删除；原因：**[reason]**"
        ],
        'email' => [
            'siteName' => '红砖图库',
            'siteColor' => '#E63D52',
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
            'mustEndWith' => '',
            'frequentRequestError' => '请求过于频繁，请1分钟后重试',
            'mustEndWithError' => '请求验证码邮箱必须以[email]结尾，如果使用外部邮箱，请选择「请求账户」',
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
            'color' => '#E63D52',
            'secondaryColor' => '#13294b',
            'title' => '红砖图库 - 附中的宝藏',
            'pls_login' => '请在右上角登录；未注册请扫描右方 二维码 获取红砖账号',
            'register_form' => 'https://hong.zuggr.com/image/wx_qr.jpg',
            'social_media' => 'https://hong.zuggr.com/image/wx_qr.jpg',
            'js' => [
                'request' => [
                    'mustEndWith' => '',
                    'codeSuccess' => '验证码已发送到指定[email]邮箱，请查收！',
                    'noEmail' => '请输入邮箱地址',
                    'mustEndWithError' => '请求验证码邮箱必须以[email]结尾，如果使用外部邮箱，请选择「请求账户」',
                    'codeSendSuccess' => '验证码已发到你的邮箱中，请查收！',
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
                    'uploadBtn' => '已选择[counter]张图片，点击上传（如数量和选择不符，请等待，图片正在压缩处理）',
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
                ],
                'layui' => [
                    'uploadError' => '上传接口发生错误，请重新上传',
                    'confirm' => '确定'
                ]
            ],
            'dns' => [
                'jquery' => 'https://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js',
                'axios' => 'https://unpkg.com/axios@0.18.0/dist/axios.min.js',
                'vue' => 'https://unpkg.com/vue@2.6.10/dist/vue.min.js',
                'materialIcon' => 'https://unpkg.com/material-design-icons@3.0.1/iconfont/material-icons.css'
            ]
        ],
        'login' => [
            'title' => '登录',
            'usin' => '学号',
            'pass' => '密码',
            'btn' => '登录'
        ],
        'register' => [
            'request_code' => '请求',
            'email' => '电子邮箱地址',
            'name' => '姓名',
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
            'logoWidth' => '90',
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
            'requestAccount' => '请求账号',
            'requestAccountForm' => '',
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
            ],
            'prev' => '上一页',
            'next' => '下一页'
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
    
    //


    'en' => [
        'authenticate' => [
            'credential_error' => 'invalid credential'
        ],
        'sendDownloadEmails' => [
            'title' => 'Image Download Alert',
            'contentTitle' => '[count] of your images where downloaded.',
            'contentItem' => "\n\n[name] downloaded your image ID **[id]**. Usage: **[usage]**"
        ],
        'sendDeleteEmails' => [
            'title' => 'Image Delete Alert',
            'contentTitle' => '[count] of your images where deleted by admin',
            'contentItem' => "\n\nImage ID **[id]** is deleted by admin. Reason: **[reason]**"
        ],
        'email' => [
            'siteName' => 'Illinium',
            'siteColor' => '#e04e39',
            'default' => [
                'hello' => 'Hello',
                'title' => 'A letter from the Illinium team',
                'btn' => 'Enter Illinium',
                'thanks' => 'Thanks'
            ]
        ],
        'authController' => [
            'validationCodeError' => 'Validation code error',
            'usinExists' => 'NetID exists',
            'validationError' => 'Validation error',
            'passOrUsinError' => 'NetID or password error',
            'userNotExists' => 'User not exists',
            'permissionDenied' => 'Permission denied',
            'allUserInfo' => 'All user information',
            'email' => [
                'welcome' => [
                    'title' => 'Welcome, photographer!',
                    'description' => '恭喜你成为红砖摄影师，现在传图权限已经为你开启啦！\n\n\n请退出账号重新登陆,传图等功能已为您开启，如遇到任何问题请及时联系我们。期待你可以把自己满意的作品传到红砖，为附中增添一份宝藏！\n\n\n如果在传图的过程中遇到问题，或者你有大量传图的需求，欢迎联系我们（微信：lrh20021108），我们会第一时间给予支持！'
                ],
                'resetPass' => [
                    'title' => 'Find your password',
                    'description' => 'Click the link to reset you password (valid in 50 minutes): [url]'
                ]
            ]
        ],
        'downloadController' => [
            'imgNotExits' => 'Image not exists',
            'imgProcessNotComplete' => 'Image is still under process, please wait for 30 minutes',
            'expiredDownloadSession' => 'Expired download session',
            'permissionDenied' => 'Permission denied',
            'downloadActivity' => 'Download activity'
        ],
        'imageController' => [
            'permissionDenied' => 'Permission denied',
            'visitorViewTag' => "Editor's pick",
            'imgNotExits' => 'Image not exists'
        ],
        'validationCodeController' => [
            'mustEndWith' => '',
            'frequentRequestError' => 'Request too frequently, please try in a minute',
            'mustEndWithError' => 'Email must ends with [email]. If you are using an outside email, please request an account.',
            'permissionDenied' => 'Permission denied',
            'excelFormatError' => 'Excel format error',
            'uploadSuccess' => 'Upload success',
            'validationCodeEmail' => [
                'title' => 'Account Activation Code | Welcome to Illinium',
                'description' => "您的激活码是：**[code]**\n\n我们是红砖社团，很高兴向您发送这封邮件。我们将在以下介绍「红砖图库」，并向您发放注册激活码。如果您已熟知「红砖图库」，可以依照邮件末尾处的指示完成注册。\n\n\n### 一、「红砖图库」是什么？\n\n「红砖图库」(以下正文简称\"红砖\")是当前北京大学附属中学最大的图片库，面向全校同学和附中校友免费开放，并已有数十位摄影师入驻。我们的目的是以图片的形式收集北大附中的校园记忆，并在保证作者权益的情况下让这些图片得到合理的使用。\n\n\n### 二、「红砖图库」能带来什么？\n\n红砖保存上千张优质的附中照片。学校可以将这些照片用于校友活动；校内的社团和书院可以使用这些照片作为宣传用途；附中的普通同学也可以将这些图片设置成手机和电脑的壁纸。红砖使校内的学生团体宣传找图变得更加容易。\n\n\n### 三、「红砖图库」的注册流程\n\n「红砖图库」采用个人激活码注册，您的激活码是：**[code]**\n\n请访问[「红砖图库」](https://hong.zuggr.com)并于页面右上角完成注册。\n\n你可以点击右侧链接按照[我们的用户手册](https://shimo.im/docs/1Z7Xhh9IUhg51ym7/)中的指导来使用「红砖图库」。\n\n如有任何疑问，请联系微信：lrh20021108"
            ],
            'exportExcelTitle' => 'Not validated codes'
        ],
        'main' => [
            'color' => '#e04e39',
            'secondaryColor' => '#13294b',
            'title' => 'Illinium - photography media library for Illinois',
            'pls_login' => 'Please login before download. 请在右上角登录；未注册请扫描右方 二维码 获取红砖账号',
            'register_form' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/register.jpg',
            'social_media' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/follow.jpg',
            'js' => [
                'request' => [
                    'mustEndWith' => '',
                    'noEmail' => 'Please enter your email address',
                    'codeSuccess' => 'Validation code is send to your [email] email inbox. Please check!',
                    'mustEndWithError' => 'Email must ends with [email]. If you are using an outside email, please request an account.',
                    'codeSendSuccess' => 'Validation code is sent to your email, please check!',
                    'resetPass' => 'Reset password success! Please login with you new password',
                    'noEmpty' => 'Please leave no empty entries',
                    'findPass' => 'Reset link sent to associated email, please check',
                    'addTags' => 'Upload success, please refresh',
                    'permissionDenied' => 'permission denied',
                    'addDescription' => 'Upload success, please refresh',
                    'samePass' => 'reenter password and password not match',
                    'selectImg' => 'Please select image',
                    'uploadedTitle' => 'Upload Success',
                    'uploadedContent' => 'Successfully uploaded [counter] images, enter the gallery to check out',
                    'uploadBtn' => 'Selected [counter], click to upload (if number doesn\'t match, please wait, it might be compressing)',
                    'downloadAlertTitle' => 'Agreement',
                    'downloadAlertContent' => '在下载图片时，本人同意将遵守「红砖平台使用协议」：用图署名作者，不在除声明用图场景外用图',
                    'downloadAlertBtn' => 'Agree and download',
                    'downloadRequireUsage' => 'Please enter the usage of the author\'s work',
                    'admin' => [
                        'deleteSuccess' => 'Delete success, please refresh',
                        'wantToDelete' => 'Do you want to delete?',
                        'deleteBtn' => 'Delete',
                        'deleteSuccess' => 'Delete success, please refresh',
                        'changePermissionSuccess' => 'change permission success, please let user logout and login again'
                    ]
                ],
                'layui' => [
                    'uploadError' => 'Error occur during upload, please retry later',
                    'confirm' => 'Confirm'
                ]
            ],
            'dns' => [
                'jquery' => 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js',
                'axios' => 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js',
                'vue' => 'https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js',
                'materialIcon' => 'https://unpkg.com/material-design-icons@3.0.1/iconfont/material-icons.css'
            ]
        ],
        'login' => [
            'title' => 'Login',
            'usin' => 'NetID',
            'pass' => 'password',
            'btn' => 'Login'
        ],
        'register' => [
            'request_code' => 'Request',
            'email' => 'Email',
            'name' => 'Name',
            'title' => 'Register',
            'usin' => 'NetID',
            'code' => 'validation code',
            'pass' => 'password',
            'reenter_pass' => 'reenter password',
            'contract' => 'I understand and agree to the',
            'btn' => 'Register'
        ],
        'download_box' => [
            'alert' => 'Remember to credit the author! 😉',
            'usage' => 'Please describe the usage of the author\'s work',
            'btn' => 'Download'
        ],
        'header' => [
            'logo' => 'https://illinium.nyc3.digitaloceanspaces.com/assets/logo.png',
            'logoWidth' => '120',
            'bg_img' => 'https://hong.zuggr.com/image/background.gif',
            'title' => 'Blue and Orange Never Fade',
            'requestAccount' => 'Request Account',
            'requestAccountForm' => '',
            'tagline' => 'Illinois\' largest photography media library. Proudly hosting [images] images，and sharing them with [users] Illinois student and faculties',
            'admin_dropdown' => [
                'name' => 'Admin Operations',
                'upload_code' => 'Upload Activation Code',
                'change_user_permission' => 'Change Permission',
                'delete_image_batch' => 'Batch Delete Image',
                'download_non_activated_codes' => 'Download not activated codes',
                'all_user_info' => 'All User Info',
                'image_download_activities' => 'Download Activity'
            ],
            'logout' => 'Logout',
            'register' => 'Register',
            'login' => 'Login',
            'find_password' => 'Reset Password',
            'index' => 'Gallery',
            'upload' => 'Upload Photos',
            'custom_menu_items' => [
                [
                    'name' => '协议',
                    'url' => 'https://shimo.im/docs/bmH8eGUP7OEKRP1e'
                ]
            ]
        ],
        'index' => [
            'left_menu_bar' => [
                'all' => 'All',
                'tags' => 'Tags',
                'photographers' => 'Photographers',
                'admins' => 'Admins'
            ],
            'order' => [
                'update_desc' => 'Latest Active',
                'created_desc' => 'Latest Upload',
                'created_asc' => 'Oldest Upload'
            ],
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
                'author' => 'Author',
                'download' => 'Download',
                'add_tags' => 'Add Tags',
                'add_description' => 'Add Description',
                'no_description' => 'There is no description...',
                'delete' => 'Delete',
                'alert' => '侵权/不规范引用将要求删除并公开道歉。引用格式：「来自红砖，作者[author]」'
            ],
            'prev' => 'previous',
            'next' => 'next'
        ],
        'reset_password' => [
            'title' => 'Reset Password',
            'pass' => 'Password',
            'reenter_pass' => 'Reenter Password',
            'btn' => 'Reset Password'
        ],
        'upload' => [
            'instruction' => 'Drag images here, or click to select files; at most 40 images are allowed in one upload',
            'btn' => 'uploading, please do not leave the page...',
            'selected' => 'Selected [img_count] images'
        ],
        'admin_upload_validation_code' => [
            'instruction' => 'Drag Excel file here, or click to select file',
            'btn' => 'Upload'
        ],
        'find_password' => [
            'title' => 'Reset Password',
            'usin' => 'NetID',
            'btn' => 'Send reset link to associated email'
        ],
        'tags_box' => [
            'btn' => 'Add Tags'
        ],
        'description_box' => [
            'enter' => 'Enter photo description',
            'btn' => 'Add Description'
        ],
        'change_permission' => [
            'usin' => 'NetID',
            'permission' => 'Permission(1 reader, 2 photographers, 3 Admin)',
            'btn' => 'Change Permission'
        ],
        'delete_image' => [
            'start' => 'Start ID (Include the ID of the deleted image)',
            'end' => 'End ID (Include the ID of the deleted image)',
            'btn' => 'Delete'
        ],
        'delete_box' => [
            'title' => 'Delete with caution',
            'reason' => 'Please provide a reason',
            'btn' => 'Delete'
        ]
    ]
];
