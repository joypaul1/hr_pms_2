<?php
require_once('../../inc/config.php'); // Include config file
function generatePagination($tableName, $currentPage,$num_per_page)
{
    global $conn_hr;

    $sql       = "SELECT * FROM $tableName"; //  select query execution
    $result    = mysqli_query($conn_hr, $sql);
    $total_record = mysqli_num_rows($result);
    $totalPages = ceil($total_record / $num_per_page);

    $html = '<nav aria-label="..."><ul class="pagination justify-content-center">';

    // Previous page link
    if ($currentPage > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="index.php?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }

    // Page links
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $currentPage) ? ' active' : '';
        $html .= '<li class="page-item' . $activeClass . '"><a class="page-link" href="index.php?page=' . $i . '">' . $i . '</a></li>';
    }

    // Next page link
    if ($currentPage < $totalPages) {
        $html .= '<li class="page-item"><a class="page-link" href="index.php?page=' . ($currentPage + 1) . '">Next</a></li>';
    }

    $html .= ' </ul></nav>';
    return $html;
}
