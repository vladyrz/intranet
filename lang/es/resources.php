<?php

return [
    'user' => [
        'label' => 'Usuario',
        'plural' => 'Usuarios',
        'navigation' => 'Usuarios',
        'navigation_group' => 'Gestión de Usuarios',
        'userSection' => 'Información de Usuario'
    ],

    'app' => [
        'navigation_group' => 'Ajustes',
    ],

    'employee' => [
        'label' => 'Empleado',
        'plural' => 'Empleados',
        'navigation' => 'Empleados',
        'navigation_group' => 'Gestión de Asesores',
        'sectionEmployee' => 'Información del Empleado',
        'sectionPersonal' => 'Información Personal',
        'sectionAddress' => 'Dirección',
        'tab_total_employees' => 'Total de empleados',
        'tab_pending' => 'Pendientes',
        'tab_in_form' => 'En formación',
        'tab_certified' => 'Certificados',
        'tab_retired' => 'Retirados',
        'tab_referred' => 'Referidos',
    ],

    'customer' => [
        'label' => 'Reporte de Cliente',
        'plural' => 'Reporte de Clientes',
        'navigation' => 'Reporte de Clientes',
        'navigation_group' => 'Mis gestiones',
        'sectionCustomer' => 'Información del Cliente',
        'section_source_customer' => 'Fuente y Preferencias de Contacto',
        'section_financial' => 'Información Financiera',
        'tab_total_customers' => 'Total de clientes',
        'tab_buyer' => 'Compradores',
        'tab_seller' => 'Vendedores',
        'tab_investor' => 'Inversionistas',
        'tab_tenant' => 'Inquilinos',
        'tab_other' => 'Otros',
    ],

    'customer_report' => [
        'label' => 'Reporte de Cliente',
        'plural' => 'Reportes de Clientes',
        'navigation' => 'Reportes de Clientes',
        'section_customer' => 'Información del Cliente',
        'section_financial' => 'Información Financiera',
        'tab_total_reports' => 'Total de reportes',
        'tab_pending' => 'Pendientes',
        'tab_approved' => 'Aprobados',
        'tab_rejected' => 'Rechazados',
    ],

    'personal_customer' => [
        'label' => 'Cliente Personal',
        'plural' => 'Clientes Personales',
        'navigation' => 'Clientes Personales',
        'navigation_group' => 'Mis gestiones',
        'section_customer' => 'Información del Cliente',
        'section_follow_up' => 'Seguimiento del Cliente',
        'section_financial' => 'Información Financiera',
    ],

    'organization' => [
        'label' => 'Banco/Financiera',
        'plural' => 'Bancos/Financieras',
        'navigation' => 'Bancos/Financieras',
        'navigation_group' => 'Gestión de Bancos/Financieras',
        'sectionOrganization' => 'Información del Banco/Financiera',
        'sectionOther' => 'Otra Información Relevante',
        'tab_total_organizations' => 'Total de Bancos/Financieras',
        'tab_banks' => 'Bancos',
        'tab_cooperatives' => 'Cooperativas',
        'tab_financial_institutions' => 'Financieras',
        'tab_associations' => 'Asociaciones',
        'tab_funds' => 'Fondos',
        'tab_development_and_others' => 'Desarrolladoras y otros',
        'tab_rent_a_car' => 'Alquiler de coches',
    ],

    'organization_contact' => [
        'label' => 'Contacto de Banco/Financiera',
        'plural' => 'Contactos de Bancos/Financieras',
        'navigation' => 'Contactos de Bancos/Financieras',
        'sectionContact' => 'Información de Contacto',
        'tab_total_contacts' => 'Total de contactos',
        'tab_adjudicated_assets' => 'Bienes Ajustados',
        'tab_cotizations' => 'Cotizaciones',
        'tab_billing' => 'Facturación',
    ],

    'offer' => [
        'label' => 'Oferta',
        'plural' => 'Ofertas',
        'navigation' => 'Envíos de Ofertas',
        'section_offer' => 'Información de la Oferta',
        'tab_total_offers' => 'Total de ofertas',
        'tab_pending' => 'Pendientes',
        'tab_sent' => 'Enviadas',
        'tab_approved' => 'Aprobadas',
        'tab_rejected' => 'Rechazadas',
        'tab_signed' => 'Firmadas',
        'tab_offer_status' => [
            'Pendientes',
            'Enviadas',
            'Aprobadas',
            'Rechazadas',
            'Firmadas',
        ],
    ],

    'timesheet' => [
        'label' => 'Registro de hora',
        'plural' => 'Registros de horas',
        'navigation' => 'Registros de horas'
    ],

    'holiday' => [
        'label' => 'Vacación',
        'plural' => 'Vacaciones',
        'navigation' => 'Vacaciones'
    ],

    'departament' => [
        'label' => 'Departamento',
        'plural' => 'Departamentos',
        'navigation' => 'Departamentos',
        'sectionDepartment' => 'Información del Departamento',
    ],

    'document' => [
        'label' => 'Documento',
        'plural' => 'Documentos',
        'navigation' => 'Documentos',
        'navigation_group' => 'Gestión de Documentos',
        'sectionDocument' => 'Información del Documento',
    ],

    'operation' => [
        'label' => 'Operación',
        'plural' => 'Operaciones',
        'navigation' => 'Operaciones',
        'navigation_group' => 'Gestión de Operaciones',
        'sectionOperation' => 'Información General'
    ],

    'property_assignment' => [
        'label' => 'Asignación de Propiedad',
        'plural' => 'Asignaciones de Propiedad',
        'navigation' => 'Asignaciones de Propiedad',
        'sectionMainInfo' => 'Información Principal',
        'sectionImages' => 'Imágenes',
        'tab_total_property_assignments' => 'Total de asignaciones',
        'tab_pending' => 'Pendientes',
        'tab_submitted' => 'Tramitadas',
        'tab_approved' => 'Aprobadas',
        'tab_rejected' => 'Rechazadas',
        'tab_published' => 'Publicadas',
        'tab_assigned' => 'Asignadas',
        'tab_finished' => 'Finalizadas',
        'stats_overview' => [
            'Pendientes',
            'Tramitadas',
            'Aprobadas',
        ],
        'stats_overview_description' => [
            'Cantidad de asignaciones pendientes',
            'Cantidad de asignaciones tramitadas',
            'Cantidad de asignaciones aprobadas',
        ],
    ],

    'acces_request' => [
        'label' => 'Solicitud de Permiso',
        'plural' => 'Solicitudes de Permiso',
        'navigation' => 'Solicitudes de Permiso',
        'sectionRequest' => 'Información de la Solicitud',
        'section_description' => 'Nota: Los permisos y llaves se deben solicitar con 24 horas de anticipación, llaves de Davivienda se entregan unicamente martes y viernes. Si la visita es con cliente, se debe indicar en la solicitud',
        'tab_total_acces_requests' => 'Total de solicitudes',
        'tab_pending' => 'Pendientes',
        'tab_sent' => 'Enviadas',
        'tab_approved' => 'Aprobadas',
        'tab_rejected' => 'Rechazadas',
    ],
];
