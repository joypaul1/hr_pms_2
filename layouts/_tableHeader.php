
<?php

$html = '<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between" style="padding: 1.0% 1rem">
        <div href="#" style="font-size: 18px;font-weight:700">
            <i class="menu-icon tf-icons bx bx-list-ul" style="margin:0;font-size:30px"></i>';

if (isset($leftSideName)) {
    $html .= $leftSideName;
}
$html .= '</div>
        <div>';

if (isset($routePath)) {
    $route = $basePath . '/' . $routePath;
    $html .= '<a href="' . $route . '" class="btn btn-sm btn-info">';
}

if (isset($rightSideName)) {
    $html .= '<i class="menu-icon tf-icons bx bx-message-alt-add" style="margin:0;"></i>' . $rightSideName;
}

$html .= '</a>
        </div>
    </div>
</div>';

echo $html;
?>