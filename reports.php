<?php
/**
 * @author jwhittaker
 * @since 21022022
 *
 * Employee dashboard: Shows reports for book reporting (e.g. most popular book lists) and customer information: weekly subscribers, overdue accounts, weekly profit
 * TO DO: Overdue accounts
 * TO DO: Connect to database
 * TO DO: Put javascript in separate file
 */

$title = "Bookify Employee Reports";
include("resources/templates/header.php");

include('./bo/api/ApiConfig.php');
$title = "Bookify Collection";
$apiKey = "AIzaSyB42BQBNzq26kjwifWZ8Sc58a9y7oE7WiE";
$apiEndpoint = "https://www.googleapis.com/books/v1/volumes/";


//Connect to db
require("lib/config.php");
if ($_SESSION["accountType"] == "admin") {

    try{
        $query = "SELECT mostpopularbooks2.bookId from mostpopularbooks2";

//Generating orderby and sort url for table header
//Source: https://makitweb.com/table-sort-on-header-click-in-the-pagination-using-php/
        function sortOrder($fieldName): string
        {
            $sortUrl = "?order_by=" . $fieldName . "&sort=";
            $sortType = "asc";
            if (isset($_GET['order_by']) && $_GET['order_by'] == $fieldName) {
                if (isset($_GET['sort']) && $_GET['sort'] == "asc") {
                    $sortType = "desc";
                }
            }
            $sortUrl .= $sortType;
            return $sortUrl;
        }

//Order by title asc by default
        $orderBy = " ORDER BY mostpopularbooks2.count desc ";
        if (isset($_GET['order_by']) && isset($_GET['sort'])) {
            $orderBy = ' order by ' . $_GET['order_by'] . ' ' . $_GET['sort'];
        }

//Here we use our $mysqli object created above and run the query() method. We pass it our query from above.
        $result = $mysqli->query($query . $orderBy);
        $num_results = $result->num_rows;



        if (isset($_GET['msg'])) {
            echo "<p>{$_GET['msg']}</p>";
        }

        if ($num_results > 0) {
//Returns a numeric array of all the books retrieved with the query
            $books = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            //If no results
            echo '<div class="alert alert-danger" role = "alert"><p>Sorry there are no entries in the database.</p></div>';
        }

        $subQuery = "SELECT t.week, t.weeklySubs, @running_total:=@running_total + t.weeklySubs AS cSum FROM ( SELECT WEEK(joinDate) as week, COUNT(DISTINCT accountId) AS weeklySubs FROM account WHERE joinDate > NOW() - INTERVAL 1 YEAR AND accountType='user' GROUP BY WEEK(joinDate)) t JOIN (SELECT @running_total:=0) r ORDER BY t.week";

        $subResult = $mysqli->query($subQuery);
        $num_results2 = $subResult->num_rows;
        if ($num_results2 > 0) {
//Returns a numeric array of all the rows retrieved with the query
            // $subs = $subResult->fetch_all(MYSQLI_ASSOC);
            $subs = array();
            foreach ($subResult as $row) {
                $subs[] = $row;
            }
        } else {
            //If no results
            echo '<div class="alert alert-danger" role = "alert"><p>Sorry there are no subscriber entries in the database.</p></div>';
        }


//echo json_encode($subs);

        ?>
        <body>
        <!-- Chart library-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
                crossorigin="anonymous"></script>

        <div id="container">
        <div id="mainArea">
        <h2>Employee Reports</h2>
        <h3>Most Popular Books</h3>
        <div class="reportsGrid">
            <?php
            $collection = array();
            foreach ($books as $book) {
                foreach ($book as $k => $v) {
                    if (empty($v)) {
                        continue;
                    }
                    array_push($collection, $v);
                }
            }

            $collection_api_config = new ApiConfig($apiEndpoint, $apiKey, "collection");
            $collection_data = $collection_api_config->fetchData($collection);

            if (isset($collection_data)) {
                foreach ($collection_data as $collection_item) {
                    foreach ($collection_item as $key => $book) {
                        @$volume_data = $book->volumeInfo;
                        @$sm_image = $volume_data->imageLinks->smallThumbnail;
                        @$title = $volume_data->title;
                        @$authors = $volume_data->authors[0];

                        echo "<div class='report'><img src = '$sm_image' />";
                        echo "<h5> ". $title . ", " . $authors . "</h5></div class='report'>";
                    }
                }
            }
            ?>
        </div>
        <div class="reportsGrid">
            <div class="report">
                <h2>$32, 100 </h2>
                <h6>daily profit</h6>
                <hr>
                <h2>32</h2>
                <h6>new books added this week</h6>
                <hr>
                <h2>2</h2>
                <h6>number of overdue accounts today</h6>

            </div>

            <div class="report">
                <h3>Weekly New Subscription Count</h3>
                <canvas id="lineChartSubscribers" width="200" height="100"></canvas>

                <div class="row">
                    <div class="col-sm center">
                        <hr>
                        <h4 id="weeklySubs"></h4><h4> new subscribers this week</h4>
                    </div>
                    <div class="col-sm center">
                        <h4 id="weeklyChange"></h4><h4> % increase</h4>
                        <h6>vs. last week</h6>
                    </div>
                </div>
            </div>
        </div>
        <!--TO DO: Put into separate js file-->
        <!--Dummy chart-->
        <script>
            subArray = (<?php echo json_encode($subs);?>)
            console.log(subArray);

            let week = [];
            let weeklySubs = []
            let weeklyCSum = [];

            for (let i in subArray) {
                week.push("Week " + subArray[i].week);
                weeklySubs.push(subArray[i].weeklySubs);
                weeklyCSum.push(subArray[i].cSum);
            }

            //Get the number of new subs this week
            $newSubs = weeklySubs[weeklySubs.length - 1]
            console.log($newSubs);
            document.getElementById("weeklySubs").innerHTML = $newSubs;

            //Get the percentage increase of subs from the week before
            $cumulativeV1 = weeklyCSum[weeklyCSum.length - 1];
            $cumulativeV2 = weeklyCSum[weeklyCSum.length - 2];
            $percentageChange = (($cumulativeV1 - $cumulativeV2) / $cumulativeV2) * 100;
            document.getElementById("weeklyChange").innerHTML = Math.round($percentageChange);

            //Setup Block
            const data = {
                labels: week,
                datasets: [{
                    label: 'Total Subscribers',
                    data: weeklyCSum,
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            };
            //Config Block
            const config = {
                type: 'line',
                data
            };
            //Render Block
            <!--Weekly subscribers chart-->
            const lineChart = document.getElementById('lineChartSubscribers');
            const lineChartSubscribers = new Chart(lineChart,
                config
            );
        </script>
        <?php
        // free result and disconnect
        $result->free();
        $subResult->free();
        $mysqli->close();
    } catch (Exception $e) {
        echo $e->getMessage() . "<br/>";
        include("resources/templates/footer.php");
    }
} else {
    echo "<p> Admin account required</p>";
}
?>
    </div>
</div>
<?php
include("resources/templates/footer.php");
?>