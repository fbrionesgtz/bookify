<?php
/**
 * @author hmchugh
 * @since 3/01/2022
 *
 * Description: CIS2288 - Take home practical: The Bookify site is a php website with access to a MySQL website.
 * Users can be authenticated (login) and will have CRUD functionality to add to their collection and delete
 */
include('./bo/api/ApiConfig.php');
$title = "Bookify Collection";
$apiKey = "AIzaSyB42BQBNzq26kjwifWZ8Sc58a9y7oE7WiE";
$apiEndpoint = "https://www.googleapis.com/books/v1/volumes/";

include("resources/templates/header.php");
require("lib/config.php");

if (isset($_SESSION["loggedIn"]) && !$_SESSION["loggedIn"]) {
    header("Location: login.php?requireLogin=true");
}

echo "<body>
    <div id='container'>
    <div id='mainArea'>";

if (isset($_POST["collectionName"]) && isset($_POST["btnAddBooks"])) {
    $query = "insert into collection (collection.collectionName, collection.accountId) 
            values ('" . $_POST["collectionName"] . "'," . $_SESSION["accountId"] . ")";

    $result = $mysqli->query($query);
    header("Location: index.php");
}


if (isset($_GET["ctx"]) && $_GET["ctx"] === "add" || empty($_GET)) {
    $query = "select 
        (select count(collection.collectionName) from collection where collection.accountId = " . $_SESSION["accountId"] . ") as 'total',
        collection.collectionName 
        from collection 
        where collection.accountId = " . $_SESSION["accountId"];

    $result = $mysqli->query($query);
    $num_results = $result->num_rows;

    if ($num_results > 0) {
        $collection_data = $result->fetch_all(MYSQLI_ASSOC);
        echo "<div class='collectionContainer'>
            <div class='collections'>
            <p>Select a collection:</p>";
        for ($i = 0; $i < sizeof($collection_data); $i++) {
            if (@$collection_data[$i]["collectionName"]
                !== @$collection_data[$i + 1]["collectionName"]) {
                echo empty($_GET) ? "<a href='collection.php?collectionName=" . $collection_data[$i]["collectionName"] . "'>" . $collection_data[$i]["collectionName"] . "</a><br>" :
                    " <a href = 'collection.php?collectionName=" . $collection_data[$i]["collectionName"] . "&add_id=" . $_GET["add_id"] . "' > " . $collection_data[$i]["collectionName"] . " </a><br > ";
            }
        }
        echo "</div>";
        ?>
        <div class="createCollectionForm">
            <p>Add new collection:</p>
            <form action="collection.php" method="post">
                <label for="collectionName">Collection Name:</label>
                <input id="collectionName" name="collectionName" type="text">
                <button type="submit" name="btnAddBooks" class="btn btnPrimary">Add Collection</button>
                <p>You will have to return home and add book again</p>
            </form>
        </div>
        </div>
        </div>
        </div>
        </body>
        <?php
        include("resources/templates/footer.php");
    } else {
        ?>
        <div class="createCollectionForm">
            <p>Add new collection</p>
            <form action="collection.php" method="post">
                <label for="collectionName">Collection Name:</label>
                <input id="collectionName" name="collectionName" type="text">
                <button type="submit" name="btnAddBooks" class="btn btnPrimary">Add Collection</button>
                <p>If no collection exists, a collection will be created. Return home to add book</p>
            </form>
        </div>
        <?php
        include("resources/templates/footer.php");
    }
    exit();
}


if (isset($_GET["collectionName"]) && isset($_GET["add_id"])) {
    $query = "insert into collection_item(collection_item.collectionId, collection_item.bookId)
              select collection.collectionId, 
                     '" . $_GET["add_id"] . "'
                     from collection 
                     where collection . collectionName ='" . $_GET['collectionName'] . "'
                    and collection . accountId =" . $_SESSION['accountId'];
    $result = $mysqli->query($query);
}

if (isset($_GET["collectionName"])) {
    $query = "select collection_item.bookId
                from collection_item
                join collection on collection.collectionId = collection_item.collectionId
                where collection . collectionName ='" . $_GET['collectionName'] . "'
                and collection . accountId =" . $_SESSION['accountId'];

    $result = $mysqli->query($query);
    $num_results = $result->num_rows;


    if ($num_results > 0) {
        $books = $result->fetch_all(MYSQLI_ASSOC);

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


        echo "<div class='bookListGrid' > ";
        if (isset($collection_data)) {
            foreach ($collection_data as $collection_item) {
                foreach ($collection_item as $key => $book) {
                    @$id = $book->id;
                    @$volume_data = $book->volumeInfo;
                    @$isbn = $volume_data->industryIdentifiers[0]->identifier;
                    @$sm_image = $volume_data->imageLinks->smallThumbnail;
                    @$description = strlen($volume_data->description) > 0 ? $volume_data->description : "Description not available . ";
                    @$rating = $volume_data->averageRating;

                    //Add showDetails css class if user click on btnBookDetails
                    echo isset($_POST["btnBookDetails"]) ? '<div class="bookItem showDetails">' : '<div class="bookItem">';
                    echo "<img src = '$sm_image' />
                        <div class='bookItemContent'>
                        <p> " . $description . "</p>
                            <div class='rating'>";
                    echo $rating > 1 ? "<span class='fa fa-star checked' ></span> " : "<span class='fa fa-star' ></span> ";
                    echo $rating > 2 ? "<span class='fa fa-star checked' ></span> " : "<span class='fa fa-star' ></span> ";
                    echo $rating > 3 ? "<span class='fa fa-star checked' ></span> " : "<span class='fa fa-star' ></span> ";
                    echo $rating > 4 ? "<span class='fa fa-star checked' ></span> " : "<span class='fa fa-star' ></span> ";
                    echo $rating > 5 ? "<span class='fa fa-star checked' ></span> " : "<span class='fa fa-star' ></span> ";
                    echo "</div>
                            <a class='btn btnPrimary' href='bookDetails.php?id=" . $id . "'>See Details</a>
                            <a class='btn btnGhost' href='readBook.php?isbn=" . $isbn . "' target='_blank'>Read Book</a>    
                        </div>
                    </div>";
                }
            }
        }
    }
    else {
        echo "<p class='emptyCollection'>The collection is empty.</p>";
    }
}

?>
    </div>
    </div>
    </body>
<?php
include("resources/templates/footer.php");
?>