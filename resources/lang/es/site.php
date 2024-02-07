<?php

return [
    'clients' => [
        'title' => 'Lista de Clientes',
        'search' => 'Buscar Cliente',
        'add-client' => 'Agregar Cliente',
        'add-client-title' => 'Crear Cliente',
        'form' => [
            'name' => 'Nombre',
            'email' => 'Correo Electrónico',
            'mobile' => 'Teléfono Móvil',
            'password' => 'Contraseña',
            'submit' => 'Enviar',
            'save-update' => 'Actualizar y Guardar',
        ],
        'list' => [
            'S-n' => 'S.N',
            'name' => 'Nombre',
            'mobile' => 'Teléfono Móvil',
            'status' => 'Estado',
            'Action' => 'Acción',
        ]
    ],

    'packages-list' => [
        'title' => 'Lista de Paquetes',
        'search' => 'Buscar Paquetes',
        'add-packages' => 'Agregar Paquete',
        'form' => [
            'title' => 'Crear Paquete',
            'product-setting' => 'Configuración del Producto',
            'name' => 'Nombre del Paquete',
            'frequency' => 'Frecuencia de Rastreo',
            'price-settings' => 'Configuración de Precio',
            'fixed' => 'Fijo',
            'subscription' => 'Suscripción',
            'price' => 'Precio (en USD)',
            'Type' => 'Tipo',
            'submit' => 'Enviar',
        ],
        'list' => [
            'S-n' => 'S.N',
            'name' => 'Nombre del Paquete',
            'frequency' => 'Frecuencia de Rastreo',
            'type' => 'Tipo',
            'payment-type' => 'Tipo de Pago',
            'price' => 'Precio (USD)',
            'status' => 'Estado',
            'action' => 'Acción',
        ]
    ],

    'packages' => [
        'title' => 'Paquete',
        'title-pay' => 'Pago por Uso',
        'website' => 'Sitio web',
        'total-cost' => 'Costo Total',
        'paynow' => 'Pagar Ahora',
        'pop' => [
            'title' => 'Método de Pago',
            'cong' => '¡Felicitaciones!',
            'sub-title' => 'Casi hemos terminado...',
            'checkout' => 'Realizar Pago con',
            'or' => 'O ',
        ]
    ],

    'website' => [
        'title' => 'Lista de Sitios Web',
        'add-website' => 'Agregar Sitio Web',
        'search-website' => 'Buscar Sitio Web',
        'buy-more' => 'Comprar Más',
        'list' => [
            's-n' => 'S.N',
            'domain' => 'Nombre de Dominio',
            'frequency' => 'Frecuencia de Rastreo',
            'status' => 'Estado',
            'action' => 'Acción',
        ],
        'pop' =>  [
            'title' => 'Crear',
            'client' => 'Cliente',
            'domain' => 'Dominio',
            'frequency' => 'Frecuencia de Rastreo',
            'sms' => 'Notificación SMS',
            'notify' => 'Notificar correos electrónicos',
            'submit' => 'Enviar',
            'edit' => 'Editar',
            'update-save' => 'Actualizar y Guardar',
        ]
    ],

    'crawl-log' => [
        'title' => 'Registro de Rastreo',
        'search' => 'Buscar Sitio Web',
        'crawl-live' => 'Rastreo en Vivo',
        'all-delete' => 'Eliminar Todo',
        'back' => 'Volver',
        'list' => [
            's-n' => 'S.N',
            'domain' => 'Dominio',
            'frequency' => 'Frecuencia',
            'crawltime' => 'Tiempo de Rastreo',
            'Status' => 'Estado',
        ]
    ],

    'transaction' => [
        'title' => 'Historial de Transacciones',
        'search' => 'Buscar Transacción',
        'list' => [
            's-n' => 'S.N',
            'name' => 'Nombre',
            'invoice-no' => 'Número de Factura',
            'packages' => 'Paquetes',
            'transaction-id' => 'ID de Transacción',
            'payment' => 'Pago (USD)',
            'paymentmode' => 'Modo de Pago',
            'date' => 'Fecha',
            'action' => 'Acción',
        ],
    ],

    'logo-settings' => [
        'title' => 'Configuración de Logotipo',
        'favicon' => 'Favicon',
        'logo' => 'Logotipo',
        'logo-dark' => 'Logotipo Oscuro',
        'save-update' => 'Guardar y Actualizar',
    ],

    'help-content' => [
        'title' => 'Ayuda',
        'save-update' => 'Guardar y Actualizar',
    ],

    'email-template' => [
        'title' => 'Plantilla de Correo Electrónico',
        'statustitle' => 'Título del Estado',
        'emailtitle' => 'Título',
        'body' => 'Contenido',
        'footer-text' => 'Texto del Pie de Página',
        'save-update' => 'Guardar y Actualizar',
    ],

    'auto-responder' => [
        'title' => 'Autorespondedores',
        'default' => 'Autoresponder Predeterminado',
        'change' => 'Cambiar Configuración',
        'save' => 'Guardar Configuración',
        'close' => 'Cerrar',
        'save-update' => 'Guardar',
    ],

    'payment' => [
        'title' => 'Configuración de Pasarela de Pago',
        'save-update' => 'Guardar y Actualizar',
    ],

    'smtp-settings' => [
        'title' => 'Configuración de SMTP',
        'select' => 'Seleccionar Configuración',
        'email' => 'Ingrese Dirección de Correo Electrónico',
        'test' => 'Probar',
        'save-update' => 'Guardar y Actualizar',
    ],

    'sms-setting'=> [
        'title' => 'Configuración de API de SMS',
        'save-update' => 'Guardar y Actualizar',
    ],

    'social-auth-setting'=> [
        'title' => 'Configuración de Autenticación Social',
        'save-update' => 'Guardar y Actualizar',
    ],

    'language-settings'=> [
        'title' => 'Configuración de Idioma',
        'Default' => 'Establecer Idioma Predeterminado',
        'save-update' => 'Guardar y Actualizar',
    ],

    'profile' => [
        'title' => 'Perfil',
        'details' => 'Detalles',
        'name' => 'Nombre',
        'email' => 'Correo Electrónico',
        'Address' => 'Dirección',
        'zip' => 'Código Postal',
        'city' => 'Ciudad',
        'state' => 'Estado',
        'country' => 'País',
        'gst-number' => 'Número de GST',
        'back' => 'Volver',
        'edit' => 'Editar Perfil',
        'website' => 'Sitio Web',
        'domain' => 'Nombre de Dominio',
        'frequency' => 'Frecuencia',
        'status' => 'Estado',
        'transactions' => 'Transacciones',
        'package' => 'Paquete',
        'transaction_id' => 'ID de Transacción',
        'transaction_id' => 'ID de Transacción',
        'payment' => 'Pago (USD)',
        'mode' => 'Modo',
        'date' => 'Fecha',
    ],

    'profile-edit'=> [
        'title' => 'Editar Perfil',
        'Name' => 'Nombre',
        'Email' => 'Correo Electrónico',
        'Mobile' => 'Teléfono Móvil',
        'Address' => 'Dirección (Opcional)',
        'Address' => 'Dirección (Opcional)',
        'Country' => 'País',
        'State' => 'Estado',
        'City' => 'Ciudad',
        'Zip' => 'Código Postal',
        'GST' => 'Número de GST',
        'Password' => 'Contraseña (Opcional)',
        'update' => 'Actualizar Perfil',
    ],


    'crawl-details' => [
        's-n' => 'S.N',
        'title' => 'Detalles de Rastreo',
        'domain' => 'Dominio',
        'frequency' => 'Frecuencia',
        'Crawl' => 'Tiempo de Rastreo',
        'status' => 'Estado',
    ],
    'tags-page' => [
        'title' => 'Lista de Etiquetas',
        'search' => 'Buscar Etiquetas',
        'add-tag' => 'Agregar Etiqueta',
        'add-tag-title' => 'Crear Etiqueta',
        'form' => [
            'name' => 'Nombre de la Etiqueta',
            'submit' => 'Enviar',
            'save-update' => 'Actualizar y Guardar',
        ],
        'list' => [
            's-n' => 'S.N',
            'name' => 'nombre',
            'action' => 'acción',
        ]
    ]


];