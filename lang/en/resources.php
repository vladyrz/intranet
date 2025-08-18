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

    'employee_checklist' => [
        'label' => 'Employee Checklist',
        'plural' => 'Employee Checklists',
        'navigation' => 'Employee Checklists',
        'navigation_group' => 'Accounting',
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

    'customer_report' => [
        'label' => 'Customer Report',
        'plural' => 'Customer Reports',
        'navigation' => 'Customer Reports',
        'section_customer' => 'Customer Info',
        'section_financial' => 'Financial Info',
        'tab_total_reports' => 'Total reports',
        'tab_pending' => 'Pending',
        'tab_received' => 'Received',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
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
        'label' => 'Bank/FI',
        'plural' => 'Banks/FIs',
        'navigation' => 'Banks/FIs',
        'navigation_group' => 'Banks/FIs Management',
        'sectionOrganization' => 'Bank/FI Info',
        'sectionOther' => 'Other Relevant Info',
        'tab_total_organizations' => 'Total Banks/FI',
        'tab_banks' => 'Banks',
        'tab_cooperatives' => 'Cooperatives',
        'tab_financial_institutions' => 'Financial institutions',
        'tab_associations' => 'Associations',
        'tab_funds' => 'Funds',
        'tab_development_and_others' => 'Development and others',
        'tab_rent_a_car' => 'Rent a car',
    ],

    'organization_contact' => [
        'label' => 'Bank/FI Contact',
        'plural' => 'Banks/FIs Contacts',
        'navigation' => 'Banks/FIs Contacts',
        'sectionContact' => 'Contact Info',
        'tab_total_contacts' => 'Total Contacts',
        'tab_adjudicated_assets' => 'Adjudicated assets',
        'tab_cotizations' => 'Cotizations',
        'tab_billing' => 'Billing',
    ],

    'offer' => [
        'label' => 'Offer',
        'plural' => 'Offers',
        'navigation' => 'Offers submissions',
        'section_offer' => 'Offer Info',
        'tab_total_offers' => 'Total Offers',
        'tab_pending' => 'Pending',
        'tab_received' => 'Received',
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

    'billing_control' => [
        'label' => 'Billing Control',
        'plural' => 'Billing Controls',
        'navigation' => 'Billing Controls',
        'sectionBillingControl' => 'Billing Control Info',
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
        'tab_received' => 'Received',
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
        'tab_received' => 'Received',
        'tab_sent' => 'Sent',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
    ],

    'project' => [
        'label' => 'Project',
        'plural' => 'Projects',
        'navigation' => 'Projects',
        'sectionProject' => 'Project Info',
        'tab_all' => 'All',
        'tab_pending' => 'Pending',
        'tab_in_progress' => 'In progress',
        'tab_finished' => 'Finished',
        'tab_stopped' => 'Stopped',
    ],

    'segment' => [
        'label' => 'Segment',
        'plural' => 'Segments',
        'navigation' => 'Segments',
        'section_agent' => 'Agent Information',
        'section_performance' => 'Performance Information (numeric values)',
        'section_skills' => 'Skills',
        'tab_all' => 'All',
        'tab_new' => 'New',
        'tab_intermediate' => 'Intermediate',
        'tab_advanced' => 'Advanced',
        'tab_specialized' => 'Specialized',
    ],

    'campaign' => [
        'label' => 'Campaign',
        'plural' => 'Campaigns',
        'navigation' => 'Campaigns',
        'navigation_group' => 'Marketing Management',
        'section_campaign' => 'Campaign Info',
        'tab_total_campaigns' => 'Total campaigns',
        'tab_pending' => 'Pending',
        'tab_active' => 'Active',
        'tab_inactive' => 'Inactive',
        'tab_finished' => 'Finished',
    ],

    'campaign_social' => [
        'label' => 'Campaign Social',
        'plural' => 'Campaign Socials',
        'navigation' => 'Campaign Socials',
        'navigation_group' => 'Marketing Management',
        'section_campaign_social' => 'Campaign Social Info',
        'tab_total_campaign_socials' => 'Total campaign socials',
        'tab_facebook' => 'Facebook',
        'tab_instagram' => 'Instagram',
        'tab_linkedin' => 'LinkedIn',
        'tab_youtube' => 'YouTube',
        'tab_tiktok' => 'TikTok',
    ],

    'leave_request' => [
        'label' => 'Leave Request',
        'plural' => 'Leave Requests',
        'navigation' => 'Leave Requests',
        'section_request' => 'Request Info',
        'tab_total_leave_requests' => 'Total leave requests',
        'tab_pending' => 'Pending',
        'tab_approved' => 'Approved',
        'tab_denied' => 'Denied',
        'tab_vacations' => 'Vacations',
        'tab_permissions' => 'Permissions',
        'section_permissions' => 'Permissions',
        'section_vacations' => 'Vacations',
    ],

    'credit_study' => [
        'label' => 'Credit Study Request',
        'plural' => 'Credit Study Requests',
        'navigation' => 'Credit Study Requests',
        'customer_section' => 'Customer Info',
        'request_section' => 'Request Info',
        'sales_section' => 'Sales Department Review',
        'tab_total_requests' => 'Total requests',
        'tab_pending' => 'Pending',
        'tab_approved' => 'Approved',
        'tab_rejected' => 'Rejected',
    ],
];
