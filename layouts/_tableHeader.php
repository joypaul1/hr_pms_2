
<?php


$html = <<<HTML
<div class='card'>
    <div class='card-header d-flex align-items-center justify-content-between' style='padding: 1.5% 1.5rem'>
        <div href='#' style='font-size: 20px;font-weight:700'>
            <i class='menu-icon tf-icons bx bx-list-ul' style='margin:0;font-size:30px'></i>

HTML;
if (isset($leftSideName)) {
    $html .= <<<HTML
    $leftSideName
    HTML;
}

$html .= <<<HTML
        </div>
        <div>
HTML;
if (isset($routePath)) {
    $route = $basePath . '/' . $routePath;
    $html .= <<<HTML
    <a href="$route"
    class='btn btn-info btn-md'>  
    HTML;
}

if (isset($rightSideName)) {
    $html .= <<<HTML
    <i class='menu-icon tf-icons bx bx-message-alt-add ' style='margin:0;'></i>
    $rightSideName
    HTML;
}

$html .= <<<HTML
            </a>
        </div>


    </div>
</div>
HTML;
echo $html;
