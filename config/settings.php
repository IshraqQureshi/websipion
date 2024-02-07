<?php

return [
    'THEME_ASSETS' => [
        'global'  => [
            'css' => [
                // 'assets/plugins/global/plugins.bundle.css',
            ],
            'js'  => [
                // 'assets/plugins/global/plugins.bundle.js',
            ],
        ],
    ],


    # Theme Vendors
    'THEME_VENDORS' => [
        'global-dashboard-assets' => [
            'css' => [
                'assets/compiled/css/app.css',
                'assets/compiled/css/app-dark.css',
                'assets/extensions/sweetalert2/sweetalert2.min.css',
                'assets/css/custom.css',
            ],

            'js' => [
                'assets/static/js/initTheme.js',
                'assets/static/js/components/dark.js',
                'assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js',
                'assets/compiled/js/app.js',
                'assets/js/custom.js',
            ]
        ],

        'dataTables' => [
            'css' => [
                'assets/css/dataTables.bootstrap5.min.css',
            ],

            'js' => [
                'assets/js/datatables.min.js',
            ]
        ],

        'select2' => [
            'css' => [
                'assets/css/select2.min.css',
            ],

            'js' => [
                'assets/js/select2.min.js',
            ]
        ],

        'clients' => [
            'js' => [
                'assets/js/clients.js',
            ]
        ],

        'website' => [
            'js' => [
                'assets/js/website.js',
            ]
        ],

        'package' => [
            'js' => [
                'assets/js/package.js',
            ]
        ],

        'package-details' => [
            'js' => [
                'assets/js/package-details.js',
                'https://checkout.razorpay.com/v1/checkout.js',
                'assets/js/checkout.js',
            ]
        ],

        'payment-history' => [
            'js' => [
                'assets/js/payment-history.js',
            ]
        ],

        'profile-edit' => [
            'js' => [
                'assets/js/profile-edit.js',
            ]
        ],

        'website-crawl-details' => [
            'js' => [
                'assets/js/website-crawl-details.js',
            ]
        ],

        'website-crawl-log' => [
            'js' => [
                'assets/js/website-crawl-log.js',
            ]
        ],


        'loginRegister' => [
            'css' => [
                'assets/compiled/css/auth.css',
            ],

            'js' => [
                'assets/js/login-register.js',
            ]
        ],
        'gateway-settings' => [
            'js' => [
                'assets/js/gateway-settings.js',
            ]
        ],
        'mail-settings' => [
            'js' => [
                'assets/js/mail-settings.js',
            ]
        ],
        'logo-settings' => [
            'js' => [
                'assets/js/logo-settings.js',
            ]
        ],
        'help-content' => [
            'css' => [
                'assets/extensions/summernote/summernote-lite.css',
                'assets/compiled/css/form-editor-summernote.css',
            ],
            'js' => [
                'assets/extensions/summernote/summernote-lite.min.js',
                'assets/static/js/pages/summernote.js',
                'assets/js/help-content.js',
            ]
        ],

        'email-template' => [
            'js' => [
                'assets/js/email-template.js',
            ]
        ],

        'auto-responders' => [
            'js' => [
                'assets/js/auto-responders.js',
            ]
        ],

        'sms-settings' => [
            'js' => [
                'assets/js/sms-settings.js'
            ]
        ],
        'social-settings' => [
            'js' => [
                'assets/js/social-settings.js'
            ]
        ],
        'language-settings' => [
            'js' => [
                'assets/js/language-settings.js'
            ]
        ],
        'auth-page-settings' => [
            'js' => [
                'assets/js/auth-page-settings.js'
            ]
        ],
        'tag' => [
            'js' => [
                'assets/js/tags.js'
            ]
            ],
        'site-up-down' => [
            'js' => [
                'assets/js/site-up-down.js'
            ]
        ]

    ],

];
