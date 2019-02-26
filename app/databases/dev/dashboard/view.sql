# View Dashboard #

-- get today
CREATE OR REPLACE VIEW v_average_amount_spend_day AS
SELECT order_date, AVG(total) average, user
FROM v_orders
WHERE status_name = 'DONE'
GROUP BY order_date, user;
-- end get today

-- get week
    -- get current week
    CREATE OR REPLACE VIEW vs_current_week_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        YEARWEEK(order_date) = YEARWEEK(CURDATE()) AND status_name = 'DONE'
    GROUP BY YEARWEEK(order_date), user;
    -- end get current week

    -- get last week
    CREATE OR REPLACE VIEW vs_last_week_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        YEARWEEK(order_date) = YEARWEEK(CURDATE() - INTERVAL 1 WEEK) AND status_name = 'DONE'
    GROUP BY YEARWEEK(order_date), user;
    -- edn get last week

    -- get average last week and current week
    CREATE OR REPLACE VIEW v_average_amount_spend_week AS
    SELECT
        u.username user,
        (CASE WHEN cw.average IS NULL THEN 0 ELSE cw.average END) AS average_current_week,
        (CASE WHEN lw.average IS NULL THEN 0 ELSE lw.average END) AS average_last_week
    FROM v_user u
    LEFT JOIN vs_current_week_average_amount_spend cw ON cw.user = u.username
    LEFT JOIN vs_last_week_average_amount_spend lw ON lw.user = u.username;
    -- end get average last week and current week
-- end get week

-- get month
    -- get current month
    CREATE OR REPLACE VIEW vs_current_month_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        (MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())) AND status_name = 'DONE'
    GROUP BY MONTH(order_date), user;
    -- end get current month

    -- get last month
    CREATE OR REPLACE VIEW vs_last_month_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        (YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) AND 
        MONTH(order_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)) AND 
        status_name = 'DONE'
    GROUP BY MONTH(order_date), user;
    -- edn get last month

    -- get average last month and current month
    CREATE OR REPLACE VIEW v_average_amount_spend_month AS
    SELECT
        u.username user,
        (CASE WHEN cm.average IS NULL THEN 0 ELSE cm.average END) AS average_current_month,
        (CASE WHEN lm.average IS NULL THEN 0 ELSE lm.average END) AS average_last_month
    FROM v_user u
    LEFT JOIN vs_current_month_average_amount_spend cm ON cm.user = u.username
    LEFT JOIN vs_last_month_average_amount_spend lm ON lm.user = u.username;
    -- end get average last month and current month
-- end get month

-- get year
    -- get current year
    CREATE OR REPLACE VIEW vs_current_year_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        YEAR(order_date) = YEAR(CURDATE()) AND status_name = 'DONE'
    GROUP BY YEAR(order_date), user;
    -- end get current year

    -- get last year
    CREATE OR REPLACE VIEW vs_last_year_average_amount_spend AS
    SELECT
        AVG(total) average, user
    FROM v_orders
    WHERE 
        YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 1 YEAR) AND status_name = 'DONE'
    GROUP BY YEAR(order_date), user;
    -- end get last year

    -- get average last year and current year
    CREATE OR REPLACE VIEW v_average_amount_spend_year AS
    SELECT
        u.username user,
        (CASE WHEN cy.average IS NULL THEN 0 ELSE cy.average END) AS average_current_year,
        (CASE WHEN ly.average IS NULL THEN 0 ELSE ly.average END) AS average_last_year
    FROM v_user u
    LEFT JOIN vs_current_year_average_amount_spend cy ON cy.user = u.username
    LEFT JOIN vs_last_year_average_amount_spend ly ON ly.user = u.username;
    -- end get average last year and current year
-- end get year

# End View Dashboard #