<?php

return [
    'user' => [
        'label' => 'User',
        'plural' => 'Users',
        'navigation' => 'Users',
        'navigation_group' => 'Users Management',
        'userSection' => 'User Info'
    ],

    'app' => [
        'navigation_group' => 'Settings',
    ],

    'employee' => [
        'label' => 'Employee',
        'plural' => 'Employees',
        'navigation' => 'Employees',
        'navigation_group' => 'Advisors Management',
        'sectionEmployee' => 'Employee Info',
        'sectionPersonal' => 'Personal Info',
        'sectionAddress' => 'Address Info',
        'tab_total_employees' => 'Total employees',
        'tab_pending' => 'Pending',
        'tab_in_form' => 'In Form',
        'tab_certified' => 'Certified',
        'tab_retired' => 'Retired',
        'tab_referred' => 'Referred',
    ],

    'customer' => [
        'label' => 'Report of Customer',
        'plural' => 'Report of Customers',
        'navigation' => 'Report of Customers',
        'navigation_group' => 'My Management',
        'sectionCustomer' => 'Customer Info',
        'section_source_customer' => 'Source and Contact Preferences',
        'section_financial' => 'Financial Info',
        'tab_total_customers' => 'Total customers',
        'tab_buyer' => 'Buyers',
        'tab_seller' => 'Sellers',
        'tab_investor' => 'Investors',
        'tab_tenant' => 'Tenants',
    ],

    'personal_customer' => [
        'label' => 'Personal Customer',
        'plural' => 'Personal Customers',
        'navigation' => 'Personal Customers',
        'navigation_group' => 'My Management',
        'section_customer' => 'Customer Info',
        'section_follow_up' => 'Follow Up',
        'section_financial' => 'Financial Info',
    ],

    'organization' => [
        'label' => 'Organization',
        'plural' => 'Organizations',
        'navigation' => 'Organizations',
        'navigation_group' => 'Organizations Management',
        'sectionOrganization' => 'Organization Info',
        'sectionOther' => 'Other Relevant Info',
        'tab_total_organizations' => 'Total organizations',
        'tab_banks' => 'Banks',
        'tab_cooperatives' => 'Cooperatives',
        'tab_financial_institutions' => 'Financial institutions',
        'tab_associations' => 'Associations',
        'tab_funds' => 'Funds',
        'tab_development_and_others' => 'Development and others',
        'tab_rent_a_car' => 'Rent a car',
    ],

    'organization_contact' => [
        'label' => 'Organization Contact',
        'plural' => 'Organization Contacts',
        'navigation' => 'Organization Contacts',
        'sectionContact' => 'Contact Info',
        'tab_total_contacts' => 'Total Contacts',
        'tab_adjudicated_assets' => 'Adjudicated assets',
        'tab_cotizations' => 'Cotizations',
        'tab_billing' => 'Billing',
    ],

    'sales' => [
        'label' => 'Sale',
        'plural' => 'Sales',
        'navigation' => 'Sales',
        'navigation_group' => 'Sales Management',
        'sectionSale' => 'Sale Info',
        'tab_total_sales' => 'Total Sales',
        'tab_offers' => 'Offers',
        'tab_in_process' => 'In Process',
        'tab_approved' => 'Approved',
        'tab_signed' => 'Signed',
        'tab_rejected' => 'Rejected',
    ],

    'offer' => [
        'label' => 'Offer',
        'plural' => 'Offers',
        'navigation' => 'Offers submissions',
        'section_offer' => 'Offer Info',
        'tab_total_offers' => 'Total Offers',
        'tab_pending' => 'Pending',
        'tab_sent' => 'Sent',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
        'tab_signed' => 'Signed',
        'tab_offer_status' => [
            'Pendings',
            'Sents',
            'Approveds',
            'Rejecteds',
            'Signeds',
        ],
    ],

    'timesheet' => [
        'label' => 'Timesheet',
        'plural' => 'Timesheets',
        'navigation' => 'Timesheets'
    ],

    'holiday' => [
        'label' => 'Holiday',
        'plural' => 'Holidays',
        'navigation' => 'Holidays'
    ],

    'departament' => [
        'label' => 'Department',
        'plural' => 'Departments',
        'navigation' => 'Departments',
        'sectionDepartment' => 'Department Info',
    ],

    'document' => [
        'label' => 'Document',
        'plural' => 'Documents',
        'navigation' => 'Documents',
        'navigation_group' => 'Documents Management',
        'sectionDocument' => 'Document Info',
    ],

    'operation' => [
        'label' => 'Operation',
        'plural' => 'Operations',
        'navigation' => 'Operations',
        'navigation_group' => 'Operations Management',
        'sectionOperation' => 'General Info'
    ],

    'property_assignment' => [
        'label' => 'Property Assignment',
        'plural' => 'Property Assignments',
        'navigation' => 'Property Assignments',
        'sectionMainInfo' => 'Main Info',
        'sectionImages' => 'Images',
        'tab_total_property_assignments' => 'Total ofassignments',
        'tab_pending' => 'Pending',
        'tab_submitted' => 'Submitted',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
        'tab_published' => 'Published',
        'tab_assigned' => 'Assigned',
        'tab_finished' => 'Finished',
        'stats_overview' => [
            'Pending',
            'Submitted',
            'Approved',
        ],
        'stats_overview_description' => [
            'Amount of property assignments pending',
            'Amount of property assignments submitted',
            'Amount of property assignments approved',
        ],
    ],

    'acces_request' => [
        'label' => 'Access Request',
        'plural' => 'Access Requests',
        'navigation' => 'Access Requests',
        'sectionRequest' => 'Request Information',
        'section_description' => 'Note: Access keys and licenses must be requested with 24 hours of advance notice, Davivienda keys are delivered only on Monday and Wednesday. If the visit is with a client, it must be indicated in the request',
        'tab_total_acces_requests' => 'Total access requests',
        'tab_pending' => 'Pending',
        'tab_sent' => 'Sent',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
    ],

    'vehicle' => [
        'label' => 'Vehicle',
        'plural' => 'Vehicles',
        'navigation' => 'Vehicles',
        'navigation_group' => 'Vehicles',
        'sectionVehicle' => 'Vehicle Information',
        'tab_total_vehicles' => 'Total vehicles',
        'tab_active' => 'Active',
        'tab_inactive' => 'Inactive',
        'tab_sold' => 'Sold',
        'tab_eliminated' => 'Eliminated',
    ],

    'movement' => [
        'label' => 'Movement',
        'plural' => 'Movements',
        'navigation' => 'Movements',
        'sectionMovement' => 'Movement Information',
    ],

    'maintenance' => [
        'label' => 'Maintenance',
        'plural' => 'Maintenances',
        'navigation' => 'Maintenances',
        'sectionMaintenance' => 'Maintenance Information',
    ],
];
