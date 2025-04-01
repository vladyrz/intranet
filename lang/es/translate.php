<?php

return [
    'user' => [
        'avatar_url' => 'Avatar',
        'name' => 'Nombre',
        'email' => 'Correo electrónico',
        'password' => 'Contraseña',
        'state' => 'Estado',
        'email_verified_at' => 'Correo verificado el',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'employee' => [
        'name' => 'Nombre',
        'email' => 'Correo electrónico',
        'contract_status' => 'Estado del contrato',
        'progress_status' => 'Estado de progreso',
        'options_progress_status' => [
            'Pendiente',
            'En formación',
            'Certificado',
            'Retirado',
            'Referidor'
        ],
        'job_position' => 'Posición de trabajo',
        'options_job_position' => [
            'Administrativo',
            'Gerente de ventas',
            'Asesor de ventas',
        ],
        'national_id' => 'Número de cédula',
        'phone_number' => 'Número de teléfono',
        'personal_email' => 'Correo personal',
        'profession' => 'Profesión',
        'license_plate' => 'Placa',
        'country' => 'País',
        'locationState' => 'Provincia',
        'locationCity' => 'Cantón',
        'address' => 'Dirección',
        'birthday' => 'Cumpleaños',
        'marital_status' => 'Estado civil',
        'options_marital_status' => [
            'Soltero/a',
            'Casado/a',
            'Divorciado/a',
            'Viudo/a',
            'Unión libre',
        ],
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'customer' => [
        'options_cpreferences' => [
            'Correo electrónico',
            'WhatsApp',
            'Teléfono',
            'Otro'
        ],
        'options_cust_type' => [
            'Comprador',
            'Vendedor',
            'Inversionista',
            'Inquilino',
            'Otro'
        ],
        'user_id' => 'Asesor',
        'full_name' => 'Nombre completo del cliente',
        'national_id' => 'Número de cédula',
        'customer_name' => 'Nombre del cliente',
        'email' => 'Correo electrónico',
        'phone_number' => 'Número de teléfono',
        'property_name' => 'Nombre de la propiedad (o ID)',
        'contact_source' => 'Fuente de contacto',
        'options_contact_source' => [
            'HubSpot',
            'Referido',
            'EasyChat',
            'WhatsApp',
            'Correo electrónico',
            'Otro'
        ],
        'organization_id' => 'Banco/Financiera',
        'contact_preferences' => 'Preferencias de contacto',
        'initial_contact_date' => 'Fecha de contacto inicial',
        'customer_type' => 'Tipo de cliente',
        'credid_information' => 'Información de credid',
        'budget_usd' => 'Presupuesto en $',
        'budget_crc' => 'Presupuesto en ₡',
        'financing' => '¿Requiere financiamiento?',
        'expected_commission_usd' => 'Comisión esperada en $',
        'expected_commission_crc' => 'Comisión esperada en ₡',
        'state' => 'Estado',
        'options_state' => [
            'Pendiente',
            'Rechazado',
            'Aprobado',
            'En proceso',
        ],
        'address' => 'Dirección',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'personal_customer' => [
        'options_prospect_status' => [
            'Caliente',
            'Tibio',
            'Frío'
        ],
        'options_next_action' => [
            'Llamar',
            'Enviar información',
            'Agendar cita',
        ],
        'prospect_status' => 'Estado del Prospecto',
        'customer_need' => 'Necesidades del cliente',
        'date_of_birth' => 'Fecha de nacimiento',
        'next_action' => 'Siguiente acción',
        'next_action_date' => 'Fecha de la siguiente acción',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'organization' => [
        'organization_type' => 'Tipo de Banco/Financiera',
        'options_organization_type' => [
            'Bancos',
            'Cooperativas',
            'Financieras',
            'Asociaciones',
            'Fondos',
            'Desarrolladoras y otros',
            'Alquiler de coches'
        ],
        'organization_name' => 'Nombre del Banco/Financiera',
        'remarks' => 'Observaciones',
        'asset_update_dates' => 'Fechas de actualización de bienes',
        'sugef_report' => 'Boleta sugef',
        'offer_form' => 'Formulario de ofertas',
        'catalog_or_website' => 'Catálogo o sitio web',
        'vehicles_page' => 'Página de vehículos',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'organization_contact' => [
        'organization_id' => 'Nombre del Banco/Financiera',
        'contact_type' => 'Tipo de contacto',
        'option_contact_type' => [
            'Bienes Adjudicados',
            'Cotizaciones',
            'Facturación',
        ],
        'contact_name' => 'Nombre del contacto',
        'contact_position' => 'Posición del contacto',
        'contact_phone_number' => 'Número de teléfono del contacto',
        'contact_email' => 'Correo electrónico del contacto',
        'contact_main_method' => 'Método principal de contacto',
        'option_contact_main_method' => [
            'Correo electrónico',
            'WhatsApp',
            'Ambos',
        ],
        'contact_remarks' => 'Observaciones del contacto',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'sale' => [
        'property_name' => 'Nombre de la propiedad',
        'user_id' => 'Asesor',
        'organization_id' => 'Banco/Financiera',
        'offer_amount_usd' => 'Monto de oferta en $',
        'offer_amount_crc' => 'Monto de oferta en ₡',
        'status' => 'Estado',
        'options_status' => [
            'Ofertado',
            'En proceso',
            'Aprobado',
            'Firmado',
            'Rechazado',
        ],
        'client_name' => 'Nombre del cliente',
        'client_email' => 'Correo electrónico del cliente',
        'offer_date' => 'Fecha de oferta',
        'comission_percentage' => 'Porcentaje de comisión',
        'offer_currency' => 'Moneda de oferta',
        'options_currency' => [
            'Doláres',
            'Colones',
        ],
        'commission_amount_usd' => 'Comisión en $',
        'commission_amount_crc' => 'Comisión en ₡',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'offer' => [
        'property_name' => 'Nombre de la propiedad',
        'property_value_usd' => 'Valor de la propiedad en $',
        'property_value_crc' => 'Valor de la propiedad en ₡',
        'organization_id' => 'Banco/Financiera',
        'user_id' => 'Asesor',
        'offer_amount_usd' => 'Monto de oferta en $',
        'offer_amount_crc' => 'Monto de oferta en ₡',
        'personal_customer_id' => 'Nombre del Cliente',
        'personal_customer_national_id' => 'Número de cédula',
        'personal_customer_phone_number' => 'Teléfono del cliente',
        'personal_customer_email' => 'Correo del cliente',
        'offer_files' => 'Archivos de oferta',
        'offer_status' => 'Estado de la oferta',
        'created_at' => 'Enviado el',
        'updated_at' => 'Actualizado el',
        'options_offer_status' => [
            'Pendiente',
            'Enviada',
            'Aprobada',
            'Rechazada',
            'Firmada'
        ],
    ],

    'departament' => [
        'name' => 'Nombre',
        'description' => 'Descripción',
    ],

    'document' => [
        'name' => 'Nombre',
        'description' => 'Descripción',
        'image' => 'Imagen',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'operation' => [
        'user_id' => 'Asesor',
        'document_id' => 'Tipo de Documento',
        'departament_id' => 'Departamento',
        'scope' => 'Alcance',
        'benefits' => 'Beneficios',
        'references' => 'Referencias',
        'policies' => 'Políticas',
        'steps' => 'Pasos',
        'attachments' => 'Adjuntar archivo',
        'created_at' => 'Creado el',
        'updated_at' => 'Actualizado el',
    ],

    'property_assignment' => [
        'user_id' => 'Asesor',
        'property_info' => 'Información de la propiedad (ID)',
        'organization_id' => 'Banco/Financiera',
        'property_observations' => 'Observaciones de la propiedad',
        'property_images' => 'Imágenes de la propiedad',
        'property_assignment_status' => 'Estado de la asignación de propiedad',
        'created_at' => 'Enviado el',
        'updated_at' => 'Actualizado el',
        'options_property_assignment_status' => [
            'Pendiente',
            'Tramitado',
            'Aprobado',
            'Rechazado',
            'Publicado',
            'Asignado',
            'Finalizado',
        ],
    ],
];
