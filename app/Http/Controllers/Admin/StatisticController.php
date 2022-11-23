<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    //
    function orderStateStatistics()
    {
        $quantity_order_new = DB::select(
            "SELECT
                COUNT(*) as quantity
            FROM orderstate
            WHERE orderstate_name = 0 AND DATE(orderstate_date) = CURDATE()"
        );

        $quantity_the_others = DB::select(
            "SELECT
                od.orderstate_name,
                COUNT(od.order_id) AS quantity
            FROM (
                SELECT o.order_id, MAX(o.orderstate_name) AS orderstate_name
                FROM orderstate AS o
                GROUP BY o.order_id ) AS od
            GROUP BY od.orderstate_name
            ORDER BY od.orderstate_name"
        );

        return ["quantity_order_new" => $quantity_order_new, "quantity_the_others" => $quantity_the_others];
    }

    function revenueStatistics($year, $month)
    {
        DB::statement(
            "CREATE TEMPORARY TABLE IF NOT EXISTS AAA
            AS
            (
                SELECT date_field
                FROM
                (
                    SELECT
                        MAKEDATE($year, 1) +
                        INTERVAL $month - 1 MONTH +
                        INTERVAL daynum DAY date_field
                    FROM
                    (
                        SELECT t*10+u daynum
                        FROM
                            (SELECT 0 t UNION SELECT 1 UNION SELECT 2 UNION SELECT 3) A,
                            (SELECT 0 u UNION SELECT 1 UNION SELECT 2 UNION SELECT 3
                            UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
                            UNION SELECT 8 UNION SELECT 9) B
                        ORDER BY daynum
                    ) AA
                ) AAA
                WHERE MONTH(date_field) = $month
            )"
        );

        $days = DB::select("SELECT * FROM AAA ORDER BY date_field");

        $order_state_count = DB::select(
            "SELECT
                AAA.date_field,
                IFNULL(BBB.delivered, 0) AS delivered,
                IFNULL(BBB.canceled, 0) AS canceled,
                IFNULL(BBB.refund, 0) AS refund
            FROM AAA LEFT JOIN
            (
                SELECT
                    COUNT(CASE WHEN os.orderstate_name = 2 then 1 ELSE NULL END) AS delivered,
                    COUNT(CASE WHEN os.orderstate_name = 3 then 1 ELSE NULL END) AS canceled,
                    COUNT(CASE WHEN os.orderstate_name = 4 then 1 ELSE NULL END) AS refund,
                    DATE(os.orderstate_date) AS _date
                FROM orderstate os
                WHERE YEAR(os.orderstate_date) = $year AND MONTH(os.orderstate_date) = $month
                GROUP BY _date
                ORDER BY _date
            ) AS BBB ON AAA.date_field = BBB._date
            ORDER BY AAA.date_field"
        );

        $total_by_day = DB::select(
            "SELECT
                AAA.date_field,
                IFNULL(BBB.total, 0) AS total
            FROM AAA LEFT JOIN
                (
                    SELECT
                        SUM(o.total) AS total,
                        DATE(os.orderstate_date) AS _date
                    FROM orders o
                        INNER JOIN (SELECT
                                        os.order_id,
                                        MAX(os.orderstate_name) AS orderstate_name
                                    FROM orderstate AS os
                                    GROUP BY os.order_id
                                    HAVING orderstate_name = 2) AS osn ON o.order_id = osn.order_id
                        INNER JOIN orderstate AS os ON os.order_id = osn.order_id
                    WHERE YEAR(os.orderstate_date) = $year AND MONTH(os.orderstate_date) = $month AND os.orderstate_name = osn.orderstate_name
                    GROUP BY _date
                    ORDER BY _date
                ) AS BBB ON AAA.date_field = BBB._date
            ORDER BY AAA.date_field"
        );

        DB::statement(
            "DROP TEMPORARY TABLE AAA"
        );

        return [
            "days" => $days,
            "total_by_day" => $total_by_day,
            "order_state_count" => $order_state_count,
        ];
    }
}
