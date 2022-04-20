<?php
$title = "Book Details";
include("resources/templates/header.php");
include("./bo/api/ApiConfig.php");

if (isset($_GET["id"])) {
    $apiKey = "AIzaSyB42BQBNzq26kjwifWZ8Sc58a9y7oE7WiE";
    $book_details_endpoint = "https://www.googleapis.com/books/v1/volumes/" . $_GET["id"];

    $book_details_api_config = new ApiConfig($book_details_endpoint, $apiKey, "details");
    $book_data = $book_details_api_config->fetchData();

    @$volume_data = $book_data->volumeInfo;
    @$image = $volume_data->imageLinks->thumbnail;
    @$title = $volume_data->title;
    @$authors = $volume_data->authors;
    @$publisher = $volume_data->publisher;
    @$publishDate = $volume_data->publishedDate;
    @$description = strlen($volume_data->description) > 0 ? $volume_data->description : "Description not available.";
    @$rating = $volume_data->averageRating;


    echo "<div class='bookDetails'>
            <div>
                <img src='$image'/>
                 <div class='rating'>";
    echo $rating > 1 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
    echo $rating > 2 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
    echo $rating > 3 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
    echo $rating > 4 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
    echo $rating > 5 ? "<span class='fa fa-star checked'></span>" : "<span class='fa fa-star'></span>";
    echo "</div>
            </div>
            <div class='bookDetailsContent'>
                <p>" . $title . "</p>
          <div class='authors'>
          <span>Authors:</span>
            <ul>";
    foreach ($authors as $author) {
        echo "<li>" . $author . "</li>";
    }
    echo "   </ul>   
            </div>
                <p><span>Publisher:</span> " . $publisher . "</p>
                <p><span>Publish date:</span> " . $publishDate . "</p>
                <span>Description:</span> 
                <p>" . $description . "</p>
            </div>
        </div>";
}