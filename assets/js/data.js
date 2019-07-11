var date = new Date(); 
date.setFullYear(14, 0, 1); // 1 January, 14
var y = date.getFullYear(), m = date.getMonth();
var firstDay = new Date(y, m, 1);
var lastDay = new Date(y, m + 1, 0);
export default {
    settings: {
        employees: [
            {
                name: 'Employee 1',
                email: 'emp1@website.com',
                user_id: 87965,
                billable_target:  0.1
            },
            {
                name: 'Employee 2',
                email: 'emp2@website.com',
                user_id: 87966,
                billable_target:  0.1
            },
            {
                name: 'Employee 3',
                email: 'emp3@website.com',
                user_id: 87967,
                billable_target:  0.1
            }
        ],
        company_targets: {
            expense_hours: 950,
            average_expense: 180000,
            expected_capacity_hours: 1087.2,
            full_capacity_hours: 1208,
            month_start_date: firstDay,
            month_end_date: lastDay,
            retained_hours: {
                total_hours: 828,
                woo_retained_hours: {
                    hours: 458,
                    title: 'Woo Target',
                    avatar: 'assets/images/woocommerce-logo.png'
                },
                magento_retained_hours: {
                    hours: 280,
                    title: 'Magento Target',
                    avatar: 'assets/images/magento-logo.png'
                },
                web_app_retained_hours: {
                    hours: 90,
                    title: 'Laravel Target',
                    avatar: 'assets/images/laravel-logo.jpg'
                },
                total_retained_hours: 828
            }
        }
    }
};