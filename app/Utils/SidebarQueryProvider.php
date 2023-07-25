<?php

namespace App\Utils;

use App\Models\Post;

class SidebarQueryProvider
{
    public static function forMysql() {
        return Post::selectRaw("
            count(*) as post_count,
            YEAR(MIN(publish_at)) as post_year,
            LPAD(MONTH(MIN(publish_at)), 2, '0') as post_month,
            MONTHNAME(MIN(publish_at)) as post_month_name
        ")
            ->published()
            ->accepted()
            ->groupByRaw("YEAR(publish_at), MONTH(publish_at)")
            ->orderByRaw("YEAR(publish_at) DESC, MONTH(publish_at) DESC")
            ->get();
    }

    public static function forSqlite() {
        return Post::selectRaw("
            COUNT(*) AS post_count,
    STRFTIME('%Y', MIN(publish_at)) AS post_year,
    CASE
        WHEN LENGTH(STRFTIME('%m', MIN(publish_at))) = 1
        THEN '0' || STRFTIME('%m', MIN(publish_at))
        ELSE STRFTIME('%m', MIN(publish_at))
    END AS post_month,
    CASE STRFTIME('%m', MIN(publish_at))
        WHEN '01' THEN 'January'
        WHEN '02' THEN 'February'
        WHEN '03' THEN 'March'
        WHEN '04' THEN 'April'
        WHEN '05' THEN 'May'
        WHEN '06' THEN 'June'
        WHEN '07' THEN 'July'
        WHEN '08' THEN 'August'
        WHEN '09' THEN 'September'
        WHEN '10' THEN 'October'
        WHEN '11' THEN 'November'
        WHEN '12' THEN 'December'
    END AS post_month_name
        ")
            ->published()
            ->accepted()
            ->groupByRaw("STRFTIME('%Y', publish_at), STRFTIME('%m', publish_at)")
            ->orderByRaw(  "STRFTIME('%Y', publish_at) DESC, STRFTIME('%m', publish_at) DESC")
            ->get();
    }
}
