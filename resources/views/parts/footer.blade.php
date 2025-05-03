<div class="side-app">
    <footer class="footer">
        <div class="px-4 row">
            <span class="col-6">
                <a>Last Login Time:</a>
            </span>
            <span class="float-right pe-0 col-6 font-weight-normal">
                <?php
                $data = date('D');
                $month = date('M');
                $day = date('d');
                $year = date('Y');

                $days = [
                    'Sun' => 'Sunday',
                    'Mon' => 'Monday',
                    'Tue' => 'Tuesday',
                    'Wed' => 'Wednesday',
                    'Thu' => 'Thursday',
                    'Fri' => 'Friday',
                    'Sat' => 'Saturday',
                ];

                $months = [
                    'Jan' => 'January',
                    'Feb' => 'February',
                    'Mar' => 'March',
                    'Apr' => 'April',
                    'May' => 'May',
                    'Jun' => 'June',
                    'Jul' => 'July',
                    'Aug' => 'August',
                    'Nov' => 'November',
                    'Sep' => 'September',
                    'Oct' => 'October',
                    'Dec' => 'December',
                ];

                echo $days["$data"] . ", {$day} " . $months["$month"] . " {$year}.";
                ?>
            </span>
        </div>
    </footer>
</div>