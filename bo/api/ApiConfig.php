<?php

class ApiConfig
{
    public $endPoint;
    public $apiKey;
    public $action;


    function __construct($endPoint, $apiKey, $action)
    {
        $this->endPoint = $endPoint;
        $this->apiKey = $apiKey;
        $this->action = $action;
    }

    function get_http_response_code($url)
    {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    function fetchData($params = array())
    {
        $endPoint = $this->endPoint;
        $apiKey = $this->apiKey;
        $action = $this->action;

        if ($action === "search") {
            if ($this->get_http_response_code($endPoint . $apiKey) !== "200") {
                echo "<div class='fetchError'>Something went wrong.</div>";
                return false;
            }
            $json_data = file_get_contents($endPoint . $apiKey);
            $response_data = json_decode($json_data);
            if (isset($response_data->error)) {
                echo "<div class='fetchError'>Something went wrong.</div>";
                return false;
            }
            return $response_data->items;
        } else if ($action === "categories") {
            if ($this->get_http_response_code($endPoint . $apiKey) !== "200" || !isset($params)) {
                echo "<div class='fetchError'>Something went wrong.</div>";
                return false;
            }
            $categoriesData = array();
            foreach ($params as $param) {
                $json_data = file_get_contents($endPoint . $param . "&printType=books&key=" . $apiKey);
                $response_data = json_decode($json_data);
                if (isset($response_data->error)) {
                    echo "<div class='fetchError'>Something went wrong.</div>";
                    return false;
                }
                $categoryData = array($param => $response_data->items);
                array_push($categoriesData, $categoryData);
            }
            return $categoriesData;
        } else if ($action === "details") {
            if ($this->get_http_response_code($endPoint) !== "200") {
                echo "<div class='fetchError'>Something went wrong.</div>";
                return false;
            }
            $json_data = file_get_contents($endPoint);
            $response_data = json_decode($json_data);
            if (isset($response_data->error)) {
                echo "<div class='fetchError'>Something went wrong.</div>";
                return false;
            }
            return $response_data;
        } else if ($action === "collection") {
            $collectionData = array();
            foreach ($params as $param) {
                if ($this->get_http_response_code($endPoint . $param) !== "200" || !isset($params)) {
                    echo "<div class='fetchError'>Something went wrong.</div>";
                    return false;
                }
                $json_data = file_get_contents($endPoint . $param);
                $response_data = json_decode($json_data);
                if (isset($response_data->error)) {
                    echo "<div class='fetchError'>Something went wrong.</div>";
                    return false;
                }
                $itemData = array($param => $response_data);
                array_push($collectionData, $itemData);
            }
            return $collectionData;
        } else {
            return false;
        }
    }
}